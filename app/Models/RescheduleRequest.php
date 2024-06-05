<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RescheduleRequest extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['student_id', 'teacher_id', 'weekly_class_id', 'reschedule_slot_id','old_class_time', 'Course','reschedule_date', 'status', 'updated_by','Requestable_type', 'Requestable_id'];


    public function Requestable() 
    {
        // it can have student or user 
        return $this->morphTo();
    }

    /**
     * Get the user that owns the RescheduleRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
