<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindCustomerForUpcomingTrialClass extends Notification implements ShouldQueue
{
    use Queueable;

    protected $trialClass;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trialClass)
    {
        $this->trialClass = $trialClass;
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
        return (new MailMessage)
            ->subject('Trial Class Reminder')
            ->view(
                'emails.mail-master',
                [
                    'header'        => true,
                    'footer'        => true,
                    'regards'       => true,
                    'query'       => true,
                    'url'           => ['Join Class' , @$this->trialClass->zoom_link],
                    'paragraphs'    => [
                        [
                            ['heading2'  => 'Dear '. @$this->trialClass->trialRequest->student->user->name.'!'],
                            ['line'      => __('Your student have an upcoming trial class in next 30 mins')],
                        ],
                        [
                            ['line'      => __('Following are the details:')],
                            ['list'      => [
                                __('Student')     => @$this->trialClass->trialRequest->student->name,
                                __('Course')      => @$this->trialClass->trialRequest->student->course->title,
                                __('Teacher')     => @$this->trialClass->trialRequest->student->teacher->name,
                                __('Starts at')   => format_time(convertTimeToUSERzone($this->trialClass->starts_at, $this->trialClass->trialRequest->student->timezone), false),
                            ]
                            ]
                        ],
                        [
                            ['button'   => ['Join Class' , @$this->trialClass->zoom_link]]
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
