@extends('layout.app')

@section('content')
    <div class="container">
        <h2>Lista de Bajas</h2>
        <hr>
        <form action="{{ route('bajas.search') }}" method="GET">
            <input type="text" name="codigo" placeholder="Buscar por código">
            <button type="submit">Buscar</button>
        </form>

        <hr>

        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Fecha de Baja</th>
                </tr>
            </thead>
            @foreach($bajas as $baja)
                <tr>
                    <td>{{ $baja->id_baja }}</td>
                    <td>{{ $baja->codigo }}</td>
                    <td>{{ $baja->responsable->nombre ?? '' }} {{ $baja->responsable->apellido ?? '' }}</td>
                    <td>{{ $baja->estado }}</td>
                    <td>{{ $baja->descripcion }}</td>
                    <td>{{ $baja->fecha_baja }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection