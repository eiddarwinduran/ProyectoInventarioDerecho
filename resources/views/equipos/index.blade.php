@extends('layout.app')

@section('content')
    <h1>Lista de Equipos</h1>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('equipos.create') }}" class="btn btn-primary">Crear Nuevo Equipo</a>
    <br><br>


    <form action="{{ route('equipos.index') }}" method="GET">
        <input type="text" name="search" placeholder="Buscar por código o descripción..." value="{{ request('search') }}">
        <button type="submit">Buscar</button>
    </form>
    <br>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID Equipo</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Procesador</th>
                <th>Tarjeta Madre</th>
                <th>RAM</th>
                <th>Disco Duro</th>
                <th>Tarjeta Video</th>
                <th>Tarjeta Red</th>
            </tr>
        </thead>
        <tbody>
            @forelse($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->id_equipo }}</td>
                    <td>{{ $equipo->codigo }}</td>
                    <td>{{ $equipo->descripcion }}</td>
                    <td>{{ $equipo->estado }}</td>
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
