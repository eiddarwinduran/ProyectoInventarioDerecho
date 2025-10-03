@extends('layout.app')

@section('content')

    <form action="{{ route('ips.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="codigo_text" class="form-label">Equipo</label>
            <input type="text" id="codigo_text" class="form-control" placeholder="Escribe código del equipo" required>
            <input type="hidden" name="codigo" id="codigo">
        </div>
        <div class="mb-3">
            <label for="ubicacion_text" class="form-label">Ubicación</label>
            <input type="text" id="ubicacion_text" class="form-control" placeholder="Escribe nombre de ubicación" required>
            <input type="hidden" name="id_ubicacion" id="id_ubicacion">
        </div>
        <div class="mb-3">
            <label for="ip" class="form-label">IP</label>
            <input type="text" id="ip" name="ip" class="form-control" placeholder="Ej: 192.168.1.22" required>
        </div>
        <div class="mb-3">
            <label for="subred" class="form-label">Subred</label>
            <input type="text" id="subred" name="subred" class="form-control" placeholder="Ej: 255.255.255.0">
        </div>
        <div class="mb-3">
            <label for="gateway" class="form-label">Gateway</label>
            <input type="text" id="gateway" name="gateway" class="form-control" placeholder="Ej: 192.168.1.1">
        </div>
        <div class="mb-3">
            <label for="mac" class="form-label">Direccion Fisica</label>
            <input type="text" id="mac" name="mac" class="form-control" placeholder="Ej: 80-5E-C0-93-F6-D0">
        </div>
        <div class="mb-3">
            <label for="puerto" class="form-label">Puerto de Switch</label>
            <input type="text" id="puerto" name="puerto" class="form-control" placeholder="Ej: 22">
        </div>
        <div class="mb-3">
            <label for="switch" class="form-label">SWITCH</label>
            <input type="text" id="switch" name="switch" class="form-control" placeholder="Ej: SW-COM">
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