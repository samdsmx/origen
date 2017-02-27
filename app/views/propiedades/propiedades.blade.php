@extends('layouts.baseInicio')
@section('titulo')
Propiedades
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
@include('propiedades.modalRegistro')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Gestión de preguntas para el cuestionario de aplicativos</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Gestión de preguntas para el cuestionario de aplicativos</a></li>
    </ol>
</section>
<section class="content">

    {{ Form::open() }}
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="tablaPropiedades" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <button id="abrirModal" type="button" class="btn btn-success  pull-left" data-toggle="modal" data-target="#modalRegistroPropiedades" ><span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Pregunta</button>
                        </div>  
                        <thead>
                        <th class="alert-info col-md-1">#</th>
                        <th class="alert-info col-md-1">ID</th>
                        <th class="alert-info col-md-1">SECCION</th>
                        <th class="alert-info col-md-4">PREGUNTA</th>
                        <th class="alert-info col-md-1" >TIPO</th>
                        <th class="alert-info col-md-1">OBLIGATORIA</th>
                        <th class="alert-info col-md-1">ORDEN</th>
                        <th class="alert-info col-md-1">ESTATUS</th>
                        <th class="alert-info col-md-1">MODIFICAR</th>
                        </thead>
                        <tbody>
                            {{-- */ $i=1; /* --}}
                            @foreach($propiedades as $propiedad)
                            <tr>
                                <td style="vertical-align: middle">{{ $i++ }}</td>
                                <td style="vertical-align: middle">Q{{$propiedad->id_propiedad}}</td>
                                <td style="vertical-align: middle">{{ $propiedad->grupo }}</td>
                                <td style="vertical-align: middle; width: 30%; text-align: left;">{{ $propiedad->descripcion }}</td>
                                <td style="vertical-align: middle">{{ $propiedad->tipo }}</td>
                                <td style="vertical-align: middle"><h4><a href="{{ url('/Propiedades/obligatoriacambia/'.$propiedad->id_propiedad) }}" type="button" class="btn label {{ $propiedad->obligatoria?'label-info':'label-warning' }}">{{ $propiedad->obligatoria ? 'SI' : 'NO' }}</a></h4></td>
                                <td style="vertical-align: middle">{{ $propiedad->orden === null ? "<i>Default</i>" : $propiedad->orden }}</td>
                                <td style="vertical-align: middle"><h4><a href="{{ url('/Propiedades/statuscambia/'.$propiedad->id_propiedad) }}" type="button" class="btn label {{ $propiedad->status ?'label-info':'label-danger' }}">{{ $propiedad->status ? 'ACTIVA' : 'INACTIVA' }}</a></h4></td>
                                <td style="vertical-align: middle">
                                    <div class="btn-group">
                                        @if ( empty($propiedad->conRespuesta))
                                        <button type="button" class="btn bg-olive updateProperty" data-toggle="modal" data-target="#modalRegistroPropiedades" data-id="{{$propiedad->id_propiedad}}"><i class='fa fa-edit'></i></button>
                                        <button type="button" class="btn bg-red-gradient deletePropiedadModal" data-toggle="modal" data-target="#modalConfirma" data-id="{{$propiedad->id_propiedad}}"><i class="fa fa-trash"></i></button>
                                        @else
                                        <button type="button" class="btn bg-gray pideConfirmacion" data-toggle="modal" data-target="#modalConfirma" data-id="{{$propiedad->id_propiedad}}"><i class='fa fa-edit'></i></button>
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
    <br/><br/><br/>
    {{ Form::close() }}
</section>
@stop

@section('recursosExtra')
{{ HTML::script('js/bootstrap-editable.js') }}
{{ HTML::style('css/bootstrap-editable.css') }}	
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.24.6/js/jquery.tablesorter.js"></script>    
<script>
$('#tablaPropiedades').DataTable({
    scrollX: false,
    responsive: true,
    searching: true,
    paging: false,
    ordering: false,
    info: true,
    language: dataTablesSpanish
});

$('#abrirModal').click(function() {
    $('div').removeClass('has-error');
    $('input').removeAttr("title");
    $("#id_propiedad").removeAttr("value");
    $("#id_grupo option[selected]").removeAttr("selected");
    $("#id_grupo option[disabled]").attr('selected', true);
    $("#id_tipo option[selected]").removeAttr("selected");
    $("#id_tipo option[disabled]").attr('selected', true);
    $('#condicionesAnidadas').removeAttr("value");
    $('#sortable').empty();
    $('#respDef').removeAttr("value");
    $('#grupoCondicion').removeAttr("value");
    $('#valorConAn').removeAttr("value");
    $('#descripcion').attr("value", "Descripción");
    $('#descripcion_grafical').text('Descripción');
    $('#asignacion').attr("value", '=');
    $('#preguntas').html('<option value="" selected disabled>-- Propiedad --</option>');
    numeroDePreg = [];
    $('#numeroPregunta').text('Q' + '00');
    $('#tituloModal').text("Agregar propiedad");
    $("#btnAgregaPropiedad").attr("value", "Guardar");
    $('#registraPropiedad').trigger("reset");
});

$('#resetear').click(function() {
    numeroDePreg = [];
    $('#descripcion_grafical').text($('#descripcion').val());
    $('#sortable').empty();
    if ($("#id_propiedad").val() > 0)
        actualizaPropiedad($("#id_propiedad").val());
});

$('#registraPropiedad').submit(function(e) {
    e.preventDefault();
    var respuestas = [];
    $("#sortable li").each(function() {
        respuestas.push($(this).text());
    });
    $('#hiddenPredefinidas').attr("value", respuestas);
    guardarFormulario($(this).serialize(), 'Propiedades/registraprop');
});

$("#tablaPropiedades").on("click", ".updateProperty", function() {
    var id = $(this).data('id');
    $('#tituloModal').text("Actualizar propiedad");
    actualizaPropiedad(id);
});

$("#tablaPropiedades").on("click", ".pideConfirmacion", function() {
    var id = $(this).data('id');
    $('#modalConfirmaTitle').text("La propiedad ya contiene respuestas");
    $("#modalConfirmaId").attr("value", id);
    $('#btnModalConfirma_Continuar').attr("data-toggle", "modal");
    $('#btnModalConfirma_Continuar').attr("data-target", "#modalRegistroPropiedades");
    $('#btnModalConfirma_Continuar').attr("data-id", id);
    $('#btnModalConfirma_Continuar').attr("data-dismiss", "modal");
    $('#tituloModal').html("Actualizar propiedad <small style='color:white;'>La propiedad ya tiene valores previos</small>");
    $('#btnModalConfirma_Continuar').click(actualizaPropiedad(id));
});

function actualizaPropiedad(id) {
    $('div').removeClass('has-error');
    $('input').removeAttr("title");

    $('#respDef').removeAttr("value");
    $('#grupoCondicion').removeAttr("value");
    $('#valorConAn').removeAttr("value");
    $('#asignacion').attr("value", '=');
    $('#preguntas').html('<option value="" selected disabled>-- Propiedad --</option>');
    numeroDePreg = [];
    $.ajax({
        type: "POST",
        url: 'Propiedades/buscar',
        data: {id: id},
        success: function(response) {
            var prop = response.propiedad;
            $("#btnAgregaPropiedad").attr("value", "Aceptar");
            $('#numeroPregunta').text('Q' + id);
            $('#id_propiedad').attr("value", prop.id_propiedad);

            $("#id_tipo option[selected]").removeAttr("selected");
            $("#id_tipo option[value='" + prop.id_tipo + "']").attr('selected', true);

            $("#id_grupo option[selected]").removeAttr("selected");
            $("#id_grupo option[value='" + prop.id_grupo + "']").attr('selected', true);

            $('#orden').attr("value", prop.orden);
            $('#descripcion').attr("value", prop.descripcion);
            $('#descripcion_grafical').text(prop.descripcion);
            $('.input-large').val(prop.descripcion);
            var cond = response.cadena;
            $('#condicionesAnidadas').removeAttr("value");
            $.each(cond, function(key, val) {
                $('#condicionesAnidadas').val(val.expresion);
            });

            var res = response.repuestas;
            $('#sortable').empty();
            $.each(res, function(key, val) {
                $('#sortable').append("<li class=\"lista_dragable\">" + val.valor + "</li>");
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Error en el servidor");
        }
    });
}

(function($) {
    $(function() {
        var numeroDePreg = [];
        $.fn.getCursorPosition = function() {
            var elem = $(this).get(0);
            var pos = 0;
            if ('selectionStart' in elem) {
                pos = elem.selectionStart;
            } else if ('selection' in document) {
                elem.focus();
                var sel = document.selection.createRange();
                var selLength = document.selection.createRange().text.length;
                sel.moveStart('character', -elem.value.length);
                pos = sel.text.length - selLength;
            }
            return pos;
        }

        $('#agregarCondicion').click(function() {
            var pos = $("#condicionesAnidadas").getCursorPosition();
            var asignacion = $('#asignacion').val();
            var preguntas = $('#preguntas').val();
            var preguntas1 = $('#preguntas option:selected').text();
            numeroDePreg[preguntas] = preguntas1;
            if (preguntas1 == "-- Propiedad --") {
                console.log('buen intento');
            } else {
                var valorDefault = $('#respDef').val();
                var condicionesAnidadas = $('#condicionesAnidadas').val();
                var condicionesAnidadas1 = condicionesAnidadas.split("");
                var numeroFinal = condicionesAnidadas1.length;
                condicionesAnidadas = "";
                for (var i = 0; i <= numeroFinal; i++) {
                    if (i == pos) {
                        if (asignacion == 'like' || asignacion == 'not like') {
                            condicionesAnidadas = condicionesAnidadas + '(\'' + preguntas1 + '\' ' + asignacion + ' "%' + valorDefault + '%")';
                        } else if (asignacion == '=') {
                            condicionesAnidadas = condicionesAnidadas + '(\'' + preguntas1 + '\' ' + asignacion + ' "' + valorDefault + '")';
                        } else {
                            condicionesAnidadas = condicionesAnidadas + '(\'' + preguntas1 + '\' ' + asignacion + ' ' + valorDefault + ')';
                        }
                        if (pos === numeroFinal) {
                            break;
                        }
                    } else {
                        if (i === numeroFinal) {
                            break;
                        }
                        condicionesAnidadas = condicionesAnidadas + condicionesAnidadas1[i];
                    }
                }
                $('#condicionesAnidadas').val(condicionesAnidadas);
                $('#asignacion').val('=');
                $('#preguntas').val('');
                $('#respDef').val('');
                $('#grupoCondicion').val('');
            }
        });

        $('#grupoCondicion').change(function() {
            var grupoCondicion = $('#grupoCondicion').val();
            $('#preguntas').html('<option value="" selected disabled>-- Propiedad --</option>');
            $.ajax({
                url: "Propiedades/pregunta/" + grupoCondicion,
                type: "GET",
                dataType: "json",
                success: function(datos) {
                    var ar = datos;
                    $.each(ar, function(i) {
                        $('#preguntas').append('<option value=' + datos[i].id + '>' + datos[i].descripcion + '</option>');
                    });

                },
                error: function() {
                    console.log('error');
                }
            });
        });

        $('#asignacion').change(function() {
            var asignacion = $('#asignacion option:selected').text();
            if (asignacion == ' is null ' || asignacion == ' not null ') {
                $('#respDef').attr('disabled', '');
            } else {
                $('#respDef').removeAttr('disabled');
            }
        });

        $('#condicionesAnidadas').on('keypress', function(tecla) {
            if (tecla.charCode == 89 || tecla.charCode == 79 || tecla.charCode == 111 ||
                    tecla.charCode == 121 || tecla.charCode == 40 || tecla.charCode == 41 || tecla.charCode == 0 || tecla.charCode == 8) {
            } else {
                return false;
            }
        });

        $('#btnAgregaPropiedad').click(function() {
            var condicionesAnidadas = $('#condicionesAnidadas').val();
            var conAniTemp = condicionesAnidadas.split("'");
            for (var i = 0; i < conAniTemp.length; i++) {
                var identificador = jQuery.inArray(conAniTemp[i], numeroDePreg);
                if (identificador > 0) {
                    conAniTemp[i] = 'Q' + identificador;
                }
            }
            var valorTemp = conAniTemp.join('');
            $('#valorConAn').val(valorTemp);
            var valorDescripcion = $('#descripcion_grafical').text();
            $('#descripcion').val(valorDescripcion);
            $('#registraPropiedad').submit();
        });

        $('#descripcion_grafical').click(function() {
            setTimeout(function() {
                if ($('.editable-input').length > 0) {
                    var textoAsignado = $('#descripcion_grafical').text();
                    $('.input-large').css("width", "400px");
                    $('.input-large').val(textoAsignado);
                }
            }, 200);
        });

        $.fn.editable.defaults.mode = 'inline';
        $('#descripcion_grafical').editable({
            rows: 2,
            placeholder: 'Propiedad / Pregunta'
        });
    });
})(jQuery);

$("#tablaPropiedades").on("click", ".deletePropiedadModal", function() {
    var id = $(this).data('id');
    $('#modalConfirmaTitle').text("Borrar Propiedad");
    $("#modalConfirmaId").attr("value", id);
    $('#btnModalConfirma_Continuar').removeAttr("data-toggle");
    $('#btnModalConfirma_Continuar').removeAttr("data-target");
    $('#btnModalConfirma_Continuar').removeAttr("data-id");
    $('#btnModalConfirma_Continuar').removeAttr("data-dismiss");
    $('#btnModalConfirma_Continuar').attr("type", "submit");
    $("#formConfirma").submit(function(e) {
        e.preventDefault();
        borrarRegistro($(this).serialize(), 'Propiedades/eliminar');
    });
});

$("#sortable").sortable({
    connetctwith: "#sortable",
}).droppable({greedy: true});

$('#trasbinsito').droppable({
    drop: function(event, ui) {
        ui.draggable.remove();
    }
});

$("#sortable").disableSelection();

$('#addDefaultAnswer').click(function(e) {
    e.preventDefault();
    var dato = $('#resDef').val();
    if (dato != '') {
        $('#sortable').append("<li class=\"lista_dragable\">" + dato + "</li>");
        $('#resDef').val("");
    }
});

</script>
@stop