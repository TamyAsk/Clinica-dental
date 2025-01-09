<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Dentista;
use App\Models\Vacaciones;
use App\Models\Paciente;
use App\Models\Especialidad;
use Carbon\Carbon;

class CitaController extends Controller
{

    public function showCalendar()
    {
    
    
        // Obtener la fecha de hoy
        $hoy = Carbon::now()->format('Y-m-d');
    
        // Obtener todas las citas con relación a paciente y dentista, solo a partir de hoy
        $citas = Cita::with(['paciente', 'dentista'])
                    ->where('fecha', '>=', $hoy)
                    ->get();
        
        // Si no hay citas, preparar un array vacío para los eventos
        $eventos = $citas->map(function ($cita) {
            return [
                'id' => $cita->id,
                'title' => 'Cita con ' . ($cita->paciente ? $cita->paciente->nombres : 'Paciente desconocido'),
                'start' => "{$cita->fecha}T{$cita->hora}", 
                'end' => "{$cita->fecha}T{$cita->hora}", 
                'notes' => $cita->descripcion,
                'paciente' => $cita->paciente ? $cita->paciente->nombres : 'Desconocido',
                'dentista' => $cita->dentista ? $cita->dentista->nombres : 'Desconocido',
            ];
        });
    
        // Obtener todos los dentistas y especialidades
        $dentistas = Dentista::all();
        $especialidades = Especialidad::all(); 
    
        // Depuración (quitar una vez revisado)
        // dd($dentistas, $especialidades, $eventos);
    
        // Pasar los datos a la vista
        return view('calendar', compact('dentistas', 'especialidades', 'eventos'));
    }
    

    public function index()
    {
        $citas = Cita::all();
        return view('calendar', ['citas' => $citas]);
    }

    public function mostrarCitas()
    {
        $citas = Cita::whereMonth('fecha_hora', Carbon::now()->month)
                     ->whereYear('fecha_hora', Carbon::now()->year)
                     ->get();
        return view('calendar', compact('citas'));
    }

    public function showAgendarCitaForm()
    {
        $dentistas = Dentista::all();
        return view('tu-vista', compact('dentistas'));
    }
    
