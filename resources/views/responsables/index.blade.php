@extends('layout.app')

@section('content')

    <h2>Lista de Responsables</h2>

    <form action="{{ route('responsables.index') }}" method="GET" style="margin: 20px 0;">
        <input type="text" name="search" placeholder="Buscar" value="{{ request('search') }}">
        <button type="submit">Buscar</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
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