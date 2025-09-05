

@extends('layout.app')

@section('content')
<h1>Agregar Responsable</h1>

<form action="{{ route('responsables.store') }}" method="POST">
            @csrf

            <!-- Datos del equipo -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Datos del Responsable</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ci" class="form-label">CI</label>
                        <input type="text" name="ci" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" name="cargo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button> <a href="{{ route('responsables.index') }}" class="btn btn-primary m-2">Regresar</a>
        </form>
@endsection