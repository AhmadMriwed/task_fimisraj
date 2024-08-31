<?php

use App\Http\Controllers\ConfigurationApiController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    Artisan::call('about');
    dd(Artisan::output());
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    dd(Artisan::output());
});
Route::get('/route-list', function () {
    Artisan::call('route:list');
    dd(Artisan::output());
});

Route::get('/migrate-refresh', function () {
    Artisan::call('migrate:fresh --seed');
    dd(Artisan::output());
});


Route::group(['prefix' => 'config_api'], function () {//ok
    Route::match(['get', 'post', 'put', 'delete'],'/infoRequest', [ConfigurationApiController::class, 'infoRequest']);
    
   
});