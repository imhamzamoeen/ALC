<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

class TrialClass extends Model
{
    use HasFactory;
    protected $fillable = ['trial_request_id','student_id', 'zoom_link', 'starts_at', 'status', 'student_status', 'teacher_status', 'session_key', 'Session_Id', 'class_duration','teacher_presence','student_presence','teacher_id'];

    protected $with = ['trialRequest'];

    private function GetUniqueSessionKey()
    {
        $code = '';
        do {
            $code = (string) Uuid::generate();
            $code[0]="D";
            $code[1]="M";
            $user_code = TrialClass::where('session_key', $code)->exists();
        } while ($user_code);
        return $code;
    }

    public static function boot()
    {

        parent::boot();

        /**
         * Write code on Method
         *
         * @return response()
         */
        static::creating(function ($item) {

            $item->session_key = self::GetUniqueSessionKey();
        });
    }

    public function trialRequest()
    {
        return $this->belongsTo(TrialRequest::class, 'trial_request_id');
    }

    public function trialReview()
    {
        return $this->hasOne(TrialReview::class, 'trial_class_id');
    }
    public function ClassAttendance()
    {
        return $this->morphMany(ZoomAttendence::class, 'sessionable');
    }

    public function Student(): BelongsTo            //This relation is used to course title at schedule or in timeline
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
