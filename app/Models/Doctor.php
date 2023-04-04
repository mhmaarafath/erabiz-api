<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function speciality(){
        return $this->belongsTo(Speciality::class);
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => image($value),
        );
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

}
