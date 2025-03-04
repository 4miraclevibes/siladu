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

    public function update(Request $request, Payment $payment)
    {
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

        return response()->json([
            'success' => true,
            'message' => 'Berhasil upload bukti pembayaran',
            'data' => $payment
        ], 200);
    } 
}
