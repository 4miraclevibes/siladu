<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class WebhookController extends Controller
{
    public function update()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        
        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing Midtrans notification'], 500);
        }

        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $transactionCode = $notif->order_id;
        
        DB::beginTransaction();
        
        try {
            $status = null;

            if ($transactionStatus == 'capture'){
                if (fraudStatus == 'challenge'){
                    $status = 'challenge';
                } else if (fraudStatus == 'accept'){
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement'){
                $status = 'success';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire'){
                $status = 'failed';
            } else if ($transactionStatus == 'pending'){
                $status = 'pending';
            }

            $payment = Payment::where('payment_code', $transactionCode)->first();

            if ($payment->payment_status !== 'success') {
                $payment->update(['payment_status' => $status]);

                if ($status === 'success') {
                    $payment->transaction->update(['status' => 'success']);
                }
            }

            DB::commit();
            return response()->json();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()]);
        }

    }
}
