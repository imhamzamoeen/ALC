<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyCustomerWithResetPin extends Notification
{
    use Queueable;

    protected $pin;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $pin)
    {
        $this->pin = $pin;
        $this->user = $user;
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
            ->subject('Console Pin Reset')
            ->view(
                'emails.mail-master',
                array(
                    'header'        => true,
                    'footer'        => true,
                    'regards'       => true,
                    'query'         => true,
                    'paragraphs'    => array(
                                            array(
                                                array('heading2'  => 'Dear '. @$this->user->name.'!'),
                                                array('line'      => __('Your AlQuranClasses console pin has been changed')),
                                            ),
                                            array(
                                                array('line'      => __('Following are the details:')),
                                                array('list'      => array(
                                                                        __('Email')  => @$this->user->email,
                                                                        __('Pin')    => @$this->pin,
                                                                     )
                                                )
                                            )
                                        )
                )
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
