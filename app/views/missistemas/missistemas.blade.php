@extends('layouts.baseInicio')
@section('titulo')
Sistemas
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
@include('missistemas.modalBaja')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Mis Sistemas</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Mis Sistemas</a></li>
    </ol>
</section>
<section class="content">
    {{ Form::open() }}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaSistemas" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        @if ($dentroPeriodo)
                            <div class="col-md-6" style="padding: 0px; text-align: center;">
                                <a href="{{ url('CrearSistemaMio') }}"><button type="button" class="btn btn-success pull-left"><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Reportar Nuevo Sistema</button></a>
                            </div>
                        @endif
                        <thead>
                        <th class="alert-info col-md-3">NOMBRE DEL SISTEMA</th>
                        <th class="alert-info col-md-2">PERIODO</th>
                        <th class="alert-info col-md-2">FASE</th>
                        <th class="alert-info col-md-2">OBSERVACION</th>
                        <th class="alert-info col-md-2">ACCIONES</th>
                        <th class="alert-info col-md-1">FICHA</th>
                        </thead>
                        <tbody>
                            @foreach($sistemas as $sistema)
                            <tr>
                                <td style="vertical-align: middle;" title="{{ $sistema->nombreCompleto }}">{{ $sistema->Sistema }}</td>
                                <td style="vertical-align: middle;">{{ $sistema->periodo }}</td>
                                <td style="vertical-align: middle;">{{ $sistema->fase }}</td>
                                <td style="vertical-align: middle;">{{ $sistema->observacion }}</td>
                                <td style="vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="#" data-toogle="tooltip" data-placement="top" title="Reportar sin Cambios">
                                            <button data-id="{{ intval( $sistema->id_sistema ) }}" type="button" class="btn btn-success sinCambios">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </a>
                                        <a href="{{ url('ActualizaMiSistema/'.$sistema->id_sistema) }}" data-toogle="tooltip" data-placement="top" title="Actualizar">
                                            <button type="button" class="btn btn-primary actualizar">
                                                <i class="fa fa-level-up"></i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-danger baja" 
                                                data-toggle="modal" data-target="#modalBaja" 
                                                data-id="{{$sistema->id_sistema}}" >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="{{ url('/Consultas/crearexcel/'.$sistema->id_sistema_periodo) }}"><img width="35" src="{{ asset('images/xls.png' )}}"/></a>
                                    <a href="{{ url('/Consultas/crearpdf/'.$sistema->id_sistema_periodo) }}"><img width="35" src="{{ asset('images/pdf.png' )}}"/></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

</section>
@stop
@section('recursosExtra')
<script>

    $('#tablaSistemas').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
        ordering: true,
        info: true,
        order: [[0, "asc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >',
        columnDefs: [{orderable: false, targets: [3, 4]}]
    });

    $('#bajaSistema').submit(function(e) {
        e.preventDefault();
        if (confirm("¿Esta usted seguro?") === true) {
            var data = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: 'MisSistemas/bajasistema',
                data: data,
                success: function(response) {
                    $('div').removeClass('has-error');
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            var campo = $(index);
                            campo.addClass("has-error");
                        });
                    } else {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {

                }
            });
        } else {
        }
    });

    $('.baja').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#id_hidden_sis').val(id);
    });

    $('.sinCambios').click(function(e) {
        e.preventDefault();
        var data = "Id=" + $(this).data("id");
        $.ajax({
            type: 'POST',
            data: data,
            url: 'Sistemas/reportarsincambios',
            success: function(response) {
                if (response.mensaje) {
                    mostrarMensaje("<p>" + response.mensaje + "</p>");
                } else {
                    window.location.href = "Sistemas";
                }
            },
            error: function(xhr, status, error) {
                alert("error en el servidor");
            }
        });
    });
</script>
@stop
