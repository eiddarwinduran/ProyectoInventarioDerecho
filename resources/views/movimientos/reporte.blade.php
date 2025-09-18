@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Reporte de Movimientos</h1>
        <a href="{{ route('movimientos.reporte') }}" class="btn btn-primary">Informe de Movimiento</a>
        <a href="{{ route('bajas.reporte') }}" class="btn btn-primary">Informe de Bajas</a>

        <form action="{{ route('movimientos.generarReporte') }}" method="POST" class="mb-4">
            @csrf
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="">-- Filtrar por --</option>
                        <option value="codigo" {{ (isset($tipo) && $tipo=='codigo') ? 'selected' : '' }}>Código de Equipo</option>
                        <option value="ci" {{ (isset($tipo) && $tipo=='ci') ? 'selected' : '' }}>Responsable</option>
                        <option value="ubicacion" {{ (isset($tipo) && $tipo=='ubicacion') ? 'selected' : '' }}>Ubicación</option>
                        <option value="anio" {{ (isset($tipo) && $tipo=='anio') ? 'selected' : '' }}>Año</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="filtro" id="filtro" class="form-control"
                        placeholder="{{ (isset($tipo) && $tipo=='anio') ? 'Buscar por año (YYYY)...' : 'Escribe el valor' }}"
                        value="{{ $filtro ?? '' }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" name="accion" value="buscar">Buscar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-danger" name="accion" value="pdf">Exportar PDF</button>
                </div>
            </div>
        </form>

        @if(isset($movimientos) && $movimientos->count() > 0)
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Equipo</th>
                        <th>Estado</th>
                        <th>Responsable</th>
                        <th>Ubicación</th>
                        <th>Fecha</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $mov)
                        <tr>
                            <td>{{ $mov->equipo->codigo }} - {{ $mov->equipo->descripcion }}</td>
                            <td>{{ $mov->estado }}</td>
                            <td>{{ $mov->responsable->nombre }} {{ $mov->responsable->apellido }}</td>
                            <td>{{ $mov->ubicacion->nombre_ubicacion }}</td>
                            <td>{{ \Carbon\Carbon::parse($mov->fecha_movimiento)->format('Y-m-d') }}</td>
                            <td>{{ $mov->detalle }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif(isset($movimientos))
            <div class="alert alert-info">No se encontraron movimientos para este filtro.</div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script>
        $(function () {
            let tipo = $("#tipo");

            tipo.on("change", function () {
                if ($(this).val() === "anio") {
                    $("#filtro").attr("placeholder", "Buscar por año (YYYY)...");
                    $("#filtro").val("");
                } else {
                    $("#filtro").attr("placeholder", "Escribe el valor");
                    $("#filtro").val("");
                }
            });

            $("#filtro").autocomplete({
                source: function (request, response) {
                    if (tipo.val() !== "anio") {
                        $.ajax({
                            url: "{{ route('movimientos.autocomplete') }}",
                            data: {
                                term: request.term,
                                tipo: tipo.val()
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    }
                },
                minLength: 1
            });
        });
    </script>
@endsection
