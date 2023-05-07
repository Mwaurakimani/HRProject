<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\InfluencerClass;
use App\Models\Platform;
use App\Models\ProjectRequirements;
use App\Models\SocialAccount;
use ErrorException;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    /**
     * @throws ErrorException
     */
    public function makeBid(Request $request, Project $project)
    {
        $user = Auth::user();

        if ($request['amount'] == null) {
            return response('Amount not entered', 400);
        }

        if ($user && $user->influencer) {
            $bid = null;


            if ($user->influencer->bids()->where('project_id', $project->id)->first() != null) {
                return [
                    'status' => false,
                    'message' => "Bid already made"
                ];
            } else {
                DB::beginTransaction();

                try {
                    if ($user->marketer) {
                        throw new ErrorException('Error found');
                    }

                    $can_bid = $this->canBid($user, $project);

                    if (!$can_bid['status']) {
                        throw new Exception($can_bid['message']);
                    }

                    $bid = $user->influencer->bids()->create([
                        'project_id' => $project->id,
                        'bid_amount' => $request['amount'],
                        'description' => $request['comment'],
                    ]);

                    DB::commit();

                } catch (Exception $e) {
                    DB::rollback();
                    return abort(403, $e->getMessage());
                }

                return [
                    'status' => true,
                    'bid' => $bid
                ];
            }
        }
    }

    public function canBid($user, $project)
    {
        //get project requirements
        $project_requirements = ProjectRequirements::where('project_id', $project->id)->get();
        $user_platforms = SocialAccount::with('platform', 'influencerClass')->where('influencer_id', (function ($user) {
            return $user->influencer->id;
        })($user))->get();
        $pass = [
            'status' => false,
            'message' => 'Unprocessed'
        ];


        $requirement_status = $project_requirements->map(function ($item) use ($user_platforms) {
            $status = [
                'required_platform' => Platform::find($item->platform_id)->name,
                'minimum_followers' => InfluencerClass::find($item->influencer_classes_id)->min_count,
                'platform_requirements_met' => false,
                'follower_requirements_met' => false,
            ];

            $platform_id = $item->platform_id;


            $user_platforms->each(function ($user_account) use ($platform_id, &$status) {
                if ($user_account->platform->id == $platform_id) {
                    $status['platform_requirements_met'] = true;


                    if ($user_account->following >= $status['minimum_followers']) {
                        $status['follower_requirements_met'] = true;
                    }
                }
            });

            return $status;
        });


        foreach ($requirement_status as $key => $value) {
            if ($value['platform_requirements_met'] || $value['follower_requirements_met']) {
                $pass['status'] = true;
                $pass['message'] = 'pass';
            } else {
                $pass['status'] = false;
                if (!$value['platform_requirements_met']) {
                    $pass['message'] = "You dont seem to have a " . $value['required_platform'] . " account registered with us.";
                }

                if (!$value['follower_requirements_met']) {
                    $pass['message'] = "Your followers on " . $value['required_platform'] . ' do not meet the minimum class requirement for this project';
                }
                break;
            }
        }

        return $pass;
    }
}
