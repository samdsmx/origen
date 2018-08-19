$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

function cambiarStatusRegistro(valor) {
    $('#Nombre').prop("disabled",valor);
    $('#Edad').prop("disabled",valor);
    $('#NivelEstudios').prop("disabled",valor);
    $('#EstadoCivil').prop("disabled",valor);
    $('#Religion').prop("disabled",valor);
    $('#Ocupacion').prop("disabled",valor);
    $('#VivesCon').prop("disabled",valor);
    $('#Telefono').prop("disabled",valor);
    $('#CorreoElectronico').prop("disabled",valor);
    $('#MedioContacto').prop("disabled",valor);
    $('#ComoTeEnteraste').prop("disabled",valor);
}

/**
 * Función que se encarga de cambiar el formulario que se pase para
 * concatenar múltiples temas.
 * peticion: es la petición que se va a enviar sin modificar
 * campo: el campo que se va a modificar
 * Regresa la petición corregida
 */
function cambiarPeticionMultiplesTemas(peticion,campo) {
    var peticionCorrecta = '';
    var temaConcat = '';
    var informacionDiv = peticion.split('&');
    for(var i=0;i<informacionDiv.length;i++) {
      var eleDiv = informacionDiv[i].split('=');
      if(eleDiv[0] === campo) {
        temaConcat += eleDiv[1] + ',';
      } else {
        peticionCorrecta += informacionDiv[i] + '&';
      }
    }
    peticionCorrecta += 'tema='+temaConcat;
    return peticionCorrecta;
}

function limpiarCampos() {
  $('#ID').val('');
  $('.select2-selection__rendered').children().each(function() {
    $(this).replaceWith('');
  });
  $('#Objetivo').val('');
  $('#Estado').val('-1');
  $('#Institucion').val('');
  $('#Direccion').val('');
  $('#Referencia').val('');
  $('#Telefono').val('');
  $('#Email').val('');
  $('#Observaciones').val('');
  $('#Requisitos').val('');
  $('#HorariosCostos').val('');
}

function mostrarMensaje(mensaje, clase) {
    clase = (typeof (clase) !== 'undefined' ? clase : "alert-danger");
    $("#mensajeVista").html(mensaje);
    $("#mensajeVista").addClass(clase);
    $("#panel-messages-vista").show();
    $("#panel-messages-vista").fadeTo(3000, 500).slideUp(500, function() {
    $("#panel-messages-vista").hide();
    });
}

function guardarFormulario(data, url, estaDesactivado) {
    //event.preventDefault();
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            $('div').removeClass('has-error');
            $('input').removeAttr("title");
            if (response.errors) {
                console.log(estaDesactivado);
                cambiarStatusRegistro(estaDesactivado);
                $.each(response.errors, function(index, error) {
                    $("#d" + index).addClass("has-error");
                    $("#" + index).attr("title", error);
                });
                mostrarMensaje(response.mensaje);
                $('html, body').animate({scrollTop: 0}, 'fast');
                return false;
            } else {
                window.location="inicio";
                return false;
            }
        },
        error: function(xhr, status, error) {
            alert("Error en el servidor");
        }
    });
}

function borrarRegistro(data, url) {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            $('html, body').animate({scrollTop: 0}, 'fast');
            location.reload();
        },
        error: function(xhr, status, error) {
            alert("Error en el servidor");
        }
    });
}

function updateUser(id) {
    $('div').removeClass('has-error');
    $('input').removeAttr("title");
    $.ajax({
        type: 'POST',
        url: 'Usuarios/buscar',
        data: {id_user: id},
        success: function(response) {
            var usu = response.usuario;
            $('#id_user').attr("value", id);
            $('#nombres').attr("value", usu.nombres);
            $('#apaterno').attr("value", usu.primer_apellido);
            $('#amaterno').attr("value", usu.segundo_apellido);
            $('#curp').attr("value", usu.curp);
            $('#correo').attr("value", usu.correo);
            $('#telefono').attr("value", usu.telefono);
            $('#usuario').attr("value", usu.usuario);
            $('.modal-title').text("Modificar usuario");
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
}

$('#registraUsuario').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: "Usuarios/registrausuario",
        data: data,
        success: function(response) {
            $('div').removeClass('has-error');
            $('input').removeAttr("title");
            if (response.errors) {
                $.each(response.errors, function(index, error) {
                    $("#d" + index).addClass("has-error");
                    $("#" + index).attr("title", error);
                });
            } else {
                $('html, body').animate({scrollTop: 0}, 'fast');
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            alert("Error en el servidor");
        }
    });
});

