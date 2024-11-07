<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Location;
use App\Models\QualityStandart;
use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('pages.frontend.transaction', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('pages.frontend.transaction-detail', compact('transaction'));
    }

    public function instansi()
    {
        $parameters = Parameter::all();
        $locations = Location::all();
        $qualityStandarts = QualityStandart::all();
        return view('pages.frontend.instansi', compact('parameters', 'locations', 'qualityStandarts'));
    }

    public function instansiStore(Request $request)
    {
        $request->validate([
            'parameter_id' => 'required',
            'location_id' => 'required',
            'quality_standart_id' => 'required',
            'nama_instansi' => 'required',
            'alamat_instansi' => 'required',
            'telepon_instansi' => 'required',
            'email_instansi' => 'required',
            'nama_penanggung_jawab' => 'required',
            'identitas_penanggung_jawab' => 'required',
            'email_penanggung_jawab' => 'required',
            'no_hp_penanggung_jawab' => 'required',
            'nama_proyek' => 'required',
            'jenis_bahan_sampel' => 'required',
            'no_surat' => 'nullable',
            'file_surat' => 'nullable|file|max:1024|mimes:png,jpg,pdf',
            'status_pengembalian' => 'required',
            'status_uji' => 'required',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('file_surat')) {
            $data['file_surat'] = $request->file('file_surat')->store('file_surat', 'public');
        }
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pending';
        $transaction = Transaction::create($data);
        $price = $transaction->parameter->package->harga;

        Payment::create([
            'transaction_id' => $transaction->id,
            'user_id' => Auth::user()->id,
            'payment_method' => null,
            'payment_code' => 'TRX-' . $transaction->id . Auth::user()->id,
            'payment_amount' => $price,
            'payment_status' => 'pending',
        ]);
        return redirect()->route('transaction')->with('success', 'Pengajuan berhasil dikirim');
    }

    public function noninstansi()
    {
        $parameters = Parameter::all();
        $locations = Location::all();
        $qualityStandarts = QualityStandart::all();
        return view('pages.frontend.noninstansi', compact('parameters', 'locations', 'qualityStandarts'));
    }

    public function noninstansiStore(Request $request)
    {
        $request->validate([
            'parameter_id' => 'required',
            'location_id' => 'required',
            'quality_standart_id' => 'required',
            'nama_penanggung_jawab' => 'required',
            'identitas_penanggung_jawab' => 'required',
            'email_penanggung_jawab' => 'required',
            'no_hp_penanggung_jawab' => 'required',
            'nama_proyek' => 'required',
            'jenis_bahan_sampel' => 'required',
            'no_surat' => 'nullable',
            'file_surat' => 'nullable|file|max:1024|mimes:png,jpg,pdf',
            'status_pengembalian' => 'required',
            'status_uji' => 'required',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('file_surat')) {
            $data['file_surat'] = $request->file('file_surat')->store('file_surat', 'public');
        }
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 'pending';
        $transaction = Transaction::create($data);
        $price = $transaction->parameter->package->harga;

        Payment::create([
            'transaction_id' => $transaction->id,
            'user_id' => Auth::user()->id,
            'payment_method' => null,
            'payment_code' => 'TRX-' . $transaction->id . Auth::user()->id,
            'payment_amount' => $price,
            'payment_status' => 'pending',
        ]);
        return redirect()->route('transaction')->with('success', 'Pengajuan berhasil dikirim');
    }
}
