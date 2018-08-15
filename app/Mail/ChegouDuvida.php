<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChegouDuvida extends Mailable
{
    use Queueable, SerializesModels;

    private $email, $duvida, $duvida_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $duvida, $duvida_id)
    {
        $this->email = $email;
        $this->duvida = $duvida;
        $this->duvida_id = $duvida_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.chegouduvida')
                    ->subject('[Pró-Mamá] Chegou uma nova dúvida')
                    ->with([
                        'email' => $this->email,
                        'duvida' => $this->duvida,
                        'duvida_id' => $this->duvida_id
                    ]);
    }
}
