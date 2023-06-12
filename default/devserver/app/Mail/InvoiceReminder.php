<?php

namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

class InvoiceReminder extends Mailable
{
   use Queueable, SerializesModels;
  
    public $approval;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval)
    {
		
        $this->status = $approval;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
		$status = $this->status;
        return $this->subject('Supreme Invoice Update')
                    ->view('backend.mail.invoicemail',compact('status'));
    }
}
