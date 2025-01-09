<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioCorreo;
use App\Models\Paciente;
use App\Models\Cita;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'email' => 'required|email|unique:pacientes,email',
            'telefono' => 'required|string|max:15',
            'genero' => 'required|string|max:10',
            'tipo_sangre' => 'nullable|string|max:5',
        ]);

        Paciente::create($request->all());

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente.');
    }

    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'email' => 'required|email',
            'telefono' => 'required|string|max:15',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
        
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado con éxito.');
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();
        
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado con éxito.');
    }

    public function lista_pacientes()
    {
        $pacientes = Paciente::all();
        return view('pacientes', compact('pacientes'));
    }

    public function toggleStatus($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->estatus = $paciente->estatus == 1 ? 0 : 1;
        $paciente->save();

        return redirect()->back()->with('status', 'El estatus del paciente ha sido actualizado correctamente.');
    }

    public function editar($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('paciente_editar', compact('paciente'));
    }

    public function actualizar(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());
        
        return redirect()->route('lista_p')->with('status', 'Paciente actualizado correctamente');
    }

    public function enviarRecordatorio($id)
{
    $paciente = Paciente::findOrFail($id);
    $mensaje = "Estimado(a) " . $paciente->nombres . ",\n\nEste es un recordatorio importante para ti.";

    $ultimaCita = Cita::where('paciente_id', $id)->orderBy('fecha', 'desc')->first();

    if ($ultimaCita) {
        $fechaCita = new \DateTime($ultimaCita->fecha); 
        $dentista = $ultimaCita->dentista;  

        if ($dentista) {
            $mensaje .= "\n\nTienes una cita el " . $fechaCita->format('d-m-Y') . " a las " . $ultimaCita->hora . " con el Dr. " . $dentista->nombre_completo . ".";
        } else {
            $mensaje .= "\n\nTienes una cita el " . $fechaCita->format('d-m-Y') . " a las " . $ultimaCita->hora . ".";
        }
        
        $mensaje .= "\nDescripción: " . $ultimaCita->descripcion. ".";

        $mensaje .= "\nEsperamos tu asistencia.";
    } else {
        $mensaje .= "\n\nNo tienes citas previas registradas.";
    }

    Mail::to($paciente->email)->send(new RecordatorioCorreo($mensaje));

    return redirect()->back()->with('status', 'Recordatorio enviado con éxito a ' . $paciente->nombres);
}

    

    

}
