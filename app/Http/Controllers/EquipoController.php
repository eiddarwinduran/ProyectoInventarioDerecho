<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Responsable;
use App\Models\Ubicacion;
use App\Models\Componente;
use App\Models\Movimiento;

class EquipoController extends Controller
{
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

    public function buscar(Request $request)
    {
        $q = $request->input('q');

        $equipos = Equipo::when($q, function ($query, $q) {
            $query->where('codigo', 'like', "%$q%")
                ->orWhere('descripcion', 'like', "%$q%");
        })->get();

        $results = $equipos->map(function ($eq) {
            return [
                'id' => $eq->codigo,
                'text' => $eq->codigo
            ];
        });

        return response()->json($results);
    }



    public function create()
    {
        $responsables = Responsable::all();
        $ubicaciones = Ubicacion::all();
        return view('equipos.create', compact('responsables', 'ubicaciones'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:equipos,codigo',
            'descripcion' => 'required',
            'tipo' => 'required|in:monitor,cpu',

            'procesador' => 'required_if:tipo,cpu',
            'tarjeta_madre' => 'required_if:tipo,cpu',
            'ram' => 'required_if:tipo,cpu',
            'disco_duro' => 'required_if:tipo,cpu',
            'tarjeta_video' => 'required_if:tipo,cpu',
            'tarjeta_red' => 'required_if:tipo,cpu',

            'ci' => 'required|exists:responsables,ci',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'detalle' => 'nullable|string',
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

        $equipo = Equipo::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'id_comp' => $componente ? $componente->id_comp : null,
        ]);

        Movimiento::create([
            'codigo' => $equipo->codigo,
            'ci' => $request->ci,
            'id_ubicacion' => $request->id_ubicacion,
            'estado' => $request->estado,
            'detalle' => $request->detalle,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route('equipos.index')->with('success', 'Equipo y movimiento registrados correctamente.');
    }

}
