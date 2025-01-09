<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\CitasController;

Route::get('/', function () {
    return view('../auth/login');
});

Route::get('/dashboard', [CitasController::class, 'mostrarCalendario'])->name('dashboard');

Route::get('/gestion_vacaciones', function () {
    return view('gestion_vacaciones');
})->middleware(['auth', 'verified'])->name('gestion_vacaciones');

Route::get('/gestion_notificaciones', function () {
    return view('gestion_notificaciones');
})->middleware(['auth', 'verified'])->name('gestion_notificaciones');

Route::post('/enviar-email', [CorreoController::class, 'enviarEmail'])->name('enviar.email');

Route::get('/crear-cita/{fecha}', [CitasController::class, 'crearCita'])->name('crear.cita');
Route::post('/guardar-cita', [CitasController::class, 'store'])->name('guardar.cita');

Route::get('/cita/{id}', [CitasController::class, 'show'])->name('citas.show');

Route::get('/citas',[CitasController::class, 'mostrarMisCitas'])->name('citas.mostrarMisCitas');

Route::get('/citas/{id}/cancelar', [CitasController::class, 'cancelarCita'])->name('citas.cancelar');
Route::get('/citas/{id}/confirmar', [CitasController::class, 'confirmarCita'])->name('citas.confirmar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/paciente', function () {
    return view('pacientes');
})->middleware(['auth', 'verified'])->name('paciente');

require __DIR__.'/auth.php';
