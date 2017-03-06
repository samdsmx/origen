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
        <meta name="csrf-token" content="{!! csrf_token() !!}">
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
        {!! Html::style('css/header-inicio.css') !!}
        {!! Html::style('css/chosen.css') !!}
        @show
    </head>
    <body class="skin-purple layout-top-nav">
        <div class="wrapper">
            <header class="main-header">               
                <nav class="navbar">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            @section('tituloSistema')
                                
                            @show
                        </div>                      
                        @if(Auth::check())
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                @section('opcionesDerecha')
                                  
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
            <div class="content-wrapper" style="background-image: url({!! asset('images/callcenter2.jpg' ) !!}); background-repeat: no-repeat; background-size: cover;">
                <div class="container">
                    <div id="panel-messages" style=" vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder;">
                        @if(Session::get('mensaje'))
                        <div class="alert alert-success" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{!! Session::get('mensaje') !!}</div>
                        @endif
                        @if(Session::get('mensajeError'))
                        <div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">{!! Session::get('mensajeError') !!}</div>
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
        @section('recursosExtra')

        @show
    </body>
</html>
