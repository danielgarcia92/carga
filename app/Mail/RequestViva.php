<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestViva extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;

    /** @return void */
    public function __construct($data, $subject)
    {
        $this->data    = $data;
        $this->subject = $subject;
    }

    /** @return $this */
    public function build()
    {
        return $this->view('emails.requestViva');
    }
}
