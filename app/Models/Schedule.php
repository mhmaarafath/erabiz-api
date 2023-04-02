<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getMaximumAppointmentsAttribute(){
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);

        return $end->diffInMinutes($start)/$this->duration;
    }
}
