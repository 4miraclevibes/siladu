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

        // Data untuk grafik transaksi per bulan (berdasarkan user)
        $transactionsByMonth = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('user_id', $userId)
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get()
        ->mapWithKeys(function($item) {
            $months = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            return [$months[$item->month] => $item->total];
        })
        ->toArray();

        // Data untuk grafik status pembayaran (berdasarkan user)
        $paymentStatus = Payment::select('payment_status', DB::raw('COUNT(*) as total'))
            ->whereHas('transaction', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status')
            ->toArray();

        return view('pages.frontend.home', compact('transactionsByMonth', 'paymentStatus'));
    }
}
