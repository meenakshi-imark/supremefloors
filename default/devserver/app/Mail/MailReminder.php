<?php

namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

class MailReminder extends Mailable
{
   use Queueable, SerializesModels;
  
    public $request;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
		
        $this->user = $request;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	// echo"<pre>";print_r($this->user);echo"</pre>";exit();
		$user = $this->user;
        return $this->subject('Supreme Reminder')
                    ->view('backend.mail.reminder',compact('user'));
    }
}
