<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $payments
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        $request->validate([
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'payment_method' => 'required|in:cash,bank_transfer'
        ]);

        if ($request->hasFile('payment_proof')) {
            $payment->payment_proof = $request->file('payment_proof')->store('payment_proof', 'public');
        }
        
        $payment->payment_method = $request->payment_method;
        $payment->payment_status = 'draft';
        $payment->save();
        $this->sendWhatsappNotification($payment);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil upload bukti pembayaran',
            'data' => $payment
        ], 200);
    } 

    public function show($id)
    {
        $payment = Payment::with('user', 'transactionDetail')->where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $payment
        ], 200);
    }

    private function sendWhatsappNotification(Payment $payment)
    {
        $transactionDetail = $payment->transactionDetail;
        $transaction = $transactionDetail->transaction;
        $details = "";
        
        $parameter = $transactionDetail->parameter;
        if ($parameter) {
            $details .= "\n- " . $parameter->name . " (" . $transactionDetail->jumlah_sampel . " sampel)";
        }

        $message = "🔔 *Notifikasi Pengajuan Baru*\n\n"
            . "Ada pengajuan baru dari:\n"
            . "Nama: *" . $payment->user->name . "*\n"
            . "Kategori: *" . ucfirst($transaction->category) . "*\n"
            . "No HP: *" . $transaction->phone . "*\n\n"
            . "📋 *Detail Pengujian*" . $details . "\n\n"
            . "📍 *Lokasi*\n"
            . "Provinsi: " . $transaction->province->name . "\n"
            . "Kota/Kabupaten: " . $transaction->city->name . "\n"
            . "Kecamatan: " . $transaction->district->name . "\n\n"
            . "Status: *PENDING*\n\n"
            . "💡 Silahkan cek dashboard admin untuk detail lebih lanjut.\n"
            . "Waktu Pengajuan: " . $transaction->created_at->format('d M Y H:i') . " WIB\n\n"
            . "⚠️ *Catatan Penting:*\n"
            . "Pastikan untuk mengunggah bukti transfer yang jelas dan sesuai dengan jumlah yang dibayarkan. "
            . "Silakan kirim bukti transfer ke WhatsApp ini: *6285171742037*. "
            . "Bukti transfer yang tidak jelas dapat menyebabkan keterlambatan dalam proses verifikasi. Terima kasih atas kerjasamanya!";

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
                'target' => '6281261686210',
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
