<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'transaction_id',
        'status'
    ];

    public function payment() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