    public function store(Request $request)
{
    // Validación de datos generales
    $request->validate([
        'paciente_id' => 'nullable|exists:pacientes,id',
        'paciente_nombre' => 'required_without:paciente_id|string|max:255',
        'paciente_apaterno' => 'required_without:paciente_id|string|max:255',
        'paciente_amaterno' => 'required_without:paciente_id|string|max:255',
        'email' => 'required_without:paciente_id|email|max:255',
        'telefono' => 'nullable|string|max:15',
        'especialidad_id' => 'required|exists:especialidad,id',
        'fecha' => 'required|date|after_or_equal:today',
        'hora' => 'required',
        'descripcion' => 'nullable|string|max:255',

        // Validación específica para nuevo paciente
        'nuevo_paciente_nombre' => 'required_without:paciente_id|string|max:255',
        'nuevo_paciente_apaterno' => 'required_without:paciente_id|string|max:255',
        'nuevo_paciente_amaterno' => 'required_without:paciente_id|string|max:255',
        'nuevo_paciente_email' => 'required_without:paciente_id|email|max:255|unique:pacientes,email',
        'nuevo_paciente_telefono' => 'nullable|string|max:15',
    ]);

    // Si se proporciona un paciente existente
    if ($request->paciente_id) {
        $paciente = Paciente::find($request->paciente_id);
        if (!$paciente) {
            return redirect()->back()->withErrors(['paciente_id' => 'Paciente no encontrado.']);
        }
    } else {
        $paciente = Paciente::create([
            'nombres' => $request->paciente_nombre,
            'apaterno' => $request->paciente_apaterno,
            'amaterno' => $request->paciente_amaterno,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);
    }


    // Validar y asignar un dentista automáticamente si no se seleccionó uno
    if (!$request->dentista_id) {
        $dentista = Dentista::where('especialidad_id', $request->especialidad_id)
            ->where('estatus', 'activo')
            ->whereDoesntHave('vacaciones', function ($query) use ($request) {
                $query->where('fecha_inicio', '<=', $request->fecha)
                      ->where('fecha_fin', '>=', $request->fecha);
            })
            ->whereJsonContains('dias_laborales', date('l', strtotime($request->fecha))) // Validar día laboral
            ->first();

        if (!$dentista) {
            return redirect()->back()->withErrors(['error' => 'No hay dentistas disponibles para la especialidad seleccionada en la fecha solicitada.']);
        }

        $request->merge(['dentista_id' => $dentista->id]);
    }

    // Crear la cita
    Cita::create([
        'paciente_id' => $paciente->id,
        'dentista_id' => $request->dentista_id,
        'fecha' => $request->fecha,
        'hora' => $request->hora,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('calendario')->with('success', 'Cita agendada exitosamente.');
}
public function storeNuevoPaciente(Request $request)
{
    $request->validate([
        'nuevo_paciente_nombre' => 'required|string|max:255',
        'nuevo_paciente_apaterno' => 'required|string|max:255',
        'nuevo_paciente_amaterno' => 'required|string|max:255',
        'nuevo_paciente_email' => 'required|email|max:255|unique:pacientes,email',
        'nuevo_paciente_telefono' => 'nullable|string|max:15',
    ]);

    $paciente = Paciente::create([
        'nombres' => $request->nuevo_paciente_nombre,
        'apaterno' => $request->nuevo_paciente_apaterno,
        'amaterno' => $request->nuevo_paciente_amaterno,
        'email' => $request->nuevo_paciente_email,
        'telefono' => $request->nuevo_paciente_telefono,
        'estatus' => 1,
    ]);

    return response()->json($paciente);
}


    public function guardarVacaciones(Request $request)
    {
        $request->validate([
            'dentista_id' => 'required|exists:dentista,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Vacaciones::create($request->only(['dentista_id', 'fecha_inicio', 'fecha_fin']));
        return redirect()->route('calendario')->with('success', 'Vacaciones registradas correctamente');
    }

    public function buscarPacientes(Request $request)
    {
        $query = $request->input('query');
        $pacientes = Paciente::where('nombres', 'LIKE', "%{$query}%")
            ->orWhere('apaterno', 'LIKE', "%{$query}%")
            ->orWhere('amaterno', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($pacientes);
    }

    public function showPacienteCitas($pacienteId)
    {
        // Busca el paciente con sus citas y su dentista
        $paciente = Paciente::with('citas.dentista')->findOrFail($pacienteId);
    
        // Retorna la vista con los datos del paciente
        return view('pacientes', compact('paciente'));
    }
    
// En el modelo Paciente
public function citas()
{
    return $this->hasMany(Cita::class);
}

public function mostrarTablaCitas(Request $request)
{
    // Filtrar citas con parámetros de búsqueda opcionales
    $query = Cita::with(['paciente', 'dentista']);
    
    // Filtrar por fecha (solo citas del día de hoy en adelante)
    $query->where('fecha', '>=', now()->toDateString());
    
    // Filtrar por fecha (si se pasa una fecha específica)
    if ($request->has('fecha') && $request->fecha) {
        $query->where('fecha', $request->fecha);
    }
    
    // Filtrar por paciente
    if ($request->has('paciente') && $request->paciente) {
        $query->whereHas('paciente', function($q) use ($request) {
            $q->where('nombres', 'like', '%' . $request->paciente . '%')
              ->orWhere('apaterno', 'like', '%' . $request->paciente . '%')
              ->orWhere('amaterno', 'like', '%' . $request->paciente . '%');
        });
    }

    // Filtrar por dentista
    if ($request->has('dentista') && $request->dentista) {
        $query->whereHas('dentista', function($q) use ($request) {
            $q->where('nombres', 'like', '%' . $request->dentista . '%')
              ->orWhere('apaterno', 'like', '%' . $request->dentista . '%')
              ->orWhere('amaterno', 'like', '%' . $request->dentista . '%');
        });
    }

    $citas = $query->get();

    return view('lista_citas', compact('citas'));
}
public function editar($id)
{
    // Buscar la cita por ID
    $cita = Cita::findOrFail($id);

    // Obtener todos los pacientes y especialidades
    $pacientes = Paciente::all();


    // Filtrar dentistas según la especialidad de la cita
    $dentistas = Dentista::all();
    // Retornar vista con la cita y la información adicional
    return view('editar_cita', compact('cita', 'pacientes', 'dentistas'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'dentista_id' => 'required|exists:dentista,id',
        'fecha' => 'required|date',
        'hora' => 'required|date_format:H:i:s',
        'descripcion' => 'nullable|string',
    ]);

    $cita = Cita::findOrFail($id);
    $cita->update($validatedData);

    return redirect()->route('lista.citas')->with('success', 'Cita actualizada correctamente.');
}









public function cancelar($id)
{
    $cita = Cita::findOrFail($id);
    $cita->delete();
    return redirect()->route('lista.citas')->with('success', 'Cita cancelada con éxito.');
}

public function obtenerDentistasDisponibles(Request $request)
{
    $especialidadId = $request->input('especialidad_id');
    $fecha = $request->input('fecha');

    $dentistasDisponibles = Dentista::where('especialidad_id', $especialidadId)
        ->whereDoesntHave('vacaciones', function ($query) use ($fecha) {
            $query->where('fecha_inicio', '<=', $fecha)
                  ->where('fecha_fin', '>=', $fecha);
        })
        ->get();

    return response()->json($dentistasDisponibles);
}


// Controlador Cita
public function asignarDentistaAutomatico($fecha, $especialidad_id) {
    $dentistasDisponibles = Dentista::whereHas('especialidad', function ($query) use ($especialidad_id) {
        $query->where('especialidad_id', $especialidad_id);
    })->whereDoesntHave('vacaciones', function ($query) use ($fecha) {
        $query->where('fecha_inicio', '<=', $fecha)
              ->where('fecha_fin', '>=', $fecha);
    })->get();
    
    if ($dentistasDisponibles->isNotEmpty()) {
        return $dentistasDisponibles->first();  // Asignar el primer dentista disponible
    }
    
    return null;  // No hay dentistas disponibles
}

// Modelo Feriado
public function feriados() {
    return $this->hasMany(Feriado::class);
}

public function validarDisponibilidad($dentista_id, $fecha) {
    $vacaciones = Vacacion::where('dentista_id', $dentista_id)
                          ->where('fecha_inicio', '<=', $fecha)
                          ->where('fecha_fin', '>=', $fecha)
                          ->exists();
    
    if ($vacaciones) {
        return false;  // El dentista está de vacaciones
    }
    
    return true;  // El dentista está disponible
}

public function validarCitaHora(Request $request)
{
    $fecha = $request->query('fecha');
    $hora = $request->query('hora');

    // Busca si existe una cita en esa fecha y hora
    $existeCita = Cita::where('fecha', $fecha)
        ->where('hora', $hora)
        ->exists();

    return response()->json(['disponible' => !$existeCita]);
}





public function mostrarFormularioCita(Request $request)
{
    $especialidad_id = $request->especialidad_id; // Recibido del formulario
    $fecha_solicitada = $request->fecha;

    // Filtra dentistas disponibles
    $dentistas = Dentista::where('especialidad_id', $especialidad_id)
                         ->where('estatus', 'activo')
                         ->whereJsonContains('dias_laborales', date('l', strtotime($fecha_solicitada))) // Valida día laboral
                         ->get();

    return view('agendar', compact('dentistas'));
}
public function agendarCita(Request $request)
{
    $request->validate([
        'paciente_id' => 'required',
        'dentista_id' => 'required',
        'fecha_hora' => 'required|date|after:now',
    ]);

    $cita = new Cita();
    $cita->paciente_id = $request->paciente_id;
    $cita->dentista_id = $request->dentista_id;
    $cita->fecha_hora = $request->fecha_hora;
    $cita->estado = 'pendiente';
    $cita->save();

    return redirect()->back()->with('success', 'Cita agendada correctamente.');
}
private function validarHorarioDisponible($dentista_id, $fecha, $hora)
{
    $citas = Cita::where('dentista_id', $dentista_id)
                ->where('fecha', $fecha)
                ->where('hora', $hora)
                ->exists();
    
    return !$citas; // Retorna true si no hay citas con este dentista en esa hora
}

public function obtenerHorasDisponibles(Request $request)
{
    
    $fecha = $request->query('fecha');
    $dentistaId = $request->query('dentista_id');

    if (!$fecha || !$dentistaId) {
        return response()->json(['error' => 'Parámetros faltantes'], 400);
    }

    // Verificar si la fecha está dentro de las vacaciones del dentista
    $vacacion = Vacacion::where('dentista_id', $dentistaId)
                        ->where('fecha_inicio', '<=', $fecha)
                        ->where('fecha_fin', '>=', $fecha)
                        ->first();

    if ($vacacion) {
        $mensaje = "El dentista está de vacaciones desde el " . $vacacion->fecha_inicio . " hasta el " . $vacacion->fecha_fin . ". Motivo: " . $vacacion->motivo;
        return response()->json(['error' => $mensaje], 400);  // Enviar el mensaje de vacaciones como error
    }

    // Generar lista de horas disponibles
    $horasDisponibles = [];
    foreach ($horariosDentista as $horario) {
        $horaInicio = \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio);
        $horaFin = \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin);

        while ($horaInicio->lt($horaFin)) {
            $horaActual = $horaInicio->format('H:i');
            if (!in_array($horaActual, $citasOcupadas)) {
                $horasDisponibles[] = $horaActual;
            }
            $horaInicio->addMinutes(30); // Intervalos de 30 minutos
        }
    }

    return response()->json(['horas_disponibles' => $horasDisponibles]);
}



}
