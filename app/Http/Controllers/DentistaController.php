<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dentista;
use App\Models\Especialidad;

class DentistaController extends Controller
{
    public function index(){
        $dentista = Dentista::all();

        return view('lista_dentistas',compact('dentista'));
    }

    public function crear_dentista(Request $request){

        $dentista = new Dentista();
        $dentista->nombres = $request->nombres;
        $dentista->apaterno = $request->apaterno;
        $dentista->amaterno = $request->amaterno;
        $dentista->email = $request->email;
        $dentista->telefono = $request->telefono;
        $dentista->dias_laborales = $request->dias_laborales;
        $dentista->estatus = 1; // Estatus activo por defecto
        $dentista->especialidad_id = $request->especialidad_id;
        $dentista->save();

        return redirect()->route('fomulario.especialidad');
    }
    
    public function toggleStatus($id)
    {
        // Encuentra al dentista por ID
        $dentista = Dentista::findOrFail($id);
        
        // Cambia el estatus (suponiendo que 1 es activo y 0 es inactivo)
        $dentista->estatus = $dentista->estatus == 1 ? 0 : 1;
        
        // Guarda los cambios
        $dentista->save();

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->back()->with('status', 'El estatus del dentista ha sido actualizado correctamente.');
    }

    public function editar($id)
    {
        $dentista = Dentista::findOrFail($id);
        $especialidad = Especialidad::all();
        return view('editar', compact('dentista', 'especialidad'));
    }


    // Actualizar los datos del dentista
    public function actualizar(Request $request, $id)
    {
        $dentista = Dentista::findOrFail($id);
        $dentista->update($request->all());
        
        return redirect()->route('mostrar.dentista')->with('status', 'Dentista actualizado correctamente');
    }
}
