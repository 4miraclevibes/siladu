<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TransactionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'parameter_id',
        'jenis_bahan_sampel',
        'kondisi_sampel',
        'jumlah_sampel',
        'activity',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
