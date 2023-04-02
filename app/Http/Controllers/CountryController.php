<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $countries = Country::all();
        return responseJson('', [
            'data' => $countries,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return JsonResponse
     */
    public function show(Country $country): JsonResponse
    {
        return responseJson('', [
            'data' => $country->load('states'),
        ]);
    }

}
