@extends('layout.app')

@section('content')
    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf

        {{-- Equipo --}}
        <div class="mb-3">
            <label for="codigo_text" class="form-label">Equipo</label>
            <input type="text" id="codigo_text" class="form-control" placeholder="Escribe código del equipo" required>
            <input type="hidden" name="codigo" id="codigo">
        </div>

        {{-- Responsable --}}
        <div class="mb-3">
            <label for="ci_text" class="form-label">Responsable</label>
            <input type="text" id="ci_text" class="form-control" placeholder="Escribe CI o nombre del responsable" required>
            <input type="hidden" name="ci" id="ci">
        </div>

        {{-- Ubicación --}}
        <div class="mb-3">
            <label for="ubicacion_text" class="form-label">Ubicación</label>
            <input type="text" id="ubicacion_text" class="form-control" placeholder="Escribe nombre de ubicación" required>
            <input type="hidden" name="id_ubicacion" id="id_ubicacion">
        </div>

        {{-- Fecha --}}
        <div class="mb-3">
            <label for="fecha_movimiento" class="form-label">Fecha Movimiento</label>
            <input type="date" name="fecha_movimiento" id="fecha_movimiento" class="form-control" required>
        </div>

        {{-- Detalle --}}
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
            // Datos desde PHP
            var equipos = [
                @foreach($equipos as $eq)
                    { label: "{{ $eq->codigo }} ", value: "{{ $eq->codigo }}" },
                @endforeach
        ];

            var responsables = [
                @foreach($responsables as $resp)
                    { label: "{{ $resp->ci }} ", value: "{{ $resp->ci }}" },
                @endforeach
        ];

            var ubicaciones = [
                @foreach($ubicaciones as $ubi)
                    { label: "{{ $ubi->nombre_ubicacion }}", value: "{{ $ubi->id_ubicacion }}" },
                @endforeach
        ];

            // Autocomplete Equipo
            $("#codigo_text").autocomplete({
                source: equipos,
                select: function (event, ui) {
                    $("#codigo").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            // Autocomplete Responsable
            $("#ci_text").autocomplete({
                source: responsables,
                select: function (event, ui) {
                    $("#ci").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            // Autocomplete Ubicación
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