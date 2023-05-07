<?php

use App\Models\Platform;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/AboutUs', function () {
    return Inertia::render('AboutUs', [
    ]);
})->name('AboutUs');

Route::get('/ContactUs', function () {
    return Inertia::render('ContactUs', [
    ]);
})->name('ContactUs');

Route::get('/Projects', function () {
    return Inertia::render('Projects', [
    ]);
})->name('Projects');

Route::get('/viewProject', function () {
    return Inertia::render('Home/ViewProject', [
    ]);
})->name('viewProjectProto');

Route::get('/Influencer', function () {
    return Inertia::render('Influencers', [
    ]);
})->name('Influencer');


Route::post('/createPlatforms', function (Request $request) {
    if($request['platforms']){
        $platforms = $request;


        DB::beginTransaction();

        try {
            foreach($platforms['platforms'] as $platform){

                $plat = Platform::create([
                    'name' => $platform['name'],
                    'link' => $platform['link']
                ]);

                foreach($platform['classes'] as $class_key => $class ){
                    $influencer_class = $plat->influencerClass()->create([
                        'name' => $class['name'],
                        'min_count' => $class['min_count'],
                        'max_count' => $class['max_count'],
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            return [$e];
            DB::rollBack();
        }

        return "success";

    }else{
        return abort(404,"No records found");
    }
})->name('Influencer');




