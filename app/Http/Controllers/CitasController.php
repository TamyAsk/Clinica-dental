<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\citas; // Asegúrate de importar el modelo Citas
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'dentista' => 'required|exists:users,id',
            'descripcion' => 'required|string',
        ]);

        citas::create([ // Usa el modelo Citas aquí
            'paciente_id' => Auth::id(), // ID del paciente
            'dentista_id' => $request->dentista, // ID del dentista seleccionado
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->back()->with('success', 'Cita guardada exitosamente.');
    }

    public function crearCita($fecha)
    {
        $usuarios = User::all();
        return view('crear-cita', ['fecha' => $fecha, 'usuarios' => $usuarios]);
    }

    public function mostrarCalendario()
    {
        $citas = Citas::all();

        return view('dashboard', compact('citas'));
    }

    public function show($id)
    {
        $cita = Citas::with(['paciente', 'dentista'])->findOrFail($id);
        return response()->json($cita);
    }

    public function mostrarMisCitas()
    {
        $userId = Auth::id(); 

        $citas = Citas::where('dentista_id', $userId)->get();

        return view('mostrar_citas', compact('citas'));
    }

    public function cancelarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->estatus = 0; 
        $cita->save();

        return redirect()->back();
    }

    public function confirmarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->estatus = 2;
        $cita->save();

        return redirect()->back();
    }


}
