<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema Callcenter Origen">
        <meta name="author" content="M en C Sergio A. Marquez De Silva">
        <link rel="shortcut icon" href="{{ asset('images/Loguito.png' )}}" type="image/x-icon"/>
        <title>Callcenter - @yield('titulo')</title>
        @section('recursos')
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-tag-cloud.css') }}
        {{ HTML::style('css/font-awesome.min.css') }}
        {{ HTML::style('css/fileinput.min.css') }}
        {{ HTML::style('css/AdminLTE.min.css') }}
        {{ HTML::style('css/skins/_all-skins.min.css') }}
        {{ HTML::style('css/footer.css') }}
        {{ HTML::style('css/SIAStyle.css') }}
        {{ HTML::style('css/listaDragable.css') }}
        {{ HTML::style('css/jquery-ui.css') }}
        {{ HTML::style('css/header-inicio.css') }}
        {{ HTML::style('css/dataTables.bootstrap.css') }}
        {{ HTML::style('css/chosen.css') }}
        @show
    </head>
    <body class="skin-purple-light sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                @section('tituloSistema')

                @show
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            @section('opcionesDerecha')    

                            @show
                        </ul>
                    </div>
                </nav>
            </header>
            <aside class="main-sidebar">
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 945px;">
                    <section class="sidebar" style="height: 945px; overflow: hidden; width: auto;">
                        <ul class="sidebar-menu">
                            <li class="header">Menú principal</li>
                            <li>
                                <a href="{{ url('inicio') }}"><i class="fa fa-home"></i><span 
                                        style="width: 200px; white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-break: break-word;">Inicio</span></a>
                            </li>
                            @section('menu')
                            @show
                        </ul>
                    </section>
                    <div class="slimScrollBar" style="width: 3px; position: absolute; top: 0px; opacity: 0.4; 
                         display: none; border-radius: 7px; z-index: 99; right: 1px; height: 905.705px; background: rgba(0, 0, 0, 0.2);"></div>
                    <div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px;
                         display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
                </div>
            </aside>

            <div class="content-wrapper">
                <div class="container">
                    <div id="panel-messages-vista" style=" vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder;" hidden>
                        <div id="mensajeVista" class="alert" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">Test</div>
                    </div>
                    <div id="panel-messages" style=" vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder;">
                        @if(Session::get('mensaje'))
                        <div class="alert alert-success" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{{ Session::get('mensaje') }}</div>
                        @endif
                        @if(Session::get('mensajeError'))
                        <div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{{ Session::get('mensajeError') }}</div>
                        @endif
                    </div>
                    <div id="dialog" title=""></div>
                    @include('actividadesusuario.modalRegistro')
                    @include('layouts.modalConfirma')
                    @yield('cuerpo')
                </div>
            </div>
            <footer class="main-footer" style="width: 100%; position: fixed; bottom: 0%; max-height: 100px;">
                <div class="container" style="padding-right:  250px">
                    @include('includes.footer')
                </div>
            </footer>
        </div>
        {{ HTML::script('js/jQuery-2.1.4.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/bootstrap-tag-cloud.js') }}
        {{ HTML::script('js/ie10-viewport-bug-workaround.js') }}
        {{ HTML::script('js/fileinput.min.js') }}
        {{ HTML::script('js/imageInput.js') }}
        {{ HTML::script('js/app.min.js') }}
        {{ HTML::script('js/fastclick.min.js') }}
        {{ HTML::script('js/login.js') }}
        {{ HTML::script('js/recursos.js') }}
        {{ HTML::script('js/jquery-ui.js') }}
        {{ HTML::script('js/jquery.dataTables.min.js') }}
        {{ HTML::script('js/dataTables.bootstrap.min.js') }}
        {{ HTML::script('js/locales/dataTables_locale_es.js') }}
        {{ HTML::script('js/bootstrap-spinner.js') }}
        {{ HTML::script('js/chosen.jquery.min.js') }}
        {{ HTML::script('//d3js.org/d3.v3.min.js') }}
        @section('recursosExtra')

        @show
    </body>
</html>