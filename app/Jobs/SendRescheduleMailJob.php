<?php

namespace App\Jobs;

use App\Mail\ReschedulRequestMail;
use App\Models\RescheduleRequest;
use App\Models\WeeklyClass;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRescheduleMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            // send the mail of reschedule to the customer and teacher co ordinator
            foreach ($this->details['email'] as $key => $mails) {
                $this->details['user'] = $mails['user'];
                Mail::to($mails['email'])
                    ->send(new ReschedulRequestMail($this->details));
            }
            if (!array_key_exists('notification_check_fail', $this->details)) {
                // we will send notification check fail when a rescheule request is approved or disapproved becuse we update the notification status in controller
                $weekly_class = WeeklyClass::find($this->details['weekly_class_id']);
                // this adds enter to notification table 
                generate_notification_by_type(
                    $this->details['notification_type'],
                    [
                        'user_id'       => $this->details['teacher_id'],
                        'student_id'    => $this->details['student_id'],
                        'remindable'    => 1,
                        'remind_at'     => Carbon::parse($this->details['reschedule_date'])->subHour()    // here the requested class time for student will come we will convert this time to student zone and then check if one hour is remaining then send him notification
                    ],
                    [
                        'type' => $this->details['notification_type'],
                        'WeeklyClass' => $weekly_class->toArray(),
                        'RescheduleRequest' => RescheduleRequest::find($this->details['Reschedule_Request_ID'])->toArray(),
                        'created_at' => $this->details['reschedule_date'],   // later we will look at trialclassupdate.php
                        'old_class_time' =>  $this->details['old_class_time'],
                        'Requester_Name' => $this->details['Requester_Name'],           // who is making the request
                        'Other_Name' => $this->details['Other_Name'],     // who is his second person i.e student h tu second requester teacher hoga
                        'Course_Name' => $this->details['Course_Name'],
                        'Requester' => $this->details['Requester'],
                        'Other_Type' => $this->details['Other_Type'],


                    ]
                );
            }
        } catch (Exception $e) {

            Log::debug($e->getMessage());
        }
    }
}
