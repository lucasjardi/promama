<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    {{--<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">--}}
    {{--<link rel="icon" type="image/png" href="../assets/img/favicon.png">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/now-ui-dashboard.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>

    <style type="text/css">
        .card-body{
            font-size: 18px !important;
        }
    </style>
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="orange">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
            <div class="logo">
                <a href="{{ url('/') }}" class="simple-text logo-normal">
                    <b>Pró-Mamá - Painel</b>
                </a>
            </div>

            @guest
                <div class="sidebar-wrapper">
                    <img src="{{ asset('img/promama.png') }}">
                </div>
            @endguest

            @auth
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="{{ Request::is('home') || Request::is('/') ? 'active' : '' }}">
                        <a href="{{ url('home') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('bairros') || Request::is('bairros/*') ? 'active' : '' }}">
                        <a href="{{ url('bairros') }}">
                            <i class="fas fa-map"></i>
                            <p>Bairros</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('postos') || Request::is('postos/*') ? 'active' : '' }}">
                        <a href="{{ url('postos') }}">
                            <i class="far fa-hospital"></i>
                            <p>Postos</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('informacoes') || Request::is('informacoes/*') ? 'active' : '' }}">
                        <a href="{{ url('informacoes') }}">
                            <i class="far fa-newspaper"></i>
                            <p>Informações</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('notificacoes') || Request::is('notificacoes/*') ? 'active' : '' }}">
                        <a href="{{ url('notificacoes') }}">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>Notificações</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('duvidas') || Request::is('duvidas/*') ? 'active' : '' }}">
                        <a href="{{ url('duvidas') }}">
                            <i class="fas fa-bullhorn"></i>
                            <p>Fale Conosco</p>
                        </a>
                    </li>
                    <li class="{{ Request::is('duvidas-frequentes') || Request::is('duvidas-frequentes/*') ? 'active' : '' }}">
                        <a href="{{ url('duvidas-frequentes') }}">
                            <i class="far fa-question-circle"></i>
                            <p>Dúvidas Frequentes</p>
                        </a>
                    </li>
                </ul>
            </div>
            @endauth

        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        {{--<a class="navbar-brand" href="#pablo">Table List</a>--}}
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>

                    @auth
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        {{--<form>--}}
                            {{--<div class="input-group no-border">--}}
                                {{--<input type="text" value="" class="form-control" placeholder="Pesquisar...">--}}
                                {{--<span class="input-group-addon">--}}
                                    {{--<i class="now-ui-icons ui-1_zoom-bold"></i>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons users_single-02"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
                @endauth

            </nav>
            <!-- End Navbar -->
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                @yield('content')
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, Designed by
                        <a href="https://www.invisionapp.com" target="_blank">Invision</a>. Coded by
                        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a>.
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="{{ asset('js/dashboard-core/jquery.min.js') }}"></script>
<script src="{{ asset('js/dashboard-core/popper.min.js') }}"></script>
<script src="{{ asset('js/dashboard-core/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/dashboard-plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chart JS -->
<script src="{{ asset('js/dashboard-plugins/chartjs.min.js') }}"></script>
<!--  Notifications Plugin    -->
<script src="{{ asset('js/dashboard-plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/dashboard-core/now-ui-dashboard.js') }}"></script>
<!-- DataTables js -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>

<!-- Tradução DataTables js -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#myTable').DataTable({
            "language" : {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });
    });
</script>

</html>