<?php

namespace App\Models;

use App\Classes\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'age', 'gender', 'status', 'timezone', 'shift_id', 'user_id', 'course_id', 'user_subscription_id', 'subscription_status', 'vacation_mode', 'is_subscribed'];
    protected $with = ['course', 'user'];
    protected $appends = ['reg_no', 'first_name', 'user_type'];

    public function getFirstNameAttribute()
    {
        return @explode(' ', $this->name)[0];
    }

    public function getUserTypeAttribute()
    {
        return 'student';
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'student_id');
    }

    public function trialRequest()
    {
        return $this->hasOne(TrialRequest::class, 'student_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'student_id')->latest();
    }

    public function routine_classes()
    {
        return $this->hasMany(RoutineClass::class, 'student_id')->where('status', StatusEnum::Active);
    }

    public function weekly_classes()
    {
        return $this->hasMany(WeeklyClass::class, 'student_id')->orderBy('class_time');
    }

    public function files()
    {
        return $this->morphToMany(LibraryFile::class, 'fileable')->withPivot(['id']);
    }

    public function getRegNoAttribute()
    {
        return 'ALQ-STD-' . $this->id;
    }

    public function Reschedule_Requests()
    {
        return $this->morphMany(RescheduleRequest::class, 'Requestable');
    }

    public function ZoomAttendance()
    {
        return $this->morphMany(ZoomAttendence::class, 'userable');
    }

    public function ChangesRequest()
    {
        return $this->hasMany(ChangesRequest::class, 'student_id');
    }

    /* its a funtion */
    public function LatestTwoChanges()
    {
        return $this->hasMany(ChangesRequest::class, 'student_id')->latest('id')->get()->groupBy('change_type')->map(function($deal) {
            return $deal->take(1);
        });
    }

    public function latestChangeRequestOfTeacher()
    {
        return $this->hasOne(ChangesRequest::class,'student_id')->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('change_type','teacher_change');
        });
    }

    public function latestChangeRequestOfCourse()
    {
        return $this->hasOne(ChangesRequest::class,'student_id')->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('change_type','course_change');
        });
    }

 

}
