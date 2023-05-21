<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/Admin/Listings', function () {
        return Inertia::render('Portal/Listings');
    })->name('AdminDashboard');

    Route::get('/Admin/CreateJobs', function () {
        return Inertia::render('Portal/Listings/CreateListings');
    })->name('CreateJob');

    Route::get('/Admin/ViewListings/{id}', function ($id) {
        return Inertia::render('Portal/Listings/ViewListings');
    })->name('ViewListing');

});


