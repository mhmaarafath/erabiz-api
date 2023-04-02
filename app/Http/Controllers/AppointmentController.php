<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $appointments = Appointment::all();
        return responseJson('', [
            'data' => $appointments,
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
            'schedule_id' => [
                'required',
                Rule::exists('schedules' ,'id'),
            ],
            'date' => [
                'required',
                'date_format:Y-m-d',
                "after_or_equal:today",
            ],
            'name' => [
                'required',
            ],
//            TODO
//            A phone number 1 time per schedule

            'phone' => [
                'required',
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function (\Illuminate\Validation\Validator $validator) use ($request){
            $schedule = Schedule::find($request->schedule_id);

            if (!$schedule->appointmentsFor($request->date)) {
                $validator->errors()->add(
                    'date', 'no appointments available!'
                );
            }
        });


        $validator->validate();

        $validated = $validator->safe()->all();

        Appointment::create($validated);

        return responseJson('data added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param Appointment $appointment
     * @return JsonResponse
     */
    public function show(Appointment $appointment): JsonResponse
    {
        return responseJson('', [
            'data' => $appointment,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Appointment $appointment
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Appointment $appointment)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Appointment $appointment
     * @return JsonResponse
     */
    public function destroy(Appointment $appointment)
    {
    }
}
