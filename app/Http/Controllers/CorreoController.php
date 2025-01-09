<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarEmail;

class CorreoController extends Controller
{
    public function mostrarFormulario()
    {
        return view('enviar_email');
    }

    public function enviarEmail(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'email' => 'required|email',
        ]);

        $detalle = [
            'titulo' => $request->input('titulo'),
            'mensaje' => $request->input('mensaje')
        ];

        Mail::to($request->input('email'))->send(new EnviarEmail($detalle));

        return redirect()->back()->with('success', 'Correo enviado exitosamente!');
    }
}
