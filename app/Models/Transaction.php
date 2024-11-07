<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'parameter_id',
        'location_id',
        'quality_standart_id',
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
        'nama_proyek',
        'status_pengembalian',
        'status_uji',
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

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function qualityStandart()
    {
        return $this->belongsTo(QualityStandart::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
