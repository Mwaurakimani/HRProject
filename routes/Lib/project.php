<?php

use App\Http\Controllers\BidController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\MarketersController;
use App\Http\Controllers\ProjectsController;
use App\Models\Assignment;
use App\Models\Bid;
use App\Models\Influencer;
use App\Models\InfluencerClass;
use App\Models\Marketer;
use App\Models\Platform;
use App\Models\SocialAccount;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Project;

//no auth needed
Route::get('/AllProjects', function () {

    $projects = Project::with('platforms', 'bids', 'projectRequirements')->get();


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
        $modified_projects->push($modified_project);
    });

    return Inertia::render('Projects', [
        'projects' => $modified_projects
    ]);

})->name('AllProjects');

Route::get('/ViewProject/{id}', function (Request $request, $id) {

    $projects = Project::where('id', $id)->with('platforms', 'bids', 'projectRequirements')->get();

    //confirm if project was found
    if (count($projects) < 0) {
        return redirect()->to('/');
    }

    $project = $projects[0];


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
        }
    }
    foreach ($project->projectRequirements as $requirement) {
        $platform = Platform::find($requirement['platform_id']);
        $influencerClass = InfluencerClass::find($requirement['influencer_classes_id']);
        $requirement['platform'] = $platform;
        $requirement['influencerClass'] = $influencerClass;
    }

    $marketer = (Marketer::find($project->marketer_id));
    $marketer['user'] = $marketer->user;
    $project['marketer'] = $marketer;


    if (Auth::check()) {
        $is_bidder = count($project['bids']->filter(function ($value, $key) {
                if (Auth::user() && Auth::user()->influencer && Auth::user()->influencer->id == $value->influencer_id) {
                    return $value;
                }

            })) > 0;

        if ($is_bidder) {
            $assigned = Project::where('id', $id)->first();
            $assigned = count(Assignment::where('bid_id', Bid::where('project_id', $assigned->id)->where('influencer_id', Auth::user()->influencer->id)->first()->id)->get()) > 0;

            return Inertia::render('ViewProject', [
                'project' => $project,
                'assigned' => $assigned
            ]);
        } else {
            return Inertia::render('ViewProject', [
                'project' => $project,
                'assigned' => []
            ]);
        }
    } else {
        return Inertia::render('ViewProject', [
            'project' => $project
        ]);
    }

})->name('ViewProject');


//required
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/PostProject', function () {
        return Inertia::render('Employer/PostAdvert');
    })->name('createProject');

    Route::post('/createProject', [ProjectsController::class, 'createProject'])->name('PostProject');

    Route::get('/ListOwnedProjects', function (Request $request) {
        $user = User::find(Auth::user()->id);

        if ($user) {
            $marketer = $user->marketer;
            if ($marketer) {

                $projects = $marketer->projects()->with('platforms', 'bids')->get();
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

                    $modified_projects->push($modified_project);
                });

                return Inertia::render('Employer/MyProjects', [
                    'projects' => $modified_projects
                ]);
            }
        }
    })->name('ListOwnedProjects');

    Route::get('/ViewOwnedProject/{id}', [MarketersController::class, 'ViewProject'])->name('ViewOwnedProject');

    Route::get('/ViewBidProject/{id}', [InfluencerController::class, 'ViewProject'])->name('ViewBidProject');

    Route::get('/influencerListViableProjects/{id}', function () {
        return "success";
    });

    Route::get('/randomizeProjects', function () {
        return "success";
    });

    Route::post('/fileUpload', [ProjectsController::class, 'fileUpload'])->name('uploadFile');

    Route::post('/validateBudget', [ProjectsController::class, 'validateBudget'])->name('validateBudget');



});
