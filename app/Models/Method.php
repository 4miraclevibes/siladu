<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    protected $fillable = [
        'name',
        'parameter_id'
    ];

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }   
}
