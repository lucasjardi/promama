<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RespostaDuvida extends Mailable
{
    use Queueable, SerializesModels;

    private $pergunta, $resposta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pergunta, $resposta)
    {
        $this->pergunta = $pergunta;
        $this->resposta = $resposta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.respostaduvida')
                    ->subject('[Pró-Mamá] Sua dúvida foi respondida!!!')
                    ->with(['pergunta' => $this->pergunta,'resposta' => $this->resposta]);
    }
}
