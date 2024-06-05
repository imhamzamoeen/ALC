<?php

namespace App\Classes;

use App\Classes\Enums\UserTypesEnum;

class AlQuranConfig
{
    public const Locales = [
        'en' => 'English',
        'ur' => 'Urdu'
    ];
    public const DefaultLocale = 'en';
    public const MaxProfiles = 6;
    public const MinAge = 2;
    public const MaxAge = 100;
    public const TimeSlot = 30;
    public const SlotPrice = 35;
    public const UI_AVATAR_URL = 'https://ui-avatars.com/api/';
    public const DefaultZoomLink = 'https://zoom.us/j/4078332260?pwd=UkUvVmYwQjhpcU9EM25lWTNWTEV5dz09';
    public const MinSecondsForAttendedClass = 900;   // 15 mins
    public const MinSecondsForAttendedStudent = 600;   // 10 mins
    public const MinSecondsForAttendedTeacher = 1680;   // 28 mins





    public const DaysMin = [

        0 => 'Mon',
        1 => 'Tue',
        2 => 'Wed',
        3 => 'Thu',
        4 => 'Fri',
        5 => 'Sat',
        6 => 'Sun',
    ];

    public const Days = [

        0 => 'Monday',
        1 => 'Tuesday',
        2 => 'Wednesday',
        3 => 'Thursday',
        4 => 'Friday',
        5 => 'Saturday',
        6 => 'Sunday',     // if you want to off sunday dont write here 
    ];

    public const Shifts = [
        1 => 'Early Morning (04:00AM-07:00AM)',
        2 => 'Morning (07:00AM-12:00PM)',
        3 => 'Evening (12:00PM-05:00PM)',
        4 => 'Night (06:00PM-11:00PM)',
        5 => 'Available All Day',
    ];

    public static $File_Type  =
    [
        'png'    => 'primary',
        'jpg'  => 'primary',
        'jpeg'  => 'primary',
        'pdf'   => 'warning',
        'doc'   => 'success',
        'docx'   => 'success',
        ''  => 'info'
    ];

    public static $File_Type_Icon  =
    [
        'png'    => '-image',
        'jpg'  => '-image',
        'jpeg'  => '-image',
        'pdf'   => '-pdf',
        'doc'   => '-word',
        'docx'   => '-word',
        ''  => '-alt'
    ];

    public const ColorClasses = ['primary', 'success', 'info', 'warning', 'danger', 'default'];

    public const Add = 'add';
    public const Edit = 'edit';
    public const View = 'view';
    public const Delete = 'delete';
    public const Assign = 'assign';

    public const BASIC_ACTIONS = [self::Add, self::Edit, self::View, self::Delete];
    public static $Modules = [
        'Dashboard'                 => [self::View],
        'users'                     => self::BASIC_ACTIONS,
        'courses'                   => self::BASIC_ACTIONS,
        'subscription-plans'        => self::BASIC_ACTIONS,
        'shared-library'            => self::BASIC_ACTIONS,
        'roles'                     => [self::Add, self::Edit, self::Edit, self::Delete, self::Assign],
        'permissions'               => [self::Add, self::Edit, self::Edit, self::Delete, self::Assign],
        'settings'                  => self::BASIC_ACTIONS,
    ];

    public static $Can_access_admin = [
        UserTypesEnum::Admin,
        UserTypesEnum::CustomerSupport,
        UserTypesEnum::TC,

        // UserTypesEnum::SalesSupport,
    ];

    public static $Can_Filters=[
        'tc'=>[
            [
                '0'=>'user_type',
                '1'=>'=',
                '2'=>'teacher'
            ]
            ],
        'customersupport'=> [
            '0'=>'user_type',
            '1'=>'=',
            '2'=>'customer'
        ]
    ];
}
