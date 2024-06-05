<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryFile extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'slug', 'file', 'file_size', 'file_type', 'created_by', 'shared_library_id', 'is_locked'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = slugify($model->title);      //while creating do the slugify and save to slug 
        });
    }

    public function sharedLibrary()
    {
        return $this->belongsTo(SharedLibrary::class, 'shared_library_id');
    }
}
