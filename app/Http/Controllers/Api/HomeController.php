<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $transactions = Transaction::where('user_id', Auth::user()->id)
            ->with('details.parameter.package')
            ->orderBy('created_at', 'desc')
            ->get();
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

        // Mengubah response menjadi format API
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_transactions' => $totalTransactionDetails,
                'payment_status' => $paymentStatus,
                'transaction' => $transactions,
                'filters' => [
                    'year' => $year,
                    'month' => $month
                ]
            ]
        ], 200);
    }
}
