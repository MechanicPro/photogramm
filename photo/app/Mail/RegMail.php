<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.reg')
                    ->with([
                        'email' => $this ->email,
                        'name' => $this ->name
                    ])
                    ->subject('Подтверждение регистрации')
                    ;
    }
}
