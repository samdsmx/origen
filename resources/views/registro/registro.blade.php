@extends('layouts.baseInicio')
@section('titulo')
Registro
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
@include('registro.modalResponseRegistro')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;text-align:center;float:inherit;" class="col-md-10 col-sm-12 col-xs-12">
        <?php
            $fun=getdate();
            if($fun['hours']>=6&&$fun['hours']<=12)print("BUENOS DIAS, ");
            if($fun['hours']>=13&&$fun['hours']<=18)print("BUENAS TARDES, ");
            if($fun['hours']>=19&&$fun['hours']<=24)print("BUENAS NOCHES, ");
            if($fun['hours']>=0&&$fun['hours']<=5)print("BUENAS NOCHES, ");
        ?>
        BIENVENIDA(O) A LA LÍNEA DE AYUDA ORIGEN, TE ATIENDE 
        {!! Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido !!} 
         ¿EN QUE TE PUEDO APOYAR?
    </h1>

    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Registro</a></li>
    </ol>
</section>
<section class="content">
    <div id="panel-table">
        
      {!! Form::open( array( 'id'=>'registrollamada', 'method'=>'POST' ) ) !!}

      <div class="col-md-12" >
          <div class="col-md-3">
             <label for="nombre">Consejera: </label>&nbsp;<small>{!! Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido !!}</small>
          </div>
          <div class="col-md-3">
             <label for="actual">Fecha:</label>&nbsp;
             <small><?php $FechaActual=date("d/m/Y"); echo $FechaActual; ?></small>
             <input type="hidden" name="fechaActual" value="<?php echo $FechaActual; ?>">
          </div>
          <div class="col-md-3">
             <label for="nombre">Hora de Inicio:</label>&nbsp;
             <small><?php $HoraActual=date("G:i:s"); echo $HoraActual; ?></small>
             <input type="hidden" name="horaInicio" value="<?php echo $HoraActual;?>">
          </div>
          <div class="col-md-3">
              <label for="duracion">Duración:</label>&nbsp;<small id="timer_div">0 Min.</small>
          </div>
      </div>
      <br/>

      <div class="box box-primary">
        @include('registro.datosGenerales')
      </div>

      <div class="row">


          <div class="col-md-6">
              <div class="box box-success">
                @include('registro.localidad')
              </div>
        
              <div class="box box-info">
                @include('registro.contacto')
              </div>

              <div class="box box-warning">
                @include('registro.motivos')
              </div>

          </div>



          <div class="col-md-6">
            <div class="box box-danger">
              @include('registro.desarrollo')
            </div>

            <div class="box box-default">
              @include('registro.canalizacion')
            </div>

          </div>

      </div>

      <h4 style="color:#605ca8; font-weight:bold; text-align:center;">
          Te atendio {!! Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido !!} no dudes en marcar las veces que sea necesario. Nuestro horario es de Lunes a Viernes de 8:00am a 8:00pm <br/>
          De acuerdo a la ley de protección de datos personales puedes conocer nuestro aviso de privacidad en nuestra página www.origenac.org<br/>
          Esta es tu línea amiga, gratuita y confidencial. Estamos para escucharte.
      </h4>

      <div style="text-align:center;">
          <button type="submit" class="btn btn-app bg-olive"><i class='fa fa-save'></i> Registrar</button>
      </div>

      {!! Form::close()!!}
        
    </div>
</section>

