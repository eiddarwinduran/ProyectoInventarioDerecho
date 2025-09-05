<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;

class UbicacionController extends Controller
{
    public function index()
    {
        $ubicaciones = Ubicacion::all();
        return view('ubicaciones.index', compact('ubicaciones'));
    }

    public function create()
    {
        return view('ubicaciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_ubicacion' => 'required',
            'descripcion' => 'nullable',
        ]);

        Ubicacion::create($validated);

        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación creada correctamente');
    }

    public function edit(Ubicacion $ubicacion)
    {
        return view('ubicaciones.edit', compact('ubicacion'));
    }

    public function update(Request $request, Ubicacion $ubicacion)
    {
        $ubicacion->update($request->all());
        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación actualizada correctamente');
    }

    public function destroy(Ubicacion $ubicacion)
    {
        $ubicacion->delete();
        return redirect()->route('ubicaciones.index')->with('success', 'Ubicación eliminada correctamente');
    }
}
