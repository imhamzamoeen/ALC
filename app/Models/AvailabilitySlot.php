<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['day_id', 'slot_id'];

    public function day(){
        return $this->belongsTo(Day::class, 'day_id');
    }

    public function routine_class(){
        return $this->hasOne(RoutineClass::class, 'slot_id');
    }
}
