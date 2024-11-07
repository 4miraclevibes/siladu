<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Parameter;
use App\Models\Location;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fungsi helper untuk nama bulan
        $getMonthName = function($month) {
            $months = [
                1 => 'Januari', 
                2 => 'Februari', 
                3 => 'Maret', 
                4 => 'April', 
                5 => 'Mei', 
                6 => 'Juni',
                7 => 'Juli', 
                8 => 'Agustus', 
                9 => 'September', 
                10 => 'Oktober', 
                11 => 'November', 
                12 => 'Desember'
            ];
            return $months[$month] ?? '';
        };

        // Data untuk grafik transaksi per bulan
        $transactionsByMonth = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->get()
        ->mapWithKeys(function($item) use ($getMonthName) {
            return [$getMonthName($item->month) => $item->total];
        })
        ->toArray();

        // Data untuk grafik parameter terpopuler
        $popularParameters = Parameter::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        // Data untuk grafik lokasi terpopuler
        $popularLocations = Location::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        // Data untuk grafik status pembayaran
        $paymentStatus = Payment::select('payment_status', DB::raw('COUNT(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status')
            ->toArray();

        // Data untuk grafik kategori transaksi
        $transactionCategories = Transaction::select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        return view('dashboard', compact(
            'transactionsByMonth',
            'popularParameters',
            'popularLocations',
            'paymentStatus',
            'transactionCategories'
        ));
    }
}
