<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>"clusters"],function($routes){
    Route::get('/',[FrontendController::class,"invokeClusters"]);
    Route::get('/appeals',[FrontendController::class,"invokeAppeals"]);
    Route::get('/keys',[FrontendController::class,"invokeClustersKeys"]);
    Route::post('/update',[FrontendController::class,"updateCluster"]);
});
Route::group(['prefix'=>"categories"],function($routes){
    Route::get('/',[FrontendController::class,"invokeData"]);
    Route::post('/filter',[FrontendController::class,"invokeDataFilter"]);
    Route::get('/names',[FrontendController::class,"invokePolygons"]);
});
Route::get('openstreetmap',[FrontendController::class,"invokeOpenStreetMap"]);
