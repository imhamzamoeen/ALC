<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNewUserEmail extends Notification
{
    use Queueable;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
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
            ->subject('Welcome To '.env('APP_NAME'))
            ->view(
                'emails.mail-master',
                array(
                    'header'        => true,
                    'footer'        => true,
                    'regards'       => true,
                    'query'         => false,
                    'paragraphs'    => array(
                        array(
                            array('heading3'  => 'Hi there,'),
                            array('line'      => 'Welcome to '.env('APP_NAME').'!'),
                        ),
                        array(['line'      => 'Thank you for signing up with AlQuranClasses. We are pleased you\'re here!']),
                        array(['line'      => 'AlQuranClasses offers different online Quran courses 1-on-1 sessions at the comfort
                                                of your home. Our vision is to spread the light of the Quran among Muslims to get a
                                                detailed understanding of the Quran.
                                                <br><br>
                                                Our Mission is "Quran in Every hand, Quran in Every Heart."
                                                <br><br><br>
                                                In case of any queries, please feel free to contact us!<br><br>

                                                Email: support@alquranclasses.com<br>

                                                Web: www.alquranclases.com<br>

                                                CA: +1 (866) 302-4897<br>
                                                USA: +1 (866) 288-9181<br>
                                                UK: + 44 (142) 980-4123<br>
                                                ']
                            ),
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
