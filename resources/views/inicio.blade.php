@extends('layouts.baseInicio')
@section('titulo')
Bienvenido
@stop

@section('tituloSistema')
@include('includes.tituloSistemaInicio')
@stop

@section('menu')
@include('includes.menu')
@stop

@section('opcionesDerecha')
@include('includes.opcionesDerechaInicio')
@stop

@section('encabezado')

@stop

@section('cuerpo')
<section class="content-header">
    <ol class="breadcrumb pull-right ">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
    </ol>
</section>
<section class="content">
    <?php
    $llamadasMes=0;
    $misAtendidas=0;
    ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-line-chart"></i></span>
                <div class="info-box-content" style="padding: 0px 10px !important;">
                  <span class="info-box-text">En este mes se han recibido</span>
                  <span class="info-box-number">{!! $llamadasMes !!}<small> llamadas</small></span>
                  <span class="info-box-text"> y tu has atendido </span>
                  <span class="info-box-number">{!! $misAtendidas !!}<small> llamadas</small></span>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-7">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-exclamation-triangle"></i></span>
            <div class="info-box-content" style="padding: 0px 10px !important;">
              <p style="text-align: justify;">La información y asesoría que se brinde a través de la línea de ayuda, incluyendo los casos (nombres y datos personales) es confidencial, por lo que queda estrictamente prohibido el uso de esta información al exterior de la institución, ya sea para análisis o algún otro motivo ajeno a nuestro objetivos.</p>
            </div>
          </div>
        </div>


      </div>



    <div>
        @foreach($menu as $opc)
            @if ($opc['icono'] !== '')
                <div style="display: inline-block; margin-bottom: 15px;" >
                    <a href="{!! $opc['url'] !!}" style="text-align: center; display: inline-block; vertical-align: top; width: 200px; padding: 30px;">
                        <i class="{!! $opc['icono'] !!} fa-5x" style="color: {!! $opc['color'] !!}"></i>
                        <br/>
                        {!! $opc["texto"] !!}
                        <br/>
                        <font style="color: #888686; font-style: italic;">
                        {!! $opc["desc"] !!}
                        </font>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</section>
@stop