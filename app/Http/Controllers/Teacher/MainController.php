<?php

namespace App\Http\Controllers\Teacher;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\GetTeacherAvailabilityRequest;
use App\Http\Requests\Teacher\MakeTeacherRescheduleRequest;
use App\Jobs\SendRescheduleMailJob;
use App\Models\RescheduleRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\Services\JsonResponseService;
use App\View\Components\TeacherRescheduleComponent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    //
    public function RescheduleRequest(GetTeacherAvailabilityRequest $request)
    {

        try {
            if ($request->ajax()) {

                $Model = User::whereId($request->teacherid)->with(['availability.days.slots.routine_class'])->first();
                $view = new TeacherRescheduleComponent($Model);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }

    public function MakeRescheduleRequest(MakeTeacherRescheduleRequest  $request)
    {

        // here we add a week to the time we get because a class can be rescheduled to next week only
        $request['reschedule_date'] = Carbon::parse($request->reschedule_date)->addWeek();
        $request['reschedule_date'] = convertTimeToUTCzone($request['reschedule_date'], User::find(auth()->user()->id)->availability()->value('timezone'));    //convert time to UTC
        try {
            DB::beginTransaction();
            if ($request->ajax()) {
                $user = User::find(auth()->user()->id);
                $old_class_time = WeeklyClass::find($request->weekly_class_id)->class_time;


                $RescheduleRequest = $user->Reschedule_Requests()->updateOrCreate([
                    'weekly_class_id' => $request->weekly_class_id,
                    'student_id' => $request->student_id,
                    'teacher_id' => $user->id,           // as this function is only used by teacher
                ], [
                    'reschedule_date' =>  $request->reschedule_date,
                    'status' => 'pending',
                    'updated_by' => $user->id,   // last action performed on this request 
                    'reschedule_slot_id' => $request->slot,
                    'updated_by' => 'teacher',
                    'old_class_time' => $old_class_time,
                ]);

                $Student_data=Student::whereId($request->student_id)->with('course')->first();

                $details = [
                    'reschedule_date' =>  $request->reschedule_date,
                    'status' => 'pending',
                    'updated_by' => $user->id,   // last action performed on this request 
                    'reschedule_slot_id' => $request->slot,
                    'updated_by' => 'teacher',
                    'weekly_class_id' => $request->weekly_class_id,
                    'student_id' => $request->student_id,
                    'teacher_id' => $user->id,
                    'notification_type' => 'Rescheduled',
                    'slot' => $request->slot,
                    'Reschedule_Request_ID' => $user->Reschedule_Requests()->where([
                        'weekly_class_id' => $request->weekly_class_id,
                        'student_id' => $request->student_id,
                        'teacher_id' => $user->id,
                    ])->value('id'),            // beacause in case of update it was  null 
                    'teacher_coordinator_id' => User::find(auth()->user()->id)->Teacher_Coordinator()->value('id'),   // this is later used to get timezone of teacher co ordinator
                    'Requester' => 'Teacher',
                    'Mail_Type' => 'Reschedule_Request',
                    'old_class_time' => $old_class_time,
                    'Requester_Name'=>$user->name,           // who is making the request
                    'Other_Name'=>$Student_data->name,     // who is his second person i.e student h tu second requester teacher hoga
                    'Other_Type'=>'Student',
                    'Course_Name'=>$Student_data->course->title, 



                ];

                DB::commit();

                $emails = [];
                // $emails[]=User::find($request->teacher_id);   //find teacher co ordinator
                $emails[] = ['email' => Student::find($request->student_id)->user()->value('email'), 'user' => 'parent'];  //parent email address
                $emails[] = ['email' => User::find($details['teacher_id'])->Teacher_Coordinator()->value('email'), 'user' => 'coordinator'];  //parent email address

                $details = array_merge(['email' => $emails], $details);         // later here comes teacher's co ordinator email

                dispatch(new SendRescheduleMailJob($details));          // send mail to student that teacher has asked for class reschedule



                if ($RescheduleRequest->wasRecentlyCreated) {
                    // WeeklyClass::find($request->weekly_class_id)->update([
                    //     'status' => 'rescheduled',
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
