<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'user_id',
        'payment_method',
        'payment_amount',
        'payment_status',
        'payment_link',
        'payment_code',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
