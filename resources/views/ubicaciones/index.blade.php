@extends('layout.app')

@section('content')
    <h1>Lista de Ubicaciones</h1>

    <a href="{{ route('ubicaciones.create') }}" class="btn btn-primary">Agregar Ubicación</a>
    <form action="{{ route('ubicaciones.buscar') }}" method="GET">
        <input type="text" name="search" placeholder="Buscar" value="{{ request('search') }}">
        <button type="submit">Buscar</button>
    </form>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ubicaciones as $ubi)
                <tr>
                    <td>{{ $ubi->id_ubicacion }}</td>
                    <td>{{ $ubi->nombre_ubicacion }}</td>
                    <td>{{ $ubi->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection