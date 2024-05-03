<?php

namespace App\Services;

use Carbon\Carbon;

class WithdrawalCreateService
{
    public function execute($request)
    {
        if (auth()->user()->account_type == 'individual') {
            if ($this->isFreeWithdrawal()) {
                $fee = 0;
            } else {
                $fee = $this->getFeeByPercentage($request, 0.015);
            }
        } elseif (auth()->user()->account_type == 'business') {
            $fee = $this->businessFee($request);
        }
        $otherData = [
            'transaction_type' => 'withdrawal',
            'date'             => now(),
            'fee'              => $fee,
        ];

        if (auth()->user()->balance >= $request['amount']) {
            auth()->user()->transactions()->create(array_merge($request, $otherData));

            auth()->user()->update([
                'balance' => auth()->user()->balance - $request['amount']
            ]);
        } else {
            echo "not sufficient balance";
        }
    }

    protected function businessFee($request): float
    {
        $userWithDrawal = auth()->user()->transactions()->withdrawal()->sum('amount');
        if ($userWithDrawal >= 50000) {
            return $this->getFeeByPercentage($request, 0.015);
        } else {
            return $this->getFeeByPercentage($request, 0.025);
        }
    }
    protected function getFeeByPercentage($request, $percentage): float
    {
        return ($percentage * $request['amount']) / 100;
    }
    protected function isFreeWithdrawal(): bool
    {
        $userWithDrawal     = auth()->user()->transactions()->withdrawal();
        $currentMonthAmount = $userWithDrawal->whereMonth('created_at', Carbon::now()->month)->sum('amount');

        if (
            (Carbon::now()->dayName == 'Friday')
            || $userWithDrawal->count() <= 1000
            || $currentMonthAmount <= 5000
        ) {
            return false;
        } else {
            return false;
        }
    }
}
