<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\WithdrawalCreateService;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'transactions' => auth()->user()->transactions,
        ];

        return view('all_transactions', $data);
    }

    public function deposit()
    {
        $data = [
            'deposits' => auth()->user()->transactions()->deposit()->get(),
        ];
        return view('all_deposits', $data);
    }

    public function CreateDeposit()
    {

        return view('deposits_create');
    }

    public function StoreDeposit(StoreTransactionRequest $request)
    {
        $request->validated();
        $otherData = [
            'transaction_type' => 'deposit',
            'date'             => now(),
        ];
        auth()->user()->transactions()->create(array_merge($request->validated(), $otherData));

        auth()->user()->update([
            'balance' => $request->amount + auth()->user()->balance
        ]);

        return redirect()->route('all.deposit');
    }


    public function withdrawal()
    {
        $data = [
            'withdrawals' => auth()->user()->transactions()->withdrawal()->get(),
        ];
        return view('all_withdrawal', $data);
    }

    public function createWithdrawal()
    {

        return view('withdrawal_create');
    }

    public function storeWithdrawal(StoreWithdrawalRequest $request)
    {
        $withdrawalService = new WithdrawalCreateService();
        $withdrawalService->execute($request->validated());

        return redirect()->route('all.withdrawal');
    }
}
