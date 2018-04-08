$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

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

function guardarFormulario(data, url) {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) {
            $('div').removeClass('has-error');
            $('input').removeAttr("title");
            if (response.errors) {
                $.each(response.errors, function(index, error) {
                    $("#d" + index).addClass("has-error");
                    $("#" + index).attr("title", error);
                });
                mostrarMensaje(response.mensaje);
                $('html, body').animate({scrollTop: 0}, 'fast');
            } else {
                window.location="inicio";
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
    var infoParaEnviar = '';
    var temaConcat = '';
    var informacionDiv = data.split('&');
    for(var i=0;i<informacionDiv.length;i++) {
      var eleDiv = informacionDiv[i].split('=');
      if(eleDiv[0] === 'Tema') {
        temaConcat += eleDiv[1] + ',';
      } else {
        infoParaEnviar += informacionDiv[i] + '&';
      }
    }
    infoParaEnviar += 'Tema='+temaConcat;
    console.log(infoParaEnviar);
    $.ajax({
        type: 'POST',
        url: "Organismos/registraorganismo",
        data: infoParaEnviar,
        success: function(response) {
          console.log(response);
            $('div').removeClass('has-error');
            $('input').removeAttr("title");
            if (response.errors) {
              console.log(response.errors);
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
        var infoParaEnviar = '';
        var temaConcat = '';
        var informacionDiv = info.split('&');
        for(var i=0;i<informacionDiv.length;i++) {
          var eleDiv = informacionDiv[i].split('=');
          if(eleDiv[0] === 'tema') {
            temaConcat += eleDiv[1] + ',';
          } else {
            infoParaEnviar += informacionDiv[i] + '&';
          }
        }
        infoParaEnviar += 'tema='+temaConcat;
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
        searching: false,
        paging: true,
        lengthMenu: [[5, 20, 200, 500], [5, 20, 200, 500]],
        ordering: false,
        info: true,
        order: [[1, "desc"]],
        language: dataTablesSpanish,
        pageLength: 4,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >'
    }
    var tabla = $('#tablaBusquedaOrganismos').DataTable({
        propiedadesTablaChica
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
        $('#buscaOrganismosCanalizacion').trigger('reset');
        $.ajax({
                type: 'POST',
                url: 'Registro/buscarorganismos',
                data: $(this).serialize(),
                success: function(response) {
                    $('#tablaMuestreo').show();
                    $('#buscaOrganismosCanalizacion').trigger('reset');
                    $.each(response, function(index, value){
                        tabla.row.add([value['Tema'], value['Institucion'], value['Estado'],
                            '<button type="button" class="btn btn-info addOrganismoCana" data-organismo="'+value['Institucion']+'"><span class="fa fa-plus-square"></span></button>' ]);
                    });
                    tabla.draw();
                    $('.addOrganismoCana').click(function(e){
                        var text = $(this).attr('data-organismo');
                        $('#CanaOtro').append(text+';\n')
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
