<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'is_custom', 'status', 'created_by', 'is_locked'];

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(){
        return $this->morphedByMany(User::class, 'courseable');
    }

    // public function users()
    // {
    //     return $this->morphedByMany(Video::class, 'taggable');
    // }


}
