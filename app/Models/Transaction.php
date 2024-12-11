<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'parameter_id',
        'category',
        'nama_penanggung_jawab',
        'identitas_penanggung_jawab',
        'email_penanggung_jawab',
        'no_hp_penanggung_jawab',
        'nama_instansi',
        'email_instansi',
        'telepon_instansi',
        'alamat_instansi',
        'no_surat',
        'file_surat',
        'pengembalian_sampel',
        'pengembalian_sisa_sampel',
        'jenis_bahan_sampel',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
