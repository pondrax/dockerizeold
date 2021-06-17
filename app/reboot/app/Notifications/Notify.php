<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Notify extends Notification implements ShouldQueue
{
    use Queueable;

    private $notify;

    public function __construct($data)
    {
        $this->notify = $notify;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database','mail',
        ];
    }

    public function viaQueues()
    {
        return [
            'database'	=> 'default',
            'mail'  	=> 'default',
        ];
    }

	public function toArray($notifiable){
		return $notifiable;
	}

    public function toMail($notifiable)
    {
        $url = url('/activate/'.$this->notify['message']);

        return (new MailMessage())
                    ->from('fromx')
                    ->subject('Hello pondrax3!')
                    ->greeting('Hello pondraxx3!')
                    ->line('mail is working fine!')
                    ->action('View Invoice', $url)
                    ->line('Thank you for using our application!');
    }

}
