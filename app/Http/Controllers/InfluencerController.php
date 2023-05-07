<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Bid;
use App\Models\Chat;
use App\Models\Influencer;
use App\Models\InfluencerClass;
use App\Models\Media;
use App\Models\Platform;
use App\Models\Project;
use App\Models\SocialAccount;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class InfluencerController extends Controller
{
    /**
     * @throws Exception
     */
    public function createInfluencer(Request $request): string
    {
        //TODO:Validation is required

        DB::beginTransaction();

        try {

            //create the user
            $user = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'password' => bcrypt($request['password']),
            ]);

            //attach Influencer Details
            $influencer = $user->influencer()->create([
                'bio' => $request['bio'],
            ]);


            if (count($request['social_account']) > 0) {
                foreach ($request['social_account'] as $key => $socialAccount) {

                    //get platform
                    $platform = Platform::where('name', $key)->first();

                    //confirm the platform exist in database
                    if ($platform == null) {
                        throw new Exception("Could not find ${key} in platforms");
                    }

                    //confirm the account username and influencer exist in request
                    if ($socialAccount['username'] == null || $socialAccount['influencerClass'] == null) {

                        //if it doesn't exist then skip this platform the influencer has no account in this platform
                        continue;
                    }

                    $influencerClass = InfluencerClass::where('platform_id', $platform->id)
                        ->where('name', $socialAccount['influencerClass'])
                        ->first();

                    if ($influencerClass != null) {
                        $social_account = $influencer->accounts()->create([
                            'platform_id' => $platform->id,
                            'influencer_class_id' => $influencerClass->id,
                            'username' => $socialAccount['username'],
                            'status' => 'unverified'
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return "Influencer account has been created successfully";
    }

    //This method receives a user and returns the user with theis social media account information
    public function attachSocialMediaAccounts(Request $request, $user): Collection
    {
        $modifiedUser = collect();
        if ($user) {
            $modifiedUser = collect($user)->map(function ($item, $key) {
                if ($key == 'influencer') {
                    $social_accounts = [];

                    $item['social_accounts'] = SocialAccount::with('platform', 'influencerClass')->where('influencer_id', $item['id'])->get();
                }
                return $item;
            });
        }


        return $modifiedUser;
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $userUpdate = $request['user'];
        $influencerUpdate = Influencer::where('user_id', $user->id)->first();
        $social_accountUpdate = $userUpdate['social_account'];
        $file = $request['formData'];


        DB::beginTransaction();

        try {
            $file_path = null;

            if ($file) {
                if ($influencerUpdate->image_path) {
                    Storage::delete('public/'.$influencerUpdate->image_path);
                    $influencerUpdate->image_path = null;
                    $influencerUpdate->save();
                    $file_path = $this->uploadProfilePicture($file);
                } else {
                    $file_path = $this->uploadProfilePicture($file);
                }
            }

            $user->update([
                'first_name' => $userUpdate['first_name'],
                'last_name' => $userUpdate['last_name'],
                'email' => $userUpdate['email'],
                'phone' => $userUpdate['phone'],
            ]);

            $influencerUpdate->update([
                'bio' => $userUpdate['bio'],
                'image_path' => $file_path
            ]);

            foreach ($social_accountUpdate as $key => $social_account) {
                $input_platform = $key;
                $platform_id = null;

                if (($social_account['username'] == null)) {
                    continue;
                }

                $platforms = Platform::all();

                foreach ($platforms as $key1 => $platform) {
                    if ($platform->name == $input_platform) {
                        $platform_id = $platform->id;
                    }
                }

                if ($platform_id != null) {
//                    if exist update
                    if (count($user->influencer->accounts()->where('platform_id', $platform_id)->get()) > 0) {
                        $account = $user->influencer->accounts()->where('platform_id', $platform_id)->first();

                        $account->username = $social_account['username'];
                        $account->influencer_class_id = $this->getInfluencerClassID($platform_id, $social_account['influencerClass']);
                        $account->status = 'unverified';

                        $account->save();
                    } //                    else create
                    else {
                        $user->influencer->accounts()->create([
                            'platform_id' => $platform_id,
                            'influencer_class_id' => $this->getInfluencerClassID($platform_id, $social_account['influencerClass']),
                            'username' => $social_account['username'],
                        ]);
                    }
                } else {
                    return 'No platform with that name found';
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return [$e];
        }

        return ['success'];
    }

    public function getInfluencerClassID(mixed $platform_id, mixed $class_name)
    {
        $class_id = InfluencerClass::where('name', 'LIKE', $class_name)
            ->where('platform_id', $platform_id)->first()->id;

        return $class_id;
    }

    public function ViewProject(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);

        //get logged in user
        if (!$user) {
            return redirect()->to('/');
        }

        //confirm he is a marketer
        $influencer = $user->influencer;
        if ($influencer == null) {
            return redirect()->to('/');
        }


        $project = Project::where('id', $id)->with('platforms', 'bids', 'projectRequirements')->first();

        //confirm if project was found
        if ($project == null) {
            return redirect()->to('/');
        }

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

        $assignment = $bid->assignment;


        foreach ($project->projectRequirements as $requirement) {
            $platform = Platform::find($requirement['platform_id']);
            $influencerClass = InfluencerClass::find($requirement['influencer_classes_id']);
            $requirement['platform'] = $platform;
            $requirement['influencerClass'] = $influencerClass;
        }

        $chats = ((function () use ($project) {

            $data = Bid::where('project_id', $project->id)->where('status', 'assigned')->get()->transform(function ($item) {
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


        $influencer['user'] = User::find(Auth::user()->id);
        $marketer = $project->marketer()->with('user')->first();
        $project['marketer'] = $marketer;
        $project['influencer'] = $influencer;
        $project['chats'] = $chats;

        return Inertia::render('Influencer/ViewProject', [
            'project' => $project,
            'marketerStatus' => $assignment->marketer_status
        ]);
    }

    public function getActiveProjects(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user) {
            $influencer = $user->influencer;
            if ($influencer) {

                $project = $user->influencer->projects()->with('bids', 'platforms', 'projectRequirements')->get();
                $modified_projects = collect();


                $influencer['projects'] = (function () use ($influencer) {
                    $influencer_id = $influencer->id;
                    $bids = Bid::where('influencer_id', $influencer_id)->get();

                    $projects = [];

                    $bids->map(function ($item, $key) use (&$projects) {
                        $project = Project::with('bids', 'platforms')->where('id', $item->project_id)->first();

                        if ($project->platforms) {
                            $project->platforms = $project->platforms->transform(function ($platform) {
                                if ($platform->pivot) {
                                    $influencer_class_id = $platform->pivot->influencer_classes_id;
                                    $influencer_class = InfluencerClass::find($influencer_class_id);
                                    $platform->pivot['influencer_data'] = $influencer_class;
                                }

                                return $platform;
                            });
                        }
                        array_push($projects, $project);

                    });
                    return $projects;
                })();

                return Inertia::render('Influencer/MyProjects', [
                    'influencer' => $influencer,
                    'projects' => $influencer['projects']
                ]);
            }
        }
    }

    private function uploadProfilePicture(array|UploadedFile $file)
    {
        $uploadedFile = new UploadedFile($file, $file->getClientOriginalName());
        $filePath = $uploadedFile->getPathname();
        $mimeType = null;
        if (extension_loaded('fileinfo')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filePath);
            finfo_close($finfo);
        } else {
            $fileObj = new File($filePath);
            $mimeType = $fileObj->getMimeType();
        }

        $type = (function ($mimeType) {

            $file_types_image = [
                'image/jpeg',
                'image/png',
            ];


            if (in_array($mimeType, $file_types_image)) {
                return 'image';
            } else {
                return 'N/A';
            }
        })($mimeType);

        if ($type == 'N/A') {
            throw new UnsupportedMediaTypeHttpException();
        }

        return $file->storeAs('ProfilePictures', time() . '_' . Auth::user()->id . '_' . $file->getClientOriginalName(), 'public');
    }
}
