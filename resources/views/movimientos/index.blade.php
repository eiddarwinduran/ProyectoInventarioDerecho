@extends('layout.app')

@section('content')
<div class="container">
    <h1>Resultado de Busqueda</h1>

    @if(isset($query))
        <p>Resultados de búsqueda para: <strong>{{ $query }}</strong></p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Responsable</th>
                <th>Ubicación</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->id_movimiento }}</td>
                    <td>{{ $movimiento->equipo->codigo ?? 'N/A' }} </td>
                    <td>{{ $movimiento->equipo->descripcion }}</td>
                    <td>{{ $movimiento->responsable->nombre ?? '' }} {{ $movimiento->responsable->apellido ?? '' }}</td>
                    <td>{{ $movimiento->ubicacion->nombre_ubicacion ?? 'N/A' }}</td>
                    <td>{{ $movimiento->fecha_movimiento }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
