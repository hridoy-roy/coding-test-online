<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', [TransactionController::class, 'index'])->name('dashboard');

    Route::get('/deposit', [TransactionController::class, 'deposit'])->name('all.deposit');
    Route::post('/deposit', [TransactionController::class, 'storeDeposit'])->name('store.deposit');
    Route::get('/create/deposit', [TransactionController::class, 'createDeposit'])->name('create.deposit');

    Route::get('/withdrawal', [TransactionController::class, 'withdrawal'])->name('all.withdrawal');
    Route::post('/withdrawal', [TransactionController::class, 'storeWithdrawal'])->name('store.withdrawal');
    Route::get('/create/withdrawal', [TransactionController::class, 'createWithdrawal'])->name('create.withdrawal');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
