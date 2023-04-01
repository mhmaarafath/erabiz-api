<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Termwind\renderUsing;

class Speciality extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function doctors(){
        return $this->hasMany(Doctor::class);
    }
}
