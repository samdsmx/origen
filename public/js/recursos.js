$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

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
    $.ajax({
        type: 'POST',
        url: "Organismos/registraorganismo",
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
        $.ajax({
                type: 'POST',
                url: 'Organismos/buscarorganismos',
                data: $(this).serialize(),
                success: function(response) {
                    $('#tableContent').html(response);  
                    $('#tablaOrganismos').DataTable(propiedadesTabla);
                    $("#tablaOrganismos").reload();
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
    
    
    
    $('#buscaOrganismosCanalizacion').submit( function(e){
        e.preventDefault();
        $.ajax({
                type: 'POST',
                url: 'Registro/buscarorganismos',
                data: $(this).serialize(),
                success: function(response) {
                    $('#tablaMuestreo').show();
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
