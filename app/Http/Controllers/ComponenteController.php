<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Componente;

class ComponenteController extends Controller
{
    public function index()
    {
        $componentes = Componente::all();
        return view('componentes.index', compact('componentes'));
    }

    public function create()
    {
        return view('componentes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'procesador' => 'required',
            'tarjeta_madre' => 'required',
            'ram' => 'required',
            'disco_duro' => 'required',
            'tarjeta_video' => 'required',
            'tarjeta_red' => 'required',
        ]);

        Componente::create($validated);

        return redirect()->route('componentes.index')->with('success', 'Componente creado correctamente');
    }

    public function edit(Componente $componente)
    {
        return view('componentes.edit', compact('componente'));
    }

    public function update(Request $request, Componente $componente)
    {
        $componente->update($request->all());
        return redirect()->route('componentes.index')->with('success', 'Componente actualizado correctamente');
    }

    public function destroy(Componente $componente)
    {
        $componente->delete();
        return redirect()->route('componentes.index')->with('success', 'Componente eliminado correctamente');
    }
}
