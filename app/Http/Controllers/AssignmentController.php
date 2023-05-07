<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Bid;
use App\Models\Chat;
use App\Models\Influencer;
use App\Models\Marketer;
use App\Models\Project;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;

class AssignmentController extends Controller
{
    public function sendMessage(Request $request)
    {
        $bid_id = $request['project']['bids'][0]['id'];

        if (empty($request['message'])) {
            return [
                'status' => false,
                'message' => 'No message found'
            ];
        }

        $assignment = Assignment::where('bid_id', $bid_id)->first();

        $chat = new Chat();

        $chat->assignment_id = $assignment->id;
        $chat->sender_id = Auth::user()->id;
        $chat->receiver_id = ((function ($user) use ($assignment) {
            if ($user->influencer != null) {
                //its influencer
                return (Marketer::find(Project::find(Bid::find($assignment->bid_id)->project_id)->marketer_id)->user_id);
            } else if ($user->marketer != null) {
                //its marketer
                //get the user who got the assignment
                $bid = Bid::find($assignment->bid_id);
                $influencer_id = Influencer::find($bid->influencer_id);

                return $influencer_id->user_id;
            }
        })(Auth::user()));
        $chat->message = $request['message'];
        $chat->save();


        return [
            'status' => true,
            'chat' => $chat
        ];

    }

    public function updateAssignmentStatus(Request $request)
    {
        $progress = $request['progress'];
        $assignment = $request['assignment'];
        $assignment_id = $assignment['id'];

        if ($progress && $assignment) {
            $assignment = Assignment::find($assignment_id);
            $assignment->marketer_status = $progress;

            $assignment->save();
        }
    }

    public function MarketerMarkAsComplete(Request $request)
    {
        $assignment = Assignment::find($request->id);
        $bid = null;
        $project = null;
        $marketer = null;
        $influencer = null;

        if ($assignment) {
            $bid = Bid::where('id', $assignment->bid_id)->first();
            $influencer = DB::table('users')->where('id',
                DB::table('influencers')->where('id',
                    DB::table('influencers')->where('id', $bid->influencer_id)->first()->id
                )->first()->user_id
            )->first();

            if ($bid) {
                $project = Project::find($bid->project_id);

                $marketer = DB::table('users')->where('id',
                    DB::table('marketers')->where('id',
                        DB::table('marketers')->where('id', $project->marketer_id)->first()->id
                    )->first()->user_id
                )->first();
            }
        }

        $admin = User::where('designation','Administrator')
            ->where('first_name', 'Administrator')
            ->where('last_name', 'Administrator')
            ->first();

        if($assignment->marketer_status == 'complete'){
            return [
                'status' => false,
                'message' => 'Project is already completed'
            ];
        }

        if ($assignment && $bid && $project) {
            DB::beginTransaction();

            try {
                $assignment->marketer_status = 'complete';
                $assignment->save();

                $bid->status = 'done';
                $bid->save();

                $project->status = 'completed';
                $project->save();

                Transfer::create([
                    'from' => $marketer->id,
                    'to' => $influencer->id,
                    'amount' => intval(($bid->bid_amount) * 0.9),
                    'transaction_code' => $bid->id,
                    'status' => 'Confirmed',
                    'notes' => "Payment for project completion.Project ID:".$project->id,
                ]);

                Transfer::create([
                    'from' => $marketer->id,
                    'to' => $admin->id,
                    'amount' => intval(($bid->bid_amount) * 0.1),
                    'transaction_code' => $bid->id,
                    'status' => 'Confirmed',
                    'notes' => 'Payment for project completion.Project ID:' . $project->id,
                ]);

                $marketer = User::find($marketer->id);
                $marketer->creditBalance = $marketer->creditBalance - ($bid->bid_amount);
                $marketer->save();

                $influencer = User::find($influencer->id);
                $influencer->creditBalance = $influencer->creditBalance + intval(($bid->bid_amount) * 0.9);
                $influencer->save();

                $admin = User::find($admin->id);
                $admin->creditBalance = $admin->creditBalance + intval(($bid->bid_amount) * 0.1);
                $admin->save();




                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                throw new Exception($e->getMessage());
            }

        }

        return [
            'status' => true,
        ];
    }

    public function InfluencerMarkAsComplete(Request $request)
    {
        $assignment = Assignment::find($request->id);

        if ($assignment) {
            DB::beginTransaction();

            try {
                $assignment->marketer_status = 'complete';
                $assignment->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                throw new Exception($e->getMessage());
            }

        }

        return [
            'status' => true,
        ];

    }
}
