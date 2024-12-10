<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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

        // Query dasar
        $transactionsQuery = Transaction::where('user_id', $userId);

        // Filter berdasarkan tahun jika dipilih
        if ($year !== 'all') {
            $transactionsQuery->whereYear('created_at', $year);
        }

        // Filter berdasarkan bulan jika dipilih
        if ($month !== 'all') {
            $transactionsQuery->whereMonth('created_at', $month);
        }

        // Total transaksi berdasarkan filter
        $totalTransactions = $transactionsQuery->count();

        // Status pembayaran
        $paymentQuery = Payment::select('payment_status', DB::raw('COUNT(*) as total'))
            ->whereHas('transaction', function($query) use ($userId) {
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
            'totalTransactions',
            'paymentStatus',
            'year',
            'month'
        ));
    }
}
