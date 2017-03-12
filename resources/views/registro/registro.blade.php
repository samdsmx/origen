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
    <h1 style="color:#605ca8;font-weight: bolder;text-align:center;">
        <?
            $fun=getdate();
            if($fun['hours']>=6&&$fun['hours']<=12)print("BUENOS DIAS, ");
            if($fun['hours']>=13&&$fun['hours']<=18)print("BUENAS TARDES, ");
            if($fun['hours']>=19&&$fun['hours']<=24)print("BUENAS NOCHES, ");
            if($fun['hours']>=0&&$fun['hours']<=5)print("BUENAS NOCHES, ");
        ?>
        BIENVENIDA(O) A LA LÍNEA DE AYUDA ORIGEN, TE ATIENDE 
        {!! Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido !!} 
        <br/>¿EN QUE TE PUEDO APOYAR?
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Registro</a></li>
    </ol>
</section>
<section class="content" style="padding-bottom: 100px;">
    <div id="panel-table">
        <div>
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
            <div class="box-header with-border">
              <h3 class="box-title">Datos Generales</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>

            <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="nombre">Nombre:</label>
                  <input type="text" class="form-control" id="nombre" placeholder="Nombre completo" tabindex="1">
                </div>

                <div class="form-group col-md-2">
                  <label for="edad">Edad:</label>
                  <input type="number" class="form-control" id="edad" placeholder="Edad en años" tabindex="3" >
                </div>

                <div class="form-group col-md-4">
                    <label for="estadoCivil">Estado Civil:</label>
                    <select name="estadoCivil" class="form-control" style="width: 100%;" tabindex="8">
                     <option>-</option>
                     <option value="Soltera">Soltera</option>
                     <option value="Divorciada">Divorciada</option>
                     <option value="Viuda">Viuda</option>
                     <option value="Casada">Casada</option>
                     <option value="Separada">Separada</option>
                     <option value="Concubinato">Concubinato</option>
                     <option value="Union Libre">Union Libre</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                  <label for="genero">Genero:</label>
                  <div class="radio">
                    <label class="col-sm-6" style="display:table;" >
                      <input type="radio" tabindex="2" name="genero" id="genero1" value="f" checked>
                      Femenino
                    </label>
                    <label class="col-sm-6">
                      <input type="radio" name="genero" id="genero2" value="m">
                      Masculino
                    </label>
                  </div>
                </div>

                <div class="form-group col-md-5">
                    <label for="estudios">Nivel de estudios:</label>
                    <select name="estudios" class="form-control" style="width: 100%;" tabindex="6">
                        <option selected="">-</option>
                        <option>Analfabeta</option>
                        <option>Primaria</option>
                        <option>Secundaria</option>
                        <option>Preparatoria</option>
                        <option>Carrera Técnica</option>
                        <option>Carrera Universitaria</option>
                        <option>Posgrado</option>
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="religion">Religión:</label>
                    <select name="religion" class="form-control" style="width: 100%;" tabindex="7">
                     <option>-</option>
                     <option selected="">Catolica</option>
                     <option>Musulmana</option>
                     <option>Judia</option>
                     <option>Pentecostes</option>
                     <option>Mormona</option>
                     <option>Evangelica</option>
                     <option>Cristiana</option>
                     <option>Testigo de Jehova</option>
                     <option>Ninguna</option>
                    </select>
                </div>

                <div class="form-group col-md-2">
                  <label for="lengua">¿Habla alguna lengua indigena?</label>
                  <div class="radio">
                    <label class="col-sm-6" style="display:table;">
                      <input type="radio" tabindex="4" name="lengua" id="lengua1" value="f" checked>
                      No
                    </label>
                    <label class="col-sm-6">
                      <input type="radio" name="lengua" id="lengua2" value="m">
                      Si
                    </label>
                  </div>
                </div>

                <div class="form-group col-md-5">
                  <label for="ocupacion">Ocupación:</label>
                  <select name="ocupacion" class="form-control" style="width: 100%;" tabindex="9" onchange="showfield(this.options[this.selectedIndex].value)">
                    <option>-</option>
                    <option selected="">Ama de casa</option>
                    <option>Empleada</option>
                    <option>Empleada Domestica</option>
                    <option>Negocio propio</option>
                    <option>Jubilado y/o pensionado</option>
                    <option>Estudiante</option>
                    <option>Desempleada</option>
                    <option value="Otra">Otra :</option>
                  </select>
                </div>

                <div class="form-group col-md-5">
                  <label for="VivesCon">Vives con...</label>
                  <select name="VivesCon" class="form-control" style="width: 100%;" tabindex="10">
                        <option>Sola</option>
                        <option>Padres</option>
                        <option>Pareja</option>
                        <option selected="">Familia</option>
                        <option>Hijos</option>
                        <option>Padre</option>
                        <option>Madre</option>
                        <option>Otros</option>
                  </select>
                </div>

            </div>
          </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="box box-success">
                        <div class="box-header with-border">
                          <h3 class="box-title">Localidad</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>
                        </div>

                        <div class="box-body">

                            <div class="form-group col-md-2">
                                <label for="edad">Codigo Postal:</label>
                                <input type="number" class="form-control" placeholder="#####">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="edad">Entidad:</label>
                                <select name="Estado" id="Estado" class="form-control" onchange="changeEstado('forma');">
                                <option value="">-</option>
                                <option>Aguascalientes</option>
                                <option>Baja California</option>
                                <option>Baja California Sur</option>
                                <option>Campeche</option>
                                <option>Chiapas</option>
                                <option>Chihuahua</option>
                                <option>Coahuila de Zaragoza</option>
                                <option>Colima</option>
                                <option>Distrito Federal</option>
                                <option>Durango</option>
                                <option>Guanajuato</option>
                                <option>Guerrero</option>
                                <option>Hidalgo</option>
                                <option>Jalisco</option>
                                <option>México</option>
                                <option>Michoacán de Ocampo</option>
                                <option>Morelos</option>
                                <option>Nayarit</option>
                                <option>Nuevo León</option>
                                <option>Oaxaca</option>
                                <option>Puebla</option>
                                <option>Querétaro</option>
                                <option>Quintana Roo</option>
                                <option>San Luis Potosí</option>
                                <option>Sinaloa</option>
                                <option>Sonora</option>
                                <option>Tabasco</option>
                                <option>Tamaulipas</option>
                                <option>Tlaxcala</option>
                                <option>Veracruz de Ignacio de la Llave</option>
                                <option>Yucatán</option>
                                <option>Zacatecas</option>
                                <option value="Extranjero">Extranjero</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="edad">Delegación o Municipio:</label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="edad">Colonia:</label>
                                <input type="text" class="form-control">
                            </div>                                                                                    

                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="box box-info">
                        <div class="box-header with-border">
                          <h3 class="box-title">Contacto</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>
                        </div>
                        <div class="box-body">

                            <div class="form-group col-md-4">
                                <label for="edad">Teléfono:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control" placeholder="####-####">
                                </div>
                            </div>

                            <div class="form-group col-md-5">
                                <label for="edad">Correo Electronico:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="edad">Medio de contacto:</label>
                                <select name="MedioContacto" class="form-control" style="width: 100%;" tabindex="10">
                                    <option selected="">Telefdno</option>
                                    <option>Chat</option>
                                    <option>Mail</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>


            {!! Form::close()!!}
        </div>
    </div>
</section>
<section class="content-footer">
    <h4 style="color:#605ca8;font-weight: bold;text-align:center;">
        Te recuerdo que mi nombre es {!! Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido !!} no dudes en marcar las veces que sea necesario. Nuestro horario es de Lunes a Viernes de 8:00 A.M. a 8:00 P.M. <br/>
        Te comento que de acuerdo a la ley de protección de datos personales, puedes conocer nuestro aviso de privacidad a través de nuestra página de internet en www.origenac.org. <br/>
        Esta es tu línea amiga, gratuita y confidencial. Estamos para escucharte.
    </h4>
</section>


@stop
@section('recursosExtra')
{!! Html::script('js/bootstrap-editable.js') !!}
{!! Html::style('css/bootstrap-editable.css') !!}
<script>

  $(document).ready(function() {
    $(".select2").select2();
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