@stop
@section('recursosExtra')
{!! Html::script('js/bootstrap-editable.js') !!}
{!! Html::style('css/bootstrap-editable.css') !!}
<script>
    $(".select2").select2();
    $('.js-example-basic-multiple').select2();
    $(".js-example-tokenizer").select2({
      tags: true,
      tokenSeparators: [',']
      });

    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-orange',
      radioClass: 'iradio_flat-orange'
    });
    
    $("#Estado").change( function(){
        $("#cp").val("");
        $("#Municipio").find('option')
                .remove()
                .end()
                .append('<option value="0">-</option>')
                .val('0');
        $("#Colonia").find('option')
                .remove()
                .end()
                .append('<option value="0">-</option>')
                .val('0');
        var estado = $(this).val();
        if( estado != "0" ){
            $.ajax({
                type: 'POST', 
                url: 'Registro/buscardelegacion', 
                data: { estado: estado }, 
                success: function( response ){
                    var opciones = '';
                    $.each( response, function( key, value ){
                        opciones += '<option value="'+key+'">'+value+'</option>';
                    }); 
                    $("#Municipio").append(opciones);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error en el servidor");
                }
            });
        }
    });
    
    $("#Municipio").change( function(){
        $("#cp").val("");
        $("#Colonia").find('option')
                .remove()
                .end()
                .append('<option value="0">-</option>')
                .val('0');
        var municipio = $(this).val();
        var estado = $("#Estado").val();
        if( municipio !== "0" ){
            $.ajax({
                type: 'POST', 
                url: 'Registro/buscarcolonia', 
                data: { municipio: municipio, estado: estado }, 
                success: function( response ){
                    var opciones = '';
                    $("#Colonia").find('option')
                            .remove()
                            .end()
                            .append('<option value="0">-</option>')
                            .val('0');
                    $.each( response, function( key, value ){
                        opciones += '<option value="'+key+'">'+value+'</option>';
                    }); 
                    $("#Colonia").append(opciones);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error en el servidor");
                }
            });
        }
    });
    
    $("#Colonia").change( function(){
        $("#cp").val("");
        var municipio = $("#Municipio").val();
        var estado = $("#Estado").val();
        var colonia = $(this).val();
        if( colonia !== "0" ){
            $.ajax({
                type: 'POST', 
                url: 'Registro/buscarcodigopostal', 
                data: { estado: estado, municipio: municipio, colonia:colonia }, 
                success: function( response ){
                    response = response.toString();
                    var cadenaCeros = '';
                    for( i=response.length; i < 5; i++ ){
                        cadenaCeros +="0"+cadenaCeros;
                    }
                    response = cadenaCeros+response;
                    $("#cp").val( response );
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error en el servidor");
                }
            });
        }
    });
    
    
    if( $('#Mexico').is(':checked')) {
        $('#cp').focusout( function() {
            var cp = $("#cp").val();
            $.ajax({
                type: 'POST', 
                url: 'Registro/buscarcp', 
                data: { cp: cp },
                success: function( response ){
                    $("#Estado").val(response["estado"]);
                    $("#Municipio").find('option')
                            .remove()
                            .end()
                            .append('<option value="0">-</option>');
                    $("#Municipio").append('<option value="'+response["municipio"]+'">'+response["municipio"]+'</option>');
                    $("#Municipio").val(response["municipio"]);
                    $("#Colonia").find('option')
                            .remove()
                            .end()
                            .append('<option value="0">-</option>');
                    $("#Colonia").append('<option value="'+response["colonia"]+'">'+response["colonia"]+'</option>');
                    $("#Colonia").val(response["colonia"]);
                }, 
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error en el servidor");
                }
            });
        });
    }
    
    $("#registrollamada").submit( function( e ) {
        e.preventDefault();
        var data = $(this).serialize()+'&duracion='+$('#timer_div').text();
        $.ajax({
           type: "POST", 
           url: "Registro/registrarllamada",
           data : data, 
           success: function( response ){
               $('#modalResponseRegistro').addClass( response.claseResponse );
               $('#modalTitulo').text( response.titulo );
               $('#modalContent').text( response.contenido );
               $('#modalResponseRegistro').modal('show');
           },
           error: function( jqXHR, textStatus, errorThrown ){
               $('#modalResponseRegistro').addClass( "modal-danger" );
               $('#modalTitulo').text( "Error en el servidor" );
               $('#modalContent').text( "A ocurrido un error en el servidor: "+errorThrown );
               $('#modalResponseRegistro').modal('show');
           }
        });
    }); 
    
    $('#cerrarModal').click(function(){
        window.location.href="<?php echo url('inicio'); ?>";
    });


    var startDate = new Date();

    var interval = setInterval(function() {
        var date2 = new Date();
        var timeDiff = Math.abs(date2.getTime() - startDate.getTime());
        var diffMin = Math.ceil(timeDiff / 60000); 
        document.getElementById('timer_div').innerHTML = diffMin + " Min."
    }, 60000);
    
    

</script>
@stop