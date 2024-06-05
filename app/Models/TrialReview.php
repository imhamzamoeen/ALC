<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialReview extends Model
{
    use HasFactory;
    protected $fillable = ['trial_class_id', 'communication', 'teaching', 'behaviour'];
    public function trialClass(){
        return $this->belongsTo(TrialClass::class, 'trial_class_id');
    }
}
