@extends('layout.app')
@section('content')
    <form action="{{ route('movimientos.storeMultiple') }}" method="POST" id="form-movimientos">
        @csrf

        <div class="mb-3">
            <label for="equipos" class="form-label">Seleccionar Equipos</label>
            <select name="equipos[]" id="equipos" class="form-select" multiple required></select>
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
            <input type="text" id="ci_text" class="form-control" placeholder="Busca responsable" required>
            <input type="hidden" name="ci" id="ci_hidden">
        </div>

        <div class="mb-3">
            <label for="ubicacion_text" class="form-label">Ubicación</label>
            <input type="text" id="ubicacion_text" class="form-control" placeholder="Busca ubicación" required>
            <input type="hidden" name="id_ubicacion" id="id_ubicacion_hidden">
        </div>

        <div class="mb-3">
            <label for="fecha_movimiento" class="form-label">Fecha Movimiento</label>
            <input type="date" name="fecha_movimiento" id="fecha_movimiento" class="form-control"
                value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="detalle" class="form-label">Detalle</label>
            <textarea name="detalle" id="detalle" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Asignar</button>
    </form>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#equipos').select2({
                placeholder: "Buscar y seleccionar equipos",
                ajax: {
                    url: '{{ route("equipos.buscar") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                width: '100%'
                
            });

            var responsables = [
                @foreach($responsables as $resp)
                    { label: "{{ $resp->ci }} - {{ $resp->nombre }} {{ $resp->apellido }}", value: "{{ $resp->ci }}" },
                @endforeach
                            ];

            $("#ci_text").autocomplete({
                source: responsables,
                select: function (event, ui) {
                    $("#ci_hidden").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            var ubicaciones = [
                @foreach($ubicaciones as $ubi)
                    { label: "{{ $ubi->nombre_ubicacion }}", value: "{{ $ubi->id_ubicacion }}" },
                @endforeach
                            ];

            $("#ubicacion_text").autocomplete({
                source: ubicaciones,
                select: function (event, ui) {
                    $("#id_ubicacion_hidden").val(ui.item.value);
                    $(this).val(ui.item.label);
                    return false;
                }
            });
        });
    </script>
@endsection