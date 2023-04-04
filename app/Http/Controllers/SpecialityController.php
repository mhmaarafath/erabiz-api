<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $specialities = Speciality::all();
        return responseJson('', [
            'specialities' => $specialities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $rules = [
          'name' => [
              'required',
          ]
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        Speciality::create($validated);

        return responseJson('data added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Speciality $speciality
     * @return JsonResponse
     */
    public function show(Speciality $speciality): JsonResponse
    {
        return responseJson('', [
            'data' => $speciality,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Speciality $speciality
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Speciality $speciality): JsonResponse
    {
        $rules = [
            'name' => [
                'required',
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        $speciality->update($validated);

        return responseJson('data edited successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Speciality $speciality
     * @return JsonResponse
     */
    public function destroy(Speciality $speciality): JsonResponse
    {
        $speciality->delete();
        return responseJson('data deleted successfully');
    }
}
