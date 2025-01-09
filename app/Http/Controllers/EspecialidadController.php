<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function mostrar_especialidad(){
        $especialidad = Especialidad::all();

        return view('formulario_dentista', compact('especialidad'));
    }

    public function crear(){
        $especialidad = new Especialidad();
        $especialidad->nombre = request('nombre');
        $especialidad->descripcion = request('descripcion');
        $especialidad->save();

        return redirect()->route('fomulario.especialidad');
    }

    
}
