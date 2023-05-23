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
    (new \App\Http\Controllers\OpeningController)->addJobOpening($request);
})->name('apiSaveOpening');

Route::post('/apiPostApplication/{jobID}', function (Request $request,$jobID) {
    $response = (new \App\Http\Controllers\JobApplicationController)->makeApplication($request, $jobID);

    return $response;
})->name('apiPostApplication');

Route::post('/apiSubmitTest/{jobID}/{applicationID}', function (Request $request,$jobID,$applicationID) {
    $response = (new \App\Http\Controllers\JobApplicationController)->submitOceanTest($request, $jobID,$applicationID);

    return [
        'status' => true,
        'trait' => $response
    ];

})->name('apiSubmitTest');

Route::post('/getAppliedJobs', function (Request $request) {
    $response = (new \App\Http\Controllers\JobApplicationController)->getAppliedJobs($request);

    return [
        'status' => true,
        'data' => $response
    ];
})->name('getAppliedJobs');

Route::post('/approveApplication/{id}',function ($id){
    $response = (new \App\Http\Controllers\JobApplicationController)->approveApplication($id);

    if($response){
        return [
            'status' => true,
            'message' => 'Approved'
        ];
    }else{
        return [
            'status' => true,
            'message' => 'Error updating'
        ];
    }
})->name('apiApproveApplication');

Route::post('/apiRejectApplication/{id}',function ($id){
    $response = (new \App\Http\Controllers\JobApplicationController)->rejectApplication($id);

    if($response){
        return [
            'status' => true,
            'message' => 'Rejected'
        ];
    }else{
        return [
            'status' => true,
            'message' => 'Error updating'
        ];
    }
})->name('apiRejectApplication');
