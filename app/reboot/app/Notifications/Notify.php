<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class Notify extends Notification implements ShouldQueue
{
	use Queueable;

	private $notify;

	public function __construct($notify){
		$this->notify = $notify;
	}
	/**
	* Get the notification's delivery channels.
	*
	* @param mixed $notifiable
	* @return array
	*/
	public function via($notifiable){
		return [
			'mail'
		];
	}
	public function viaQueues(){
		return [
			'mail'=>'default'
		];
	}
	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable){
		$url = url('/activate/'.$this->notify['message']);

		return (new MailMessage)
					->from('fromx')
					->subject('Hello pondrax3!')
					->greeting('Hello pondraxx3!')
					->line('mail is working fine!')
					->action('View Invoice', $url)
					->line('Thank you for using our application!');
	}
}
