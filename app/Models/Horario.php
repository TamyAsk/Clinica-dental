<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    //tabla de la base de datos
    protected $table = 'horario';

    protected $fillable = [
        'dentista_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];
              // Relaciones 
              public function dentista()
              {
                  return $this->belongsTo(User::class, 'dentista_id');
              }
}
