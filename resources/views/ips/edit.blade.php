@extends('layout.app')

@section('content')
<h3>Editar IP del equipo</h3>

<form action="{{ route('ips.update', $ip->id_ip) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Equipo</label>
        <input type="text" class="form-control" value="{{ $ip->equipo->codigo ?? 'N/A' }}" disabled>
    </div>

    <div class="mb-3">
        <label for="ip" class="form-label">IP</label>
        <input type="text" id="ip" name="ip" class="form-control" value="{{ $ip->ip }}" required>
    </div>

    <div class="mb-3">
        <label for="subred" class="form-label">Subred</label>
        <input type="text" id="subred" name="subred" class="form-control" value="{{ $ip->subred }}">
    </div>

    <div class="mb-3">
        <label for="gateway" class="form-label">Gateway</label>
        <input type="text" id="gateway" name="gateway" class="form-control" value="{{ $ip->gateway }}">
    </div>

    <div class="mb-3">
        <label for="mac" class="form-label">Direccion Fisica</label>
        <input type="text" id="mac" name="mac" class="form-control" value="{{ $ip->mac }}">
    </div>

    <div class="mb-3">
        <label for="puerto" class="form-label">Puerto de Switch</label>
        <input type="text" id="puerto" name="puerto" class="form-control" value="{{ $ip->puerto }}">
    </div>

    <div class="mb-3">
        <label for="switch" class="form-label">SWITCH</label>
        <input type="text" id="switch" name="switch" class="form-control" value="{{ $ip->switch }}">
    </div>

    <button type="submit" class="btn btn-success">Actualizar</button>
    <a href="{{ route('ips.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
