<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
        $this->subject($details['subject']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (!empty($this->details['attach'])) {
            return $this->view($this->details['view'], $this->details)
                ->attach($this->details['attach']['file'], [
                    'as'   => $this->details['attach']['name'], // Tên file đính kèm
                    'mime' => $this->details['attach']['mime'] // Kiểu MIME của file
                ]);
        }
        return $this->view($this->details['view'], $this->details);
    }
}
