@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Resultado</h1>

        <div>
            <a href="{{ route('movimientos.create') }}" class="btn btn-primary">Asignar Responsable</a>
            <a href="{{ route('movimientos.storeMultiple') }}" class="btn btn-primary">Asignacion Multiple</a>
            <br><br>
        </div>
    </div>
    <br>
    @if(isset($query))
        <p>Resultados de búsqueda para: <strong>{{ $query }}</strong></p>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Responsable</th>
                <th>Ubicación</th>
                <th>Fecha</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->id_movimiento }}</td>
                    <td>{{ $movimiento->equipo->codigo ?? 'N/A' }} </td>
                    <td>{{ $movimiento->equipo->descripcion }}</td>
                    <td>{{ $movimiento->estado }}</td>
                    <td>{{ $movimiento->responsable->nombre ?? '' }} {{ $movimiento->responsable->apellido ?? '' }}</td>
                    <td>{{ $movimiento->ubicacion->nombre_ubicacion ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('Y-m-d') }}</td>
                    <td>{{ $movimiento->detalle }}</td>
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