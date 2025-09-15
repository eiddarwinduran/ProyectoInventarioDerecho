@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <h2>Reporte de Bajas</h2>
        <a href="{{ route('movimientos.reporte') }}" class="btn btn-primary">Informe de Movimiento</a>
        <a href="{{ route('bajas.reporte') }}" class="btn btn-primary">Informe de Bajas</a>

        <form action="{{ route('bajas.generaReporte') }}" method="GET" class="mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <select name="tipo" class="form-select" required>
                        <option value="codigo" {{ (isset($tipo) && $tipo == 'codigo') ? 'selected' : '' }}>Por Código</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="filtro" id="filtro" class="form-control" placeholder="Buscar por código..."
                        value="{{ $filtro ?? '' }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="accion" value="buscar" class="btn btn-primary w-100">Buscar</button>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="accion" value="pdf" class="btn btn-danger w-100">Generar PDF</button>
                </div>
            </div>
        </form>
        @if(isset($bajas) && count($bajas) > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Código</th>
                            <th>Equipo</th>
                            <th>Fecha Baja</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bajas as $baja)
                            <tr>
                                <td class="text-center">{{ $baja->codigo }}</td>
                                <td>{{ $baja->equipo->descripcion ?? 'N/A' }}</td>
                                <td class="text-center">{{ $baja->fecha_baja }}</td>
                                <td class="text-center">{{ $baja->estado }}</td>
                                <td>{{ $baja->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif(isset($bajas))
            <div class="alert alert-warning">No se encontraron bajas.</div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script>
        $(function () {
            $("#filtro").autocomplete({
                source: "{{ route('bajas.autocomplete') }}",
                minLength: 2,
                select: function (event, ui) {
                    const codigo = ui.item.value.split(' - ')[0].trim();
                    $("#filtro").val(codigo);
                }
            });
        });
    </script>
@endsection