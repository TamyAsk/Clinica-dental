<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';
    // Define los atributos que se pueden llenar
    protected $fillable = ['nombres', 'apaterno', 'amaterno', 'email', 'telefono','estatus'];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
    public function dentistas()
{
    return $this->hasMany(Dentista::class, 'especialidad_id');
}



}
