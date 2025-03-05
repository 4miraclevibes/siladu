<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Parameter;
use App\Models\Payment;
use App\Models\QualityStandart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)
            ->with('details.parameter.package', 'user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $transactions
        ], 200);
    }

    public function show($id)
    {
        try {
            $detail = TransactionDetail::with('details')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $detail
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function getCities($provinceId)
    {
        $cities = \Indonesia::findProvince($provinceId)->cities;
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = \Indonesia::findCity($cityId)->districts;
        return response()->json($districts);
    }

    public function pengajuan()
    {
        $data = [
            'parameters' => Parameter::with('package')->get(),
            'locations' => Location::all(),
            'quality_standarts' => QualityStandart::all(),
            'provinces' => \Indonesia::allProvinces()->load('cities.districts')
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    private function generatePaymentCode($transactionId, $transactionDetailId, $userId) 
    {
        $randomNumber = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT); // Generate 2 digit random number
        return sprintf("TRX%d%d%d%s", $transactionId, $transactionDetailId, $userId, $randomNumber);
    }

    public function pengajuanStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'category' => 'required|in:instansi,perusahaan,pribadi',
                'phone' => 'required',
                'no_surat' => 'nullable',
                'file_surat' => 'nullable|file|max:1024|mimes:png,jpg,pdf',
                'province_id' => 'required|exists:indonesia_provinces,id',
                'city_id' => 'required|exists:indonesia_cities,id',
                'district_id' => 'required|exists:indonesia_districts,id',
                'address' => 'required|string',
                'details.*.parameter_id' => 'required|exists:parameters,id',
                'details.*.jenis_bahan_sampel' => 'required|string',
                'details.*.kondisi_sampel' => 'required|string',
                'details.*.jumlah_sampel' => 'required|integer|min:1',
                'details.*.activity' => 'required|string',
                'status_pengembalian_sisa' => 'required|boolean',
                'status_pengembalian_hasil' => 'required|boolean',
            ]);

            \DB::beginTransaction();
            
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'category' => $request->category,
                'instansi' => $request->category !== 'pribadi' ? $request->instansi : null,
                'phone' => $request->phone,
                'no_surat' => $request->no_surat,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'address' => $request->address,
                'status_pengembalian_sisa' => $request->status_pengembalian_sisa,
                'status_pengembalian_hasil' => $request->status_pengembalian_hasil,
            ]);

            if ($request->hasFile('file_surat')) {
                $transaction->file_surat = $request->file('file_surat')->store('file_surat', 'public');
                $transaction->save();
            }

            $details = json_decode($request->input('details'), true);

            foreach ($details as $detail) {
                $transactionDetail = $transaction->details()->create([
                    'parameter_id' => $detail['parameter_id'],
                    'jenis_bahan_sampel' => $detail['jenis_bahan_sampel'],
                    'kondisi_sampel' => $detail['kondisi_sampel'],
                    'jumlah_sampel' => $detail['jumlah_sampel'],
                    'activity' => $detail['activity'],
                ]);

                $parameter = Parameter::find($detail['parameter_id']);
                $price = ($parameter->package->harga - $parameter->package->discount) * $detail['jumlah_sampel'];

                Payment::create([
                    'transaction_detail_id' => $transactionDetail->id,
                    'user_id' => Auth::id(),
                    'payment_code' => $this->generatePaymentCode($transaction->id, $transactionDetail->id, Auth::id()),
                    'payment_amount' => $price,
                    'payment_status' => 'pending',
                ]);
            }

            \DB::commit();
            $this->sendWhatsappNotification($transaction);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan berhasil dikirim',
                'data' => $transaction->load('details', 'details.parameter')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \DB::rollback();
            Log::error('Pengajuan Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses pengajuan'
            ], 500);
        }
    }

    private function sendWhatsappNotification($transaction)
    {
        $details = "";
        foreach($transaction->details as $detail) {
            $details .= "\n- " . $detail->parameter->name . " (" . $detail->jumlah_sampel . " sampel)";
        }

        $message = "🔔 *Notifikasi Pengajuan Baru*\n\n"
            . "Ada pengajuan baru dari:\n"
            . "Nama: *" . $transaction->user->name . "*\n"
            . "Kategori: *" . ucfirst($transaction->category) . "*\n"
            . "No HP: *" . $transaction->phone . "*\n\n"
            . "📋 *Detail Pengujian*" . $details . "\n\n"
            . "📍 *Lokasi*\n"
            . "Provinsi: " . $transaction->province->name . "\n"
            . "Kota/Kabupaten: " . $transaction->city->name . "\n"
            . "Kecamatan: " . $transaction->district->name . "\n\n"
            . "Status: *PENDING*\n\n"
            . "💡 Silahkan cek dashboard admin untuk detail lebih lanjut.\n"
            . "Waktu Pengajuan: " . $transaction->created_at->format('d M Y H:i') . " WIB";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => '6285171742037',
                'message' => $message
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: gsRuqgbVqLAd6zpnWG9U'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
