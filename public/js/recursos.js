function mostrarMensaje(mensaje) {
    $("#mensajeVista").html(mensaje);
    $("#mensajeVista").addClass("alert-danger");
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
            } else {
                $('html, body').animate({scrollTop: 0}, 'fast');
                location.reload();
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
        url: 'ActividadesUsuario/buscar',
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
            $('#ur').attr("value", usu.id_unidad_responsable);
            $('#urName').attr("value", usu.nombre_ur);
            $('#usuario').attr("value", usu.usuario);
            $('.modal-title').text("Modificar usuario");
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
}

$(document).ready(function() {
    $("#panel-messages").fadeTo(3000, 500).slideUp(500, function() {
        $("#panel-messages").hide();
    });

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
