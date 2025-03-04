<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.frontend.payment', compact('payments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'payment_method' => 'required|in:cash,bank_transfer'
        ]);

        $payment->update([
            'payment_proof' => $request->file('payment_proof')->store('payment_proof', 'public'),
            'payment_method' => $request->payment_method,
            'payment_status' => 'draft'
        ]);

        $this->sendWhatsappNotification($payment);

        return back()->with('success', 'Berhasil upload bukti pembayaran');
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


    public function generatePayment(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|in:bni_va,bca_va,bri_va'
        ]);
        DB::beginTransaction();
        try {

            $params = $this->buildMidtransParameter([
                'transaction_code' => $payment->payment_code,
                'amount' => $payment->payment_amount,
                'payment_method' => $request->payment_method
            ]);


            $midtrans = $this->callMidtrans($params);

            $payment->update([
                'payment_link' => $midtrans['redirect_url'],
                'payment_method' => $request->payment_method
            ]);

            DB::commit();

            return back()->with('success', 'Berhasil generate link pembayaran');
        } catch (\Throwable $th) {
            DB::rollback();

            return back()->with('error', 'Gagal generate link pembayaran');
        }
    }

    private function callMidtrans(array $params)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = (bool) env('MIDTRANS_IS_SANITIZED', true);
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_IS_3DS', true);

        $createTransaction = \Midtrans\Snap::createTransaction($params);

        return [
            'redirect_url' => $createTransaction->redirect_url,
            'token' => $createTransaction->token
        ];
    }

    private function buildMidtransParameter(array $params)
    {
        $transactionDetails = [
            'order_id' => $params['transaction_code'],
            'gross_amount' => $params['amount']
        ];

        $user = Auth::user();
        $splitName = $this->splitName($user->name);
        $customerDetails = [
            'first_name' => $splitName['first_name'],
            'last_name' => $splitName['last_name'],
            'email' => $user->email
        ];

        $enabledPayments = [
            $params['payment_method']
        ];

        return [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => $enabledPayments
        ];
    }

    private function splitName($fullName)
    {
        $name = explode(' ', $fullName);

        $lastName = count($name)  > 1 ? array_pop($name) : $fullName;
        $firstName = implode(' ', $name);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName
        ];
    }
}
