<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Opening;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    //
    public function makeApplication(Request $request,$jobID)
    {
        $job = Opening::find($jobID);

        dd($job);
    }
}
