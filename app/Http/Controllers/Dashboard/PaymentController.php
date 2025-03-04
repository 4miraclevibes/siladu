<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('transactionDetail')->latest()->get();
        return view('pages.backend.payments.index', compact('payments'));
    }
    
    public function update(Request $request, Payment $payment)
    {
        $payment->update([
            'payment_status' => $request->payment_status
        ]);

        return redirect()->route('dashboard.payments.index')->with('success', 'Payment status updated successfully');
    }
}
