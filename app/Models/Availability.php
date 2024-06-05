<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = ['user_id' , 'timezone', 'user_type', 'status'];
    protected $with = ['slots'];

    public function days(){
        return $this->morphMany(Day::class, 'dayable');
    }

    public function slots(){
        return $this->hasManyThrough('App\Models\AvailabilitySlot', 'App\Models\Day', 'dayable_id')
            ->where(
                'dayable_type',
                array_search(static::class, Relation::morphMap()) ?: static::class
            );
    }
}
