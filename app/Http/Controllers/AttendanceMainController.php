<?php

namespace App\Http\Controllers;

use App\Classes\AlertMessages;
use App\Http\Requests\GetAttendanceRequest;
use App\Http\Requests\GetTeacherAttendanceRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\Services\JsonResponseService;
use App\Traits\StateHelperClass;
use App\View\Components\AttendanceComponent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AttendanceMainController extends Controller
{

    use StateHelperClass;
    public function GetAttendance(GetAttendanceRequest $request)
    {

        /* this bassically chceks student attendace */

        try {
                
                $classStatus = '';
                $attendance = collect();
                //attendance Query 
                 $Data = WeeklyClass::where(['student_id' => $request->student_id])->whereBetween('class_time', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ])->cursor();
                foreach ($Data as $eachattendance) {
                    //since we have attended and unattended in db so only need to take scheduled and rescheduled 
                    if($eachattendance->student_status=='rescheduled' || $eachattendance->student_status=='scheduled'){
                        $classStatus = 'scheduled';
                    }
                    else{
                        $classStatus = lcfirst($eachattendance->student_status);
                    }
                  
                    // if ($eachattendance->student_status == "attended") {
                    //     $classStatus = 'Present';
                    // } elseif ($eachattendance->student_status == "unattended") {
                    //     $classStatus = 'Absent';
                    // } else {
                    //     $classStatus = $eachattendance->student_status;
                    // }
                    $attendance->push([
                        'title' => $classStatus,
                        'start' => convertTimeToUSERzone(Carbon::parse($eachattendance->class_time), User::find($request->asking_id)->timezone)->format(
                            'Y-m-d H:i:s'
                        ),
                        'className' => lcfirst($classStatus),
                    ]);
                }
              

    
                $view = new AttendanceComponent($attendance, Student::find($request->student_id));  //this get all the attendacne and student id for details
                   $view = $view->resolveView()->with($view->data())->render();
               return  JsonResponseService::JsonSuccess("Success", $view);
            
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }

    public function GetTeacherAttendance(GetTeacherAttendanceRequest $request)
    {
        try {
            if ($request->ajax()) {
                $classStatus = '';
                $attendance = collect();
                //attendance Query 
                 $Data = WeeklyClass::where(['teacher_id' => $request->teacher_id])->whereBetween('class_time', [
                    Carbon::now()->startOfYear(),
                    Carbon::now()->endOfYear(),
                ])->cursor();
                foreach ($Data as $eachattendance) {
                    //since we have attended and unattended in db so only need to take scheduled and rescheduled 

                    if($eachattendance->teacher_status=='rescheduled' || $eachattendance->teacher_status=='scheduled'){
                        $classStatus = 'scheduled';
                    }
                    else{
                        $classStatus = lcfirst($eachattendance->teacher_status);
                    }

                    // if ($eachattendance->teacher_status == "attended") {
                    //     $classStatus = 'Present';
                    // } elseif ($eachattendance->teacher_status == "unattended") {
                    //     $classStatus = 'Absent';
                    // } else {
                    //     $classStatus = $eachattendance->teacher_status;
                    // }
                    $attendance->push([
                        'title' => $classStatus,
                        'start' => convertTimeToUSERzone(Carbon::parse($eachattendance->class_time),User::find($request->asking_id)->timezone)->format(
                            'Y-m-d H:i:s'
                        ),
                        'className' => lcfirst($classStatus),
                    ]);
                }
              
              
                $view = new AttendanceComponent($attendance, User::find($request->teacher_id));  //this get all the attendacne and student id for details
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }


    
}
