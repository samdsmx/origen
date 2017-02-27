@extends('layouts.baseInicio')
@section('titulo')
Actividades
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
    <h1 style="color:#605ca8;font-weight: bolder;">Gestión de actividades del sistema</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Actividades</a></li>
    </ol>
</section>
<section class="content" style="padding-bottom: 100px;">
    <div id="panel-table">
        <div>
            {{ Form::open() }}
            <table id="tablaActividades" class="table table-bordered table-striped table-dataTable" cellspacing="0" width="100%">
                <tr>
                    <th class="alert-info text-center text-info">NOMBRE</th>
                    <th class="alert-info text-center text-info">DESCRIPCIÓN</th>
                    <th class="alert-info text-center text-info">ESTATUS</th>
                </tr>
                @foreach($actividades as $actividad)
                <tr>
                    <td class="text-center text-info" style="vertical-align: middle;">{{ $actividad->nombre }}</td>
                    <td class="text-center text-info" style="vertical-align: middle;">{{ $actividad->descripcion }}</td>
                    <td class="text-center"><h4><a href="{{ url('/Actividades/cambia/'.$actividad->id_actividad)}}" type="button" class="btn label {{ $actividad->status ? 'label-info' : 'label-danger' }}">{{ $actividad->status ? 'ACTIVO' : 'INACTIVO' }}</a></h4></td>
                </tr>
                @endforeach
            </table>
            {{ Form::close()}}
        </div>
    </div>
</section>
@stop
@section('recursosExtra')
{{ HTML::script('js/bootstrap-editable.js') }}
{{ HTML::style('css/bootstrap-editable.css') }}
<script>
    $('#registraActividad').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'Actividades/registraactividad',
            data: data,
            success: function(response) {
                $('div').removeClass('has-error');
                if (response.errors) {
                    $.each(response.errors, function(index, error) {
                        var campo = $("#grupo-" + index);
                        campo.addClass("has-error");
                    });
                } else {
                    $('html, body').animate({ scrollTop: 0 }, 'fast');                
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                alert("Error en el servidor");
            }
        });
    });


</script>

@stop