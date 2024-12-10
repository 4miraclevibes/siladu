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
        $year = request('year', 'all');
        $month = request('month', 'all');

        // Query dasar
        $transactions = Transaction::query();
        $paymentQuery = Payment::select('payment_status', DB::raw('COUNT(*) as total'));
        $categoryQuery = Transaction::select('category', DB::raw('COUNT(*) as total'));
        $incomeQuery = Payment::where('payment_status', 'success');

        // Filter berdasarkan tahun dan bulan
        if ($year !== 'all') {
            $transactions->whereYear('created_at', $year);
            $paymentQuery->whereYear('created_at', $year);
            $categoryQuery->whereYear('created_at', $year);
            $incomeQuery->whereYear('created_at', $year);
        }
        if ($month !== 'all') {
            $transactions->whereMonth('created_at', $month);
            $paymentQuery->whereMonth('created_at', $month);
            $categoryQuery->whereMonth('created_at', $month);
            $incomeQuery->whereMonth('created_at', $month);
        }

        $data = [
            'total_transactions' => $transactions->count(),
            'total_parameters' => Parameter::count(),
            'total_locations' => Location::count(),
            'total_income' => $incomeQuery->sum('payment_amount'),
            'payment_status' => $paymentQuery->groupBy('payment_status')
                ->pluck('total', 'payment_status')
                ->toArray(),
            'transaction_categories' => $categoryQuery->groupBy('category')
                ->pluck('total', 'category')
                ->toArray()
        ];

        return view('dashboard', compact('data', 'year', 'month'));
    }
}

