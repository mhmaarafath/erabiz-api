<?php

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

Route::apiResource('specialities', \App\Http\Controllers\SpecialityController::class);
Route::apiResource('hospitals', \App\Http\Controllers\HospitalController::class);
Route::apiResource('doctors', \App\Http\Controllers\DoctorController::class);
Route::apiResource('countries', \App\Http\Controllers\CountryController::class)->only('index', 'show');

