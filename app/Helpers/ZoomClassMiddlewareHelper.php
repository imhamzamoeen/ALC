<?php

namespace App\Helpers;

use App\Exceptions\ZoomClassException;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;

class ZoomClassMiddlewareHelper
{

    protected  function CheckTime($time, $timezone)
    {

        $start_time = convertTimeToUSERzone(Carbon::parse($time), $timezone, 'UTC', 'Y-m-d H:i:s');
        $current_time = Carbon::parse(Carbon::now('UTC')->format('Y-m-d H:i:s'));
        $time_diff = $start_time->diffInMinutes($current_time);  // this return always positive number .. 


        if (!(($start_time->gt($current_time) && $time_diff <= 5) || ($start_time->lt($current_time) && $time_diff <= 30))) {
            // he cannot join this class right now 
            abort(499, 'Nhe bachy kdr ');
            // throw new ZoomClassException('no time');
        }
    }
    


    protected  function CheckRelation($current_user, $Class)
    {


        if ($current_user->user_type == "teacher") {
            // if it's teacher or parent the given student must belong to them
            if ($Class->teacher_id != $current_user->id) {

                abort(403); // the teacher trying to take class does not belong to this class
            }
        } elseif ($current_user->user_type == "customer") {
            // if it's teacher or parent the given student must belong to them
            if (in_array($Class->student_id, $current_user->profiles()->pluck('id')->toArray()) == false) {
                abort(403); // the student trying to take class does not belong to this class
            }
        } elseif ($current_user->user_type == "teacher-coordinator") {
            // if it's teacher or parent the given student must belong to them
            if (in_array($Class->teacher_id, $current_user->Teacher()->pluck('id')->toArray()) == false) {
                abort(403); // the teacher coordinator  trying to take class does not belong to this class 
            }
        }
    }

    protected function GetModel($current_user,$user){
        $model=$current_user;
        if ($current_user->user_type == "teacher" || $current_user->user_type == 'teacher-coordinator') {
            $model = User::findOrFail($user);
        } else if ($current_user->user_type == "customer") {
            $model = Student::findOrFail($user);
        } else {
            $model = auth()->user();
           
        }
        return $model;
    }
}
