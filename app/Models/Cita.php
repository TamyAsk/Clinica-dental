<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'dentista_id',
        'fecha',
        'hora',
        'descripcion',
        'estado',
        'motivo'
    ];
    

    // Relación con el modelo Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con el modelo Dentista
    public function dentista()
    {
        return $this->belongsTo(Dentista::class);
    }
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);  // Si tienes un modelo de Especialidad
    }
}
