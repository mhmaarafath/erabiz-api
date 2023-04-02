<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;
use PhpParser\Comment\Doc;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $doctors = Doctor::all();
        return responseJson('', [
           'data' => $doctors,
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
            'name' => ['required'],
            'speciality_id' => [
                'required',
                Rule::exists('specialities', 'id'),
            ],
            'avatar' => [
                'sometimes',
                File::image(),
            ],
            'degree' => ['required'],
            'chamber' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        Doctor::create($validated);

        return responseJson('data added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function show(Doctor $doctor): JsonResponse
    {
        return responseJson('', [
           'data' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Doctor $doctor
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Doctor $doctor): JsonResponse
    {
        $rules = [
            'name' => ['sometimes', 'required'],
            'speciality_id' => [
                'sometimes',
                'required',
                Rule::exists('specialities', 'id'),
            ],
            'avatar' => [
                'sometimes',
                File::image(),
            ],
            'degree' => ['sometimes', 'required'],
            'chamber' => ['sometimes', 'required'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        $doctor->update($validated);

        return responseJson('data edited successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        $doctor->delete();

        return responseJson('data deleted successfully');

    }
}
