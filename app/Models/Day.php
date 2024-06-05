<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['day_id', 'dayable_id', 'dayable_type'];
    /*protected $with = ['slots'];*/

    public function dayable(){
        return $this->morphTo();
    }

    public function slots(){
        return $this->hasMany(AvailabilitySlot::class, 'day_id', 'id');
    }
}
