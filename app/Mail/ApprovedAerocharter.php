<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovedAerocharter extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $items;
    public $subject;

    /** @return void */
    public function __construct($data, $items, $subject)
    {
        $this->data    = $data;
        $this->items   = $items;
        $this->subject = $subject;
    }

    /** @return $this */
    public function build()
    {
        return $this->view('emails.approvedAerocharter');
    }
}
