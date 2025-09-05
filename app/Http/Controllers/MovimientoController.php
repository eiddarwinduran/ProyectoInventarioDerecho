<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Equipo;
use App\Models\Responsable;
use App\Models\Ubicacion;
use PDF;

class MovimientoController extends Controller
{
    public function index()
    {
        $movimientos = Movimiento::with(['equipo', 'responsable', 'ubicacion'])->get();
        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        $responsables = Responsable::all();
        $ubicaciones = Ubicacion::all();

        return view('movimientos.create', compact('equipos', 'responsables', 'ubicaciones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|exists:equipos,codigo',
            'ci' => 'required|exists:responsables,ci',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'detalle' => 'nullable|string',
        ]);

        Movimiento::create($validated);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento creado correctamente.');
    }
    public function buscar(Request $request)
{
    $query = $request->input('q'); // ejemplo: ?q=palabra

    $movimientos = Movimiento::with(['equipo', 'responsable', 'ubicacion'])
        ->where('codigo', 'like', "%{$query}%")
        ->orWhere('ci', 'like', "%{$query}%")
        ->orWhere('detalle', 'like', "%{$query}%")
        ->get();

    return view('movimientos.index', compact('movimientos'));
}
public function show($id)
{
    $movimiento = Movimiento::findOrFail($id);
    return view('movimientos.show', compact('movimiento'));
}

 // Formulario de reporte
    public function reporte()
    {
        return view('movimientos.reporte');
    }

    // Generar reporte filtrado
    public function generarReporte(Request $request)
    {
        $request->validate([
            'filtro' => 'required|string',
            'tipo' => 'required|in:codigo,ci',
        ]);

        $filtro = $request->filtro;
        $tipo = $request->tipo;

        $movimientos = Movimiento::with(['equipo', 'responsable', 'ubicacion'])
                        ->when($tipo === 'codigo', fn($q) => $q->where('codigo', $filtro))
                        ->when($tipo === 'ci', fn($q) => $q->where('ci', $filtro))
                        ->get();

        return view('movimientos.reporte', compact('movimientos', 'filtro', 'tipo'));
    }
    /*public function reportePDF(Request $request)
    {
        $request->validate([
            'filtro' => 'required|string',
            'tipo' => 'required|in:codigo,ci',
        ]);

        $filtro = $request->filtro;
        $tipo = $request->tipo;

        $movimientos = Movimiento::with(['equipo.componentes', 'responsable', 'ubicacion'])
                        ->when($tipo === 'codigo', fn($q) => $q->where('codigo', $filtro))
                        ->when($tipo === 'ci', fn($q) => $q->where('ci', $filtro))
                        ->get();

        $pdf = PDF::loadView('movimientos.reportepdf', compact('movimientos', 'filtro', 'tipo'));
        return $pdf->download("reporte_movimientos_{$tipo}_{$filtro}.pdf");
    }*/
    
}
