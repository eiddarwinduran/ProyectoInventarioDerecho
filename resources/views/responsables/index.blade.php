@extends('layout.app')

@section('content')

    <h1>Lista de Responsables</h1>

    <a href="{{ route('responsables.create') }}" class="btn btn-primary">Agregar Responsable</a>

    <form action="{{ route('responsables.index') }}" method="GET" style="margin: 20px 0;">
        <input type="text" name="search" placeholder="Buscar" value="{{ request('search') }}">
        <button type="submit">Buscar</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>CI</th>
                <th>Cargo</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($responsables as $resp)
                <tr>
                    <td>{{ $resp->id_responsable }}</td>
                    <td>{{ $resp->nombre }}</td>
                    <td>{{ $resp->apellido }}</td>
                    <td>{{ $resp->ci }}</td>
                    <td>{{ $resp->cargo }}</td>
                    <td>{{ $resp->telefono }}</td>
                    <td>{{ $resp->correo }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No se encontraron resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection