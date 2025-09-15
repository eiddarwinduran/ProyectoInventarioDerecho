@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h2>Registrar Baja de Equipo</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bajas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="codigo_text" class="form-label">Equipo</label>
            <input type="text" id="codigo_text" class="form-control" placeholder="Escribe código o descripción del equipo" required>
            <input type="hidden" name="codigo" id="codigo">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Motivo de Baja</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Dar de Baja</button>
        <a href="{{ route('bajas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- jQuery UI Autocomplete --}}
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    $(document).ready(function () {
        var equipos = [
            @foreach($equipos as $eq)
                { label: "{{ $eq->codigo }}" },
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
    });
</script>
@endsection
