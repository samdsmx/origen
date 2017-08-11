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
@include('permisosusuarios.modalQuitarPermiso')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Gestión de permisos para usuarios.</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Gestión de permisos para usuarios.</a></li>
    </ol>
</section>
<section class="content">
    {!! Form::open(array('id'=>'concedePermiso')) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaUsuariosUnidad" class="table table-bordered table-striped table-dataTable text-center" cellspacing="0" width="100%">
                        <thead>
                        <th class="alert-info col-md-1">SELECCIONAR</th>
                        
                        <th class="alert-info col-md-2">USUARIO</th>
                        <th class="alert-info">PERMISOS</th>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usu)
                            <tr>
                                <td style="vertical-align: middle"><input type="checkbox" value="{!! $usu->id_usuario.','.$usu->nombre !!}" name="usuarios[]"/></td>
                                
                                <td style="vertical-align: middle">{!! $usu->nombre !!}</td>
                                <td style="vertical-align: middle; text-align: left;">
                                    <ul id="grupoMedios{!! $usu->id_usuario !!}">
                                        @foreach(explode(',',$usu->permisos) as $actividad)     
                                        <?php
                                        $m = explode('|', $actividad);
                                        $activo1 = ($m[1] == ' --- ' || strtotime($m[1]) <= strtotime("now"));
                                        $activo2 = ($m[2] == ' --- ' || strtotime($m[2]) >= strtotime("now"));
                                        ?>
                                        @if ( !empty($m[0]) )
                                        <li class="tag-cloud {!!($activo1 && $activo2)?'tag-cloud-success':((!$activo2)?'tag-cloud-danger':(!$activo1?'tag-cloud-warning':'')) !!}" data-toggle="modal" data-target="#modalQuitarPermiso" data-id="{!!$m[3]!!}"  style="white-space: normal; {!!$m[4]==1?'':'text-decoration: line-through;'!!}   " title="Inicio: {!!isset($m[1])?$m[1]:'---'!!} Fin: {!!isset($m[2])?$m[2]:'---'!!}">
                                            {!! $m[0]; !!}
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4" id="selected_div">
                            <label class="text-center text-info">Permiso de:</label>
                            <select name="permiso" id="permiso" class="form-control">
                                <option value="">-- Permiso --</option>
                                @foreach($actividades as $actividad)
                                <option value="{!! $actividad["id_actividad"] !!}" title="{!! $actividad["descripcion"] !!}">{!! $actividad["nombre"] !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4" id="selected_div">
                            <label class="text-center text-info">Inicio:</label>
                            <div class='form-group has-feedback' style="z-index: 1000;">
                                <input type="text" id="fecha_inicio" name="fecha_inicio" class="form-control"/>
                                <i class="glyphicon glyphicon-calendar form-control-feedback" style="opacity: 0.25;"></i>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-center text-info">Fin:</label>
                            <div class='form-group has-feedback' style="z-index: 1000;">
                                <input type="text" id="fecha_fin" name="fecha_fin" class="form-control" />
                                <i class="glyphicon glyphicon-calendar form-control-feedback" style="opacity: 0.25;"></i>
                            </div>
                        </div>
                        <div class="col-md-1" style="float: none; margin: 0 auto; padding: 10px 0;">
                            {!! Form::submit('Conceder Permiso', array('class' => 'btn btn-success', 'id' => 'btnAgregaPermiso')) !!}
                        </div>
                    </div>                      
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>  
@stop
@section('recursosExtra')
<script>
    $('#tablaUsuariosUnidad').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[6, 10, 20, 40], [6, 10, 20, 40]],
        ordering: true,
        info: true,
        order: [[1, "asc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"> p > >',
        columnDefs: [{orderable: false, targets: [0]}]
    });

    $("#tablaUsuariosUnidad").on("click", ".tag-cloud", function() {
        var id = $(this).data('id');
        $('#id').val(id);
    });

    $('#quitaPermiso').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'PermisosUsuarios/quitapermiso',
            data: data,
            success: function(response) {
                $('div').removeClass('has-error');
                if (response.errors) {
                    $.each(response.errors, function(index, error) {
                        var campo = $("#d-" + index);
                        campo.addClass("has-error");
                    });                    
                } else {
                    $('html, body').animate({scrollTop: 0}, 'fast');
                    location.reload();
                }
            },
            error: function(xhr, status, error) {

            }
        });
    });

    $('#concedePermiso').submit(function(e) {
        e.preventDefault();
        var usus = []
        $("input[name='usuarios[]']:checked").each(function()
        {
            usus.push(parseInt($(this).val()));
        });
        if (usus.length == 0) {
            mostrarMensaje("Debe seleccionar al menos un usuario");
        } else {
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "PermisosUsuarios/registrapermiso",
                data: data,
                success: function(response) {
                    $("[id^='___']").remove();
                    if (response.errors) {
                        $.each(response.errors, function(index, error) {
                            var campo = $("#" + index);
                            campo.addClass("has-error");
                            var datos = '<div class="input-group-addon alert-danger" id="___' + index + '">' + error + '</div>'
                            campo.parent().append(datos);
                        });
                    } else {
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });
        }

    });
</script>
@stop
