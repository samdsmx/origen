@extends('layouts.baseInicio')
@section('titulo')
Periodos
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
    <h1 style="color:#605ca8;font-weight: bolder;">Calendario y recordatorios</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Calendario y recordatorios</a></li>
    </ol>
</section>
<section class="content">
    {!! Form::open( ) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <iframe SRC='http://localhost:8080/callcenter/vcalendar/index.php' width="980" height="500"></iframe>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close()!!}
</section>
@stop
@section('recursosExtra')
<script>

</script>
@stop
