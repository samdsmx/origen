@extends('layouts.baseInicio')
@section('titulo')
Usuarios
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
    <h1 style="color:#605ca8; font-weight: bolder">Gestión de Usuarios</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Gestión de Usuarios</a></li>
    </ol>
</section>
<section class="content">
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaUsuarios" class="table table-bordered table-striped table-dataTable  text-center" width="100%">
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <button id="abrirModal" type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modalRegistroUsuario" ><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Usuario</button>
                        </div>
                        <thead>
                            <th class="alert-info col-md-1">USUARIO</th>
                            <th class="alert-info col-md-4">NOMBRE</th>
                            <th class="alert-info col-md-1">ESTATUS</th>
                            <th class="alert-info col-md-1">OPERACIONES</th>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td style="vertical-align: middle;">{!! $usuario->usuario !!}</td>
                                <td style="vertical-align: middle;">{!! $usuario->nombre !!}</td>
                                <td style="vertical-align: middle;"><h4><a href="{!! url('/Usuarios/cambia/'.$usuario->id_usuario)!!}" type="button" class="btn label {!! $usuario->status ? 'label-info' : 'label-danger' !!}">{!! $usuario->status ? 'ACTIVO' : 'INACTIVO' !!}</a></h4></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn bg-olive open-UserUpdaterModal" data-toggle="modal" data-target="#modalRegistroUsuario" data-id="{!!$usuario->id_usuario!!}"><i class='fa fa-edit'></i></button>
                                        <button type="button" class="btn bg-red-gradient deleteUsuarioModal" data-toggle="modal" data-target="#modalConfirma" data-id="{!!$usuario->id_usuario!!}"><i class="fa fa-trash"></i></button>
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
    {!! Form::close() !!}
</section>   
@stop
@section('recursosExtra')
<script>
    $('#tablaUsuarios').DataTable({
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
        columnDefs: [{orderable: false, targets: [3]}]
    });

    $("#tablaUsuarios").on("click", ".open-UserUpdaterModal", function() {
        updateUser($(this).data('id'));
    });

    $("#tablaUsuarios").on("click", ".deleteUsuarioModal", function() {
        $('#modalConfirmaTitle').text("Borrar Usuario");
        $("#modalConfirmaId").attr("value", $(this).data('id'));
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'Usuarios/eliminar');
        });
    });

    $("#abrirModal").click(function(e) {
        e.preventDefault();
        $('div').removeClass('has-error');
        $('input').removeAttr("title");
        $('.modal-title').text("Nuevo usuario");
        $('#id_user').removeAttr("value");
        $('#nombres').removeAttr("value");
        $('#apaterno').removeAttr("value");
        $('#amaterno').removeAttr("value");
        $('#curp').removeAttr("value");
        $('#correo').removeAttr("value");
        $('#telefono').removeAttr("value");
        $("select#ur").find("option").removeAttr("selected");
        $("select#ur").find("option#-1").attr("selected", true);
        $('#ur').removeAttr("value");
        $('#urName').removeAttr("value");
        $('#usuario').removeAttr("value");
    });

</script>
@stop