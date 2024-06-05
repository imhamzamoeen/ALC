<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCustomerSignedUp extends Notification
{
    use Queueable;
    protected $user;
    protected $ip;
    protected $country;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->ip = get_client_ip();
        $this->country = ip_info("Visitor", 'Country');
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
            ->subject('New Customer Registered')
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
                            ['line'      => 'A new customer has signed up for '.env('APP_NAME')],
                        ],
                        [
                            ['line'      => __('Following are the details:')],
                            ['list'      => [
                                'Name'      => @$this->user['name'],
                                'Phone'     => @$this->user['phone'],
                                'Email'     => @$this->user['email'],
                                'Country'   => @$this->country,
                                'User IP'   => @$this->ip,
                                /*'Date/Time' => Carbon::now()->format('d M, Y h:s A'),*/
                                'Terms & Conditions' => 'I hereby agree to the Terms of Use and Privacy Policy and do hereby state that I am over 13+ years of age.'
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
