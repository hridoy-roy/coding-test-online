<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function transactionType(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
        );
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value, 3),
        );
    }

    protected function fee(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value?  number_format($value, 3) :  $value,
        );
    }


    public function scopeDeposit($query)
    {
        return $query->where('transaction_type', 'deposit');
    }
    public function scopeWithdrawal($query)
    {
        return $query->where('transaction_type', 'withdrawal');
    }
}
