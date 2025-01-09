<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelaciones extends Model
{
    use HasFactory;
    protected $fillable = [
        'citas_id',
        'motivo'
    ];

    // Puedes agregar relaciones aquí si lo deseas
    public function citas()
    {
        return $this->belongsTo(User::class, 'citas_id');
    }
}
