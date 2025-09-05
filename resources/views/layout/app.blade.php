<!DOCTYPE html>
<html lang="es">
<head>
   <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
    <title>Inventario USFX</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Sistema de Inventario</h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-primary m-2">Gestión de Equipos</a>
    <a href="{{ route('responsables.index') }}" class="btn btn-primary m-2">Gestión de Responsables</a>
    <a href="{{ route('ubicaciones.index') }}" class="btn btn-primary m-2">Gestión de Ubicaciones</a>
    <a href="{{ route('movimientos.index') }}" class="btn btn-primary">Mostrar Asignaciones</a>
    <a href="{{ route('movimientos.create') }}" class="btn btn-primary">Asignar Responsable</a>
    <a href="{{ route('movimientos.reporte') }}" class="btn btn-primary">Informe</a>
    </div>
    <div class="container mt-4">
    <h3> Buscar Movimientos</h3>

    <form action="{{ route('movimientos.buscar') }}" method="GET" class="d-flex mb-4">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar" value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
    </div>


<div class="container mt-5 pt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
