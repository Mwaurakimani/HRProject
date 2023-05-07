<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//required
Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {

    Route::get('/marketerHiresInfluencer/{id}', function () {
        return "success";
    });

    Route::get('/changeProjectStatus/{id}', function () {
        return "success";
    });

    Route::get('/rateProject/user/{id}/project/{project}', function () {
        return "success";
    });

    Route::get('/sendMessage/marketer/{id}/influencer/{influencer}', function () {
        return "success";
    });

    Route::post('/SendMessage',[AssignmentController::class,'sendMessage'])->name('sendMessage');

    Route::post('/MMarkAsComplete',[AssignmentController::class,'MarketerMarkAsComplete'])->name('MarketerMarkAsComplete');

    Route::post('/IMarkAsComplete',[AssignmentController::class,'InfluencerMarkAsComplete'])->name('InfluencerMarkAsComplete');

});
