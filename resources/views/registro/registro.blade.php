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
        
      {!! Form::open() !!}

      <div class="col-md-12" >
          <div class="col-md-3">
             <label for="nombre">Consejera: </label>&nbsp;<small>{!! Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido !!}</small>
          </div>
          <div class="col-md-3">
             <label for="nombre">Fecha:</label>&nbsp;<small><? $FechaActual=date("d/m/Y"); echo $FechaActual; ?></small>
          </div>
          <div class="col-md-3">
             <label for="nombre">Hora de Inicio:</label>&nbsp;<small><? $HoraActual=date("h:i A"); echo $HoraActual; ?></small>
          </div>
          <div class="col-md-3">
             <label for="nombre">Duración:</label>&nbsp;<small id="timer_div">0 Min.</small>
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
        <button type="button" class="btn btn-app bg-olive"><i class='fa fa-save'></i> Registrar</button>
      </div>

      {!! Form::close()!!}
        
    </div>
</section>

@stop
@section('recursosExtra')
{!! Html::script('js/bootstrap-editable.js') !!}
{!! Html::style('css/bootstrap-editable.css') !!}
<script>

  $(document).ready(function() {
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
    
    if( $('#Mexico').is(':checked')) {
        $('#cp').focusout( function() {
            var cp = $("#cp").val();
            $.ajax({
                type: 'POST', 
                url: 'Registro/buscarcp', 
                data: {cp: cp},
                success: function(response){
                    $("#Estado").val(response["estado"]);
                    $("#Colonia").val(response["colonia"]);
                    $("#Municipio").val(response["municipio"]);
                    
                }, 
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error en el servidor");
                }
            });
        }); 
    }

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