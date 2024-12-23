<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $year = request('year', 'all');
        $month = request('month', 'all');

        // Query dasar menggunakan TransactionDetail
        $transactionDetailsQuery = TransactionDetail::whereHas('transaction', function($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        // Filter berdasarkan tahun jika dipilih
        if ($year !== 'all') {
            $transactionDetailsQuery->whereYear('created_at', $year);
        }

        // Filter berdasarkan bulan jika dipilih
        if ($month !== 'all') {
            $transactionDetailsQuery->whereMonth('created_at', $month);
        }

        // Total transaksi berdasarkan filter
        $totalTransactionDetails = $transactionDetailsQuery->count();

        // Status pembayaran
        $paymentQuery = Payment::select('payment_status', DB::raw('COUNT(*) as total'))
            ->whereHas('transactionDetail.transaction', function($query) use ($userId) {
                $query->where('user_id', $userId);
            });

        if ($year !== 'all') {
            $paymentQuery->whereYear('created_at', $year);
        }
        if ($month !== 'all') {
            $paymentQuery->whereMonth('created_at', $month);
        }

        $paymentStatus = $paymentQuery->groupBy('payment_status')
            ->pluck('total', 'payment_status')
            ->toArray();

        return view('pages.frontend.home', compact(
            'totalTransactionDetails',
            'paymentStatus',
            'year',
            'month'
        ));
    }
}
