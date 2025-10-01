@extends('layout.app')

@section('content')
    <h2>Lista de Ubicaciones</h2>

    <form action="{{ route('ubicaciones.buscar') }}" method="GET">
        <input type="text" name="p" placeholder="Buscar" value="{{ request('p') }}">
        <button type="submit">Buscar</button>
    </form>
    <br>
    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ubicaciones as $ubi)
                <tr>
                    <td>{{ $ubi->nombre_ubicacion }}</td>
                    <td>{{ $ubi->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection