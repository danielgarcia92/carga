<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectedAerocharter extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $items;
    public $subject;
    public $approved_name;

    /** @return void */
    public function __construct($data, $items, $subject, $approved_name)
    {
        $this->data    = $data;
        $this->items   = $items;
        $this->subject = $subject;
        $this->approved_name = $approved_name;
    }

    /** @return $this */
    public function build()
    {
        return $this->view('emails.rejectedAerocharter');
    }
}
