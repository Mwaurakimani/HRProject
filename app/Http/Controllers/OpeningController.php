<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Opening;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpeningController extends Controller
{
    public function addJobOpening($request)
    {
        DB::beginTransaction();

//        dd($request);

        try {
            $temp_opening = new Opening();

            $temp_opening->Title = $request->title;
            $temp_opening->Description = $request->description;
            $temp_opening->About = $request->about;
            $temp_opening->Responsibilities = json_encode($request->responsibility);
            $temp_opening->Qualification = json_encode($request->qualifications);
            $temp_opening->Education = json_encode($request->EducationRequirement);
            $temp_opening->Skills = json_encode($request->SkillRequirement);
            $temp_opening->Model = $request->OceanModel;
            $temp_opening->Questions = json_encode($request->Questions);

            $temp_opening->save();

            DB::commit();

        } catch (Exception $e) {
            dump($e->getMessage());
        }
    }

    public function getOpeningMetaData(Opening $job)
    {
        $data = [];

        $applications = JobApplication::where('opening_id', $job->id)->get();
        $consideredApplications = JobApplication::where('status', 'Approved')->orWhere(function ($query) use ($job){
            return $query->where('trait', $job->Model)->where('status','<>','rejected');
        })->get();
        $unConsideredApplications = JobApplication::where('status', '<>', 'Approved')->orWhere(function ($query) {
            return $query->where('status', '<>', 'Approved')->where('trait', null);
        })->where(function ($query) use ($job) {
            return $query->where('status', 'Rejected');
        })->get();

        $data['stats']['totalApplications'] = count($applications);
        $data['stats']['consideredApplications'] = count($consideredApplications);
        $data['stats']['unconsideredApplications'] = count($applications) - count($consideredApplications);

        $data['data']['consideredApplications'] = $consideredApplications;
        $data['data']['unconsideredApplications'] = $unConsideredApplications;


        return $data;
    }
}
