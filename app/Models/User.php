<?php

namespace App\Models;

use App\Classes\Enums\StatusEnum;
use App\Classes\Enums\UserTypesEnum;
use App\Scopes\UserScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;
use TealOrca\LaravelFreshchat\Traits\ChatUser;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use ChatUser;
    use HasRoles;
    use Billable;
    public $guard_name = 'sanctum';
    /*use TwoFactorAuthenticatable;*/

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'is_locked',
        'ip',
        'country',
        'coordinated_by',
        'customer_pin',
        'social_type',
        'social_id',
        'email_verified_at',
        'timezone',
        'pf',
        'pn',
        'pin_check'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];


    protected static function boot()
    {
        parent::boot();
        // if (Auth::check()) {

        //     $user_type = auth()->user()->user_type;

        //     static::addGlobalScope('Users', function (Builder $builder) use ($user_type) {
        //         if ($user_type == UserTypesEnum::TC)
        //             return   $builder->where('user_type', '=', 'teacher');
        //         else if ($user_type == UserTypesEnum::CustomerSupport)
        //             return $builder->where('user_type', '=', 'customer');
        //     });
        // }
    }

    public function scopeRoleUser($query)
    {

       
        // this scope is used to filter users for tc and customersupport
        
        $user_type = auth()->user()->user_type;
        
        if ($user_type == UserTypesEnum::TC){
            return   $query->where('user_type',UserTypesEnum::Teacher);
        }
        else if ($user_type == UserTypesEnum::CustomerSupport)
            return $query->where('user_type',UserTypesEnum::Customer);
      
       
    }




    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'first_name',
        'timezone',
    ];

    protected $freshchatRestoreId = 'freshchat_restore_id';

    /**
     * Specify the value for Freshchat External Id
     *
     * @return string
     */
    public function chatUserExternalId()
    {
        return $this->email; // using the user's email as the external id
    }

    /**
     * Specify the properties
     *
     * @return array
     */
    public function chatUserProperties()
    {

        return [
            'firstName' => 'name',
            'lastName' => '',
            'email' => 'email',
            'phone' => 'phone',
            'phoneCountryCode' => '',
        ];
    }

    public function profiles()
    {
        return $this->hasMany(Student::class, 'user_id')->where('status', StatusEnum::Active);       
    }
    

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id')->latest();
    }
    public function getTimezoneAttribute($value)
    {
        if (!is_null($value)) {
            return $value;
        } else {

            //agar apny user k table main nhe pari vi tu availability k table s le kr aao 
            /* Note Later jab har bandy ki user k table main hogi tb hm yeh delete kr dein gay  */


            return $this->hasOne(Availability::class, 'user_id')->value('timezone');
        }
        // return '';
    }

    public function getVerifiedAttribute()
    {
        return !is_null($this->email_verified_at) ? 1 : 0;
    }

    public function availability()
    {
        return $this->hasOne(Availability::class, 'user_id');
    }

    public function routine_classes()
    {
        return $this->hasMany(RoutineClass::class, 'teacher_id');
    }

    public function getFirstNameAttribute()
    {
        return @explode(' ', $this->name)[0];
    }
    public function courses()
    {
        return $this->morphToMany(Course::class, 'courseable');
    }

    // public function courses()
    // {
    //     return $this->morphMany(Courseble::class, 'courseable');
    // }

    public function libraries()
    {
        return $this->morphToMany(SharedLibrary::class, 'shareable');
    }

    public function shareableLibraries()
    {
        return $this->morphMany(Shareable::class, 'shareable');
    }

    public function teacherClasses()
    {
        return $this->hasMany(RoutineClass::class, 'teacher_id');
    }


    public function getRegNoAttribute()
    {
        //dd($this->roles()->first());
        $code = @UserTypesEnum::$USER_REG[$this->roles()->pluck('name')->first()] ?? 'MGT';
        return !empty($code) ? 'ALQ-' . $code . '-' . $this->id : $this->id;
    }

    public function weekly_classes()
    {

        return $this->hasMany(WeeklyClass::class, 'teacher_id')->orderBy('class_time', 'ASC');
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Students(): HasMany
    {

        return $this->hasMany(Student::class, 'teacher_id',);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Teacher(): HasMany
    {

        return $this->hasMany(User::class, 'coordinated_by',);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function MyFolders(): HasMany
    {

        return $this->hasMany(SharedLibrary::class, 'created_by',);
    }


    public function Reschedule_Requests()
    {
        return $this->morphMany(RescheduleRequest::class, 'Requestable');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    function Teacher_Coordinator()
    {
        return $this->belongsTo(User::class, 'coordinated_by');  // get teacher co ordinator of a  teacher 
    }

    public function ZoomAttendance()
    {
        return $this->morphMany(ZoomAttendence::class, 'userable');
    }

    public function refund()
    {
        return $this->hasMany(Student::class, 'user_id')->where('status', StatusEnum::Active)->where('is_subscribed','=','1');    
    }
}
