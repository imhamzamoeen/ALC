<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyCustomerOnManualRegistration extends Notification
{
    use Queueable;
    protected $user;
    protected $password;
    protected $is_updating;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $password = '', $is_updating = false)
    {
        $this->user = $user;
        $this->password = $password;
        $this->is_updating = $is_updating;
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
            ->subject('AlQuranClasses Registration')
            ->view(
                'emails.mail-master',
                [
                    'header'        => true,
                    'footer'        => true,
                    'regards'       => true,
                    'query'       => true,
                    'paragraphs'    => [
                        [
                            ['heading2'  => 'Dear '. @$this->user->name.'!'],
                            ['line'      => 'An admin has '. ($this->is_updating ? 'updated your account' : 'created an account for you') .' on <a href="'.env('APP_URL').'" target="_blank" class="text" style=" color: #0A5CD6;   font-weight: bold;"><strong>AlQuranClasses</strong></a>'],
                        ],
                        [
                            ['line'      => __('Following are the credentials:')],
                            ['list'      => [
                                __('Name')     => @$this->user->name,
                                __('Email')     => @$this->user->email,
                                __('Password')  => !empty($this->password) ? $this->password : '--'
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
