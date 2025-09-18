<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\Movimiento;
use App\Models\Equipo;
use Illuminate\Http\Request;

class BajaController extends Controller
{
    public function index()
    {
        $bajas = Baja::with('equipo')->get();
        return view('bajas.index', compact('bajas'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        return view('bajas.create', compact('equipos'));
    }
    public function reporte()
    {
        return view('bajas.reporte');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|exists:equipos,codigo',
            'descripcion' => 'nullable|string',
        ]);

        $baja = Baja::create([
            'codigo' => $request->codigo,
            'estado' => 'Baja',
            'descripcion' => $request->descripcion,
        ]);

        $ultimoMovimiento = Movimiento::where('codigo', $request->codigo)
            ->latest('fecha_movimiento')
            ->first();

        Movimiento::create([
            'codigo' => $request->codigo,
            'ci' => $ultimoMovimiento?->ci,
            'id_ubicacion' => $ultimoMovimiento?->id_ubicacion,
            'estado' => 'baja',
            'fecha_movimiento' => now(),
            'detalle' => 'Equipo dado de baja: ' . $request->descripcion,
        ]);

        return redirect()->route('bajas.index')->with('success', 'Baja registrada y movimiento actualizado.');
    }

    public function search(Request $request)
    {
        $codigo = $request->input('codigo');
        $bajas = Baja::where('codigo', $codigo)->get();

        return view('bajas.index', compact('bajas'));
    }
    public function autocomplete(Request $request)
    {
        $term = $request->get('term');

        $resultados = Baja::with('equipo')
            ->whereHas('equipo', function ($q) use ($term) {
                $q->where('codigo', 'LIKE', "%{$term}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($baja) {
                return [
                    'id' => $baja->id,
                    'value' => $baja->equipo->codigo
                ];
            });

        return response()->json($resultados);
    }

    public function generarReporte(Request $request)
    {
        $tipo = $request->input('tipo');
        $filtro = $request->input('filtro');
        $accion = $request->input('accion');

        $bajas = Baja::with('equipo')
            ->when($tipo == 'codigo', function ($q) use ($filtro) {
                $q->whereHas('equipo', function ($query) use ($filtro) {
                    $query->where('codigo', $filtro);
                });
            })
            ->when($tipo == 'anio', function ($q) use ($filtro) {
                $q->whereYear('fecha_baja', $filtro);
            })
            ->get();

        if ($accion === 'buscar') {
            return view('bajas.reporte', compact('bajas', 'tipo', 'filtro'));
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
        $pdf->Cell(0, 10, 'Reporte de Bajas', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(25, 6, 'Codigo', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Descripcion Equipo', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Fecha Baja', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Estado', 1, 0, 'C');
        $pdf->Cell(65, 6, 'Motivo', 1, 1, 'C');

        $pdf->SetFont('helvetica', '', 8);
        foreach ($bajas as $baja) {
            $codigo = $baja->codigo ?? '';
            $descripcionEquipo = $baja->equipo->descripcion ?? 'N/A';
            $fecha = $baja->fecha_baja ?? '';
            $estado = $baja->estado ?? 'N/A';
            $motivo = $baja->descripcion ?? '';

            $w_codigo = 25;
            $w_descEq = 50;
            $w_fecha = 25;
            $w_estado = 20;
            $w_motivo = 65;
            $h = 6;

            $nb = max(
                $pdf->getNumLines($codigo, $w_codigo),
                $pdf->getNumLines($descripcionEquipo, $w_descEq),
                $pdf->getNumLines($fecha, $w_fecha),
                $pdf->getNumLines($estado, $w_estado),
                $pdf->getNumLines($motivo, $w_motivo)
            );

            $rowHeight = $h * $nb;

            $pdf->MultiCell($w_codigo, $rowHeight, $codigo, 1, 'C', 0, 0);
            $pdf->MultiCell($w_descEq, $rowHeight, $descripcionEquipo, 1, 'L', 0, 0);
            $pdf->MultiCell($w_fecha, $rowHeight, $fecha, 1, 'C', 0, 0);
            $pdf->MultiCell($w_estado, $rowHeight, $estado, 1, 'C', 0, 0);
            $pdf->MultiCell($w_motivo, $rowHeight, $motivo, 1, 'L', 0, 1);
        }

        $pdf->Output('Reporte_Bajas.pdf', 'I');
    }

}
