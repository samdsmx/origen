<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sistema Callcenter Origen">
        <meta name="author" content="M en C Sergio A. Marquez De Silva">
        <meta name="csrf-token" content="{!! csrf_token() !!}">
        <link rel="shortcut icon" href="{!! asset('images/Loguito.png' )!!}" type="image/x-icon"/>
        <title>Callcenter - @yield('titulo')</title>
        @section('recursos')
        {!! Html::style('css/bootstrap.min.css') !!}
        {!! Html::style('css/bootstrap-tag-cloud.css') !!}
        {!! Html::style('css/font-awesome.min.css') !!}
        {!! Html::style('css/fileinput.min.css') !!}
        {!! Html::style('css/AdminLTE.min.css') !!}
        {!! Html::style('css/skins/_all-skins.min.css') !!}
        {!! Html::style('css/footer.css') !!}
        {!! Html::style('css/SIAStyle.css') !!}
        {!! Html::style('css/listaDragable.css') !!}
        {!! Html::style('css/jquery-ui.css') !!}
        {!! Html::style('css/header-inicio.css') !!}
        {!! Html::style('css/dataTables.bootstrap.css') !!}
        {!! Html::style('css/chosen.css') !!}
        {!! Html::style('css/select2.css') !!}
        {!! Html::style('css/skins/flat/orange.css') !!}
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
                                <a href="{!! url('inicio') !!}"><i class="fa fa-home"></i><span 
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

            <div class="content-wrapper" style="padding-bottom: 100px;">
                <div class="container">
                    <div id="panel-messages-vista" style=" vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder;" hidden>
                        <div id="mensajeVista" class="alert" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">Test</div>
                    </div>
                    <div id="panel-messages" style=" vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder;">
                        @if(Session::get('mensaje'))
                        <div class="alert alert-success" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{!! Session::get('mensaje') !!}</div>
                        @endif
                        @if(Session::get('mensajeError'))
                        <div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{!! Session::get('mensajeError') !!}</div>
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
        {!! Html::script('js/jQuery-2.1.4.min.js') !!}
        {!! Html::script('js/bootstrap.min.js') !!}
        {!! Html::script('js/bootstrap-tag-cloud.js') !!}
        {!! Html::script('js/ie10-viewport-bug-workaround.js') !!}
        {!! Html::script('js/fileinput.min.js') !!}
        {!! Html::script('js/imageInput.js') !!}
        {!! Html::script('js/app.min.js') !!}
        {!! Html::script('js/fastclick.min.js') !!}
        {!! Html::script('js/login.js') !!}
        {!! Html::script('js/recursos.js') !!}
        {!! Html::script('js/jquery-ui.js') !!}
        {!! Html::script('js/jquery.dataTables.min.js') !!}
        {!! Html::script('js/dataTables.bootstrap.min.js') !!}
        {!! Html::script('js/locales/dataTables_locale_es.js') !!}
        {!! Html::script('js/bootstrap-spinner.js') !!}
        {!! Html::script('js/chosen.jquery.min.js') !!}
        {!! Html::script('js/d3.v3.min.js') !!}
        {!! Html::script('js/select2.js') !!}
        {!! Html::script('js/icheck.js') !!}
        @section('recursosExtra')

        @show
    </body>
</html>