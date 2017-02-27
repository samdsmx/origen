<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
        {{ HTML::style('css/header-inicio.css') }}
        {{ HTML::style('css/chosen.css') }}
        @show
    </head>
    <body class="skin-purple layout-top-nav">
        <div class="wrapper">
            <header class="main-header">               
                <nav class="navbar navbar-static-top">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            @section('tituloSistema')
                                
                            @show
                        </div>                      
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                @section('menu')
                                    
                                @show
                            </ul>
                        </div>
                        @if(Auth::check())
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                @section('opcionesDerechaHome')
                                  
                                @show
                            </ul>
                        </div> 
                        @else
                        <div class="collapse navbar-collapse" id="navbar-collapse">
                            @section('opcionesDerecha')
                                
                            @show
                        </div>
                        @endif
                        
                    </div>
                </nav>
            </header>
            <div class="content-wrapper" style="background-image: url({{ asset('images/callcenter2.jpg' ) }}); background-repeat: no-repeat; background-size: cover;">
                <div class="container">
                    <div id="panel-messages" style=" vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder;">
                        @if(Session::get('mensaje'))
                        <div class="alert alert-success" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{{ Session::get('mensaje') }}</div>
                        @endif
                        @if(Session::get('mensajeError'))
                        <div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{{ Session::get('mensajeError') }}</div>
                        @endif
                    </div>
                    @yield('cuerpo')
                </div>
            </div>
            <footer class="main-footer" style="width: 100%; position: fixed; bottom: 0%; max-height: 100px;">
                <div class="container">
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
