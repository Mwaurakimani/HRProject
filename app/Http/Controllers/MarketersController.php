<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Bid;
use App\Models\Chat;
use App\Models\Influencer;
use App\Models\InfluencerClass;
use App\Models\Marketer;
use App\Models\Media;
use App\Models\Platform;
use App\Models\SocialAccount;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Ramsey\Collection\Collection;
use function PHPUnit\Framework\returnArgument;

class MarketersController extends Controller
{
    /**
     * @throws Exception
     */
    public function createMarketer(Request $request)
    {
        //TODO:Validation is required

        DB::beginTransaction();

        try {

            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'password' => bcrypt($request['password']),
            ]);

            $user->marketer()->create([
                'type' => $request['account_type'],
            ]);


            if ($request['account_type'] == 'Company' && $request['company_name'] != null) {
                $user->marketer->company()->create([
                    'name' => $request['company_name']
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return 'Marketer account has been created successfully';
    }

    public function hireInfluencer(Request $request,$id)
    {
        $marketer = User::find(Auth::user()->id);
        $bid = Bid::find($id);
        $influencer = Influencer::find($bid->influencer_id)->user;

        $project = Project::find($bid->project_id);

        $authorize = $this->confirmProjectOwner($marketer, $project);
        $bidExist = $this->confirmBid($influencer, $project);
        $influencerAllowed = $this->confirmInfluencerClass($influencer, $project);
        $assigned = $this->assigned($bid);

        if (!$authorize) {
            return "Marketer does not own the project";
        }

        if (!$bidExist) {
            return "Influencer has not bid for this project";
        }

        if (!$influencerAllowed) {
            return "The influencer does not meet the minimum qualifications for this project";
        }

        if ($assigned) {
            return 'Project is already assigned';
        }

        DB::beginTransaction();

        //create
        try {
            $bid->status = 'assigned';

            $bid->save();

            $user = Assignment::create([
                'bid_id' => $bid->id,
                'agreed_price' => $bid->bid_amount,
                'marketer_status' => "Assigned",
                'influencer_status' => "Accepted",
                'general_status' => "Incomplete",
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

        return [
            'status' => true,
            'message' => 'created'
        ];
    }

    public function rejectInfluencer(Request $request)
    {
        $marketer = User::find(Auth::user()->id);
        $influencer = User::find($request['influencer_id']);
        $bid = Bid::find($request['bid_id']);


        $project = Project::find($bid->project_id);

        $authorize = $this->confirmProjectOwner($marketer, $project);
        $bidExist = $this->confirmBid($influencer, $project);
        $influencerAllowed = $this->confirmInfluencerClass($influencer, $project);
        $assigned = $this->assigned($bid);

        if (!$authorize) {
            return "Marketer does not own the project";
        }

        if (!$bidExist) {
            return "Influencer has not bid for this project";
        }

        if (!$influencerAllowed) {
            return "The influencer does not meet the minimum qualifications for this project";
        }

        if ($assigned) {
            return 'Project is already assigned';
        }

        DB::beginTransaction();

        //create
        try {
            $bid->status = 'assigned';

            $bid->save();

            $user = Assignment::create([
                'bid_id' => $bid->id,
                'agreed_price' => $bid->bid_amount,
                'marketer_status' => "Assigned",
                'influencer_status' => "Accepted",
                'general_status' => "Incomplete",
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

        return [
            'status' => true,
            'message' => 'created'
        ];
    }

    public function confirmProjectOwner($marketer, $project)
    {
        return $project->marketer_id == $marketer->marketer->id;
    }

    public function confirmBid($influencer, $project)
    {
        $bids = Bid::where('influencer_id', $influencer->influencer->id)
            ->where('project_id', $project->id)->get();

        return count($bids) > 0;
    }

    public function confirmInfluencerClass($influencer, $project)
    {
        $influencer = $influencer->influencer->accounts;
        $platforms = Platform::all();


        $requirements = $project->projectRequirements;

        foreach ($requirements as $key => $requirement) {
            $require_min_count = InfluencerClass::find($requirement->influencer_classes_id)->min_count;
            $require_max_count = InfluencerClass::find($requirement->influencer_classes_id)->min_count;

            return $influencer;
        }

    }

    public function assigned($bid)
    {
        $project = Project::find($bid->project_id);

        $bids = Bid::where('project_id', $project->id)->where('status', 'LIKE', 'assigned')->get();

        if (count($bids) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function openWorkspace($id)
    {
        $user = User::find(Auth::user()->id);

        if ($user) {

            if ($user->marketer) {
                $person = $user->marketer;
            } else {
                $person = $user->influencer;
            }

            $projects = $person->projects()->where('projects.id', $id)->with('platforms', 'bids')->get();

            $is_assigned = $this->is_assigned($projects[0]);

            if (!$is_assigned) {
                return redirect()->back()->withErrors([
                    'WorkspaceError' => 'Project is not assigned'
                ]);
            }

            $modified_projects = collect();

            $projects->each(function ($project) use ($modified_projects) {
                $modified_project = $project;
                if ($project->platforms) {
                    $modified_project->platforms->each(function ($platform) {
                        if ($platform->pivot) {
                            $influencer_class_id = $platform->pivot->influencer_classes_id;
                            $influencer_class = InfluencerClass::find($influencer_class_id);
                            $platform->pivot['influencer_data'] = $influencer_class;
                        }
                    });
                }

                if ($project->bids) {
                    $modified_project->bids->each(function ($bid) use ($project) {
                        if ($bid->influencer_id) {
                            $influencer_id = $bid->influencer_id;
                            $influencer = Influencer::find($influencer_id);
                            $user = User::with('influencer')->find($influencer->user_id);
                            $user->influencer = $influencer;
                            $bid['user'] = $user;
                            $bid['user']['social_accounts'] = SocialAccount::
                            with('platform', 'influencerClass')
                                ->where('influencer_id', $bid->influencer_id)
                                ->get();
                        }
                    });
                }
                $modified_projects->push($modified_project);
            });

            $temp_media = Bid::where('project_id', $projects[0]->id)->get()->transform(function ($item) {
                $assignment = Assignment::where('bid_id', $item->id)->get();

                if (count($assignment) > 0) {
                    $data = $assignment->transform(function ($item, $key) {
                        return Media::where('assignment_id', $item->id)->get();
                    });

                    return $data;
                } else {
                    return null;
                }
            });

            $media = $temp_media->flatten()->filter();

            $chats = ((function () use ($projects) {

                $data = Bid::where('project_id', $projects[0]->id)->get()->transform(function ($item) {
                    $assignment = Assignment::where('bid_id', $item->id)->get();

                    return $assignment;
                });

                if (count($data) > 0) {
                    $assignment = $data->flatten()[0];

                    $chats = Chat::where('assignment_id', $assignment->id)->get();

                    return $chats;
                } else {
                    return null;
                }
            })());

            $assignment = (Bid::where('project_id', $projects[0]->id)->with('assignments')->get())->filter(function ($value) {
                return $value->assignments != null;
            });

            if (count($assignment) > 0) {
                $assigned_status = $assignment[0]->assignments;
            }else{
                $assigned_status = null;
            }


            if ($user->marketer) {
                return Inertia::render('Employer/WorkingSpace', [
                    'project' => $modified_projects,
                    'media' => $media,
                    'chats' => $chats,
                    'status' => $assigned_status,
                    'assignment' => $assignment,
                    'account_type' => 'Marketer'
                ]);
            } else {
                return Inertia::render('Employer/WorkingSpace', [
                    'project' => $modified_projects,
                    'media' => $media,
                    'chats' => $chats,
                    'status' => $assigned_status,
                    'assignment' => $assignment,
                    'account_type' => 'Influencer'
                ]);
            }

        }
    }

    public function is_assigned($project)
    {
        $bids = Bid::with('assignments')->where('project_id', $project->id)->get();

        if (count($bids) < 0) {
            return false;
        } else {
            $assigned = $bids->where('assignments', '<>', null);

            if (count($assigned) > 0) {
                return true;
            }
        }
    }

    public function ViewProject(Request $request, $id)

    {
        $user = User::find(Auth::user()->id);

        //get logged in user
        if (!$user) {
            return redirect()->to('/');
        }

        //confirm he is a marketer
        $marketer = $user->marketer;
        if ($marketer == null) {
            return redirect()->to('/');
        }

        $project = $marketer->projects()->where('id', $id)->with('platforms', 'bids', 'projectRequirements')->get();

        //confirm if project was found
        if (count($project) < 0) {
            return redirect()->to('/');
        }

        $project = $project[0];

        foreach ($project->platforms as $platform) {
            if ($platform->pivot) {
                $influencer_class_id = $platform->pivot->influencer_classes_id;
                $influencer_class = InfluencerClass::find($influencer_class_id);
                $platform->pivot['influencer_data'] = $influencer_class;
            }
        }

        foreach ($project->bids as $bid) {
            if ($bid->influencer_id) {
                $influencer_id = $bid->influencer_id;
                $influencer = Influencer::find($influencer_id);
                $user = User::find($influencer->user_id);
                $user->load('influencer');
                $user->influencer = $influencer;
                $bid['user'] = $user;
                $social_accounts = SocialAccount::
                with('platform', 'influencerClass')
                    ->where('influencer_id', $bid->influencer_id)
                    ->get();
                $bid['user']['social_accounts'] = $social_accounts;
                $bid['assignment'] = $bid->assignments()->first();

                if ($bid['assignment']) {
                    $bid['assignment']['media'] = Media::with('user')->where('assignment_id', $bid['assignment']->id)->get();
                }
            }
        }

        foreach ($project->projectRequirements as $requirement) {
            $platform = Platform::find($requirement['platform_id']);
            $influencerClass = InfluencerClass::find($requirement['influencer_classes_id']);
            $requirement['platform'] = $platform;
            $requirement['influencerClass'] = $influencerClass;
        }

        $chats = ((function () use ($project) {

            $data = Bid::where('project_id', $project->id)->where('status','assigned')->get()->transform(function ($item) {
                $assignment = Assignment::where('bid_id', $item->id)->get();

                return $assignment;
            });

            if (count($data) > 0) {
                $assignment = $data->flatten()[0];

                $chats = Chat::where('assignment_id', $assignment->id)->get();

                return $chats;
            } else {
                return null;
            }
        })());


        $marketer['user'] = User::find(Auth::user()->id);
        $project['marketer'] = $marketer;
        $project['chats'] = $chats;

        return Inertia::render('Employer/ViewProject', [
            'project' => $project
        ]);
    }
}
