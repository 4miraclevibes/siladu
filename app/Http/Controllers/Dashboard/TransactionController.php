<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['parameter']);

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

        $this->sendWhatsappNotification($transaction);

        return redirect()->route('dashboard.transactions.index')
            ->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function show(Transaction $transaction)
    {
        return view('pages.backend.transactions.show', compact('transaction'));
    }

    private function sendWhatsappNotification($transaction)
    {
        $message = "🔔 *Halo " . $transaction->nama_penanggung_jawab . "*\n\n"
            . "Terima kasih telah menggunakan layanan kami. Pengajuan Anda telah kami terima.\n\n"
            . "📋 *Detail Pengajuan*\n"
            . "No. Pengajuan: *" . $transaction->id . "*\n"
            . "Parameter: *" . $transaction->parameter->name . "*\n"
            . "Jenis Sampel: " . $transaction->jenis_bahan_sampel . "\n"
            . ($transaction->nama_instansi ? "Instansi: " . $transaction->nama_instansi . "\n" : "")
            . "Status: *" . strtoupper($transaction->status) . "*\n\n"
            . "📝 *Data Penanggung Jawab*\n"
            . "Nama: " . $transaction->nama_penanggung_jawab . "\n"
            . "No HP: " . $transaction->no_hp_penanggung_jawab . "\n"
            . "Email: " . $transaction->email_penanggung_jawab . "\n\n"
            . "⏰ Waktu Pengajuan: " . $transaction->created_at->format('d M Y H:i') . " WIB\n\n"
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
                'target' => $transaction->no_hp_penanggung_jawab,
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
