<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//required
Route::middleware([
     'auth:sanctum',
     config('jetstream.auth_session'),
     'verified',
])->group(function () {

});
