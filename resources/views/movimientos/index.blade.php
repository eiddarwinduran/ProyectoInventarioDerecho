@extends('layout.app') 

@section('content')
    <h2>Lista de Movimientos</h2>

    <form action="{{ route('movimientos.buscar') }}" method="GET">
        <input type="text" name="q" placeholder="Buscar" value="{{ request('q') }}">
        <button type="submit">Buscar</button>
    </form>

    <br>
    @if(isset($query))
        <p>Resultados de búsqueda para: <strong>{{ $query }}</strong></p>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
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
                    <td>{{ $movimiento->equipo->codigo ?? 'N/A' }}</td>
                    <td>{{ $movimiento->equipo->descripcion }}</td>
                    <td>{{ $movimiento->estado }}</td>
                    <td>{{ $movimiento->responsable->nombre ?? '' }} {{ $movimiento->responsable->apellido ?? '' }}</td>
                    <td>{{ $movimiento->ubicacion->nombre_ubicacion ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($movimiento->fecha_movimiento)->format('Y-m-d') }}</td>
                    <td>{{ $movimiento->detalle }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se encontraron resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
