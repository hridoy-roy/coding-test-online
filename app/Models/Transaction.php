<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeDeposit($query)
    {
        return $query->where('transaction_type', 'deposit');
    }
    public function scopeWithdrawal($query)
    {
        return $query->where('transaction_type', 'withdrawal');
    }
}
