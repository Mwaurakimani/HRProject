<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentFileUploadRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Models\Assignment;
use App\Models\Bid;
use App\Models\InfluencerClass;
use App\Models\Marketer;
use App\Models\Media;
use App\Models\MediaOwner;
use App\Models\Platform;
use App\Models\Project;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class ProjectsController extends Controller
{
    public function createProject(CreateProjectRequest $request)
    {
        $marketer = User::find(Auth::user()->id)->marketer;
        DB::beginTransaction();

        try {

            $project = $marketer->projects()->create([
                'title' => $request['title'],
                'type' => $request['projectType'],
                'description' => $request['description'],
                'budget' => $request['budget'],
                'metrics' => $request['timeline']['period'],
                'runtime' => $request['timeline']['value'],
                'notes' => $request['notes'],
                'location' => $request['location'],
            ]);

            foreach ($request['platform']['data'] as $key => $value) {
                if ($value['selected'] == null) {
                    continue;
                }
                $platform_id = $this->getPlatformByName($value['name']);
                $influencerClass = null;

                foreach ($request['influencerClass'] as $influencerClassIndex => $influencerClassDetails) {
                    $platform = Platform::find($platform_id);

                    if ($platform->name == $influencerClassDetails['name']) {
                        $influencerClass = $influencerClassDetails['selectedClass'];
                    }
                }

                $influencer_class_id = $this->getInfluencerClassByNameAndPlatformID($platform_id, $influencerClass);


                $projectRequirements = $project->projectRequirements()->create([
                    'platform_id' => $platform_id,
                    'post_location' => $value['selected'],
                    'influencer_classes_id' => $influencer_class_id,
                    'targets' => json_encode($value['target']),
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            return $e;
            DB::rollBack();
        }

        return [
            "status" => true,
            "project" => $project
        ];
    }

    public function getPlatformByName($name)
    {
        $platform = Platform::where('name', $name)->get();

        return $platform[0]->id;
    }

    public function getInfluencerClassByNameAndPlatformID($platformID, $name)
    {
        $class = InfluencerClass::where('platform_id', $platformID)->where('name', $name)->get();

        return $class[0]->id;
    }

    public function fileUpload(AssignmentFileUploadRequest $request)
    {
        $file = $request->file()['fileData']['data'];
        $project = $request['project'];
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

        try {

            $media = new Media();
            $media->type = (function ($mimeType) {

                $file_types_image = [
                    'image/jpeg',
                    'image/gif',
                    'image/png',
                ];

                $file_types_document = [
                    'application/pdf',
                ];

                $file_types_video = [
                    'video/mp4',
                    'video/x-ms-wmv',
                    'video/x-msvideo',
                    'video/h264',
                    'video/webm'
                ];



                if (in_array($mimeType, $file_types_image)) {
                    return 'image';
                } elseif (in_array($mimeType, $file_types_document)) {
                    return 'PDF';
                } elseif (in_array($mimeType, $file_types_video)) {
                    return 'video';
                } else {
                    return 'N/A';
                }
            })($mimeType);

            if ($media->type == 'N/A') {
                throw new UnsupportedMediaTypeHttpException();
            }

            $media->assignment_id = (function ($project) {
                $project_id = $project['id'];
                $bid = Bid::where('project_id', $project_id)->first();
                $assignment = Assignment::where('bid_id', $bid->id)->first();
                return $assignment->id;
            })($project);



            $filePath = $file->storeAs('uploads', time() . '_' . $file->getClientOriginalName(), 'public');
            $media->path = $filePath;
            $media->name = $file->getClientOriginalName();

            $media->save();

            $media_owner = new MediaOwner();

            $media_owner->media_id = $media->id;
            $media_owner->user_id = Auth::user()->id;

            $media_owner->save();

            return [
                'status' => true,
                'message' => "uploaded"
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'error' => "Unsupported File was sent"
            ];
        }
    }

    public function validateBudget(Request $request){
        $budget = $request['budget'];

        $credits = User::where('id',Auth::user()->id)->first()->creditBalance;
        $marketer = Marketer::where('user_id',Auth::user()->id)->first();
        $activeProjectsValue = Project::where('marketer_id',$marketer->id)->where('status','<>', 'completed')->sum('projects.budget');

        $credits = $credits - $activeProjectsValue;

        if($budget <= $credits){
            return [
                'status' => true
            ];
        }else{
            return [
                'status' => false
            ];
        }
    }
}
