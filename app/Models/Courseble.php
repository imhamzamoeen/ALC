<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courseble extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table='courseables';
    protected $fillable = ['course_id', 'courseable_id', 'courseable_type'];

    public function courseable(){
        return $this->morphTo();
    }
}
