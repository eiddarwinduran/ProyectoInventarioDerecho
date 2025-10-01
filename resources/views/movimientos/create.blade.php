@extends('layout.app')

@section('content')

    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="codigo_text" class="form-label">Equipo</label>
            <input type="text" id="codigo_text" class="form-control" placeholder="Escribe código del equipo" required>
            <input type="hidden" name="codigo" id="codigo">
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Activo">Activo</option>
                <option value="Baja">Baja</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="ci_text" class="form-label">Nuevo Responsable</label>
            <input type="text" id="ci_text" class="form-control" placeholder="Escribe CI o nombre del responsable" required>
            <input type="hidden" name="ci" id="ci">
        </div>

        <div class="mb-3">
            <label for="ubicacion_text" class="form-label">Nueva Ubicación</label>
            <input type="text" id="ubicacion_text" class="form-control" placeholder="Escribe nombre de ubicación" required>
            <input type="hidden" name="id_ubicacion" id="id_ubicacion">
        </div>

        <div class="mb-3">
            <label for="fecha_movimiento" class="form-label">Fecha Movimiento</label>
            <input type="date" name="fecha_movimiento" id="fecha_movimiento" value="{{ date('Y-m-d') }}" class="form-control" required >
        </div>

        <div class="mb-3">
            <label for="detalle" class="form-label">Detalle</label>
            <textarea name="detalle" id="detalle" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function () {
            var equipos = [
                @foreach($equipos as $eq)
                    { label: "{{ $eq->codigo }} ", value: "{{ $eq->codigo }}" },
                @endforeach
            ];

            var responsables = [
                @foreach($responsables as $resp)
                    { label: "{{ $resp->ci }} {{ $resp->nombre }} {{ $resp->apellido }} ", value: "{{ $resp->ci }}" },
                @endforeach
            ];

            var ubicaciones = [
                @foreach($ubicaciones as $ubi)
                    { label: "{{ $ubi->nombre_ubicacion }}", value: "{{ $ubi->id_ubicacion }}" },
                @endforeach
            ];

            $("#codigo_text").autocomplete({
                source: equipos,
                select: function (event, ui) {
                    $("#codigo").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            $("#ci_text").autocomplete({
                source: responsables,
                select: function (event, ui) {
                    $("#ci").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            $("#ubicacion_text").autocomplete({
                source: ubicaciones,
                select: function (event, ui) {
                    $("#id_ubicacion").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });
        });
    </script>

@endsection