<?php

use App\Http\Controllers\BidController;
use Illuminate\Support\Facades\Route;

//required
Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {
    Route::post('/bid/project/{project}', [BidController::class, 'makeBid'])->name('MakeBid');

    Route::get('/viewBidderAccount/project/{project}/influencer/{influencer}', function () {
        return "success";
    });

});
