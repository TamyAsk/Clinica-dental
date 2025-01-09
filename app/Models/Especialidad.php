<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;
            protected $table = 'especialidad';

            protected $fillable = [
                'nombre',
                'descripcion'
            ];
            public function dentistas()
{
    return $this->hasMany(Dentista::class, 'especialidad_id');
}

public function citas()
{
    return $this->hasMany(Cita::class);
}

}
