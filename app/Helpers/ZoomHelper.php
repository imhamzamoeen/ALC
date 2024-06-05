<?php

use App\Classes\AlQuranConfig;

if (!function_exists('GetStatusFromStudentSeconds')) {
    function GetStatusFromStudentSeconds($seconds = 0)
    {
        return $seconds >= AlQuranConfig::MinSecondsForAttendedStudent ? 'attended' : 'unattended';
    }
}

if (!function_exists('GetStatusFromTeacherSeconds')) {
    function GetStatusFromTeacherSeconds($seconds = 0)
    {
        return $seconds >= AlQuranConfig::MinSecondsForAttendedTeacher ? 'attended' : 'unattended';

    }
}

if (!function_exists('GetClassStatus')) {
    function GetClassStatus($seconds = 0)
    {
        return $seconds >= AlQuranConfig::MinSecondsForAttendedClass ? 'attended' : 'unattended';

       
    }
}
