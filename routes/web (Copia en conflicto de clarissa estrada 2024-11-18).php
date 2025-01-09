<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\VacacionController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\DentistaController;

Route::get('/', function () {
    return view('../auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard'); // Asegúrate de que la vista se llama 'inicio.blade.php' y está en el directorio resources/views
})->name('dashboard');
Route::get('/gestion_vacaciones', function () {
    return view('gestion_vacaciones');
})->middleware(['auth', 'verified'])->name('gestion_vacaciones');

Route::get('/gestion_notificaciones', function () {
    return view('gestion_notificaciones');
})->middleware(['auth', 'verified'])->name('gestion_notificaciones');



Route::post('/enviar-email', [CorreoController::class, 'enviarEmail'])->name('enviar.email');

Route::middleware('auth')->group(function () {
Route::prefix('citas')->group(function () {
    // Ruta para mostrar el formulario de agendar citas
Route::get('/agendar', [CitaController::class, 'showAgendarCitaForm'])->name('citas.agendar');
    
    // Guarda la nueva cita
 Route::post('/', [CitaController::class, 'store'])->name('citas.store');
});
});
Route::middleware('auth')->group(function () {
// Grupo de rutas para vacaciones del personal
Route::prefix('vacaciones')->group(function () {
    Route::post('/vacacion/store', [VacacionController::class, 'store'])->name('vacacion.store');
    Route::post('/agregar', [CitaController::class, 'guardarVacaciones'])->name('vacaciones.agregar');
});
});

//dentistas
Route::get('/formulario_dentista',[EspecialidadController::class, 'mostrar_especialidad'])->name('fomulario.especialidad');
Route::post('/formulario_dentista/crear',[DentistaController::class, 'crear_dentista'])->name('crear.dentista');
Route::get('/lista_dentista',[DentistaController::class, 'index'])->name('mostrar.dentista');
Route::patch('/dentista/{id}/toggle-status', [DentistaController::class, 'toggleStatus'])->name('dentista.toggleStatus');
Route::get('/dentista/{id}/editar', [DentistaController::class, 'editar'])->name('dentista.editar');
Route::put('/dentista/{id}', [DentistaController::class, 'actualizar'])->name('dentista.actualizar');

//especialidad
Route::post('/especialidad',[EspecialidadController::class, 'crear'])->name('especialidad.crear');

//Pacientes
Route::get('/pacientes/lista',[PacientesController::class, 'index'])->name('pacientes.mostrar');

Route::middleware('auth')->group(function () {
    
    
Route::get('/pacientes', [PacienteController::class, 'index']); // Muestra todos los pacientes
Route::get('/pacientes/{id}', [PacienteController::class, 'show']); // Muestra 

Route::get('/calendario', [CitaController::class, 'showCalendar'])->name('calendario');
Route::get('/calendar', [CitaController::class, 'index']); // Asegúrate de que este método exista
Route::get('/buscar-pacientes', [CitaController::class, 'buscarPacientes'])->name('buscar.pacientes');
Route::post('/nuevo-paciente', [CitaController::class, 'storeNuevoPaciente'])->name('nuevo.paciente');
Route::resource('citas', CitaController::class);
Route::get('/citas/{id}/detalles', [CitaController::class, 'detalles'])->name('citas.detalles');
Route::get('/calendario-vacaciones', [CitaController::class, 'index'])->name('calendario.vacaciones');


Route::get('/citas_mostrar', [CitaController::class, 'mostrarTablaCitas'])->name('lista.citas');
});











Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/paciente', function () {
    return view('pacientes');
})->middleware(['auth', 'verified'])->name('paciente');

require __DIR__.'/auth.php';


