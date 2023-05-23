<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Opening;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class JobApplicationController extends Controller
{
    public function makeApplication(Request $request, $jobID)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'ID' => 'required',
            'Age' => 'required',
            'cvFile' => 'required|file'
        ]);

        $file = ($request->file('cvFile'));
        $skills = $this->sendPostRequestWithFileToAnotherServer($file);

        if (count($skills) > 0) {
            $job = Opening::find($jobID);

            if ($job) {
                $skills_required = array_map('strtoupper', json_decode($job->Skills));

                $missingSkills = array_diff($skills_required, $skills);

                if (count($missingSkills)) {
                    return [
                        'status' => 1,
                        'message' => 'Missing Skills:',
                        'skills_missing' => $missingSkills
                    ];
                } else {
                    $application = new JobApplication();

                    $file_name = $this->generateRandomString() . "." . $file->getClientOriginalExtension();

                    $path = $file->storeAs('public/CVs', $file_name);

                    $application->opening_id = $jobID;
                    $application->name = $request->firstName . " " . $request->lastName;
                    $application->email = $request->email;
                    $application->national_id = $request->ID;
                    $application->age = $request->Age;
                    $application->cv_path = $path;
                    $application->trait = null;

                    $application->save();

                    return [
                        'status' => 2,
                        'message' => 'Passed',
                        'application_id' => $application->id,
                    ];
                }
            }

            return [
                'status' => 0,
                'message' => 'Job Not found'
            ];
        }

        return [
            'status' => 0,
            'message' => "Could not Extract Skills"
        ];
    }

    public function sendPostRequestWithFileToAnotherServer($file)
    {
        $client = new Client();

        try {
            $stream = new Stream(fopen($file->getRealPath(), 'r'));

            $response = $client->request('POST', 'http://127.0.0.1:8080/process_resume', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => $stream,
                        'filename' => $file->getClientOriginalName(),
                    ],
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $skills = json_decode($body);

            if ($skills->cvData->skills) {
                $skills = array_map('strtoupper', $skills->cvData->skills);
                $skills = array_unique($skills);
            } else {
                $skills = [];
            }

            return $skills;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function generateRandomString($length = 10): string
    {
        $original_string = array_merge(range(0, 29), range('a', 'z'), range('A', 'Z'));
        $original_string = implode('', $original_string);
        return substr(str_shuffle($original_string), 0, $length);
    }

    public function submitOceanTest(Request $request, $jobID, $applicationID)
    {
        $application = JobApplication::find($applicationID);

        $obj = [
            "name" => $application->name,
            "age" => $application->age,
            "gender" => 1,
            "openness" => (int)($this->extractModel($request, 'Openness')),
            "neuroticism" => (int)($this->extractModel($request, 'neuroticism')),
            "conscientiousness" => (int)($this->extractModel($request, 'conscientiousness')),
            "agreeableness" => (int)($this->extractModel($request, 'agreeableness')),
            "extraversion" => (int)($this->extractModel($request, 'extroversion'))
        ];

        $trait = $this->sendPostRequestToAnotherServer($obj);

        $application->trait = $trait;

        $application->save();

        return $trait;
    }

    public function extractModel($request, $name)
    {
        $val = null;

        collect($request)->each(function ($question, $index) use ($request, &$val, $name) {
            foreach ($question as $key => $value) {
                if ($key == 'ModelTest') {
                    if ($value == $name) {
                        $val = $request[$index]['ans'];
                    }
                }
            }
        });

        return $val;
    }

    public function sendPostRequestToAnotherServer($obj)
    {
        $client = new Client();

        try {
            $response = $client->request('POST', 'http://127.0.0.1:8080/process_trait', [
                'json' => $obj
            ]);

            $body = $response->getBody()->getContents();

            $data = json_decode($body);

            return $data->data;

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getAppliedJobs($request){
        $email = $request->email;
        $id = $request->id;

        $applications = JobApplication::where('email',$email)->where('national_id',$id)->get('opening_id');

        $jobs = [];

        collect($applications)->each(function ($value) use (&$jobs){
            $job = Opening::find($value->opening_id);

            array_push($jobs,$job);
        });

        return $jobs;
    }

    public function approveApplication($id)
    {
        $application = JobApplication::where('id',$id)->first();

        $application->status = "Approved";

        $application->save();

        return true;

    }

    public function rejectApplication($id)
    {
        $application = JobApplication::where('id', $id)->first();

        $application->status = 'Rejected';

        $application->save();

        return true;
    }
}
