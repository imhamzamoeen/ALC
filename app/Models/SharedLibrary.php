<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedLibrary extends Model
{
    use HasFactory; use SoftDeletes;
    protected $fillable = ['title', 'slug', 'status', 'files_count', 'created_by', 'is_locked'];



    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = slugify($model->title);      //while creating do the slugify and save to slug 
        });
    }

    public function courses()
    {
        return $this->morphMany(Courseble::class, 'courseable');
    }

    public function files()
    {
        return $this->hasMany(LibraryFile::class, 'shared_library_id');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'shareable');
    }

    public function shareableUsers()
    {
        return $this->hasMany(Shareable::class, 'shared_library_id');
    }

    public function userFiles()
    {
        return $this->hasManyThrough('App\Models\LibraryFile', 'App\Models\Shareable', 'shareable_id')
            ->where(
                'shareable_type',
                array_search(static::class, Relation::morphMap()) ?: static::class
            );
    }
}
