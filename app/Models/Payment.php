<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_detail_id',
        'user_id',
        'payment_method',
        'payment_amount',
        'payment_status',
        'payment_proof',
        'payment_code',
    ];

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
