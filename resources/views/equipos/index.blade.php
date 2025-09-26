@extends('layout.app')

@section('content')
    <h2>Lista de Equipos</h2>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('equipos.index') }}" method="GET">
        <input type="text" name="search" placeholder="Buscar por código o descripción..." value="{{ request('search') }}">
        <button type="submit">Buscar</button>
    </form>
    <br>

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Procesador</th>
                <th>Tarjeta Madre</th>
                <th>RAM</th>
                <th>Disco Duro/Disco Solido</th>
                <th>Tarjeta Video</th>
                <th>Tarjeta Red</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->codigo }}</td>
                    <td>{{ $equipo->descripcion }}</td>
                    <td>{{ $equipo->componente->procesador ?? '' }}</td>
                    <td>{{ $equipo->componente->tarjeta_madre ?? '' }}</td>
                    <td>{{ $equipo->componente->ram ?? '' }}</td>
                    <td>{{ $equipo->componente->disco_duro ?? '' }}</td>
                    <td>{{ $equipo->componente->tarjeta_video ?? '' }}</td>
                    <td>{{ $equipo->componente->tarjeta_red ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">No se encontraron equipos</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection