<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Base\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller{
	
	public function mail() {
		$data = array('name'=>"Drax");
		Mail::send('mail', $data, function($message) {
			$message->to('pondras.setiawan@gmail.com', 'Pondra')->subject('Test email text');
			$message->from('pondrax3@gmail.com','pondra');
		});
		echo "Email Sent. Check your inbox.";
	}
}
