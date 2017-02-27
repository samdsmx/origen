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
@include('periodos.modalCreaPeriodo')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Gestión de periodos para el registro de aplicativos</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Gestión de periodos para el registro de aplicativos</a></li>
    </ol>
</section>
<section class="content">
    {{ Form::open( ) }}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaPeriodos" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <button id="abrirModal" type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modalCreaPeriodos" ><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar periodo</button>
                        </div>
                        <thead>
                        <th class="alert-info col-md-4">PERIODO</th>
                        <th class="alert-info col-md-3">INICIO</th>
                        <th class="alert-info col-md-3">FIN</th>
                        <th class="alert-info col-md-1">ESTATUS</th>
                        <th class="alert-info col-md-1">MODIFICAR</th>
                        </thead>
                        <tbody>
                            @foreach($periodos as $per)
                            <tr>
                                <td style="vertical-align: middle;">{{ $per->comentarios }}</td>
                                <td style="vertical-align: middle;">{{ $per->fecha_inicio }}</td>
                                <td style="vertical-align: middle;">{{ $per->fecha_fin }}</td>                                    
                                <td style="vertical-align: middle;"><h4><a href="{{ url('/Periodos/cambia/'.$per->id_periodo)}}" type="button" class="btn label {{ $per->status ? 'label-info' : 'label-danger' }}">{{ $per->status ? 'ACTIVO' : 'INACTIVO' }}</a></h4></td>
                                <td>
                                    <div class="btn-group" >
                                        <button type="button" class="btn bg-olive open-PeriodUpdaterModal" data-toggle="modal" data-target="#modalCreaPeriodos" data-id="{{$per->id_periodo}}"><i class='fa fa-edit'></i></button>
                                        @if ( empty($per->conSistemaPeriodo) )
                                        <button type="button" class="btn bg-red-gradient deletePeriodoModal" data-toggle="modal" data-target="#modalConfirma" data-id="{{$per->id_periodo}}"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close()}}
</section>
@stop
@section('recursosExtra')
<script>
    $('#tablaPeriodos').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        ordering: false,
        paging: false,
        info: true,
        language: dataTablesSpanish
    });

    $("#abrirModal").click(function() {
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $('.modal-title').text("Nuevo periodo");
        $("#id_periodo").removeAttr("value");
        $('#fecha_inicio').removeAttr("value");
        $('#fecha_fin').removeAttr("value");
        $('#comentarios').removeAttr("value");
        $("#btnCrearperiodo").attr("value", "Guardar");
    });

    $('#creaPeriodo').submit(function(e) {
        e.preventDefault();
        guardarFormulario($(this).serialize(), 'Periodos/registraperiodo');
    });

    $("#tablaPeriodos").on("click", ".open-PeriodUpdaterModal", function() {
        event.preventDefault();
        var id = $(this).data('id');
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $.ajax({
            type: "POST",
            url: 'Periodos/buscar',
            data: {id: id},
            success: function(response) {
                var periodo = response.periodo;
                $('.modal-title').text("Actualizar Periodo");
                $("#btnCrearperiodo").attr("value", "Aceptar");
                $("#id_periodo").attr("value", periodo.id_periodo);
                $("#fecha_inicio").attr("value", periodo.fecha_inicio);
                $("#fecha_fin").attr("value", periodo.fecha_fin);
                $("#comentarios").attr("value", periodo.comentarios);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error en el servidor");
            }
        });
    });

    $("#tablaPeriodos").on("click", ".deletePeriodoModal", function() {
        $('#modalConfirmaTitle').text("Borrar Periodo");
        $("#modalConfirmaId").attr("value", $(this).data('id'));
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'Periodos/eliminar');
        });
    });

</script>
@stop
