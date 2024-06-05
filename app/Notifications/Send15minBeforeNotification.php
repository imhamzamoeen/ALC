<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Send15minBeforeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $details;
    public function __construct($details)
    {
        //
        $this->details = $details;
        generate_notification_by_type(
            'class_update',
            [
                'user_id'       => $this->details['teacher_id'],
                'student_id'    => $this->details['student_id'],
                'remindable'    => 1,
                'remind_at'     => Carbon::parse($this->details['class_time'])->addMinutes(13)
            ],
            [
                'type' => 'class_update',
                'WeeklyClass' => $this->details,
                'created_at' => now(),
            ]
        );
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
        $details = $this->details->toArray();
        $user = $notifiable;

        return (new MailMessage)->view(
            'emails.partials.15MinBefore.mail',
            compact('details', 'user')
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
