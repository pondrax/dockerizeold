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
			'mail'=>'mail-queue'
		];
	}
	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable){
		$url = url('/invoice/'.$this->notify['message']);

		return (new MailMessage)
					->greeting('Hello delay3!')
					->line('One of your invoices has been paid!')
					->action('View Invoice', $url)
					->line('Thank you for using our application!');
	}
}
