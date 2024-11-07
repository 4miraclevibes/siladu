<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'satuan',
        'harga',
        'catatan',
        'laboratory_id'
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }
}
