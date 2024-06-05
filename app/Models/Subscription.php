<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="subscriptions";
    protected $fillable = ['user_id', 'student_id', 'payment_id','payer_id','sub_id', 'payment_status','planID', 'price', 'quantity', 'start_at', 'ends_at','payment_name'];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function student()
    {
        return $this->belongsTo(Student::class,"student_id");
    }
}
