<!DOCTYPE HTML>
<html>

<head>
    <title>Editorial by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Main -->
        <div id="main">
            <div class="inner">
                <header id="header">
                    <h2>Facultad de Derecho, Ciencias Politicas y Sociales <br>
                        Sistema de Inventario de Equipos Informaticos</h2>
                </header>

                <!-- Section -->
                <div class="container mt-5 pt-5">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif


                    @yield('content')
                </div>

            </div>
        </div>

        <!-- Sidebar -->
        <div id="sidebar">
            <div class="inner">
                <!-- Menu -->
                <nav id="menu">
                    <header class="major">
                        <img src="{{ asset('images/escudo.png') }}" alt="" height="60px">
                        <h2>Menu</h2>
                    </header>
                    <ul>
                        <li><a href="{{ route('inicio') }}">Inicio</a></li>
                        <li>
                            <span class="opener">Equipos</span>
                            <ul>
                                <li><a href="{{ route('equipos.index') }}">Lista de Equipos</a></li>
                                <li><a href="{{ route('equipos.create') }}">Crear Nuevo Equipo</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="opener">IPs</span>
                            <ul>
                                <li><a href="{{ route('ips.index') }}">Lista de IPs asignados</a></li>
                                <li><a href="{{ route('ips.create') }}">Asignar IP a equipo</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="opener">Responsables</span>
                            <ul>
                                <li><a href="{{ route('responsables.index') }}">Lista de Responsables</a></li>
                                <li><a href="{{ route('responsables.create') }}">Agregar Nuevo Responsable</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="opener">Movimientos</span>
                            <ul>
                                <li><a href="{{ route('movimientos.index') }}">Lista de Movimientos</a></li>
                                <li><a href="{{ route('movimientos.create') }}">Crear Nueva Asignacion</a></li>
                                <li><a href="{{ route('movimientos.storeMultiple') }}">Crear Nueva Asignacion\
                                        Multiple</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="opener">Ubicaciones</span>
                            <ul>
                                <li><a href="{{ route('ubicaciones.index') }}">Lista de Ubicaciones</a></li>
                                <li><a href="{{ route('ubicaciones.create') }}">Agregar Nueva Ubicacion</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="opener">Bajas</span>
                            <ul>
                                <li><a href="{{ route('bajas.index') }}">Lista de Bajas</a></li>
                                <li><a href="{{ route('bajas.create') }}">Dar de Baja</a></li>
                            </ul>
                        </li>
                        <li>
                            <span class="opener">Informe</span>
                            <ul>
                                <li><a href="{{ route('movimientos.reporte') }}">Informe de Movimientos</a></li>
                                <a href="{{ route('bajas.reporte') }}">Informe de Bajas</a>
                            </ul>
                        </li>
                    </ul>
                </nav>

                <!-- Footer -->
                <footer id="footer">
                    <p class="copyright">&copy; Facultad de Derecho, Ciencias Politicas y Sociales</p>
                </footer>

            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="{{ asset('assets/js/browser.min.js') }}"></script>
    <script src="{{ asset('assets/js/breakpoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/util.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
@yield('scripts')
</body>

</html>