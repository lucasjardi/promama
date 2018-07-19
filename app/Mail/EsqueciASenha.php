<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EsqueciASenha extends Mailable
{
    use Queueable, SerializesModels;

    private $senha_reserva;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($senha_reserva)
    {
        $this->senha_reserva = $senha_reserva;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.esqueceuasenha')
                    ->subject('Sua senha do Aplicativo Pró-Mamá')
                    ->with(['senha_reserva' => $this->senha_reserva]);
    }
}
