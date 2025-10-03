@extends('layout.app')

@section('content')
    <h2>Lista de IPs</h2>

    <form action="{{ route('ips.buscar') }}" method="GET">
        <input type="text" name="ip" placeholder="Buscar" value="{{ request('ip') }}">
        <button type="submit">Buscar</button>
    </form>

    <br>
    @if(isset($query))
        <p>Resultados de búsqueda para: <strong>{{ $query }}</strong></p>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>Codigo de Equipo</th>
                <th>Ubicacion</th>
                <th>IP</th>
                <th>Subred</th>
                <th>Gateway</th>
                <th>Direccion Fisica</th>
                <th>puerto</th>
                <th>Switch</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ips as $ip)
                <tr>
                    <td>{{ $ip->equipo->codigo ?? 'N/A' }}</td>
                    <td>{{ $ip->ubicacion->nombre_ubicacion ?? 'N/A' }}</td>
                    <td>{{ $ip->ip }}</td>
                    <td>{{ $ip->subred ?? 'N/A' }}</td>
                    <td>{{ $ip->gateway ?? 'N/A' }} </td>
                    <td>{{ $ip->mac ?? 'N/A' }} </td>
                    <td>{{ $ip->puerto ?? 'N/A' }} </td>
                    <td>{{ $ip->switch ?? 'N/A' }} </td>
                    <td>
                        <a href="{{ route('ips.edit', $ip->id_ip) }}" class="btn btn-warning">Editar</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No se encontraron resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection