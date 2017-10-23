@extends('layouts.baseInicio')
@section('titulo')
Grupos
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
@include('grupos.modalRegistro')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Gestión de Catalogos.</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Catalogos</a></li>
    </ol>
</section>
<section class="content">
    {!! Form::open( ) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                   
                    <table id="tablaGrupos" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <button id="abrirModal" type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modalRegistroGrupo" ><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Campo</button>
                            <div class="col-md-1" style="line-height: 33px;"><label for="tipo">Tipo:</label></div>
                            <div class="col-md-3">
                                <select name="tipo" class="form-control" onchange="filtro();" >
                                    @foreach($tipos as $tipo)
                                        <option value="{!! $tipo->Tipo !!}">{!! $tipo->Tipo !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    
    

                        <thead>
                        <th class="alert-info col-md-5">TIPO</th>
                        <th class="alert-info col-md-5">DESCRIPCION</th>
                        <th class="alert-info col-md-1">ESTATUS</th>
                        <th class="alert-info col-md-1">OPERACIONES</th>
                        </thead>
                        @section('tableContent')
                            <tbody>
                                @foreach($grupos as $grupo)
                                <tr>
                                    <td style="vertical-align: middle;">{!! $grupo->Tipo !!}</td>
                                    <td style="vertical-align: middle;">{!! $grupo->Nombre !!}</td>
                                    <td>
                                        <h4>
                                            <a href="{!! url('/Grupos/cambia/'.$grupo->Tipo)!!}" type="button" class="btn label {!! $grupo->activo ? 'label-info' : 'label-danger' !!}">
                                                {!! $grupo->activo ? 'ACTIVO' : 'INACTIVO' !!}
                                            </a>
                                        </h4>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-olive updateGroup" data-toggle="modal" data-target="#modalRegistroGrupo" data-id="{!!$grupo->Tipo!!}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn bg-red-gradient deleteGroupModal" data-toggle="modal" data-target="#modalConfirma" data-id="{!!$grupo->Tipo!!}"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        @show
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
    $('#tablaGrupos').DataTable({
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
        $('.modal-title').text("Nuevo grupo");
        $("#id_grupo").removeAttr("value");
        $('#grupo').removeAttr("value");
        $('#orden').removeAttr("value");
        $("#btnGuardarGrupo").attr("value", "Guardar");
    });

    $('#registraGrupo').submit(function(e) {
        e.preventDefault();
        guardarFormulario($(this).serialize(), 'Grupos/registragrupo');
    });

    $("#tablaGrupos").on("click", ".updateGroup", function() {
        event.preventDefault();
        var id = $(this).data('id');
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $.ajax({
            type: "POST",
            url: 'Grupos/buscar',
            data: {id: id},
            success: function(response) {
                var grupo = response.grupo;
                $('.modal-title').text("Actualizar Grupo");
                $("#btnGuardarGrupo").attr("value", "Aceptar");
                $("#id_grupo").attr("value", grupo.id_grupo);
                $('#grupo').attr("value", grupo.grupo);
                $('#orden').attr("value", grupo.orden);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error en el servidor");
            }
        });
    });

    $("#tablaGrupos").on("click", ".deleteGroupModal", function() {
        $('#modalConfirmaTitle').text("Borrar Grupo");
        $("#modalConfirmaId").attr("value", $(this).data('id'));
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'Grupos/eliminar');
        });
    });

    function filtro() {
        var tipo = document.getElementsByName('tipo')[0].value;
        alert(tipo);
        $.ajax({
            type: "POST",
            url: 'Grupos/filtro',
            data: {tipo: tipo},
            success: function(response) {
                
                
                //$('#tableContent').empty().append($(response)); 
                $("#tableContent").html(grupos);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error en el servidor");
            }
        });
    }


</script>
@stop