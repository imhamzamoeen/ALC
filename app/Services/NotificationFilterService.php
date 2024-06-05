<?php

namespace App\Services;

use App\Jobs\SendRescheduleMailJob;
use App\Models\Notification;
use App\Models\RescheduleRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationFilterService
{
    public function __construct()
    {
        //
    }

    public static function FilterNotification($request)
    {

        try {
            // now we are getting appropriatea record 

            $Reschedule = RescheduleRequest::find($request->reschedule_class_id);

            if (property_exists($request, 'teacher_id')) {
                // its teacher logged in and perforing the action but we will have to first check whether teacher can approve the request or not 
                if ($Reschedule->Requestable_id == $request->teacher_id) {

                    // teacher made that request and now want to change the request it's not possible 
                    return JsonResponseService::JsonFailed("You cannot Approve Your Own Request", []);
                } else {
                    DB::beginTransaction();
                    $Reschedule->update([
                        'status' => 'disapproved',
                        'updated_by' => 'teacher'
                    ]);
                    $old_weekly_class = WeeklyClass::find($request->weekly_class_id);
                    $old_class_time = $old_weekly_class->class_time;
                    // $weeklyclass_update = $old_weekly_class->update([
                    //     //incase of disapprove we change status of reschedule class to schedueled again as it changes when we put a request of reschedule
                    //     'status' => 'scheduled',
                    // ]);
                    $WeeklyClass = WeeklyClass::find($request->weekly_class_id);
                    $RescheduleData = RescheduleRequest::find($request->reschedule_class_id);
                    $notiication_object = Notification::query()->find($request->notification_id);
                    $notification_content = json_decode($notiication_object->json);
                    $notification_update = $notiication_object->update([
                        'remindable' => 0,        //no need to remind him as he has taken action
                        'is_seen' => 1, // he has seen that notification 
                        'json' => json_encode([
                            'type' => 'Rescheduled',
                            'WeeklyClass' => $WeeklyClass->toArray(),
                            'RescheduleRequest' => $RescheduleData->toArray(),
                            'created_at' => $Reschedule->reschedule_date,   // later we will look at trialclassupdate.php
                            'old_class_time' => $old_class_time,
                            'Requester_Name' => $notification_content->Requester_Name,
                            'Other_Name' => $notification_content->Other_Name,
                            'Course_Name' => $notification_content->Course_Name,
                            'Requester' => $notification_content->Requester,
                            'Other_Type' => $notification_content->Other_Type,

                        ]),
                    ]);

                    //reschedule request is approved now change the weekly class status and then notification 
                    if ($notification_update > 0) {
                        $details = [
                            'notification_check_fail' => 'True',
                            'student_id' => $RescheduleData->student_id,
                            'teacher_id' => $RescheduleData->teacher_id,
                            'weekly_class_id' => $WeeklyClass->id,
                            'reschedule_date' => $RescheduleData->reschedule_date,
                            'slot' => $RescheduleData->reschedule_slot_id,
                            'old_class_time' => $old_class_time,
                            // 'Requester' => 'teacher',
                            'Mail_Type' => 'Reschedule_Disapprove',
                            'Requester_Name' => $notification_content->Requester_Name,
                            'Other_Name' => $notification_content->Other_Name,
                            'Course_Name' => $notification_content->Course_Name,
                            'Requester' => $notification_content->Requester,
                            'Other_Type' => $notification_content->Other_Type,
                        ];

                        // as teacher is is disapproving so student's parent and teacher co ordinator 
                        $emails = [];
                        // $emails[]=User::find($request->teacher_id);   //find teacher co ordinator
                        $emails[] = ['email' => Student::find($details['student_id'])->user()->value('email'), 'user' => 'parent'];  //parent email address
                        $emails[] = ['email' => User::find($details['teacher_id'])->Teacher_Coordinator()->value('email') ?? '', 'user' => 'coordinator'];  //parent email address


                        $details = array_merge(['email' => $emails], $details);
                        dispatch(new SendRescheduleMailJob($details));
                        //both updates worked perfectily
                        DB::commit();
                        return JsonResponseService::JsonSuccess("Request For Reschedule Dis Approved Successfully", $request->reschedule_class_id);
                    } else {
                        DB::rollback();
                        return JsonResponseService::JsonFailed("Failed to update the Rescheule Request", $request->reschedule_class_id);
                    }
                }
            } elseif (property_exists($request, 'student_id')) {

                //student is doing 
                if ($Reschedule->Requestable_id == $request->student_id) {

                    // Student  made that request and now want to change the request it's not possible 
                    return JsonResponseService::JsonFailed("You cannot Approve Your Own Request", []);
                } else {
                    DB::beginTransaction();
                    //teacher made the reschedule request and now want to change that request 
                    $Reschedule->update([
                        'status' => 'disapproved',
                        'updated_by' => 'student'
                    ]);
                    $old_weekly_class = WeeklyClass::find($request->weekly_class_id);
                    $old_class_time = $old_weekly_class->class_time;
                    // $weeklyclass_update =   $old_weekly_class->update([
                    //     //incase of disapprove we change status of reschedule class to schedueled again as it changes when we put a request of reschedule
                    //     'status' => 'scheduled',
                    // ]);
                    $WeeklyClass = WeeklyClass::find($request->weekly_class_id);
                    $RescheduleData = RescheduleRequest::find($request->reschedule_class_id);
                    $notiication_object = Notification::query()->find($request->notification_id);
                    $notification_content = json_decode($notiication_object->json);
                    $notification_update = $notiication_object->update([
                        'remindable' => 0,        //no need to remind him as he has taken action
                        'is_seen' => 1, // he has seen that notification 
                        'json' => json_encode([
                            'type' => 'Rescheduled',
                            'WeeklyClass' => $WeeklyClass->toArray(),
                            'RescheduleRequest' =>   $RescheduleData->toArray(),
                            'created_at' => $Reschedule->reschedule_date,   // later we will look at trialclassupdate.php
                            'old_class_time' => $old_class_time,
                            'Requester_Name' => $notification_content->Requester_Name,
                            'Other_Name' => $notification_content->Other_Name,
                            'Course_Name' => $notification_content->Course_Name,
                            'Requester' => $notification_content->Requester,
                            'Other_Type' => $notification_content->Other_Type,

                        ]),
                    ]);

                    //reschedule request is approved now change the weekly class status and then notification 
                    if ($notification_update > 0) {

                        $details = [
                            'notification_check_fail' => 'True',
                            'student_id' => $RescheduleData->student_id,
                            'teacher_id' => $RescheduleData->teacher_id,
                            'weekly_class_id' => $WeeklyClass->id,
                            'reschedule_date' => $RescheduleData->reschedule_date,
                            'slot' => $RescheduleData->reschedule_slot_id,
                            'old_class_time' => $old_class_time,
                            // 'Requester' => 'student',
                            'Mail_Type' => 'Reschedule_Disapprove',
                            'Requester_Name' => $notification_content->Requester_Name,
                            'Other_Name' => $notification_content->Other_Name,
                            'Course_Name' => $notification_content->Course_Name,
                            'Requester' => $notification_content->Requester,
                            'Other_Type' => $notification_content->Other_Type,
                        ];

                           Log::info($details['teacher_id']);
                        // as student is is disapproving so student's parent and teacher co ordinator and teacher  should get mail
                        $emails = [];
                        // $emails[]=User::find($request->teacher_id);   //find teacher co ordinator
                        $emails[] = ['email' => Student::find($details['student_id'])->user()->value('email'), 'user' => 'parent'];  //parent email address
                        $emails[] = ['email' => User::find($details['teacher_id'])->Teacher_Coordinator()->value('email')?? '', 'user' => 'coordinator'];  //parent email address
                        $emails[] = ['email' => User::find($details['teacher_id'])->email, 'user' => 'teacher'];  //parent email address

                        $details = array_merge(['email' => $emails], $details);
                        dispatch(new SendRescheduleMailJob($details));          // send mail to student that teacher has asked for class reschedule
                        //both updates worked perfectily
                        DB::commit();
                        return JsonResponseService::JsonSuccess("Request For Reschedule Dis Approved Successfully", $request->reschedule_class_id);
                    } else {
                        DB::rollback();
                        return JsonResponseService::JsonFailed("Failed to update the Rescheule Request", $request->reschedule_class_id);
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }
}
