<?php

use App\Models\InfluencerClass;
use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
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
    $jobs = \App\Models\Opening::all();

    return Inertia::render('Welcome', [
        'jobs' => $jobs,
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
    return redirect('/');
})->name('jobBoard');

Route::get('/checkStatus', function () {
    return Inertia::render('CheckStatus');
})->name('checkStatus');

Route::get('/viewJob/{id}', function (Request $request,$id) {

    $job = \App\Models\Opening::find($id);
    $application = null;

    if($request->query('user')){
        $application = \App\Models\JobApplication::where('opening_id',$job->id)->where('national_id',$request->query('user'))->first();

        if($application == null){
            return abort('404');
        }
    }

    if ($job == null) {
        return \Illuminate\Support\Facades\Redirect::back();
    }

    return Inertia::render('ViewJob', [
        'job' => $job,
        'application' => $application
    ]);
})->name('viewJob');

//TODO:: remember to change this to post

Route::match(array('GET', 'POST'), '/OceanTest/{id}/{applicationID}', function ($id,$applicationID) {

    $job = \App\Models\Opening::find($id);

    return Inertia::render('OceanTest', [
        'job' => $job,
        'application_id' =>$applicationID
    ]);

})->name('OceanTest');

Route::get('/CheckStatus/', function () {
    return Inertia::render('CheckStatus');
})->name('CheckStatus');

Route::get('/JobStatus/{id}', function () {
    return Inertia::render('JobStatus');
})->name('JobStatus');


include 'Lib/user.php';
include 'AdminPortal/index.php';

