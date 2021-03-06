@extends('layouts.baseInicio')
@section('titulo')
Catalogos
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
@include('catalogos.modalRegistro')
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
                    <div class="col-md-6" style="padding: 0px; text-align: center;">
                        <button id="abrirModal" type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modalRegistroGrupo" ><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Campo</button>
                        <div class="col-md-1" style="line-height: 33px;"><label for="tipo">Tipo:</label></div>
                        <div class="col-md-6">
                            <select name="tipo" class="form-control" onchange="filtro();" >
                                @foreach($tipos as $tipo)
                                    <option value="{!! $tipo->Tipo !!}">{!! $tipo->Tipo !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @section('tableContent')
                    <section id="tableContent">
                    <table id="tablaCampos" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                            <thead>
                                <th class="alert-info col-md-5">TIPO</th>
                                <th class="alert-info col-md-5">DESCRIPCION</th>
                                <th class="alert-info col-md-1">ESTATUS</th>
                                <th class="alert-info col-md-1">OPERACIONES</th>
                            </thead>
                            
                            <tbody>
                                @foreach($campos as $campo)
                                <tr>
                                    <td style="vertical-align: middle;">{!! $campo->Tipo !!}</td>
                                    <td style="vertical-align: middle;">{!! $campo->Nombre !!}</td>
                                    <td>
                                        <h4>
                                            <a href="{!! url('/Catalogos/cambia/'.$campo->Tipo.'/'.$campo->Nombre)!!}" type="button" class="btn label {!! $campo->activo ? 'label-info' : 'label-danger' !!}">
                                                {!! $campo->activo ? 'ACTIVO' : 'INACTIVO' !!}
                                            </a>
                                        </h4>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-olive updateCatalogo" data-toggle="modal" data-target="#modalRegistroGrupo" data-id="{!!$campo->Tipo.'-'.$campo->Nombre!!}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn bg-red-gradient deleteGroupModal" data-toggle="modal" data-target="#modalConfirma" data-id="{!!$campo->Tipo.'-'.$campo->Nombre!!}"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </section>
                        @show  
                </div>
            </div>
        </div>
    </div>
    {!! Form::close()!!}
</section>
@stop
@section('recursosExtra')
<script>

    var propiedadesTabla = {
        scrollX: false,
        responsive: true,
        searching: true,
        ordering: false,
        paging: false,
        info: true,
        language: dataTablesSpanish
        }

    $('#tablaCampos').DataTable(propiedadesTabla);

    $("#abrirModal").click(function() {
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $('.modal-title').text("Nuevo grupo");
        $("#id_grupo").removeAttr("value");
        $('#grupo').removeAttr("value");
        $('#orden').removeAttr("value");
        $("#btnGuardarGrupo").attr("value", "Guardar");
        $('#grupo').val('');
        $('#orden').val('');
        $('#id_grupo').val('');
        $('#id_orden').val('');
    });

    $('#registraGrupo').submit(function(e) {
        e.preventDefault();
        guardarFormulario($(this).serialize(), 'Catalogos/registragrupo');
    });

    $("#tablaCampos").on("click", ".updateCatalogo", function() {
        event.preventDefault();
        var id = $(this).data('id').split('-');
        $('div').removeClass('has-error');
        $('.modal-title').text("Editar grupo");
        $('input').removeAttr("title");
        $('#grupo').val(id[0]);
        $('#orden').val(id[1]);
        $('#id_grupo').val(id[0]);
        $('#id_orden').val(id[1]);
    });

    $("#tablaCampos").on("click", ".deleteGroupModal", function() {
        $('#modalConfirmaTitle').text("Borrar Grupo");
        $("#modalConfirmaId").attr("value", $(this).data('id'));
        $("#formConfirma").attr("action",'');
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'Catalogos/eliminar');
        });
    });

    function filtro() {
        var tipo = document.getElementsByName('tipo')[0].value;
        $.ajax({
            type: "POST",
            url: 'Catalogos/filtro',
            data: {tipo: tipo},
            success: function(response) {
                $('#tableContent').html(response);  
                $('#tablaCampos').DataTable(propiedadesTabla);           
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Error en el servidor");
            }
        });
    }


</script>
@stop