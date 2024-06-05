<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReschedulRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $details;
    public $timezone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
        $this->timezone = $details['Requester'] == 'student' ? Student::find($this->details['student_id'])->timezone : User::find($this->details['teacher_id'])->timezone;
        // $this->details['Requester_Name'] = $details['Requester'] == 'student' ? Student::find($this->details['student_id'])->name : User::find($this->details['teacher_id'])->name;
        $this->details['Old_Class'] = Carbon::parse($this->details['old_class_time']);
        // $this->details['Old_Class'] = convertTimeToUSERzone(WeeklyClass::whereId($this->details['weekly_class_id'])->value('class_time'),  $this->timezone);    // here we will say if it's user then user's timezone else teacher co ordinator timezone
        $this->details['New_Class'] = convertTimeToUSERzone(Carbon::parse($this->details['reschedule_date'])->addMinutes($this->details['slot'] * 30),  $this->timezone);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->view('emails.reschedule-mail')->with([
            'details' => $this->details
        ])->subject('AlQuran ' . str_replace("_", " ", $this->details['Mail_Type']) . ' Mail');
    }
}
