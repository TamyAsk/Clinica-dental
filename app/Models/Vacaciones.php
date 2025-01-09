<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacaciones extends Model
{
    use HasFactory;
    //tabla de la base de datos
    protected $table = 'vacaciones';

    protected $fillable = [
        'dentista_id',
        'fecha_inicio',
        'fecha_fin',
        'motivo'
    ];
              // Relaciones 
              public function dentista()
              {
                  return $this->belongsTo(dentista::class, 'dentista_id');
              }

              
}
