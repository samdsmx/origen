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
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Mis Sistemas</a></li>
    </ol>
</section>
<section class="content">
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaSistemas" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        @if ($dentroPeriodo)
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <a href="{!! url('CrearSistemaMio') !!}"><button type="button" class="btn btn-success pull-left"><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Reportar Nuevo Sistema</button></a>
                        </div>
                        @endif
                        <thead>
                        <th class="alert-info col-md-3">NOMBRE DEL SISTEMA</th>
                        <th class="alert-info col-md-2">PERIODO</th>
                        <th class="alert-info col-md-2">FASE</th>
                        <th class="alert-info col-md-2">OBSERVACI&Oacute;N</th>
                        <th class="alert-info col-md-2">ACCIONES</th>
                        <th class="alert-info col-md-1">FICHA</th>
                        </thead>
                        <tbody>
                            @foreach($sistemas as $sistema)
                            <tr>
                                <td style="vertical-align: middle;" title="{!! $sistema->nombreCompleto !!}">{!! ($sistema->Sistema)?$sistema->Sistema:'Sin nombre' !!}</td>
                                <td style="vertical-align: middle;">{!! $sistema->periodo !!}</td>
                                <td style="vertical-align: middle; {!! (($idPeriodoActual!=$sistema->id_periodo || strpos($sistema->fase,'Incom'))?'color:red;':'') !!} ">{!!($idPeriodoActual==$sistema->id_periodo)?$sistema->fase:"Pendiente" !!}</td>
                                <td style="vertical-align: middle;">{!! (($sistema->observacion == "Baja")?'<span title="'.$sistema->nota.'">'.$sistema->observacion.'</span>':$sistema->observacion) !!}</td>
                                <td style="vertical-align: middle;">
                                    <div class="btn-group">
                                        <a href="{!! url('Ver/'.$sistema->id_sistema) !!}" role="button" data-toogle="tooltip" title="Ver" class="btn btn-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if ($dentroPeriodo && $sistema->status)
                                            <a href="{!! url('ActualizaMiSistema/'.$sistema->id_sistema.'/'.(($sistema->Sistema)?$sistema->Sistema:'Sin nombre')) !!}" role="button" data-toogle="tooltip" data-placement="top" title="Actualizar" class="btn btn-primary actualizar">
                                                <i class="fa fa-level-up"></i>
                                            </a>
                                            @if($sistema->fase != 'Registro Incompleto')
                                                <button data-id="{!!$sistema->id_sistema!!}" data-target="#modalBaja" type="button" data-toggle="modal"  data-placement="top" title="Dar de baja" class="btn btn-danger baja">
                                                <i class="fa fa-times"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-danger eliminar" data-toggle="modal"  data-target="#modalConfirma" data-id="{!!$sistema->id_sistema!!}" data-placement="top" title="Eliminar" >
                                                <i class="fa fa-trash-o"></i>	
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="{!! url('/Consultas/crearexcel/'.$sistema->id_sistema_periodo) !!}"><img width="35" src="{!! asset('images/xls.png' )!!}"/></a>
                                     <a href="{!! url('/Consultas/crearpdf/'.$sistema->id_sistema_periodo) !!}"><img width="35" src="{!! asset('images/pdf.png' )!!}"/></a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@stop
@section('recursosExtra')
<script>

    $('#tablaSistemas').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[10, 15, 20], [10, 15, 20]],
        ordering: true,
        info: true,
        order: [[1, "desc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >',
        columnDefs: [{orderable: false, targets: [3, 4]}]
    });

    $("#tablaSistemas").on("click", ".baja", function() {
        $("#id_hidden_sis").attr("value", $(this).data('id'));
        $("#bajaSistema").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'MisSistemas/bajasistema');
        });
    });

    $("#tablaSistemas").on("click", ".eliminar", function() {
        $('#modalConfirmaTitle').text("Eliminar sistema");
        $("#modalConfirmaId").attr("value", $(this).data('id'));
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'MisSistemas/eliminar');
        });
    });

</script>
@stop
