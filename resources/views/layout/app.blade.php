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
        <h1>Sistema de Inventario de Equipos Informaticos</h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-primary m-2">Gestionar Equipos</a>
    <a href="{{ route('responsables.index') }}" class="btn btn-primary m-2">Gestionar Responsables</a>
    <a href="{{ route('ubicaciones.index') }}" class="btn btn-primary m-2">Gestionar Ubicaciones</a>
    <a href="{{ route('movimientos.index') }}" class="btn btn-primary">Gestionar Asignaciones</a>
    <a href="{{ route('bajas.index') }}" class="btn btn-primary">Dar de baja</a>
    <a href="{{ route('movimientos.reporte') }}" class="btn btn-primary">Informe</a>
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
