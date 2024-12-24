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
}
