@extends('layouts.baseInicio')
@section('titulo')
Unidades Responsables
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
@include('unidadesresponsables.modalRegistro')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Gestión de Unidades Responsables</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Gestión de Unidades Responsables</a></li>
    </ol>
</section>
<section class="content">
    {!! Form::open( ) !!}
    <div class="row" style="padding-bottom: 100px;">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaUnidadesResponsables" class="table table-bordered table-striped table-dataTable  text-center" width="100%">
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <button id="abrirModal" type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modalRegistroUR" ><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Unidad Responsable</button>
                        </div>
                        <thead>
                        <th class="alert-info col-md-5">UNIDAD RESPONSABLE</th>
                        <th class="alert-info col-md-3">NOMBRE CORTO</th>
                        <th class="alert-info col-md-2">RESPONSABLE</th>
                        <th class="alert-info col-md-1">ESTATUS</th>
                        <th class="alert-info col-md-1">MODIFICAR</th>
                        </thead>
                        <tbody>
                            @foreach($urs as $ur)
                            <tr>
                                <td style="vertical-align: middle">{!! $ur->nombre_ur !!}</td>
                                <td style="vertical-align: middle">{!! $ur->nombre_corto !!}</td>
                                <td style="vertical-align: middle">{!! $ur->persona == null ? "sin Asignar" : $ur->persona !!}</td>
                                <td style="vertical-align: middle"><h4><a href="{!! url('/UnidadesResponsables/cambia/'.$ur->id_unidad_responsable)!!}" type="button" class="btn label {!! $ur->status ? 'label-info' : 'label-danger' !!}">{!! $ur->status ? 'ACTIVO' : 'INACTIVO' !!}</a></h4></td>
                                <td style="vertical-align: middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn bg-olive open-URUpdaterModal" data-toggle="modal" data-target="#modalRegistroUR" data-id="{!!$ur->id_unidad_responsable!!}"><i class='fa fa-edit'></i></button>
                                        @if ( empty($ur->conPersona) )
                                        <button type="button" class="btn bg-red-gradient deleteURModal" data-toggle="modal" data-target="#modalConfirma" data-id="{!!$ur->id_unidad_responsable!!}"><i class="fa fa-trash"></i></button>
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
    {!! Form::close()!!}
</section>
@stop
@section('recursosExtra')
<script>

    $('#tablaUnidadesResponsables').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[5, 10, 20, 40], [5, 10, 20, 40]],
        ordering: true,
        info: true,
        order: [[0, "asc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >',
        columnDefs: [{orderable: false, targets: [4]}]
    });

    $("#tablaUnidadesResponsables").on("click", ".open-URUpdaterModal", function() {
        var ide = $(this).data('id');
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $.ajax({
            type: 'post',
            url: 'UnidadesResponsables/buscar',
            data: {id: ide},
            success: function(response) {
                var ur = response.ur;
                $('#id_unidad_responsable').attr("value", ur.id_unidad_responsable);
                $('#nombre_ur').attr("value", ur.nombre_ur);
                $('#nombre_corto').attr("value", ur.nombre_corto);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error en el servidor");
            }
        });
    });

    $('#registraUR').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'UnidadesResponsables/registraur',
            data: data,
            success: function(response) {
                $('div').removeClass('has-error');
                $('input').removeAttr("title");
                if (response.errors) {
                    $.each(response.errors, function(index, error) {
                        var campo = $("#d" + index);
                        campo.addClass("has-error");
                        $("#" + index).attr("title", error);
                    });
                } else {
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                alert("Error en el servidor");
            }

        });
    });

    function borrarUnidad(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'UnidadesResponsables/eliminar',
            data: data,
            success: function(response) {
                $('html, body').animate({scrollTop: 0}, 'fast');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error");
            }
        });
    }

    $("#tablaUnidadesResponsables").on("click", ".deleteURModal", function() {
        var id = $(this).data('id');
        $('#modalConfirmaTitle').text("Borrar Unidad Responsable");
        $("#modalConfirmaId").attr("value", id);
        $("#formConfirma").submit(borrarUnidad);
    });

    $("#abrirModal").click(function() {
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $('#id_unidad_responsable').removeAttr("value");
        $('#nombre_ur').removeAttr("value");
        $('#nombre_corto').removeAttr("value");
    });

</script>
@stop