<?php

namespace App\Services;

use App\Jobs\SendJobErrorMailJob;
use App\Mail\SendJobError;
use App\Models\TrialClass;
use App\Models\WeeklyClass;
use App\Traits\SDKTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ZoomWebhookCalculationService
{
    use SDKTrait;




    public function __construct()
    {
        //

    }
    private function StoreWeeklyClassSessionId($response)
    {
        try {
            $Weekly_class = WeeklyClass::query()->Where('session_key', $response['session_key'])->firstOrFail();
            $Weekly_class->update([
                'Session_Id' => $response['id'],
            ]);
        } catch (Exception $e) {
            Log::info("StoreWeeklyClassSessionId failed");
            dispatch(new SendJobErrorMailJob(['function' => 'StoreWeeklyClassSessionId', 'message' => $e->getMessage()]));
        }
    }

    private function StoreTrialClassSessionId($response)
    {
        try {
            $Trialclass = TrialClass::query()->Where('session_key', $response['session_key'])->firstOrFail();
            $Trialclass->update([
                'Session_Id' => $response['id'],
            ]);
        } catch (Exception $e) {
            Log::info("StoreTrialClassSessionId failed");
            dispatch(new SendJobErrorMailJob(['function' => 'StoreTrialClassSessionId', 'message' => $e->getMessage()]));
        }
    }
    private function GetModelOfWeeklyClass($response): WeeklyClass
    {
        try {
            return  WeeklyClass::query()->where('Session_Id', $response['payload']['object']['session_id'])->firstOrFail();
        } catch (Exception $e) {
            Log::info("GetModelOfWeeklyClass failed");
            dispatch(new SendJobErrorMailJob(['function' => 'GetModelOfWeeklyClass', 'message' => $e->getMessage()]));
        }
    }

    private function GetModelOfTrialClass($response): TrialClass
    {
        try {
            return   TrialClass::query()->where('Session_Id', $response['payload']['object']['session_id'])->firstOrFail();
        } catch (Exception $e) {
            Log::info("GetModelOfTrialClass failed");
            dispatch(new SendJobErrorMailJob(['function' => 'GetModelOfTrialClass', 'message' => $e->getMessage()]));
        }
    }





    public function StoreSessionIdInWeeklyClass(array $data)
    {
        try {
            // Log::info($data['payload']['object']['id']);
            DB::transaction(function () use ($data) {
                $response = $this->GetDetailOfSession($data['payload']['object']['id'], 'live');
                // Log::info("response");
                // Log::info($response);
                if (!empty($response)) {
                    // the api got the response 
                    Log::info("inside");
                    if ($data['payload']['object']['session_key'][0] == 'W' && $data['payload']['object']['session_key'][1] == 'K') {
                        // its data of weekly class
                        self::StoreWeeklyClassSessionId($response);
                    } elseif ($data['payload']['object']['session_key'][0] == 'D' && $data['payload']['object']['session_key'][1] == 'M') {
                        self::StoreTrialClassSessionId($response);
                    }
                }
            });
        } catch (Exception $e) {
            Log::info("store session id failed");
            Log::debug($e->getMessage());
            dispatch(new SendJobErrorMailJob(['function' => 'StoreSessionIdInWeeklyClass', 'message' => $e->getMessage()]));
        }
    }
    public function StoreSessionAttendence(array $data)
    {

        try {
            DB::transaction(function () use ($data) {
                Log::info("Store session attendance inside");
                $response = $this->GetUsersOfSession($data['payload']['object']['id'], 'past');
                if (!empty($response)) {
                    $weekly_class_data = WeeklyClass::query()->where('Session_Id', $data['payload']['object']['id'])->firstOrFail();
                    $attendence = [];
                    foreach ($response as $key => $eachuser) {
                        //as we only need to store the teacher and student attendance '
                        if (strpos($eachuser['user_key'], 'TCH') == true) {
                            Log::info("teacher found");
                            $attendence[] = [
                                'join_time' => Carbon::parse($eachuser['join_time'])->format('Y-m-d H:i:s'),
                                'leave_time' => Carbon::parse($eachuser['leave_time'])->format('Y-m-d H:i:s'),
                                'userable_id' => $weekly_class_data->teacher_id,
                                'userable_type' => 'App\Models\User',
                            ];
                            // teacher ki attendance aai h
                            // WeeklyClass::query()->wherer('Session_Id',$data['payload']['object']['id'])
                        } else if (strpos($eachuser['user_key'], 'STD') == true) {
                            $attendence[] = [
                                'join_time' => Carbon::parse($eachuser['join_time'])->format('Y-m-d H:i:s'),
                                'leave_time' => Carbon::parse($eachuser['leave_time'])->format('Y-m-d H:i:s'),
                                'userable_id' => $weekly_class_data->student_id,
                                'userable_type' => 'App\Models\Student',
                            ];
                            Log::info($attendence);
                            // student ki attendance aai h 
                        }
                    }
                    $weekly_class_data->ClassAttendance()->createMany($attendence);
                }
            });
        } catch (Exception $e) {
            Log::info("store session attendence failed");
            Log::debug($e->getMessage());
            dispatch(new SendJobErrorMailJob(['function' => 'StoreSessionAttendence', 'message' => $e->getMessage()]));
        }
    }


    public function MarkAttendenceOfClass($data = [])
    {
        if (empty($data))
            return;
        try {
            // Log::info($data['payload']['object']['id']);
            DB::transaction(function () use ($data) {
                Log::info("MarkAttendenceOfClass inside");
                if ($data['payload']['object']['session_key'][0] == 'W' && $data['payload']['object']['session_key'][1] == 'K') {
                    // its data of weekly class
                    $Model = self::GetModelOfWeeklyClass($data);
                } elseif ($data['payload']['object']['session_key'][0] == 'D' && $data['payload']['object']['session_key'][1] == 'M') {
                    // its data of trial class
                    $Model = self::GetModelOfTrialClass($data);
                }




                $teacher_attendance = $Model->ClassAttendance->where('userable_type', 'App\Models\User')->toArray();
                $student_attendance = $Model->ClassAttendance->where('userable_type', 'App\Models\Student')->toArray();
                $teacher_seconds = GetSecondsOfClass($teacher_attendance);      // this return total seconds  a teacher joined class
                $student_seconds = GetSecondsOfClass($student_attendance);
                $Model->update([
                    'teacher_status' =>  GetStatusFromTeacherSeconds($teacher_seconds),
                    'student_status' =>  GetStatusFromStudentSeconds($student_seconds),
                ]);
            });
        } catch (Exception $e) {
            Log::info("Mark Attendance failed");
            Log::debug($e->getMessage());
            dispatch(new SendJobErrorMailJob(['function' => 'MarkAttendenceOfClass', 'message' => $e->getMessage()]));
        }
    }


    public function MarkClassStatus($session_id = null)
    {

        // this is used to mark the status of class 
        if (is_null($session_id))
            return;
        try {
            // Log::info($data['payload']['object']['id']);
            DB::transaction(function () use ($session_id) {
                // Log::info("MarkClassStatus inside");
                // Log::info($session_id.' sending');
                $response = $this->GetDetailOfSession($session_id, 'past');
                if (!empty($response)) {
                    // Log::info("isaide of mark ckass status ".$response['duration']);
                    $Weekly_class = WeeklyClass::query()->Where('Session_Id', $session_id)->firstOrFail();
                    $Weekly_class->update([
                        'status' =>  GetClassStatus(GetSecondsFromTime($response['duration'])),
                        'class_duratoin' => $response['duration'],
                    ]);
                }
                // it means that session not found and we wiill have to calculate from our side 
                else if (empty($response)) {
                    $Weekly_class = WeeklyClass::query()->Where('Session_Id', $session_id)->firstOrFail()->ClassAttendance->toArray();
                    $duration = GetMinutesFromSeconds(GetSecondsOfClass($Weekly_class));
                    $Weekly_class->update([
                        'status' =>  GetClassStatus(GetSecondsFromTime($duration)),
                        'class_duration' => $duration,
                    ]);
                }
            });
        } catch (Exception $e) {
            Log::info("Mark class status failed");
            Log::debug($e->getMessage());
            dispatch(new SendJobErrorMailJob(['function' => 'MarkClassStatus', 'message' => $e->getMessage()]));
        }
    }


    public function StoreUserAttendanceJoin(array $data = [])
    {

        // this is used to mark the status of class 
        if (empty($data))
            return;
        try {

            DB::transaction(function () use ($data) {
                Log::info(" store attendance join inside ");

                if ($data['payload']['object']['session_key'][0] == 'W' && $data['payload']['object']['session_key'][1] == 'K') {
                    // its data of weekly class
                    $Model = self::GetModelOfWeeklyClass($data);
                } elseif ($data['payload']['object']['session_key'][0] == 'D' && $data['payload']['object']['session_key'][1] == 'M') {
                    // its data of trial class
                    $Model = self::GetModelOfTrialClass($data);
                }
                Log::info($Model);

                if (!is_null($Model)) {
                    $attendence = [];
                    if (strpos($data['payload']['object']['user']['user_key'], 'TCH') == true) {
                        Log::info("teacher found");
                        $attendence[] = [
                            'join_time' => Carbon::parse($data['payload']['object']['user']['join_time'])->format('Y-m-d H:i:s'),
                            'userable_id' => $Model->teacher_id,
                            'userable_type' => 'App\Models\User',
                        ];
                        // teacher ki attendance aai h
                        // WeeklyClass::query()->wherer('Session_Id',$data['payload']['object']['id'])
                    } else if (strpos($data['payload']['object']['user']['user_key'], 'STD') == true) {
                        $attendence[] = [
                            'join_time' => Carbon::parse($data['payload']['object']['user']['join_time'])->format('Y-m-d H:i:s'),
                            'userable_id' => $Model->student_id,
                            'userable_type' => 'App\Models\Student',
                        ];
                   
                        Log::info($attendence);
                    }
                    $Model->ClassAttendance()->createMany($attendence);
            
                }
            });
        } catch (Exception $e) {
            Log::info("Store user attendance join with webhook failed ");
            Log::debug($e->getMessage());
            dispatch(new SendJobErrorMailJob(['function' => 'StoreUserAttendanceJoin', 'message' => $e->getMessage()]));
        }
    }


    public function StoreUserAttendanceLeft(array $data = [])
    {

        // this is used to mark the status of class 
        if (empty($data))
            return;
        try {

            DB::transaction(function () use ($data) {
                Log::info(" store attendance Left inside ");
                if ($data['payload']['object']['session_key'][0] == 'W' && $data['payload']['object']['session_key'][1] == 'K') {
                    // its data of weekly class
                    $Model = self::GetModelOfWeeklyClass($data);
                } elseif ($data['payload']['object']['session_key'][0] == 'D' && $data['payload']['object']['session_key'][1] == 'M') {
                    // its data of trial class
                    $Model = self::GetModelOfTrialClass($data);
                }

                $Model = $Model->ClassAttendance->sortByDesc('id');

                if (!is_null($Model)) {
              
                    if (strpos($data['payload']['object']['user']['user_key'], 'TCH') == true) {
                        $class = $Model->where('userable_type', 'App\Models\User')->firstOrFail();
                        Log::info("teacher found");
                        $attendence = [
                            'leave_time' => Carbon::parse($data['payload']['object']['user']['leave_time'])->format('Y-m-d H:i:s'),
                        ];
                        $class->update($attendence);
                        // teacher ki attendance aai h

                    } else if (strpos($data['payload']['object']['user']['user_key'], 'STD') == true) {
                        $class = $Model->where('userable_type', 'App\Models\Student')->firstOrFail();
                        $attendence = [
                            'leave_time' => Carbon::parse($data['payload']['object']['user']['leave_time'])->format('Y-m-d H:i:s'),
                        ];
                        $class->update($attendence);
                        }
                       
                    }
                
            });
        } catch (Exception $e) {
            Log::info("Store user attendance left with webhook failed ");
            Log::debug($e->getMessage());
            dispatch(new SendJobErrorMailJob(['function' => 'StoreUserAttendanceLeft', 'message' => $e->getMessage()]));
        }
    }
}
