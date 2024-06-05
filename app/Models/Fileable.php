<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileable extends Model
{
    use HasFactory;
    protected $fillable = ['library_file_id', 'fileable_id', 'fileable_type'];

    public function fileable(){
        return $this->morphTo();
    }
}
