<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangesRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'reason',
        'course_id',
        'change_type',
        'student_id',
        'status',
    ];


    public function scopeType($query, $type='pending_changes')
    {
        return $query->whereStatus(explode('_',$type)[0]);
    }

    public function scopeWhichRequest($query, $type='teacher')
    {
        return $query->whereChangeType("{$type}_change");
    }

    /**
     * Get the user that owns the ChangesRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', );
    }

    public function Course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', );
    }
}
