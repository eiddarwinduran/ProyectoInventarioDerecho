@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Reporte de Movimientos</h1>

        <form action="{{ route('movimientos.generarReporte') }}" method="POST" class="mb-4" target="_blank">
            @csrf
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="tipo" class="form-select" required>
                        <option value="">-- Filtrar por --</option>
                        <option value="codigo">Código de Equipo</option>
                        <option value="ci">CI Responsable</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="filtro" class="form-control" placeholder="Escribe el valor" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="pdf" value="1" class="btn btn-danger">Exportar PDF</button>
                </div>
            </div>
        </form>

        @if(isset($movimientos) && $movimientos->count() > 0)
            <table border="1" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>Equipo</th>
                        <th>Estado</th>
                        <th>Responsable</th>
                        <th>Ubicación</th>
                        <th>Fecha</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $mov)
                        <tr>
                            <td>{{ $mov->equipo->codigo }} - {{ $mov->equipo->descripcion }}</td>
                            <td>{{ $mov->estado }}</td>
                            <td>{{ $mov->responsable->ci }} - {{ $mov->responsable->nombre }} {{ $mov->responsable->apellido }}</td>
                            <td>{{ $mov->ubicacion->nombre_ubicacion }}</td>
                            <td>{{ $mov->fecha_movimiento }}</td>
                            <td>{{ $mov->detalle }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($movimientos))
            <div class="alert alert-info">No se encontraron movimientos para este filtro.</div>
        @endif
    </div>
@endsection