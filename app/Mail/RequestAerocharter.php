<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestAerocharter extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Carga: Solicitud de Aerocharter enviada con éxito';

    public $data;
    public $items;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $items)
    {
        $this->data = $data;
        $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.requestAerocharter');
    }
}
