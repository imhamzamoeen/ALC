<?php

use Carbon\Carbon;

if (!function_exists('GetSecondsOfClass')) {
    function GetSecondsOfClass(array $data)
    {
        //bcz seconds are more accurate
        $seconds = 0;
        // it will get zoom attendence of student of teacher data and will return minutes 
        foreach ($data as $key => $value) { //  
            $seconds += Carbon::parse($value['join_time'])->diffInSeconds(Carbon::parse($value['leave_time']));
        }
        return $seconds;
    }
}

if (!function_exists('GetMinutesFromSeconds')) {
    function GetMinutesFromSeconds($seconds=0)
    {
       return  gmdate("H:i:s", $seconds);
    }
}





if (!function_exists('GetSecondsFromTime')) {
    function GetSecondsFromTime($minutes = '00:00:00')
    {
        $data = explode(":", $minutes);
        $seconds = 0;
        if (sizeof($data) == 3) {
            // hour minute second aaye
            $seconds += $data[0] * 3600;
            $seconds += $data[1] * 60;
            $seconds += $data[2];
        } else  if (sizeof($data) == 2) {
            //  minute second aaye
            $seconds += $data[0] * 60;
            $seconds += $data[1];
        } else  if (sizeof($data) == 1) {
            //   second aaye
            $seconds += $data[1];
        }
        return $seconds;



       
    }
}