$('#registraOrganismo').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var infoParaEnviar = cambiarPeticionMultiplesTemas(data,'tema');
    $.ajax({
        type: 'POST',
        url: "Organismos/registraorganismo",
        data: infoParaEnviar,
        success: function(response) {
            $('div').removeClass('has-error');
            $('input').removeAttr("title");
            if (response.errors) {
                $.each(response.errors, function(index, error) {
                    $("#d" + index).addClass("has-error");
                    $("#" + index).attr("title", error);
                });
            } else {
                $('html, body').animate({scrollTop: 0}, 'fast');
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            alert(xhr);
        }
    });
});

$(document).ready(function() {
    $("#panel-messages").fadeTo(3000, 500).slideUp(500, function() {
        $("#panel-messages").hide();
    });

    $('#buscaOrganismos').submit( function(e){
        e.preventDefault();
        $("#tablaOrganismos").DataTable().clear().draw();
        var info = $(this).serialize();
        var infoParaEnviar = cambiarPeticionMultiplesTemas(info,'tema');
        $.ajax({
                type: 'POST',
                url: 'Organismos/buscarorganismos',
                data: infoParaEnviar,
                success: function(response) {
                    $("#tablaOrganismos").DataTable().clear();
                    var resultado = [];
                    for(var i=0;i<response.length;i++) {
                      var ele = response[i];
                      var arrayInterno = [];
                      arrayInterno.push(ele.Tema);
                      arrayInterno.push(ele.Institucion);
                      arrayInterno.push(ele.Estado);
                      arrayInterno.push(ele.Direccion);
                      arrayInterno.push(ele.Telefono);
                      arrayInterno.push(ele.Email);
                      arrayInterno.push('<button type="button" class="btn btn-danger eliminarOrganismo"'
                                                                      +'data-toggle="modal" data-target="#modalConfirma" data-id="'+ele.ID+'">'
                                                                  +'<span class="fa fa-trash"></span>'
                                                                                +'</button>'
                                                                                +'<button type="button" class="btn btn-success modificarOrganismo"'
                                                                                        +'data-toggle="modal" data-target="#modalRegistroOrganismo" data-id="'+ele.ID+'">'
                                                                                    +'<span class="fa fa-pencil"></span>'
                                                                                                  +'</button>');
                      resultado.push(arrayInterno);
                }
                $("#tablaOrganismos").DataTable().rows.add(resultado).draw();
              },
                error: function(xhr, status, error) {
                    alert("Error en el servidor");
                }
            });
    } );

    var propiedadesTablaChica = {
        scrollX: false,
        responsive: true,


       
        ordering: false,
        info: true,
        order: [[1, "desc"]],


      }
    var tabla = $('#tablaBusquedaOrganismos').DataTable({
        searching: false,
        paging: true,
        pageLength: 2,
        bLengthChange : false,
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >'
    });

    function resetForm(campos){
        $.each(campos, function(index, c){
            var campo = $('#'+c);
            if( campo.get(0).nodeName == 'INPUT' ){
                $("#"+c).val('');
            } else if( campo.get(0).nodeName == 'SELECT') {
                if( $("#"+c ).attr('multiple') ){
                    $("#"+c+" option[value]").remove();
                } else {
                    $("#"+c+" option:selected").prop("selected", false);
                }
            }
        });
    }

    $('#resetear').click(function() {
      limpiarCampos();
    });

    $('#resetearBusqueda').click(function() {
      limpiarCampos();
    });

    $(document).on('hide.bs.modal','#modalRegistroOrganismo', function(){
        tabla.clear();
//       $('#buscaOrganismosCanalizacion').trigger('reset');
        //resetForm(['tema','objetivo','institucion','estado']);
        limpiarCampos();
        $('#tablaMuestreo').hide();
    });

    $('#buscaOrganismosCanalizacion').submit( function(e){
        e.preventDefault();
        //$('#buscaOrganismosCanalizacion').trigger('reset');
        info = $(this).serialize();
        var informacionEnv = cambiarPeticionMultiplesTemas(info,'tema');
        $.ajax({
                type: 'POST',
                url: 'Registro/buscarorganismos',
                data: informacionEnv,
                success: function(response) {
                    $('#tablaMuestreo').show();
                    //$('#buscaOrganismosCanalizacion').trigger('reset');
                    $.each(response, function(index, value){
                        tabla.row.add([value['Tema'], value['Institucion'], value['Estado'],
                            '<button type="button" class="btn btn-info addOrganismoCana" data-organismo="'+value['Institucion']+'"><span class="fa fa-plus-square"></span></button>' ]);
                    });
                    tabla.draw();
                    $('.addOrganismoCana').click(function(e){
                        var text = $(this).attr('data-organismo');
                        var valor_anterior = $('#CanaOtro').val();
                        $('#CanaOtro').val(valor_anterior + text+';\n')
                    });
                },
                error: function(xhr, status, error) {
                    alert("Error en el servidor");
                }
            });
    } );

    function crearTablaSeguimiento(id) {
        console.log(id);
        var direccion = window.location.href.split('/');
                    direccion.pop();
                    direccion.push('Registro');
                    direccion = direccion.join('/');
        let content = '<table id="'+id+'" class="tablaDetallesConsulta">';
        $.ajax({
            type: 'GET',
            url: 'Consultas/followcalls/'+id,
            success: function(response) {
                console.log(response);
                for(let i=0;i<response.length;i++) {
                    let direccionVerLlamada = direccion+'?caso='+response[i].IDCaso+'&llamada='+response[i].LlamadaNo;
                    $('#'+id+' tr:last').after('<tr> <td><span class="fecha">'+ response[i].FechaLlamada+'</span><br>'+
                    response[i].Horainicio
                    +'</td> <td>'+
                    response[i].nombres+' '+response[i].primer_apellido+' '+response[i].segundo_apellido
                    +'</td><td><a href="'+direccionVerLlamada+'">Ver detalles</a></td> </tr>');
                }
            },
            error: function(xhr, status, error) {
                alert("Error en el servidor");
                content += '</table>';
                return content;
            }

        });
                content += '<tr> <td> </td> <td> </td><td> </td> </tr>';
                content += '</table>';
                return content;
    }

    $('#buscaCasos').submit( function(e){
        e.preventDefault();
        $("#tablaCasos").DataTable().clear().draw();
        info = $(this).serialize();
        var informacionEnv = cambiarPeticionMultiplesTemas(info,'motivos');
        $.ajax({
                type: 'POST',
                url: 'Consultas/consultarllamadas',
                data: informacionEnv,
                success: function(response) {
                  var resultado = [];
                    var direccion = window.location.href.split('/');
                    direccion.pop();
                    direccion.push('Registro');
                    direccion = direccion.join('/');
                   for(var i=0;i<response.length;i++) {
                     var ele = response[i];
                    direccionNvoCaso = direccion+'?caso='+ele.IDCaso;
                    direccionVerLlamada = direccion+'?caso='+ele.IDCaso+'&llamada='+ele.LlamadaNo;
                    var arrayInterno = [];
                    arrayInterno.push(ele.IDCaso);
                    arrayInterno.push('<strong>'+ele.FechaLlamada+'</strong><br>'+ele.Horainicio);
                    arrayInterno.push(ele.Nombre);
                    arrayInterno.push(ele.Telefono);
                    arrayInterno.push(ele.nombres+' '+ele.primer_apellido+' '+ele.segundo_apellido);
			        arrayInterno.push('<a href="'+direccionVerLlamada+'" style="margin-right:10%;" class="btn btn-warning verLlamada">'
                                        +'<span class="fa fa-eye"></span>'
                                        +'</a> '
                                        +'<a href="'+direccionNvoCaso+'" class="btn btn-success llamadaSeguimiento">'
                                        +'<span class="fa fa-plus"></span>'
                                        +'</a>');
                     resultado.push(arrayInterno);
                    }
                $("#tablaCasos").DataTable().rows.add(resultado).draw();
                $('#tablaCasos tbody tr').each(function(index,ele) {
                    var row = $('#tablaCasos').DataTable().row( $(this));
                    row.child( crearTablaSeguimiento($(this).children()[0].innerHTML )).show();
                });
                },
                error: function(xhr, status, error) {
                    alert("Error en el servidor");
                }
            });
    } );



    $("#fecha_inicio").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#fecha_fin").datepicker("option", "minDate", selectedDate);
        }
    });

    $("#fecha_fin").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        numberOfMonths: 2,
        onClose: function(selectedDate) {
            $("#fecha_inicio").datepicker("option", "maxDate", selectedDate);
        }
    });

    $('.open-UserUpdaterModal').click(function() {
        updateUser($(this).data('id'));
    });

});

//Codigo Analytics
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-46971700-3', 'auto');
  ga('require', 'linkid');
  ga('send', 'pageview');
//Fin codigo analytics
