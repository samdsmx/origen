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
                        <th class="alert-info col-md-2">ID del caso</th>
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

    $('#tablaCasos').DataTable({
       scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[10, 20, 200], [10, 20, 200]],
        ordering: true,
        info: true,
        order: [[0, "desc"]],
        language: dataTablesSpanish,
		ajax: {
            type: 'POST',
            url: 'Consultas/casosllamadas',
            data: {
              'tamanio': 0,
              'num_elementos': 0
            },
            dataSrc: function(response) {
				console.log(response);
              var resultado = [];
              for(var i=0;i<response.length;i++) {
                var ele = response[i];
                var arrayInterno = [];
                arrayInterno.push(ele.IDCaso);
                arrayInterno.push(ele.FechaLlamada);
                arrayInterno.push(ele.Nombre);
                arrayInterno.push(ele.Telefono);
                arrayInterno.push(ele.nombres+' '+ele.primer_apellido+' '+ele.segundo_apellido);
				arrayInterno.push('<input type="hidden" class="datosCaso" value="'+ele.IDCaso+'/'+ele.LlamadaNo+'"/>'
										+'<button type="button" style="margin-right:10%;" class="btn btn-warning verLlamada">'
                                        +'<span class="fa fa-eye"></span>'
                                        +'</button> '
                                        +'<button type="button" class="btn btn-success llamadaSeguimiento">'
                                        +'<span class="fa fa-plus"></span>'
                                        +'</button>');
                resultado.push(arrayInterno);
              }
              return resultado;
            }
        },
    });
</script>
@stop
