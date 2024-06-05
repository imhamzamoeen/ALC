<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Webpatser\Uuid\Uuid;

class WeeklyClass extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'teacher_id', 'routine_class_id', 'status', 'student_status', 'teacher_status', 'class_time', 'session_key', 'class_link', 'Session_Id', 'class_duration','teacher_presence','student_presence'];

    private function GetUniqueSessionKey()
    {
        $code = '';
        do {
            $code = (string) Uuid::generate();
            $code[0]="W";
            $code[1]="K";
            $user_code = WeeklyClass::where('session_key', $code)->exists();
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
    /**
     * Get the user that owns the WeeklyClass
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Student(): BelongsTo            //This relation is used to course title at schedule or in timeline
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }


    public function ClassAttendance()
    {
        return $this->morphMany(ZoomAttendence::class, 'sessionable');
    }
}
