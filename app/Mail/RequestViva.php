<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestViva extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $path;
    public $subject;

    /** @return void */
    public function __construct($data, $subject, $path)
    {
        $this->data    = $data;
        $this->path    = $path;
        $this->subject = $subject;
    }

    /** @return $this */
    public function build()
    {
        if ($this->path == NULL) {
            return $this->view('emails.requestViva');
        } else {
            return $this->view('emails.requestViva')
                ->attach(public_path($this->path), [
                    'as' => $this->path
                ]);
        }
    }
}
