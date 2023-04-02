<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $hospitals = Hospital::all();
        return responseJson('', [
           'data' => $hospitals,
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
          'name' => 'required',
          'state_id' => [
            'required',
            Rule::exists('states', 'id'),
          ],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        Hospital::create($validated);

        return responseJson('data added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Hospital $hospital
     * @return JsonResponse
     */
    public function show(Hospital $hospital): JsonResponse
    {
        return responseJson('', [
            'data' => $hospital,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Hospital $hospital
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Hospital $hospital): JsonResponse
    {

        $rules = [
            'name' => 'sometimes| required',
            'state_id' => [
                'sometimes',
                'required',
                Rule::exists('states', 'id'),
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        $hospital->update($validated);

        return responseJson('data edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hospital $hospital
     * @return JsonResponse
     */
    public function destroy(Hospital $hospital): JsonResponse
    {
        $hospital->delete();
        return responseJson('data deleted successfully');
    }
}
