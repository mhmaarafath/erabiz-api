<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
      'maximum_appointments',
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function hospital(){
        return $this->belongsTo(Hospital::class);
    }

/*
    public function getMaximumAppointmentsAttribute(){
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);

        return $end->diffInMinutes($start)/$this->duration;
    }
*/
    protected function maximumAppointments(): Attribute
    {
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);

        return Attribute::make(
            get: fn () => $end->diffInMinutes($start)/$this->duration,
        );
    }


    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function appointmentsFor($date){
        if($this->day != Carbon::parse($date)->format('l')){
            throw ValidationException::withMessages([
                'date' => ['invalid date'],
            ]);
        }

        $scheduleAppointments = $this->appointments->groupBy('date')->all();
        if(!array_key_exists($date, $scheduleAppointments)){
            return true;
        }
        return collect($scheduleAppointments[$date])->count() < $this->maximum_appointments;
    }

}
