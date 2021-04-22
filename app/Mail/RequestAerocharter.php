<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestAerocharter extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $path;
    public $items;
    public $subject;

    /** @return void */
    public function __construct($data, $items, $subject, $path)
    {
        $this->data    = $data;
        $this->path    = $path;
        $this->items   = $items;
        $this->subject = $subject;
    }

    /** @return $this */
    public function build()
    {
        if ($this->path == NULL) {
            return $this->view('emails.requestAerocharter');
        } else {
            return $this->view('emails.requestAerocharter')
                ->attach(public_path($this->path), [
                    'as' => $this->path
                ]);
        }
    }
}
