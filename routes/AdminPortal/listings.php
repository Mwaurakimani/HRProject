<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/Admin/Listings', function () {
        $jobs = \App\Models\Opening::all();

        return Inertia::render('Portal/Listings',[
            'jobs' => $jobs
        ]);
    })->name('ViewListings');

    Route::get('/Admin/CreateJobs', function () {
        return Inertia::render('Portal/Listings/CreateListings');
    })->name('CreateJob');

    Route::get('/Admin/ViewListings/{id}', function ($id) {
        $job = \App\Models\Opening::find($id);

        $data = (new \App\Http\Controllers\OpeningController)->getOpeningMetaData($job);

        return Inertia::render('Portal/Listings/ViewListings',[
            'job' => $job,
            'data' => $data
        ]);
    })->name('ViewListing');

});


