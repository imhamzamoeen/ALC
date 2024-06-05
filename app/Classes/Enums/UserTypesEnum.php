<?php

namespace App\Classes\Enums;

class UserTypesEnum{

    public const Customer = 'customer';
    public const Admin = 'admin';
    public const Teacher = 'teacher';
    public const TeacherCoordinator = 'teacher-coordinator';
    public const CustomerSupport = 'customersupport';
    public const SalesSupport = 'sales-support';
    public const TC='tc';   // this is same like teacher Coordinator but for admin

    public static $USER_TYPE_COLOR =
        [
            self::Customer              => 'success',
            self::Admin                 => 'danger',
            self::Teacher               => 'info',
            self::TeacherCoordinator    => 'primary',
            self::CustomerSupport       => 'warning',
            self::SalesSupport          => 'dark',
            self::TC          => 'warning',

        ];

    public static $USER_TYPES =
        [
            self::Customer,
            self::Admin,
            self::Teacher,
            self::TeacherCoordinator,
            self::CustomerSupport,
            self::SalesSupport,
            self::TC          

        ];

    public static $USER_REG = [
        ''                          => 'MGT',
        self::Customer              => 'CST',
        self::Teacher               => 'TCH',
        self::Admin                 => 'ADM',
        self::SalesSupport          => 'SSP',
        self::TeacherCoordinator    => 'TCO',
        self::CustomerSupport       => 'CSP',
        self::TC          => 'TC',


    ];

}
