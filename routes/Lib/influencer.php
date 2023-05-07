<?php

use App\Http\Controllers\InfluencerController;
use App\Http\Requests\CreateInfleuncerRequest;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Influencer;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

//no auth needed



Route::post('/CreateInfluencerValidate',function (CreateInfleuncerRequest $request){
    return [
        'status' =>true
    ];
})->name('createInfluencerValidate');

//required

Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {

    Route::get('/viewInfluencer/{id}', function (Request $request, $id) {
        $user = User::find($id);

        if ($user && $user->influencer) {
            $user->influencer = $user->influencer;
            return $user;
        } else {
            return abort(404, "User not Found");
        }
    });

    Route::get('/ViewAllInfluencer', function () {
        $influencers = User::all()->filter(function ( $value ){
            if($value->influencer){
                return $value;
            }
        });

        return Inertia::render('Influencers',[
            'influencers' => $influencers
        ]);


    })->name('Influencer');

    Route::get('/randomizeInfluencerAccounts', function () {
        return "success";
    });

    Route::post('/updateInfluencer', [InfluencerController::class,'update'])->name('updateInfluencer');

    Route::get('/updatePassword/{id}', function () {
        return "success";
    });

    Route::get('/ListMyProjects', [InfluencerController::class, 'getActiveProjects'])->name('ListActiveInfluencerProjects');

    // Route::post('/user/{user}',function(Request $request,))
});

