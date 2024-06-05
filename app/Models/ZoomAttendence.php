<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoomAttendence extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'sessionable_id',
        'sessionable_type',
        'userable_id',
        'userable_type',
        'join_time',
        'leave_time',
    ];


    public function userable()
    {
        return $this->morphTo();
    }


    public function sessionable()
    {
        return $this->morphTo();
    }
}
