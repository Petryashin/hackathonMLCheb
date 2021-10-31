<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\TestController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', [TestController::class,"test"]);
Route::get('/parse', [ApiController::class,"parse"]);
Route::get('/parseGeoTags', [ApiController::class,"parseGeoTags"]);
Route::get('/parseTypes', [ApiController::class,"parseTypes"]);
Route::get('/parseclusters', [ApiController::class,"parseClusters"]);
Route::get('/parseOpenStreetMap', [ApiController::class,"parseOpenStreetMap"]);
