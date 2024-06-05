<?php

namespace App\Http\Controllers\Student;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\GetStudentAvailabilityRequest;
use App\Http\Requests\Student\MakeStudentRescheduleRequest;
use App\Jobs\SendRescheduleMailJob;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\Services\JsonResponseService;
use App\View\Components\Student\StuentRescheduleComponent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    //
    public function RescheduleRequest(GetStudentAvailabilityRequest $request)
    {

        try {
            if ($request->ajax()) {
                $Model = Student::whereId($request->studentid)->with('teacher.availability.days.slots.routine_class')->first();
                $view = new StuentRescheduleComponent($Model);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }

    public function MakeRescheduleRequest(MakeStudentRescheduleRequest  $request)
    {   
        $StudentData=Student::whereId($request->student_id)->with('course')->first();
        $old_class_time=WeeklyClass::find($request->weekly_class_id)->class_time;    

        // here we add a week to the time we get because a class can be rescheduled to next week only
        $request['reschedule_date'] = Carbon::parse($request->reschedule_date)->addWeek();
        $request['reschedule_date'] = convertTimeToUTCzone($request['reschedule_date'],$StudentData->timezone);    //convert time to UTC
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                // $user = User::find(auth()->user()->id);

                $RescheduleRequest = $StudentData->Reschedule_Requests()->updateOrCreate([
                    'weekly_class_id' => $request->weekly_class_id,
                    'student_id' => $request->student_id,
                    'teacher_id' => $request->teacher_id,           // as this function is only used by teacher
                ], [
                    'reschedule_date' =>  $request->reschedule_date,
                    'status' => 'pending',
                    'updated_by' => 'student',   // last action performed on this request 
                    'reschedule_slot_id' => $request->slot,
                    'old_class_time'=>$old_class_time,
              
                ]);


                $details = [
                    'reschedule_date' =>  $request->reschedule_date,
                    'status' => 'pending',
                    'updated_by' => $request->student_id,   // last action performed on this request 
                    'reschedule_slot_id' => $request->slot,
                    'updated_by' => 'student',
                    'weekly_class_id' => $request->weekly_class_id,
                    'student_id' => $request->student_id,
                    'teacher_id' =>  $request->teacher_id,
                    'notification_type' => 'Rescheduled',
                    'slot' => $request->slot,
                    'Reschedule_Request_ID' => $StudentData->Reschedule_Requests()->where([
                        'weekly_class_id' => $request->weekly_class_id,
                        'student_id' => $request->student_id,
                        'teacher_id' =>$request->teacher_id,
                    ])->value('id'),            // beacause in case of update it was  null 
                    'teacher_coordinator_id'=>User::find($request->teacher_id)->Teacher_Coordinator()->value('id'),   // this is later used to get timezone of teacher co ordinator
                     'Requester'=>'Student',
                     'Mail_Type'=>'Reschedule_Request',
                    'old_class_time'=>$old_class_time,
                    'Requester_Name'=>$StudentData->name,           // who is making the request
                    'Other_Name'=>User::find($request->teacher_id)->name,     // who is his second person i.e student h tu second requester teacher hoga
                    'Other_Type'=>'Teacher',
                    'Course_Name' =>$StudentData->course->title, 

                ];

                DB::commit();
              
                $emails = [];
                // $emails[]=User::find($request->teacher_id);   //find teacher co ordinator
                $emails[] = ['email' => User::find($request->teacher_id)->email, 'user' => 'teacher'];  //teacher email address
                $emails[] = ['email' => Student::find($request->student_id)->user()->value('email'), 'user' => 'parent'];  //parent email address
                $emails[] = ['email' => User::find($details['teacher_id'])->Teacher_Coordinator()->value('email'), 'user' => 'coordinator'];  //parent email address
         
                $details = array_merge(['email' => $emails], $details);         // later here comes teacher's co ordinator email

                dispatch(new SendRescheduleMailJob($details));          // send mail to student that teacher has asked for class reschedule



                if ($RescheduleRequest->wasRecentlyCreated) {
                    // WeeklyClass::find($request->weekly_class_id)->update([
                    //     'status' => 'reschedul ed',
                    // ]);

                    // create a notification against student to appreove or disapprove
                    return JsonResponseService::JsonSuccess("Request For Reschedule Sent Successfully", $request->weekly_class_id);
                }

                return JsonResponseService::JsonSuccess("Request For Reschedule Re sent Successfully", $request->weekly_class_id);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }
}
