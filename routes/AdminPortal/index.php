<?php

use App\Models\InfluencerClass;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/Portal', function () {
    return Inertia::render('Portal/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('AdminLogin');

Route::post('/AdminLogin', function (Request $request) {


    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user->designation == null) {
        return Redirect::to('/');
    }

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('Admin/Dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('AdminLogin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/Admin/Dashboard', function () {
        return Inertia::render('Portal/Dashboard');
    })->name('AdminDashboard');

    Route::get('/Admin/Projects', function () {
        return Inertia::render('Portal/Projects');
    })->name('AdminProjects');


    Route::get('/Admin/Platforms', function () {
        return Inertia::render('Portal/Platforms');
    })->name('AdminPlatform');


    Route::get('/Admin/Finance', function () {
        return Inertia::render('Portal/Finance');
    })->name('AdminFinance');


    Route::get('/Admin/Media', function () {
        return Inertia::render('Portal/Media');
    })->name('AdminMedia');


    Route::get('/Admin/Tags', function () {
        return Inertia::render('Portal/Tags');
    })->name('AdminTags');


    Route::get('/Admin/Settings', function () {
        return Inertia::render('Portal/Settings');
    })->name('AdminSettings');

});

include 'Transactions/index.php';
include 'Users/index.php';


