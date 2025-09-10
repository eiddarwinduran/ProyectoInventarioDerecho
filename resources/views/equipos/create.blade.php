@extends('layout.app')

@section('content')
<body class="bg-light">

    <div class="container">
        <h2 class="mb-4">Registrar Equipo</h2>

        <form action="{{ route('equipos.store') }}" method="POST">
            @csrf
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">Datos del Equipo</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" name="codigo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Activo">Activo</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Equipo</label>
                        <select name="tipo" id="tipo" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="monitor">Monitor</option>
                            <option value="cpu">CPU</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-4 d-none" id="componentes-card">
                <div class="card-header bg-success text-white">Componentes</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Procesador</label>
                        <input type="text" name="procesador" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarjeta Madre</label>
                        <input type="text" name="tarjeta_madre" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Memoria RAM</label>
                        <input type="text" name="ram" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Disco Duro</label>
                        <input type="text" name="disco_duro" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarjeta de Video</label>
                        <select name="tarjeta_video" class="form-select">
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarjeta de Red</label>
                        <select name="tarjeta_red" class="form-select">
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">Asignación inicial (Movimiento)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="ci_text" class="form-label">Responsable</label>
                        <input type="text" id="ci_text" class="form-control" placeholder="Escribe CI o nombre" required>
                        <input type="hidden" name="ci" id="ci">
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion_text" class="form-label">Ubicación</label>
                        <input type="text" id="ubicacion_text" class="form-control" placeholder="Escribe ubicación" required>
                        <input type="hidden" name="id_ubicacion" id="id_ubicacion">
                    </div>
                    <div class="mb-3">
                        <label for="detalle" class="form-label">Detalle</label>
                        <textarea name="detalle" id="detalle" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Equipo</button>
            <a href="{{ route('equipos.index') }}" class="btn btn-secondary m-2">Regresar</a>
        </form>
    </div>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        document.getElementById('tipo').addEventListener('change', function () {
            let componentesCard = document.getElementById('componentes-card');
            if (this.value === 'cpu') {
                componentesCard.classList.remove('d-none');
            } else {
                componentesCard.classList.add('d-none');
            }
        });

        $(function () {
            var responsables = [
                @foreach($responsables as $resp)
                    { label: "{{ $resp->ci }}  {{ $resp->nombre }} {{ $resp->apellido }}", value: "{{ $resp->ci }}" },
                @endforeach
            ];

            var ubicaciones = [
                @foreach($ubicaciones as $ubi)
                    { label: "{{ $ubi->nombre_ubicacion }}", value: "{{ $ubi->id_ubicacion }}" },
                @endforeach
            ];

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
</body>
@endsection
