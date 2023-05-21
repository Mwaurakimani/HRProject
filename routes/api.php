<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/createUSer', function (Request $request) {
    $user = new User();

    $name = explode(' ',$request->name);

    $user->first_name = $name[0];
    $user->username = $name[0];
    $user->last_name = !empty($name[1])?$name[1]:$name[0];
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->identification_number = $request->id_number;
    $user->password = bcrypt('password');
    $user->designation = $request->designation;

    $data = $user->save();

    if($data){
        return [
            'status' => true
        ];
    }else{
        return [
            'status' => false
        ];
    }

})->name('apiAddUser');


Route::post('/apiSaveOpening', function (Request $request) {
    $response = (new \App\Http\Controllers\OpeningController)->addJobOpening($request);
})->name('apiSaveOpening');
