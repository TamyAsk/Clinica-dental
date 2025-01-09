<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioCorreo extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;

    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function build()
    {
        return $this->subject('Recordatorio de Cita')
                    ->view('emails.recordatorio')
                    ->with([
                        'mensaje' => $this->mensaje,
                    ]);
    }
}
