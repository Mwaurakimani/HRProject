<?php

use App\Http\Controllers\UserController;
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
    Route::get('/AdminAddUser',function (){
        return Inertia::render('Portal/User/AddUsers');
    })->name('AdminAddUser');

    Route::post('/CreateUser',function (Request $request){


        try {

            $response = (new UserController)->createUser($request);

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
    })->name('CreateUser');

    Route::get('/Admin/Users/{type?}', function ($type = null) {
        $users = User::with('influencer', 'marketer')->get();

        if ($type != null) {
            if ($type == 'Influencers') {
                $users = $users->filter(function ($item) {
                    return $item->influencer != null;
                });
            } elseif ($type == 'Marketers') {
                $users = $users->filter(function ($item) {
                    return $item->marketer != null;
                });
            } elseif ($type == 'Moderators') {
                $users = $users->filter(function ($item) {
                    return $item->designation != null;
                });
            } else {
                return abort(404, "Page not found");
            }
        }

        return Inertia::render('Portal/Users', [
            'users' => $users,
            'tag' => $type
        ]);
    })->name('AdminUsers');

    Route::get('/Admin/Users/View/{id}', function ($id) {
        $data = null;

        $data = (new UserController())->AdminViewUser($id);

        return Inertia::render('Portal/User/ViewUsers', [
            'user' => $data,
        ]);
    })->name('AdminViewUser');

    Route::post('/UpdateAdminUser/{id}',function (Request $request,$id){


        try {

            $response = (new UserController)->updateUser($request,$id);

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
    })->name('UpdateAdminUser');

    Route::post('/updateSocialAccountStatus/{id}',function (Request $request,$id){


        try {

            $response = (new UserController)->updateSocialAccountStatus($request,$id);

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
    })->name('updateSocialAccountStatus');

});

