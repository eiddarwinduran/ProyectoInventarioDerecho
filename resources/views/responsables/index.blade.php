@extends('layout.app')

@section('content')

<h1>Lista de Responsables</h1>

<a href="{{ route('responsables.create') }}" class="btn btn-primary">Agregar Responsable</a>

{{-- Buscador --}}
<form action="{{ route('responsables.index') }}" method="GET" style="margin: 20px 0;">
    <input type="text" name="search" placeholder="Buscar" value="{{ request('search') }}">
    <button type="submit" >Buscar</button>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
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
