@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Detalles del Movimiento</h2>

        <ul>
            <li><strong>Equipo:</strong> {{ $movimiento->equipo->codigo ?? '-' }}</li>
            <li><strong>Responsable:</strong> {{ $movimiento->responsable->nombre ?? '' }}
                {{ $movimiento->responsable->apellido ?? '' }}</li>
            <li><strong>Ubicación:</strong> {{ $movimiento->ubicacion->nombre ?? '-' }}</li>
            <li><strong>Tipo:</strong> {{ $movimiento->tipo_movimiento }}</li>
            <li><strong>Fecha:</strong> {{ $movimiento->fecha_movimiento }}</li>
        </ul>

        <a href="{{ route('movimientos.index') }}" class="btn btn-secondary">Volver</a>
    </div>
@endsection