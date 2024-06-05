<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

class Shareable extends Model
{
    use HasFactory;
    protected $fillable = ['shared_library_id', 'shareable_id', 'shareable_type'];

    public function shareable(){
        return $this->morphTo();
    }

    /**
     * Get the user that owns the Shareable
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Folder(): BelongsTo
    {
        return $this->belongsTo(SharedLibrary::class, 'shared_library_id');
    }
}
