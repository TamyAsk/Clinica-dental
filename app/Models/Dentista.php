<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentista extends Model
{
    use HasFactory;
         //tabla de la base de datos
         protected $table = 'dentista';

         // Campos 
         protected $fillable = [
            'especialidad_id',
             'nombres',
             'apaterno',
             'amaterno',
             'email',
             'telefono',
             'dias_laborales',
             'estatus',
         ];

          // Relaciones 
          public function especialidad()
          {
              return $this->belongsTo(Especialidad::class, 'especialidad_id');
          }
                public function vacaciones()
        {
            return $this->hasMany(Vacaciones::class);
        }

        public function estaDisponible($fecha)
        {
            // Validar vacaciones
            $enVacaciones = $this->vacaciones()
                ->where('fecha_inicio', '<=', $fecha)
                ->where('fecha_fin', '>=', $fecha)
                ->exists();
        
            if ($enVacaciones) {
                return false;
            }
        
            // Validar días laborales
            $diaSemana = date('l', strtotime($fecha));
            return in_array($diaSemana, $this->dias_laborales);
        }
        

          public function citas() 
          { 
            return $this->hasMany(Cita::class);
          }

          // Método para obtener el nombre completo del dentista
          public function getNombreCompletoAttribute()
          {
              return "{$this->nombres} {$this->apaterno} {$this->amaterno}";
          }
          
}
