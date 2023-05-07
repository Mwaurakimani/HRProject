<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        //TODO:Validation is required

        DB::beginTransaction();

        try {

            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'designation' => $request['designation'],
                'password' => bcrypt($request['password']),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return 'Account has been created successfully';
    }

    public function updateUser(Request $request, User $user)
    {
        //TODO:Validation is required

        DB::beginTransaction();

        try {

            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->designation = $request['designation'];

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return 'Account has been created successfully';
    }

    public function AdminViewUser($id)
    {
        $user = User::where('id', $id)->with('influencer', 'marketer')->first();

        if($user == null){
            return abort(404,"User not found");
        }


        if($user->influencer != null){
            $user['social_account'] = SocialAccount::with('platform')->with('influencerClass')->where('influencer_id',$user['influencer']['id'])->get();
        }

        return $user;
    }

    public function updateSocialAccountStatus(Request $request, $id): string
    {
        $social_account = SocialAccount::find($id);
        $social_account->status = $request['status'];
        $social_account->save();

        return "Updated social account status";
    }
}
