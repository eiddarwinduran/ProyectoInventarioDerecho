
@extends('layout.app')

@section('content')
<h1>Agregar Ubicación</h1>

<form action="{{ route('ubicaciones.store') }}" method="POST">
            @csrf
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Datos de la Ubicacion</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nombre_ubicacion" class="form-label">Nombre de la ubicacion</label>
                        <input type="text" name="nombre_ubicacion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" required></textarea>
                    </div>
            </div>
        </div>
            <button type="submit" class="btn btn-primary">Guardar Ubicacion</button> <a href="{{ route('ubicaciones.index') }}" class="btn btn-primary m-2">Regresar</a>
        </form>
@endsection