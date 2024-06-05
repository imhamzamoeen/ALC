<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoutineClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['availability_slot'];
    public function availability_slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'slot_id')->with('day');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function WeeklyClass(): HasMany
    {
        return $this->hasMany(WeeklyClass::class, 'routine_class_id');
    }

}
