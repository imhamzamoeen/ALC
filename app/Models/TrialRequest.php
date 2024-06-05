<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialRequest extends Model
{
    use HasFactory;
    protected $fillable=['student_id', 'status', 'request_date', 'reason','teacher_preference'];
    protected $with = ['student', 'days'];
    public $timestamps = ['request_date'];

    public function days(){
        return $this->morphMany(Day::class, 'dayable');
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function trialClass(){
        return $this->hasOne(TrialClass::class, 'trial_request_id');
    }
}
