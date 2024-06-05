<?php

namespace App\Http\Controllers\TeacherCoordinator;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCoordinator\GetNotificationForCoordinator;
use App\Http\Requests\TeacherCoordinator\GetNotificationForCoordinatorRequest;
use App\Http\Requests\TeacherCoordinator\GetStudentOfTeacherRequest;
use App\Http\Requests\TeacherCoordinator\MakeRescheduleRequest;
use App\Http\Requests\TeacherCoordinator\RescheduleRequesOfTeacherCoordinatorRequest;
use App\Jobs\SendRescheduleMailJob;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use App\Services\JsonResponseService;
use App\View\Components\TeacherCoordinator\NotificationComponent;
use App\View\Components\TeacherCoordinator\RescheduleComponent;
use App\View\Components\TeacherCoordinator\TeacherStudentComponent;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    //
    public function GetStudentOfTeacher(GetStudentOfTeacherRequest $request)
    {
        try {
            if ($request->ajax()) {
                $Model = User::select('id', 'name', 'email')->whereId($request->teacher_id)->with(['Students' => function ($query) {
                    return $query->select('id', 'name', 'teacher_id');
                }])->first();
                $view = new TeacherStudentComponent($Model);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }

    public function RescheduleRequest(RescheduleRequesOfTeacherCoordinatorRequest $request)
    {

        try {
            if ($request->ajax()) {

                $CoordinatorData = User::select('id', 'name', 'email')->whereId(auth()->id())->with([
                    'Teacher' => function ($query) use ($request) {
                        $query->select('id', 'name', 'coordinated_by');
                        $query->whereId($request->teacherid);
                    }, 'Teacher.Students' => function ($query) use ($request) {
                        $query->select('id', 'name', 'user_id', 'teacher_id', 'course_id', 'timezone');
                        $query->whereId($request->studentid);
                    },
                    'Teacher.availability.days.slots.routine_class',
                ])->first();

                // return JsonResponseService::JsonSuccess("Success", $CoordinatorData);

                $view = new RescheduleComponent($CoordinatorData);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {
            return JsonResponseService::getJsonException($e);
        }
    }


    public function MakeRescheduleRequest(MakeRescheduleRequest $request)
    {


        try {
            $user = User::query()->find(auth()->user()->id);
            $old_class_time = WeeklyClass::find($request->weekly_class_id)->class_time;
            // here we add a week to the time we get because a class can be rescheduled to next week only
              $request['reschedule_date'] = Carbon::parse($request->reschedule_date)->addWeek();
            $request['reschedule_date'] = convertTimeToUTCzone($request['reschedule_date'], $user->timezone ?? 'UTC');    //convert time to UTC
            DB::beginTransaction();
            if ($request->ajax()) {;

                $RescheduleRequest = $user->Reschedule_Requests()->updateOrCreate([
                    'weekly_class_id' => $request->weekly_class_id,
                    'student_id' => $request->student_id,
                    'teacher_id' => $request->teacher_id,           // as this function is only used by teacher
                ], [
                    'reschedule_date' =>  $request->reschedule_date,
                    'status' => 'approved',
                    'updated_by' => $user->id,   // last action performed on this request 
                    'reschedule_slot_id' => $request->slot,
                    'updated_by' => 'teacher-coordintaor',
                    'old_class_time' => $old_class_time,
                ]);

                $Student_data=Student::whereId($request->student_id)->with('course')->first();

                $details = [
                    'reschedule_date' =>  $request->reschedule_date,
                    'status' => 'approved',
                    'updated_by' => $user->id,   // last action performed on this request 
                    'reschedule_slot_id' => $request->slot,
                    'updated_by' => 'teacher-coordintaor',
                    'weekly_class_id' => $request->weekly_class_id,
                    'student_id' => $request->student_id,
                    'teacher_id' => $request->teacher_id,
                    'notification_type' => 'Rescheduled',
                    'slot' => $request->slot,
                    'Reschedule_Request_ID' => $user->Reschedule_Requests()->where([
                        'weekly_class_id' => $request->weekly_class_id,
                        'student_id' => $request->student_id,
                        'teacher_id' => $request->teacher_id,
                    ])->value('id'),            // beacause in case of update it was  null 
                    'teacher_coordinator_id' => $user->id,   // this is later used to get timezone of teacher co ordinator
                    'Requester' => 'Teacher-Coordinator',
                    'Mail_Type' => 'Reschedule_Approve',
                    'old_class_time' => $old_class_time,
                    'Requester_Name'=>$user->name,           // who is making the request   i.e in case of teacher coordinator we are writing the teacher's coordinator name 
                    'Other_Name'=>$Student_data->name,     // who is his second person i.e student h tu second requester teacher hoga
                    'Other_Type'=>'student',
                    'Course_Name'=>$Student_data->course->title, 

                ];

                DB::commit();

                $emails = [];
                // $emails[]=User::find($request->teacher_id);   //find teacher co ordinator
                $emails[] = ['email' => Student::find($request->student_id)->user()->value('email'), 'user' => 'parent'];  //parent email address
                $emails[] = ['email' => User::find($request->teacher_id)->email, 'user' => 'teacher'];  //teacher email address

                $details = array_merge(['email' => $emails], $details);         //

                dispatch(new SendRescheduleMailJob($details));          // send mail to student that teacher has asked for class reschedule

                if ($RescheduleRequest->wasRecentlyCreated) {
                    WeeklyClass::find($request->weekly_class_id)->update([
                        'status' => 'rescheduled',
                        'teacher_status' => 'unattended',
                        'student_status' => 'unattended',   //class is rescheduled now both are unattended
                        'class_time' => Carbon::parse($request->reschedule_date)->addMinutes($request->slot * 30),
                    ]);
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


    public function GetNotifcationForCoordinator(GetNotificationForCoordinatorRequest $request)
    {
       $request['date']=Carbon::parse($request->date)->format('Y-m-d');
        try {
            if ($request->ajax()) {
              $Model=  User::select('id', 'name')->whereId(auth()->id())->with([
                'Teacher' => function ($query) use ($request)  {
                    $query->select('id', 'name', 'coordinated_by');
                    $query->whereHas('notifications', function ($query) use ($request)  {
                        $query->whereDate('created_at',$request->date);
                    });
                },
                'Teacher.Students' => function ($query) use ($request) {
                    $query->select('id','name','user_id','course_id','teacher_id');
                    $query->whereHas('notifications', function ($query) use ($request)  {
                        $query->whereDate('created_at',$request->date);
                    });
                },
                'Teacher.Students.course' => function ($query) {
                    $query->select('id', 'title');
                },
                'Teacher.Students.user' => function ($query) {
                    $query->select('id', 'name');
                },
                'Teacher.Students.notifications' => function ($query) use ($request)  {
                  $query->whereDate('created_at',$request->date);
                },
                'Teacher.notifications' => function ($query) use ($request)  {
                    $query->whereDate('created_at',$request->date);
        
                },
            ])->first();
                $view = new NotificationComponent($Model);   //incase of teacher we load the course function from here bcz student model is always fetched with corses
                $view = $view->resolveView()->with($view->data())->render();
                return JsonResponseService::JsonSuccess("Success", $view);
            }
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
        } catch (Exception $e) {   //  catch all Exceptions
            return JsonResponseService::getJsonException($e);
        }
    }
}
