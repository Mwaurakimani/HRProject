<?php

use App\Http\Controllers\MarketersController;
use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



//required
Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {

    Route::get('/viewEmployer/{id}', function (Request $request, $id) {
        $user = User::find($id);

        if ($user && $user->marketer) {
            $user->marketer = $user->marketer;
            $user->marketer->company = $user->marketer->company;

            return $user;
        } else {
            return abort(404, "User not found");
        }
    });

    Route::post('/updateEmployer/{id}', function (Request $request, $id) {
        $user = User::find($id);

        if ($user) {
            DB::beginTransaction();

            try {
                $user->update([
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                ]);

                $user->marketer()->update([
                    "type" => $request['marketer']['type'],
                ]);

                if ($request['marketer']['type'] == 'company' && $request['marketer']['company']['company_name'] != null) {
                    if($user->marketer->company){
                        $user->marketer->company()->update([
                            "name" => $request['marketer']['company']['company_name'],
                        ]);
                    }else{
                        $user->marketer->company()->create([
                            "name" => $request['marketer']['company']['company_name'],
                        ]);
                    }

                } else if ($request['marketer']['type'] == 'single') {
                    $user->marketer->company()->delete();
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                return $e;
            }

            return [$user];
        } else {
            return abort(404, "User not found");
        }
    });

    Route::post('/updatePassword/{id}', function (Request $request, $id) {
        $user = User::find($id);

        if($user){
            if(Hash::check($request['password'], $user->password)) {

                $user->password = bcrypt($request['new_password']);

                $user->save();

                return "password updated";

            }else {
                echo "dont match";
                return [false];
            }
        }else{
            return abort(404,"Not found");
        }
    });

    Route::get('/ViewInfluencerAccount/{id}', function (Request $request, $id) {
        $user = User::find($id);

        if($user){
            return $user->influencer->with('accounts')->get();
        }else{
            return abort(404,"User not Found");
        }
    });

    Route::post('/HireInfluencer/influencer/{id}', [MarketersController::class,'hireInfluencer'])->name('AcceptBid');

    Route::post('/RejectInfluencer/influencer/{id}', [MarketersController::class,'rejectInfluencer'])->name('RejectBid');

    Route::get('/Workspace/{id}', [MarketersController::class,'openWorkspace'])->name('EmployerWorkspace');

});
