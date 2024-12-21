<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Location;
use App\Models\QualityStandart;
use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Log;
class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.frontend.transaction', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('pages.frontend.transaction-detail', compact('transaction'));
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

    public function getVillages($districtId)
    {
        $villages = \Indonesia::findDistrict($districtId)->villages;
        return response()->json($villages);
    }

    public function noninstansi()
    {
        $parameters = Parameter::all();
        $locations = Location::all();
        $qualityStandarts = QualityStandart::all();
        $provinces = \Indonesia::allProvinces();
        return view('pages.frontend.noninstansi', compact('parameters', 'locations', 'qualityStandarts', 'provinces'));
    }

    public function noninstansiStore(Request $request)
    {
        $request->validate([
            'parameter_id' => 'required',
            'nama_penanggung_jawab' => 'required',
            'identitas_penanggung_jawab' => 'required',
            'email_penanggung_jawab' => 'required',
            'no_hp_penanggung_jawab' => 'required',
            'jenis_bahan_sampel' => 'required',
            'no_surat' => 'nullable',
            'file_surat' => 'nullable|file|max:1024|mimes:png,jpg,pdf',
            'pengembalian_sampel' => 'required',
            'pengembalian_sisa_sampel' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_surat')) {
            $data['file_surat'] = $request->file('file_surat')->store('file_surat', 'public');
        }
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pending';
        $transaction = Transaction::create($data);
        $price = $transaction->parameter->package->harga;

        Payment::create([
            'transaction_id' => $transaction->id,
            'user_id' => Auth::user()->id,
            'payment_method' => null,
            'payment_code' => 'TRX-' . $transaction->id . Auth::user()->id,
            'payment_amount' => $price,
            'payment_status' => 'pending',
        ]);
        $this->sendWhatsappNotification($transaction);
        return redirect()->route('transaction')->with('success', 'Pengajuan berhasil dikirim');
    }

    private function sendWhatsappNotification($transaction)
    {
        $message = "🔔 *Notifikasi Pengajuan Baru*\n\n"
            . "Ada pengajuan baru dari:\n"
            . "Nama: *" . $transaction->nama_penanggung_jawab . "*\n"
            . "No HP: *" . $transaction->no_hp_penanggung_jawab . "*\n"
            . "Email: " . $transaction->email_penanggung_jawab . "\n\n"
            . "📋 *Detail Pengajuan*\n"
            . "Parameter: *" . $transaction->parameter->name . "*\n"
            . "Jenis Sampel: " . $transaction->jenis_bahan_sampel . "\n"
            . ($transaction->nama_instansi ? "Instansi: " . $transaction->nama_instansi . "\n" : "")
            . "\n📍 *Lokasi*\n"
            . "Provinsi: " . $transaction->province->name . "\n"
            . "Kota/Kabupaten: " . $transaction->city->name . "\n"
            . "Kecamatan: " . $transaction->district->name . "\n"
            . "Desa/Kelurahan: " . $transaction->village->name . "\n\n"
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
