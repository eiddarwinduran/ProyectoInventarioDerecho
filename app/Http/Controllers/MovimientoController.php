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


    public function reporte()
    {
        return view('movimientos.reporte');
    }
    public function generarReporte(Request $request)
    {
        $tipo = $request->input('tipo');   // codigo o ci
        $filtro = $request->input('filtro');

        // Consulta dinámica con componentes incluidos
        $movimientos = Movimiento::with(['equipo.componente', 'responsable', 'ubicacion'])
            ->when($tipo == 'codigo', function ($q) use ($filtro) {
                $q->whereHas('equipo', function ($query) use ($filtro) {
                    $query->where('codigo', 'like', "%$filtro%");
                });
            })
            ->when($tipo == 'ci', function ($q) use ($filtro) {
                $q->whereHas('responsable', function ($query) use ($filtro) {
                    $query->where('ci', 'like', "%$filtro%");
                });
            })
            ->get();

        // Si no pide PDF, mostrar en la vista
        if (!$request->has('pdf')) {
            return view('movimientos.reporte', compact('movimientos', 'tipo', 'filtro'));
        }

        // Generar PDF con TCPDF
        $pdf = new \TCPDF('P', 'mm', 'Letter', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->AddPage();
        $pdf->Image(public_path('images/escudo123.png'), 15, 10, 15);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Universidad San Francisco Xavier de Chuquisaca', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 10, 'Reporte de Movimientos', 0, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 8, 'Encargado de Sistemas: Ing. Richard Cruz Pinedo', 0, 1, 'L');
        $pdf->Ln(5);

        // Cabecera tabla
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(30, 6, 'Codigo', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Descripcion', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Responsable', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Ubicacion', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Fecha', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Detalle', 1, 1, 'C');

        // Datos
        $pdf->SetFont('helvetica', '', 8);
        foreach ($movimientos as $mov) {
            $codigo = $mov->equipo->codigo;
            $descripcion = $mov->equipo->descripcion;
            $responsable = $mov->responsable->nombre . " " . $mov->responsable->apellido;
            $ubicacion = $mov->ubicacion->nombre_ubicacion ?? 'N/A';
            $fecha = $mov->fecha_movimiento ? \Carbon\Carbon::parse($mov->fecha_movimiento)->format('Y-m-d') : '';
            $detalle = substr($mov->detalle, 0, 30);

            // Definimos anchos de columnas
            $w_codigo = 30;
            $w_desc = 50;
            $w_resp = 40;
            $w_ubi = 30;
            $w_fecha = 20;
            $w_det = 20;

            // Altura base
            $h = 6;

            // Calculamos número de líneas para las columnas que pueden crecer
            $nb = max(
                $pdf->getNumLines($codigo, $w_codigo),
                $pdf->getNumLines($descripcion, $w_desc),
                $pdf->getNumLines($responsable, $w_resp),
                $pdf->getNumLines($ubicacion, $w_ubi),
                $pdf->getNumLines($fecha, $w_fecha),
                $pdf->getNumLines($detalle, $w_det)
            );

            $rowHeight = $h * $nb; // altura máxima de la fila

            // Guardamos coordenada inicial
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            // Imprimir cada celda con la misma altura
            $pdf->MultiCell($w_codigo, $rowHeight, $codigo, 1, 'C', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M');
            $pdf->MultiCell($w_desc, $rowHeight, $descripcion, 1, 'L', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M');
            $pdf->MultiCell($w_resp, $rowHeight, $responsable, 1, 'C', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M');
            $pdf->MultiCell($w_ubi, $rowHeight, $ubicacion, 1, 'C', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M');
            $pdf->MultiCell($w_fecha, $rowHeight, $fecha, 1, 'C', 0, 0, '', '', true, 0, false, true, $rowHeight, 'M');
            $pdf->MultiCell($w_det, $rowHeight, $detalle, 1, 'L', 0, 1, '', '', true, 0, false, true, $rowHeight, 'M');
        }



        $pdf->Output('Reporte_Movimientos.pdf', 'I');
    }


}
