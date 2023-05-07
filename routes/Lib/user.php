<?php

use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\MarketersController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//guest routes
Route::middleware(['guest'])->group(function () {

    //Sign up page
    Route::get('/SignUpAs', function () {
        return Inertia::render('Shared/SignUpAs');
    })
        ->name('SignUpAs');

    //sign up as an Influencer Page
    Route::get('/SignUpAsInfluencer', function () {
        return Inertia::render('Influencer/CreateInfluencer');
    })
        ->name('SignUpAsInfluencer');

    //sign up as a marketer
    Route::get('/SignUpAsEmployer', function () {
        return Inertia::render('Employer/CreateEmployer');
    })
        ->name('SignUpAsEmployer');

    //checks to see if the user is already signed in
    Route::post('/testIfLoggedIn', function () {
        dd("hi");
        return Auth::check();
    })->name('routeIsLoggedIn');

    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })
        ->name('login');

    //create user
    Route::post('/createUser/{type}', function (Request $request, $type) {

        try {

            if ($type == 'Influencer') {
                $response = (new InfluencerController)->createInfluencer($request);
            } else if ($type == 'Marketer') {
                $response = (new MarketersController)->createMarketer($request);
            }else{
                throw new InvalidArgumentException;
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }

        return [
            'status' => true,
            'message' => $response
        ];
    })->name('createUser');
});

//Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

//    Navigate to the authenticated user account
    Route::get('/Account', function (Request $request) {
        $user = Auth::user();

        if ($user->influencer) {


            //get users social accounts
            $user = (new InfluencerController)->attachSocialMediaAccounts($request, $user);

            return Inertia::render('Influencer/Account', [
                'user' => $user
            ]);
        } else if ($user->marketer) {

            return Inertia::render('Employer/Account', [
                'user' => $user,
                'marketer' => $user->marketer,
            ]);
        }

    })->name('Account');

    Route::get('/MyProjects', function () {
        $user = Auth::user();

        if ($user->influencer) {
            return redirect()->route('ListActiveInfluencerProjects');
        } else if ($user->marketer) {
            return redirect()->route('ListOwnedProjects');
        }

    })->name('MyProjects');

});
