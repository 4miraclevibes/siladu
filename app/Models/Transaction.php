<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'phone',
        'instansi',
        'no_surat',
        'file_surat',
        'province_id',
        'city_id',
        'district_id',
        'address',
        'status_pengembalian_sisa',
        'status_pengembalian_hasil',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
