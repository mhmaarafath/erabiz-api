<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $schedules = Schedule::withWhereHas('hospital')->withWhereHas('doctor')->get();

        return responseJson('', [
           'schedules' => $schedules,
            'doctors' => Doctor::all(),
            'hospitals' => Hospital::all(),
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
            'doctor_id' => [
                'required',
                Rule::exists('doctors', 'id'),
            ],
            'hospital_id' => [
                'required',
                Rule::exists('hospitals', 'id'),
            ],
            'day' => [
                'required',
                Rule::in([
                    'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
                ])
            ],
            'start' => [
                'required',
                'date_format:H:i'

            ],
            'end' => [
                'required',
                'date_format:H:i',
                'after:start'
            ],
            'duration' => [
                'required',
                'integer'
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        Schedule::create($validated);

        return responseJson('data added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Schedule $schedule
     * @return JsonResponse
     */
    public function show(Schedule $schedule): JsonResponse
    {
        return responseJson('', [
            'data' => $schedule,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Schedule $schedule
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Schedule $schedule): JsonResponse
    {

        $rules = [
            'doctor_id' => [
                'sometimes',
                'required',
                Rule::exists('doctors', 'id'),
            ],
            'hospital_id' => [
                'sometimes',
                'required',
                Rule::exists('hospitals', 'id'),
            ],
            'day' => [
                'sometimes',
                'required',
                Rule::in([
                    'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
                ])
            ],
            'start' => [
                'sometimes',
                'required',
                'date_format:H:i'

            ],
            'end' => [
                'sometimes',
                'required',
                'date_format:H:i',
                'after:start'
            ],
            'duration' => [
                'sometimes',
                'required',
                'integer'
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->validate();

        $validated = $validator->safe()->all();

        $schedule->update($validated);

        return responseJson('data added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Schedule $schedule
     * @return JsonResponse
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        $schedule->delete();
        return responseJson('data deleted successfully');

    }
}
