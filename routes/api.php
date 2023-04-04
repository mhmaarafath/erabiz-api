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
Route::apiResource('schedules', \App\Http\Controllers\ScheduleController::class);
Route::apiResource('appointments', \App\Http\Controllers\AppointmentController::class)->except('update', 'destroy');


Route::prefix('public')->group(function () {
    Route::post('/doctors', function (Request $request){
        $search = $request->search ?? null;
        $stateId = $request->state_id ?? null;
        $specialities = $request->specialities ?? null;

        $query = \App\Models\Doctor::query();
        if($search && $search != ''){
            $query = $query->where('name', 'like', "%{$search}%");
        }

        if($stateId && $stateId != ''){
            $query = $query->whereRelation('schedules.hospital', 'state_id', $stateId);
        }

        if(is_array($specialities) && !empty($specialities)){
            $query = $query->whereIn('speciality_id', $specialities);
        }



        $doctors = $query->with('speciality')->get();


        return responseJson('', [
            'data' => $doctors,
        ]);

    });

    Route::get('/countries/{search}', function ($search){
        $query = \App\Models\Country::query();
        if($search && $search != ''){
            $query = $query->where('name', 'like', "%{$search}%");
        }

        $countries = $query->with('states')->get();


        return responseJson('', [
            'results' => $countries,
        ]);

    });

    Route::get('/doctors/{doctor}', function (\App\Models\Doctor $doctor){
        return responseJson('', [
            'data' => $doctor->load('schedules.hospital.state'),
        ]);

    });

});
