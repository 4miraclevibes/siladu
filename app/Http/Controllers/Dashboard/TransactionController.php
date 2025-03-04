<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user']);

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $transactions = $query->latest()->get();

        return view('pages.backend.transactions.index', compact('transactions'));
    }

    public function updateStatus(Request $request, TransactionDetail $transactionDetail)
    {
        $transactionDetail->update([
            'status' => $request->status
        ]);

        $this->sendWhatsappNotification($transactionDetail);

        return redirect()->route('dashboard.transactions.index')
            ->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function show(TransactionDetail $transactionDetail)
    {
        return view('pages.backend.transactions.show', compact('transactionDetail'));
    }

    private function sendWhatsappNotification($transactionDetail)
    {
        $message = "🔔 *Halo " . $transactionDetail->transaction->user->name . "*\n\n"
            . "Terima kasih telah menggunakan layanan kami. Pengajuan Anda telah kami terima.\n\n"
            . "📋 *Detail Pengajuan*\n"
            . "No. Pengajuan: *" . $transactionDetail->transaction->id . "*\n"
            . "Parameter: *" . $transactionDetail->parameter->name . "*\n"
            . "Jenis Sampel: " . $transactionDetail->jenis_bahan_sampel . "\n"
            . ($transactionDetail->transaction->nama_instansi ? "Instansi: " . $transactionDetail->transaction->nama_instansi . "\n" : "")
            . "Status: *" . strtoupper($transactionDetail->status) . "*\n\n"
            . "📝 *Data Penanggung Jawab*\n"
            . "Nama: " . $transactionDetail->transaction->user->name . "\n"
            . "No HP: " . $transactionDetail->transaction->phone . "\n"
            . "Email: " . $transactionDetail->transaction->user->email . "\n\n"
            . "⏰ Waktu Pengajuan: " . $transactionDetail->transaction->created_at->format('d M Y H:i') . " WIB\n\n"
            . "💡 *Informasi*\n"
            . "• Tim kami akan segera memproses pengajuan Anda\n"
            . "• Mohon simpan nomor pengajuan untuk keperluan tracking\n"
            . "• Anda akan mendapat notifikasi jika ada update status\n\n"
            . "Jika ada pertanyaan, silakan hubungi kami di nomor WhatsApp yang tertera di website.\n\n"
            . "Terima kasih! 🙏";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $transactionDetail->transaction->phone,
                'message' => $message
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: gsRuqgbVqLAd6zpnWG9U'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
