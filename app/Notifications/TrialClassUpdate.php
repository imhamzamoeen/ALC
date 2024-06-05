<?php

namespace App\Notifications;

use App\Classes\Enums\StatusEnum;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class TrialClassUpdate extends Notification implements ShouldQueue
{
    use Queueable;
    public $trialClass;
    public $type;
    public $student;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trialClass, $type)
    {
        $this->trialClass = $trialClass->load('trialRequest.student.teacher');
        $this->type = ($type == StatusEnum::TrialUnScheduled) ? 'Scheduled' : 'Updated' ;
        $this->student= Student::whereId($this->trialClass->trialRequest->student->id)->with(['user','course','teacher'])->first();
        generate_notification_by_type('trial_update',
            [
                'user_id'       => $this->trialClass->teacher_id,
                'student_id'    => $this->trialClass->trialRequest->student->id,
                'remindable'    => 1,
                'remind_at'     => Carbon::parse($this->trialClass->starts_at)->subHour()
            ],
            [
                'type' => $this->type,
                'trialClass' => $this->trialClass->toArray(),
                'created_at' => now(),
            ]);
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

        $details = $this->trialClass;
        $user = $notifiable;
        $type=$this->type;
        $student=$this->student->toArray();
     
        return (new MailMessage)->view(
            'emails.partials.Trial.mail',
            compact('details', 'user','type','student')
        );

        //dd($this->trialClass->trialRequest->student);
       /* return (new MailMessage)
                    ->subject('Trial Class '.$this->type)
                    ->greeting('Hello '. @$this->trialClass->trialRequest->student->user->name.'!')
                    ->line(__('A trial class has been '.$this->type.' against your request.'). __('Following are the details:'))
                    ->line('')
                    ->line('Student: '. @$this->trialClass->trialRequest->student->name)
                    ->line('Course: '. @$this->trialClass->trialRequest->student->course->title)
                    ->line('Teacher: '. @$this->trialClass->teacher_name)
                    ->line('Starts at: '. Carbon::parse(@$this->trialClass->starts_at)->format('d M, Y h:s A'). '('.Carbon::parse(@$this->trialClass->starts_at)->diffForHumans().')')

                    ->action('Join Class', @$this->trialClass->zoom_link)
                    ->line('Thank you for using our application!');*/
        // return (new MailMessage)
        //     ->subject('Trial Class '.$this->type)
        //     ->view(
        //     'emails.mail-master',
        //     [
        //         'header'        => true,
        //         'footer'        => true,
        //         'regards'       => true,
        //         'query'       => true,
        //         'url'           => ['Join Class' , @$this->trialClass->zoom_link],
        //         'paragraphs'    => [
        //             [
        //                 ['heading2'  => 'Dear '. @$this->trialClass->trialRequest->student->user->name.'!'],
        //                 ['line'      => __('A trial class has been '.$this->type.' against your request.')],
        //             ],
        //             [
        //                 ['line'      => __('Following are the details:')],
        //                 ['list'      => [
        //                         __('Student')     => @$this->trialClass->trialRequest->student->name,
        //                         __('Course')      => @$this->trialClass->trialRequest->student->course->title,
        //                         __('Teacher')     => @$this->trialClass->teacher_name,
        //                         __('Starts at')   => format_time(convertTimeToUSERzone($this->trialClass->starts_at, $this->trialClass->trialRequest->student->timezone), false),
        //                     ]
        //                 ]
        //             ],
        //             [
        //                 ['button'   => ['Join Class' , @$this->trialClass->zoom_link]]
        //             ],
        //         ]
        //     ]
        // );
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
