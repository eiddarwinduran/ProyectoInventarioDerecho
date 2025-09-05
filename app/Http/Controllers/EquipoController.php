<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Componente;

class EquipoController extends Controller
{
    // Mostrar todos los equipos con sus componentes
    public function index(Request $request)
{
    $search = $request->input('search');

    $equipos = Equipo::with('componente')
        ->when($search, function ($query, $search) {
            return $query->where('codigo', 'like', "%{$search}%")
                         ->orWhere('descripcion', 'like', "%{$search}%");
        })
        ->get();

    return view('equipos.index', compact('equipos'));
    }


  
    public function create()
    {
        return view('equipos.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'codigo' => 'required|unique:equipos,codigo',
        'descripcion' => 'required',
        'estado' => 'nullable',
        'tipo' => 'required|in:monitor,cpu',

        // Solo obligatorios si es CPU
        'procesador' => 'required_if:tipo,cpu',
        'tarjeta_madre' => 'required_if:tipo,cpu',
        'ram' => 'required_if:tipo,cpu',
        'disco_duro' => 'required_if:tipo,cpu',
        'tarjeta_video' => 'required_if:tipo,cpu',
        'tarjeta_red' => 'required_if:tipo,cpu',
    ]);

    $componente = null;

    if ($request->tipo === 'cpu') {
        $componente = Componente::create([
            'procesador' => $request->procesador,
            'tarjeta_madre' => $request->tarjeta_madre,
            'ram' => $request->ram,
            'disco_duro' => $request->disco_duro,
            'tarjeta_video' => $request->tarjeta_video,
            'tarjeta_red' => $request->tarjeta_red,
        ]);
    }

    Equipo::create([
        'codigo' => $request->codigo,
        'descripcion' => $request->descripcion,
        'estado' => $request->estado,
        'tipo' => $request->tipo,
        'id_comp' => $componente ? $componente->id_comp : null,
    ]);

    return redirect()->route('equipos.index')->with('success', 'Equipo registrado correctamente.');
}

}
