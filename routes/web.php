<?php

use App\Models\InfluencerClass;
use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
 Route::get('/', function () {
     return Inertia::render('Welcome', [
         'canLogin' => Route::has('login'),
         'canRegister' => Route::has('register'),
         'laravelVersion' => Application::VERSION,
         'phpVersion' => PHP_VERSION,
     ]);
 })->name('home');

Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Portal/Dashboard');
    })->name('dashboard');
});



Route::get('/jobBoard', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('jobBoard');

Route::get('/checkStatus', function () {
    return Inertia::render('CheckStatus');
})->name('checkStatus');

Route::get('/viewJob/{id}', function ($id) {
    return Inertia::render('ViewJob');
})->name('viewJob');

Route::get('/OceanTest/{id}', function ($id) {
    return Inertia::render('OceanTest');
})->name('OceanTest');

Route::get('/CheckStatus/', function () {
    return Inertia::render('CheckStatus');
})->name('CheckStatus');

Route::get('/JobStatus/{id}', function () {
    return Inertia::render('JobStatus');
})->name('JobStatus');


include 'Lib/user.php';
include 'AdminPortal/index.php';

