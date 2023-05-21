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
    Route::get('/Admin/Applications', function () {
        return Inertia::render('Portal/Applications');
    })->name('AdminApplications');

    Route::get('/Admin/Account', function () {
        $users = User::where('designation','!=','Null')->get();

        return Inertia::render('Portal/Accounts',[
            'users' => $users,
        ]);
    })->name('AdminAccount');

    Route::get('/Admin/Settings', function () {
        return Inertia::render('Portal/Settings');
    })->name('AdminSettings');

    include_once "listings.php";


});


