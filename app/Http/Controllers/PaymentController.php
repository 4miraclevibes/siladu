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
