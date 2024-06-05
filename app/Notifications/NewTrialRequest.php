<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTrialRequest extends Notification implements ShouldQueue
{
    use Queueable;
    protected $trialRequest;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trialRequest)
    {
        $this->trialRequest = $trialRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $availability = '';
            if(count($this->trialRequest->days)){
                foreach($this->trialRequest->days as $day){
                   $availability .=   __(\App\Classes\AlQuranConfig::DaysMin[$day['day_id']]). ',';
                }
            }
        return (new MailMessage)
            ->subject('New Trial Requested')
            ->view(
                'emails.mail-master',
                [
                    'header'        => true,
                    'footer'        => false,
                    'regards'       => true,
                    'query'       => false,
                    'paragraphs'    => [
                        [
                            ['heading2'  => 'Dear Support Team!'],
                            ['line'      => 'A new trial has been requested by a customer'],
                        ],
                        [
                            ['line'      => __('Following are the details:')],
                            ['list'      => [
                                'Customer Name'  => @$this->trialRequest->student->user->name,
                                'Student Name'      => @$this->trialRequest->student->name,
                                'Age'      => @$this->trialRequest->student->age,
                                'Gender'      => @$this->trialRequest->student->gender,
                                'Timezone'      => @$this->trialRequest->student->timezone,
                                'Course'            => @$this->trialRequest->student->course->title,
                                'Availability'      => @$availability,
                                /*'Date (If Any)'     => !is_null($this->trialRequest->request_date) ? format_time(@$this->trialRequest->request_date) : '--',*/
                            ]
                            ]
                        ],
                    ]
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
