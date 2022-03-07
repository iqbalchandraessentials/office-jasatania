<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Acceptance extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $item;
    private $message;
    public function __construct($data, $pesan)
    {
        $this->item = $data;
        $this->message = $pesan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.acceptance',
            [
                'item' => $this->item,
                'pesan' => $this->message,
            ]

        );
    }
}
