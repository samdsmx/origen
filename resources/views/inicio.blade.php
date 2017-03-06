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
    <h1 style="color:#605ca8;font-weight: bolder;">Sistema de Inventario de Aplicativos</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
    </ol>
</section>
<section class="content">
    {!!'Usted cuenta con '. sizeof($menu) .' opciones habilitadas.'!!}
    <div style="padding-top: 5%;" >
        @foreach($menu as $opc)
        <div style="display: inline-block; margin-bottom: 15px;" >
            <a href="{!! $opc["url"] !!}" style="text-align: center; display: inline-block; vertical-align: top; width: 200px; padding: 30px;">
                <i class="{!! $opc["icono"] !!} fa-5x" style="color: {!! $opc["color"] !!}"></i>
                <br/>
                {!! $opc["texto"] !!}
                <br/>
                <font style="color: #888686; font-style: italic;">
                {!! $opc["desc"] !!}
                </font>
            </a>
        </div>
        @endforeach
    </div>
</section>
@stop