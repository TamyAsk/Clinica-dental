<?php

namespace App\Http\Controllers;
use App\Models\Vacaciones;
use Illuminate\Http\Request;
use App\Models\Dentista;
use App\Models\Especialidad;

class VacacionController extends Controller
{
    public function index()
    {
        // Cargar las especialidades y dentistas
        $especialidades = Especialidad::all();
        $vacaciones = Vacaciones::all();
        $dentistas = Dentista::all();
    
        // Asignar un color único basado en el dentista (esto puede mejorarse)
        $vacacionesEventos = $vacaciones->map(function ($vacacion) {
            $color = '#' . substr(md5($vacacion->dentista_id), 0, 6); // Generar color único basado en dentista_id
        
            return [
                'id' => $vacacion->id,
                'title' => $vacacion->dentista->nombres . ' ' . $vacacion->dentista->apaterno, // Nombre completo del dentista
                'start' => $vacacion->fecha_inicio,
                'end' => $vacacion->fecha_fin,
                'color' => $color,
                'notes' => $vacacion->motivo, // Motivo
                'dentista_id' => $vacacion->dentista_id,
            ];
        });
        
    
        // Pasar las variables a la vista
        return view('calendario_vacaciones', compact('vacacionesEventos', 'especialidades', 'dentistas'));
    }
    
    

    

    public function create()
{
    $dentistas = Dentista::all(); // Asegúrate de tener un modelo Dentista
    $especialidades = Especialidad::all(); // Carga las especialidades, si las tienes

    return view('vacacion.create', compact('dentistas', 'especialidades'));
}


    public function store(Request $request)
    {
        $request->validate([
            'dentista_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Vacaciones::create($request->all());

        return redirect()->route('calendario_vacaciones')->with('success', 'Solicitud de vacaciones creada exitosamente.');
    }

    // Otros métodos como show, edit y destroy pueden ser agregados aquí
}
