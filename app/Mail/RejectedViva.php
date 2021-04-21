<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectedViva extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $approved_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $subject, $approved_name)
    {
        $this->data    = $data;
        $this->subject = $subject;
        $this->approved_name = $approved_name;
    }

    /** @return $this */
    public function build()
    {
        return $this->view('emails.rejectedViva');
    }
}
