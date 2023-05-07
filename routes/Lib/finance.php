<?php

use App\Http\Controllers\FinanceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//no auth needed


//required
Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {

    Route::get('/Finance', function () {
        if(!Auth::check()) {
            return Redirect::to('/');
        }

        $data = (new FinanceController)->FinanceAccount();

        return Inertia::render('Shared/Finance',[
            'finance' => $data
        ]);
    })->name('Finance');

    Route::get('/approveTransaction/{id}', function () {
        return "success";
    });

    Route::get('/changeTransactionStatus/{id}', function () {
        return "success";
    });


    Route::post('/addCredits', [FinanceController::class,'makeDeposit'])->name('makeDeposit');

    Route::post('/withdrawCredits', [FinanceController::class,'makeWithdrawal'])->name('makeWithdrawal');
});
