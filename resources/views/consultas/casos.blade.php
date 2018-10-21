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
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Consultas</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Consultas</a></li>
    </ol>
</section>
<section class="content">
    <div class="row" style="padding-bottom: 100px;">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    @include('consultas.busqueda')
                    <table id="tablaCasos" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <thead>
                        <th class="alert-info col-md-1"> </th>
                        <th class="alert-info col-md-1">ID del caso</th>
                        <th class="alert-info col-md-2">FECHA</th>
                        <th class="alert-info col-md-2">NOMBRE</th>
                        <th class="alert-info col-md-2">TELÉFONO</th>
                        <th class="alert-info col-md-2">CONSEJERA</th>
                        <th class="alert-info col-md-2">ACCIONES</th>
                        </thead>
                        <tbody>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('recursosExtra')
<script>
    $("i.fa").popover({'trigger': 'hover'});

    $('.js-example-basic-multiple').select2();

    $('#tablaCasos').DataTable({
       scrollX: false,
        responsive: true,
        searching: false,
        paging: true,
        lengthMenu: [[10, 20, 200], [10, 20, 200]],
        ordering: true,
        info: true,
        order: [[0, "desc"]],
        language: dataTablesSpanish,
    });

    $('#fechaInicial').datepicker(({ dateFormat: 'yy/mm/dd' }));
    $('#fechaFinal').datepicker({ dateFormat: 'yy/mm/dd' });

    function cerrarTableButton(id) {
        let clase = $('#'+id).attr('class');
        if(clase === 'tablaDetallesConsulta') {
            $('#'+id).attr('class','hidden');
            $('#'+id+'button button').html('+');
        } else {
            $('#'+id).attr('class','tablaDetallesConsulta');
            $('#'+id+'button button').html('-');
        }
    }
</script>
@stop
