<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['parameter', 'location']);
        
        if ($request->category) {
            $query->where('category', $request->category);
        }
        
        $transactions = $query->latest()->get();
        
        return view('pages.backend.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $transaction->update([
            'status' => $request->status
        ]);

        return redirect()->route('dashboard.transactions.index')
            ->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function show(Transaction $transaction)
    {
        return view('pages.backend.transactions.show', compact('transaction'));
    }
}
