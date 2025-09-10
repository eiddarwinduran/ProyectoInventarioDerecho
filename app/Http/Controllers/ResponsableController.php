<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsable;

class ResponsableController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $responsables = Responsable::when($search, function ($query, $search) {
            return $query->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%")
                ->orWhere('ci', 'like', "%{$search}%")
                ->orWhere('cargo', 'like', "%{$search}%")
                ->orWhere('telefono', 'like', "%{$search}%")
                ->orWhere('correo', 'like', "%{$search}%");
        })
            ->get();

        return view('responsables.index', compact('responsables'));
    }

    public function create()
    {
        $responsables = Responsable::all();
        return view('responsables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'ci' => 'required|unique:responsables',
            'cargo' => 'nullable',
            'telefono' => 'nullable',
            'correo' => 'nullable|email',
        ]);

        Responsable::create($validated);

        return redirect()->route('responsables.index')->with('success', 'Responsable creado correctamente');
    }

    public function edit(Responsable $responsable)
    {
        return view('responsables.edit', compact('responsable'));
    }

    public function update(Request $request, Responsable $responsable)
    {
        $responsable->update($request->all());
        return redirect()->route('responsables.index')->with('success', 'Responsable actualizado correctamente');
    }

    public function destroy(Responsable $responsable)
    {
        $responsable->delete();
        return redirect()->route('responsables.index')->with('success', 'Responsable eliminado correctamente');
    }
}
