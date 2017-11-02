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
@include('organismos.modalRegistro')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Organismos</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Organismos</a></li>
    </ol>
</section>
<section class="content">
    <div class="row" style="padding-bottom: 100px;">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    @include('organismos.busqueda')
                    <table id="tablaOrganismos" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <div class="col-md-6" style="padding: 0px; text-align: center;">
                            <button type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modalRegistroOrganismo" >
                                <span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Organismo
                            </button>
                        </div>
                        <thead>
                        <th class="alert-info col-md-3">TEMA</th>
                        <th class="alert-info col-md-2">INSTITUCI&Oacute;N</th>
                        <th class="alert-info col-md-2">ESTADO</th>
                        <th class="alert-info col-md-2">DIRECCI&Oacute;N</th>
                        <th class="alert-info col-md-2">TEL&Eacute;FONO</th>
                        <th class="alert-info col-md-2">EMAIL</th>
                        <th class="alert-info col-md-2">ACCIONES</th>
                        </thead>
                        <tbody>
                            @foreach($organismos as $organismo)
                            <tr>
                                <td style="vertical-align: middle;">{!! $organismo['Tema'] !!}</td>
                                <td style="vertical-align: middle;">{!! $organismo['Institucion'] !!}</td>
                                <td style="vertical-align: middle;">{!! $organismo['Estado'] !!}</td>
                                <td style="vertical-align: middle;">{!! $organismo['Direccion'] !!}</td>
                                <td style="vertical-align: middle;">{!! $organismo['Telefono'] !!}</td>
                                <td style="vertical-align: middle;">{!! $organismo['Email'] !!}</td>
                                <td style="vertical-align: middle;">
                                    <button type="button" class="btn btn-danger eliminarOrganismo" 
                                            data-toggle="modal" data-target="#modalConfirma" data-id="{!! $organismo['ID'] !!}">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                    <button type="button" class="btn btn-success modificarOrganismo" 
                                            data-toggle="modal" data-target="#modalRegistroOrganismo" data-id="{!! $organismo['ID'] !!}">
                                        <span class="fa fa-pencil"></span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach

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

    $('#tablaOrganismos').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[10, 20, 200], [10, 20, 200]],
        ordering: true,
        info: true,
        order: [[1, "desc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >',
        columnDefs: [{orderable: false, targets: [3, 4]}]
    });

    /*function buscarInformacion(tipo, id) {
     $.ajax({
     url: 'Consultas/obtenerlistado/' + tipo + '/' + id,
     success: function(data) {
     if (data == 'error') {
     mostrarMensajeError('Ha ocurrido un error debido a que la información introducida no es correcta. Vuelva a intentarlo más tarde.');
     console.log('data = error');
     }
     else {
     var cantidad = data.length;
     $('#textoOpcionPregunta').html('Respuesta: <select name="respuesta_filter" id="inputTextOpcionPregunta"><select>');
     for (var i = 0; i < cantidad; i++) {
     $('#inputTextOpcionPregunta').append('<option value="' + data[i].id + '">' + data[i].valor + '</option>');
     }
     }
     },
     error: function(xhr) {
     mostrarMensajeError("Ocurrio un error en el servidor. Intente de nuevo más tarde, y si persiste, por favor contacte con el administrador del sistema.");
     }
     });
     }*/

    $('#tablaSistemas').on('click', '.botonUsuarios', function () {
        var contenido = $(this).attr('data-content').trim().split('<p>');
        var sistema = $(this).parent().parent().children('.nombreSistema').text();
        var isistema = $(this).attr('value').split('/');
        $('#buscarResponsable').addClass('hidden');
        $('#modalResponsableAgregar').removeClass('hidden');
        $('#modalResponsableSistema').text(sistema);
        $('#modalResponsableCandidato').val('0');
        $('#modalResponsableISistema').val(isistema[0]);
        $('#modalResponsablePersonas').html('');
        var j = 0;
        for (var i = 1; i < contenido.length; i++) {
            var multiValorificado = isistema[1].split(',');
            var valorificado = multiValorificado[j].split('|');
            var texto = contenido[i].split('</p>');
            $('#modalResponsablePersonas').append('<tr><td class="responsable" value="' + valorificado[0] + '" >' + texto[0] + '</td><td style="padding-left: 100%;"><span class="eliminarPersona  btn btn-link" style="margin-left: 20%;"><i class="fa fa-times" aria-hidden="true"></i></span></td></tr>');
            j++;
        }
        $("#modalResponsable").modal();
        $('.eliminarPersona').click(function () {
            eliminarPersona(this);
        });
    });

    $('#modalResponsableAgregar').click(function () {
        $('#buscarResponsable').removeClass('hidden');
        $(this).addClass('hidden');
    });

    $('#modalResponsableEnviar').click(function () {
        var usuario = $('#modalResponsableCandidato').val();
        var sistema = $('#modalResponsableISistema').val();
        $.ajax({url: "Consultas/agregar-responsable/" + usuario + '/' + sistema,
            success: function (data) {
                if (data[0] == 'error') {
                    $('#modalResponsableMensaje').removeClass('hidden');
                    $('#modalResponsableMensaje').addClass('alert alert-danger');
                    $('#modalResponsableMensaje').text(data[1]);
                    setTimeout(function () {
                        $('#modalResponsableMensaje').addClass('hidden');
                        $('#modalResponsableMensaje').removeClass('alert alert-danger');
                    }, 4000);
                } else if (data[0] == 'exito') {
                    $('#modalResponsableMensaje').removeClass('hidden');
                    $('#modalResponsableMensaje').addClass('alert alert-success');
                    $('#modalResponsableMensaje').text(data[1]);
                    $('#modalResponsablePersonas').append('<tr><td class="responsable" value="' + data[3] + '" >' + data[2] + '</td><td style="padding-left: 100%;"><span class="eliminarPersona btn btn-link" style="margin-left: 20%;"><i class="fa fa-times" aria-hidden="true"></i></span></td></tr>');
                    $('.eliminarPersona').click(function () {
                        eliminarPersona(this);
                    });
                    setTimeout(function () {
                        $('#modalResponsableMensaje').addClass('hidden');
                        $('#modalResponsableMensaje').removeClass('alert alert-success');
                    }, 4000);
                } else {

                }
            },
            error: function (xhr) {
                alert("An error occured: " + xhr.status + " " + xhr.statusText);
            }
        });

        $('#buscarResponsable').addClass('hidden');
        $('#modalResponsableAgregar').removeClass('hidden');
    });

    $('#tablaOrganismos').on('click', 'button', function () {
        var id = $(this).data('id');
        if ($(this).hasClass('eliminarOrganismo')) {
            $('#modalConfirmaTitle').text("Borrar Organismo");
            $("#modalConfirmaId").attr("value", id);
            $('#btnModalConfirma_Continuar').removeAttr("data-toggle");
            $('#btnModalConfirma_Continuar').removeAttr("data-target");
            $('#btnModalConfirma_Continuar').removeAttr("data-id");
            $('#btnModalConfirma_Continuar').removeAttr("data-dismiss");
            $('#btnModalConfirma_Continuar').attr("type", "submit");
            $("#formConfirma").submit(function (e) {
                e.preventDefault();
                borrarRegistro($(this).serialize(), 'Organismos/eliminarorganismo');
            });
        } else if ($(this).hasClass('modificarOrganismo')) {

        }
    });

    function eliminarPersona(objeto) {
        var usuario = $(objeto).parent().parent().children('.responsable').attr('value');
        var sistema = $('#modalResponsableISistema').val();
        $.ajax({url: "Consultas/eliminar-responsable/" + usuario + '/' + sistema,
            success: function (data) {
                if (data[0] == 'error') {
                    $('#modalResponsableMensaje').removeClass('hidden');
                    $('#modalResponsableMensaje').addClass('alert alert-danger');
                    $('#modalResponsableMensaje').text(data[1]);
                    setTimeout(function () {
                        $('#modalResponsableMensaje').addClass('hidden');
                        $('#modalResponsableMensaje').removeClass('alert alert-danger');
                    }, 4000);
                } else if (data[0] == 'exito') {
                    $('#modalResponsableMensaje').removeClass('hidden');
                    $('#modalResponsableMensaje').addClass('alert alert-success');
                    $('#modalResponsableMensaje').text(data[1]);
                    $(objeto).parent().parent().empty();
                    setTimeout(function () {
                        $('#modalResponsableMensaje').addClass('hidden');
                        $('#modalResponsableMensaje').removeClass('alert alert-success');
                    }, 4000);
                } else {

                }
            },
            error: function (xhr) {
                alert("An error occured: " + xhr.status + " " + xhr.statusText);
            }
        });

        $('#buscarResponsable').addClass('hidden');
        $('#modalResponsableAgregar').removeClass('hidden');
    }

    $(".select2").select2();
    $('.js-example-basic-multiple').select2();

</script>
@stop
