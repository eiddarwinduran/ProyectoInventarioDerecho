<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimiento;
use App\Models\Equipo;
use App\Models\Responsable;
use App\Models\Ubicacion;
use TCPDF;

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
            'estado' => 'nullable',
            'ci' => 'required|exists:responsables,ci',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'detalle' => 'nullable|string',
        ]);

        Movimiento::create($validated);

        return redirect()->route('movimientos.index')->with('success', 'Movimiento creado correctamente.');
    }
    public function autocomplete(Request $request)
    {
        $tipo = $request->get('tipo');
        $term = $request->get('term');

        $resultados = [];

        if ($tipo === 'codigo') {
            $resultados = Equipo::where('codigo', 'LIKE', "%{$term}%")
                ->limit(10)
                ->select('codigo as label', 'codigo as value')
                ->get();
        } elseif ($tipo === 'ci') {
            $resultados = Responsable::where('ci', 'LIKE', "%{$term}%")
                ->orWhere('nombre', 'LIKE', "%{$term}%")
                ->orWhere('apellido', 'LIKE', "%{$term}%")
                ->limit(10)
                ->selectRaw("CONCAT(ci, ' - ', nombre, ' ', apellido) as label, ci as value")
                ->get();
        } elseif ($tipo === 'ubicacion') {
            $resultados = Ubicacion::where('nombre_ubicacion', 'LIKE', "%{$term}%")
                ->limit(10)
                ->select('nombre_ubicacion as label', 'nombre_ubicacion as value')
                ->get();
        }

        return response()->json($resultados);
    }
    public function buscar(Request $request)
    {
        $query = $request->input('q');

        $movimientos = Movimiento::with(['equipo', 'responsable', 'ubicacion'])
            ->where('codigo', 'like', "%{$query}%")
            ->orWhereHas('responsable', function ($q) use ($query) {
                $q->where('nombre', 'like', "%{$query}%")
                    ->orWhere('apellido', 'like', "%{$query}%")
                    ->orWhere('ci', 'like', "%{$query}%");
            })
            ->orWhere("estado", "like", "%{$query}%")
            ->orWhere('detalle', 'like', "%{$query}%")
            ->orWhereHas('ubicacion', function ($q) use ($query) {
                $q->where('nombre_ubicacion', 'like', "%{$query}%")
                    ->orWhere('descripcion', 'like', "%{$query}%");
            })
            ->get();

        return view('movimientos.index', compact('movimientos'));
    }
    public function show($id)
    {
        $movimiento = Movimiento::findOrFail($id);
        return view('movimientos.show', compact('movimiento'));
    }
    public function storeMultiple(Request $request)
    {
        if ($request->isMethod('get')) {
            $equipos = Equipo::all();
            $responsables = Responsable::all();
            $ubicaciones = Ubicacion::all();
            return view('movimientos.storeMultiple', compact('equipos', 'responsables', 'ubicaciones'));
        }

        $request->validate([
            'equipos' => 'required|array',
            'equipos.*' => 'exists:equipos,codigo',
            'ci' => 'required|exists:responsables,ci',
            'id_ubicacion' => 'required|exists:ubicaciones,id_ubicacion',
            'fecha_movimiento' => 'required|date',
            'estado' => 'nullable',
            'detalle' => 'nullable|string',
        ]);

        foreach ($request->equipos as $codigo) {
            Movimiento::create([
                'codigo' => $codigo,
                'ci' => $request->ci,
                'id_ubicacion' => $request->id_ubicacion,
                'estado' => $request->estado,
                'fecha_movimiento' => $request->fecha_movimiento,
                'detalle' => $request->detalle ?? 'Asignación múltiple',
            ]);
        }

        return redirect()->route('movimientos.index')->with('success', 'Equipos asignados correctamente.');
    }


    public function reporte()
    {
        return view('movimientos.reporte');
    }
    public function generarReporte(Request $request)
    {
        $tipo = $request->input('tipo');   // codigo, ci, ubicacion
        $filtro = $request->input('filtro');
        $accion = $request->input('accion');

        $movimientos = Movimiento::with(['equipo', 'responsable', 'ubicacion'])
            ->when($tipo == 'codigo', function ($q) use ($filtro) {
                $q->whereHas('equipo', function ($query) use ($filtro) {
                    $query->where('codigo', 'like', "%$filtro%");
                });
            })
            ->when($tipo == 'ci', function ($q) use ($filtro) {
                $q->whereHas('responsable', function ($query) use ($filtro) {
                    $query->where('ci', 'like', "%$filtro%")
                        ->orWhere('nombre', 'like', "%$filtro%")
                        ->orWhere('apellido', 'like', "%$filtro%");
                });
            })
            ->when($tipo == 'ubicacion', function ($q) use ($filtro) {
                $q->whereHas('ubicacion', function ($query) use ($filtro) {
                    $query->where('nombre_ubicacion', 'like', "%$filtro%")
                        ->orWhere('descripcion', 'like', "%$filtro%");
                });
            })
            ->when($tipo == 'anio', function ($q) use ($filtro) {
                $q->whereYear('fecha_movimiento', $filtro);
            })
            ->get();

        if ($accion === 'buscar') {
            return view('movimientos.reporte', compact('movimientos', 'tipo', 'filtro'));
        }

        // Acción PDF → generar PDF
        $pdf = new \TCPDF('P', 'mm', 'Letter', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->AddPage();

        $pdf->Image(public_path('images/escudo123.png'), 15, 10, 15);

        $pdf->SetFont('helvetica', 'I', 14);
        $pdf->Cell(0, 10, 'Universidad San Francisco Xavier de Chuquisaca', 0, 1, 'C');
        $pdf->Cell(0, 10, 'Facultad de Derecho, Ciencias Políticas y Sociales', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Reporte de Movimientos', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(25, 6, 'Codigo', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Descripcion Equipo', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Responsable', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Ubicacion', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Fecha', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Estado', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Detalle', 1, 1, 'C');

        $pdf->SetFont('helvetica', '', 8);
        foreach ($movimientos as $mov) {
            $codigo = $mov->equipo->codigo ?? '';
            $descripcionEquipo = $mov->equipo->descripcion ?? 'N/A';
            $responsable = $mov->responsable ? ($mov->responsable->nombre . " " . $mov->responsable->apellido) : 'N/A';
            $ubicacion = $mov->ubicacion->nombre_ubicacion ?? 'N/A';
            $fecha = $mov->fecha_movimiento ? \Carbon\Carbon::parse($mov->fecha_movimiento)->format('Y-m-d') : '';
            $estado = $mov->estado ?? 'N/A';
            $detalle = $mov->detalle ?? '';

            $w_codigo = 25;
            $w_descEq = 45;
            $w_resp = 35;
            $w_ubi = 25;
            $w_fecha = 20;
            $w_estado = 20;
            $w_detalle = 25;
            $h = 6;

            $nb = max(
                $pdf->getNumLines($codigo, $w_codigo),
                $pdf->getNumLines($descripcionEquipo, $w_descEq),
                $pdf->getNumLines($responsable, $w_resp),
                $pdf->getNumLines($ubicacion, $w_ubi),
                $pdf->getNumLines($fecha, $w_fecha),
                $pdf->getNumLines($estado, $w_estado),
                $pdf->getNumLines($detalle, $w_detalle)
            );

            $rowHeight = $h * $nb;

            $pdf->MultiCell($w_codigo, $rowHeight, $codigo, 1, 'C', 0, 0);
            $pdf->MultiCell($w_descEq, $rowHeight, $descripcionEquipo, 1, 'L', 0, 0);
            $pdf->MultiCell($w_resp, $rowHeight, $responsable, 1, 'C', 0, 0);
            $pdf->MultiCell($w_ubi, $rowHeight, $ubicacion, 1, 'C', 0, 0);
            $pdf->MultiCell($w_fecha, $rowHeight, $fecha, 1, 'C', 0, 0);
            $pdf->MultiCell($w_estado, $rowHeight, $estado, 1, 'C', 0, 0);
            $pdf->MultiCell($w_detalle, $rowHeight, $detalle, 1, 'L', 0, 1);
        }

        $pdf->Output('Reporte_Movimientos.pdf', 'I');
    }


}
