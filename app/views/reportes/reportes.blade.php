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
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Reportes</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Reportes</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 style="margin: 0px; padding: 0px; top: -150px;">{{ abs($dias) }}</h3>
                    <p style="margin: 0px; padding: 0px; top: -150px;">días para {{ (($dias>=0)?'cierre':'apertura') }} del <br/> periodo.</p>
                </div>
                <div class="icon visible-lg visible-sm">
                    <i class="fa fa-calendar"></i>
                </div>
                <a href="Periodos" class="small-box-footer">Mas... <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 style="margin:0;">{{ $activos  }}<sup style="font-size: 20px;">activos</sup></h3>
                    <p style="margin:0;">{{ $completos }}<sub style="font-size: 10px;"> completos</sub>&nbsp;&nbsp;&nbsp;{{ $incompletos }}<sub style="font-size: 10px;"> pendientes</sub></p>
                    <hr class="hidden-xs" style="margin:1px; width: 135px;">
                    <hr class="visible-xs" style="margin-left:10%; margin-top: 1px; margin-bottom: 1px; width: 80%;">
                    <p style="margin:-2px; text-align: center;">{{ $bajas }}<sub style="font-size: 10px;"> bajas</sub></p>
                </div>
                <div class="icon visible-lg visible-sm">
                    <i class="fa fa-binoculars"></i>
                </div>
                <a href="Consultas" class="small-box-footer">Mas... <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="small-box bg-yellow" >
                <div class="inner hidden-xs" style="height: 103px; text-align: center; margin-left:-5px;">
                    @foreach( $observaciones as $n => $obs )
                        <div class="progress" style="width:{{ ($n+3) * 25 }}px; padding: 0; margin: 0; margin-left: {{12.5*(sizeof($observaciones) - $n - 1)}}px; text-align: center;">
                            <div class="progress-bar infoPeriodos" style="background-color: #ce840f; width: 100%; text-align: center;" >{{$obs->descripcion.': '.$obs->cuenta }} </div>
                        </div>
                    @endforeach
                </div>
		<div class="inner visible-xs piramidePeque" style="height: 103px; text-align: center; padding-left: 40%; margin-right: 30%;">
                    @foreach( $observaciones as $n => $obs )
                        <div class="progress" style="width:{{ ($n+3) * 25 }}px; padding: 0; margin: 0; margin-left: {{12.5*(sizeof($observaciones) - $n - 1)}}px; text-align: center;">
                            <div class="progress-bar infoPeriodos" style="background-color: #ce840f; width: 100%; text-align: center;" >{{$obs->descripcion.': '.$obs->cuenta }} </div>
                        </div>
                    @endforeach
                </div>
                <div class="icon visible-lg visible-sm" >
                    <i class="fa fa-area-chart" style="font-size: 80px;"></i>
                </div>
		    <a href="#" id="periodoSelect" class="small-box-footer">{{ 'Del '.fechaLarga($periodo->fecha_inicio) . ' al '. fechaLarga($periodo->fecha_fin) }} <i class="fa fa-arrow-circle-right"></i></a>
		    <div id="opcionesPeriodoSelect" class="small-box box box-warning" style="display:none;position:absolute;z-index:9000;">
			      	<div class="box-header with-border">
    					<h3 class="box-title">Seleccione una opción</h3>
    					<div class="box-tools pull-right">
						<button id="cerrarOpcionesPeriodo" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
    					</div>
  				</div>
			    <div class="box-body" style="color:#444;">
				    @foreach($fechaPeriodos as $fec)
				    <p class="opcionPeriodo" value="{{$fec->id_periodo}}">Del {{fechaLarga($fec->fecha_inicio)}} al {{fechaLarga($fec->fecha_fin)}}</p>
				    @endforeach
			    </div>
		    </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{round($resultadoTareas)}}</h3>
                    <p>Sistemas por día</p>
                </div>
                <div class="icon visible-lg visible-sm" style="top:2px">
		<canvas id="gauge1" width="100" height="100"
		data-type="canv-gauge"
		data-min-value="0"
		data-max-value="15"
		data-major-ticks=" 5 10 15"
		data-minor-ticks="2"
		data-stroke-ticks="true"
		data-value-format="5"
		data-glow="true"
		data-animation-delay="10"
		data-animation-duration="200"
		data-animation-fn="bounce"
		data-colors-needle="#f00 #00f"
		data-highlights="0 5 #088A08, 5 10 #FFFF00, 10 15 #B40404"
		
></canvas>
                </div>
                <a href="#" class="small-box-footer">Mas... <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="container" style="padding: 20px;">
	    <div class="row">
		    <div id="zonaGraficas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 zonaGraficas box box-info hidden-xs">
			    <div class="box-header with-border">
				    <h4><select id="opcionesGraficas" class="col-lg-3 col-md-3 col-sm-3">
				    <option selected disabled value="0"> Seleccione un tipo de gráfica </option>
				    @foreach($graficasPosibles as $graf)
				    <option value="{{$graf['id']}}">{{$graf['nombre']}}</option>
				    @endforeach
			    </select> 
					    <button id="enviarGraficas" style="margin-left:2%" class="btn btn-primary">Crear gráfica</button>
					    <input type="hidden" value="0" id="switchGraficas">
				    </h4>
				    <div class="box-tools pull-right">
					    <button id="descargarTabla" class="btn btn-box-tool"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
					     <a id="downloadImgLink" class="btn btn-box-tool" onclick="$('#downloadImgLink').attr('href', canvas.toDataURL());" download="Grafica.png" href="#" target="_blank"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
      					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				    </div>
			    </div>
			    <div class="box-body">
			    <div id="todoGraficas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display:none;">
				    <div id="formularioGraficas" class="col-lg-3 col-md-2 col-sm-2 " style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; padding-bottom: 2%;">
					    <input type="hidden" id="tipoTodoGraficas" value="0">
					    <input type="hidden" id="idGrafica" value="0">
				    <p class="text-center ">
					    <input id="rangoGraficas" type="range" min="1" max="3" step="1" value="0">
					<label id="valorRangoGraficas">Por periodo</label>
				    </p>
				    <p class="text-center">
					    <select id="periodosSelectGraficas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						    <option value="0" selected>Periodo actual</option>
					    </select>
				    </p>
				    <p class="text-center">
					    <label>Tipo de gráfica: </label> 
					    <select id="tipoGraficas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						    <option value="0" disabled selected> Seleccione un tipo de gráfica </option>
						    <option value="1">Grafica de lineas</option>
						    <option value="2">Grafica de barras</option>
						    <option value="3">Grafica de radar</option>
						    <option value="4">Grafica polar</option>
						    <option value="5">Grafica de pastel</option>
						    <option value="6">Grafica de dona</option>
					    </select>
				    </p>
				    <p id="valoresMedidosGraficas"class="text-center">
					    <label >Elemento a graficar: </label> 
					    <select id="medidoGraficas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						    <option selected disabled value="0">Seleccione una opción</option>
						    @foreach($nombresCamposT as $cam)
						    	<option value="{{$cam->tabla.':'.$cam->columna}}">{{'La columna '.strtoupper($cam->columna).' de la tabla '.strtoupper($cam->tabla)}}</option>
						    @endforeach
					    </select>
				    </p>
				    <p class="text-center">
				    </p>
				    <p class="text-center">
					    <input id="filtroGraficas" type="checkbox"> Agregar filtro 
				    </p>
				    <p >
				    	<div id="filtroContenidoGraficas" style="display:none;" class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<span class="input-group-addon">
							<select id="filtroSelectGraficas">
								<option value="0" selected disabled> Seleccione un filtro </option>
								<option value="=" >=</option>
				                                <option value="<>">&#60;&#62;</option>
                                    				<option value=">"> &#62;  </option>
                                    				<option value=">="> &#62;= </option>
                                    				<option value="<"> &#60; </option>
                                    				<option value="<="> &#60;= </option>
                                    				<option value="like"> like </option>
                                    				<option value="is Null"> is null </option>
                                    				<option value="is not null"> not null </option>
							</select> 
						</span>
						<input type="text" id="filtroTextoGraficas" class="form-control">
					</div>    
				    </p>
				    <p class="text-center">
					    <input id="comparadorGraficas" type="checkbox"> <span id="textoComparadorGraficas">Comparar</span>
				    </p>
				    <p id="comparadoGraficas" class="text-center" style="display:none;">
					    <label>Elemento a comparar: </label>
					    <select id="elementoComparadoGraficas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						    <option value="1">Valor cambiante</option>
					    </select>
				 </div> 
				    <div id="contenedorCanvas" class="col-lg-8 col-md-10 col-sm-10">
					    <canvas id="canvas"  style="margin-left: 30%" width="300" height="300"></canvas>
				    </div>
			    </div>  
			</div>
		    </div>	    
	    </div>        
    </div>
	<form id="getExcel" action="Reportes/excel" method="post">
		<input id="informacionTabulada" name="informacionTabulada" type="hidden" value="0">
		<input id="fechasTabuladas" name="fechasTabuladas" type="hidden" value="0">
	</form>

</section>
@stop
@section('recursosExtra')
{{ HTML::script('js/plugins/Chart.js') }}
{{ HTML::script('js/plugins/gauge.js') }}
<style>
.opcionPeriodo:hover{
	background-color: #23527c;
	color: #f2f2f2;
}
.zonaGraficas{
	background-color: white;
	max-height: 100%;
	min-height: 50%;
	
}
</style>
	<script>


    $('#tablaSistemas').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        ordering: true,
        info: true,
        order: [[0, "asc"]],
        lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
        language: dataTablesSpanish,
        columnDefs: [{orderable: false, targets: [0, 1]}]
    });

    $('.sinCambios').click(function(e) {
        e.preventDefault();
        var data = "Id=" + $(this).data("id");
        $.ajax({
            type: 'POST',
            data: data,
            url: 'Sistemas/reportarsincambios',
            success: function(response) {
                if (response.mensaje) {
                    mostrarMensaje("<p>" + response.mensaje + "</p>");
                } else {
                    window.location.href = "Sistemas";
                }
            },
            error: function(xhr, status, error) {
                mostrarMensajeError("error en el servidor");
            }
        });
    });

    $('#buscarSistemas').on("click", function() {
        $("#buscarSis").submit();
    });


	$('#periodoSelect').click(function(){
		$('#opcionesPeriodoSelect').toggle('slow');
	});
	$('.opcionPeriodo').click(function(){
		var j=0;
		var id = 'fecha='+$(this).attr('value');
		var fecha = $(this).text()+'  <i class="fa fa-arrow-circle-right"></i>';
		$.ajax({
			url:'Reportes/periodo',
			data:id,
			method:'POST',
			success(data){
				if(data=='noNumerico'){
					mostrarMensajeError('Error al intentar acceder a la información, intente de nuevo más tarde');
					console.log('buen intento, tendrás que ser más listo la prox vez');
					$('#opcionesPeriodoSelect').toggle('slow');
				}else if(data=='vacio'){
					mostrarMensajeError('El periodo seleccionado no tiene información');	
					$('#opcionesPeriodoSelect').toggle('slow');
				}else{
							
						$('.infoPeriodos').each(function(){
							$(this).text(data[j].descripcion+': '+data[j].cuenta);
							j++;
						});
						$('#periodoSelect').html(fecha);
					$('#opcionesPeriodoSelect').toggle('slow');
				}
			},
			error(){
				mostrarMensajeError('Error al intentar acceder a la información, intente de nuevo más tarde');
			}
			
		});


	});
	{{$resultadoTareas}}



	$('#cerrarOpcionesPeriodo').click(function(){
		$('#opcionesPeriodoSelect').toggle('slow');
	});	
	$('#gauge1').attr('data-onready','Gauge.Collection.get("gauge1").setValue({{$resultadoTareas}});');

	$(window).resize(function() {

		var ventana = $( window ).width();

		if(ventana <= 326){
			$('.piramidePeque').attr('style','height: 103px; text-align: center; margin-left:-5px;');
		}else{
			$('.piramidePeque').attr('style','height: 103px; text-align: center; padding-left: 40%; margin-right: 30%;');
		}
		
	});

	function generarGrafica(valor){
		var ctx = document.getElementById("canvas").getContext("2d");
		var tipoGrafica;
		var cantidadGraficada = [];
		var labelGraficada = [];
		$.ajax({
			url:'Reportes/graficar/'+valor,
			success: function(data){
				informacionTabulada = data;
				var cantidad = data.length;
				for(var i=0; i<cantidad;i++){
					if(i==0){
						tipoSplit = data[i].split(':');
						tipoGrafica = tipoSplit[0];
					}else{
						var separadorCantidadLabel = data[i].split(':');
						cantidadGraficada.push(separadorCantidadLabel[1]);
						labelGraficada.push(separadorCantidadLabel[0]);
					}
				}	

				 if(tipoGrafica == 2){
				
				var barInformacion = {
    					labels: ["Periodo actual"],
   					datasets: [
        					{
        					    label: labelGraficada[0],
						    fillColor: "rgba(220,220,220,0.5)",
						    strokeColor: "rgba(220,220,220,0.8)",
					            highlightFill: "rgba(220,220,220,0.75)",
					            highlightStroke: "rgba(220,220,220,1)",
					            data: [cantidadGraficada[0]]
        					},
        					{
					            label: labelGraficada[1],
					            fillColor: "rgba(151,187,205,0.5)",
						    strokeColor: "rgba(151,187,205,0.8)",
					            highlightFill: "rgba(151,187,205,0.75)",
					            highlightStroke: "rgba(151,187,205,1)",
					            data: [cantidadGraficada[1]]
        					}
    					]
				};
	
				var myBarChart = new Chart(ctx).Bar(barInformacion,{responsive:false});
	
				}else if(tipoGrafica == 3){

					var radarInformacion = {
						labels:labelGraficada,
						datasets: [
							{
								label:"informacionPrincipal",
								fillColor: "rgba(220,220,220,0.2)",
							        strokeColor: "rgba(220,220,220,1)",
			        	    			pointColor: "rgba(220,220,220,1)",
	            						pointStrokeColor: "#fff",
			            				pointHighlightFill: "#fff",
            							pointHighlightStroke: "rgba(220,220,220,1)",					
								data:cantidadGraficada,
							}
						]
					};	
					
					var myRadarChart = new Chart(ctx).Radar(radarInformacion,{responsive:false});
			}},
			error: function(){
				mostrarMensajeError('error');
			}
		});
		
	}


	$('#opcionesGraficas').change(function(){
		var texto;
		var valor; 
		$( "#opcionesGraficas option:selected" ).each(function() {
			texto = $( this ).text();
			valor = $( this ).val();
    		    });
		$('#switchGraficas').val('0');
		var switchGraficas = $('#switchGraficas').val();
		$('#enviarGraficas').click(function(){
		if(switchGraficas== 0){
		$('#rangoGraficas').val('1');
		$('#rangoGraficas').trigger('change');
		$('#canvas').remove();
		var tamano = $(window).width();
		if(tamano >= 1200){
			$('#contenedorCanvas').append('<canvas id="canvas" style="margin-left: 30%" width="300" height="300"></canvas>');
		}else if(tamano >= 992 && tamano < 1200){
			$('#contenedorCanvas').append('<canvas id="canvas" style="margin-left: 30%" width="300" height="400"></canvas>');
		}else if(tamano >=767 && tamano < 992){
			$('#contenedorCanvas').append('<canvas id="canvas" style="margin-left: 10%" width="300" height="300"></canvas>');
		}
		
		if(valor > 0 && texto == "Personalizada"){
			$('#opcionesGraficas').val(valor);
			$('#todoGraficas').attr('style','display:inline;');		
			$('#valoresMedidosGraficas').attr('style','display:block;');
			$('#tipoGraficas').parent('p').attr('style','display:block;');
			$('#filtroGraficas').parent('p').attr('style','display:block;');
			if($('#comparadorGraficas').is(':checked')){
				$('#comparadorGraficas').trigger('click');
			}
			$('#tipoTodoGraficas').val(1);
			$('#switchGraficas').val('1');

		}else if(valor > 0 && texto != "Personalizada"){
			$('#idGrafica').val(valor);
			$('#opcionesGraficas').val(valor);
			$('#todoGraficas').attr('style','display:inline;');			
			$('#valoresMedidosGraficas').attr('style','display:none;');
			$('#tipoGraficas').parent('p').attr('style','display:none;');
			$('#filtroGraficas').parent('p').attr('style','display:none;');
			$('#btnSemestreGraficas').parent('div').attr('style','display:block;');
			$('#periodosSelectGraficas').parent('p').attr('style','display:block;');
			$('#comparadorGraficas').parent('p').attr('style','display:block;');
			if($('#filtroGraficas').is(':checked')){
				$('#filtroGraficas').trigger('click');
			}
			if($('#comparadorGraficas').is(':checked')){
				$('#comparadorGraficas').trigger('click');
			}
			$('#tipoTodoGraficas').val(2);
			generarGrafica(valor);
			$('#switchGraficas').val('1');
		}
		}
		});	
	});

	$('#comparadorGraficas').change(function(){
    		$('#comparadoGraficas').attr('style', this.checked ? 'display:block;' : 'display:none;');
	});

	$('#filtroGraficas').change(function(){
    		$('#filtroContenidoGraficas').attr('style', this.checked ? 'display:table;' : 'display:none;');
	});


	function llenarPeriodoSelect(tipo){

		if(tipo == 1){
			$.ajax({
				url:'Reportes/periodos',
				data:'tipo='+tipo,
				method:'POST',
				success: function(data){
					if(data == "fallo"){
						console.log('nice try');
					}else{
						$('#periodosSelectGraficas').empty();
						$('#elementoComparadoGraficas').empty();
						$('#periodosSelectGraficas').append('<option disabled selected value="0">Seleccione una opcion</option>');
						$('#elementoComparadoGraficas').append('<option disabled selected value="0">Seleccione una opcion</option>');							
						for(var i = 0; i<data.length; i++){
							$('#periodosSelectGraficas')
								.append('<option value='+data[i].fecha_inicio+':'+data[i].fecha_fin+'>Del '
								+data[i].fecha_inicio+' al '+data[i].fecha_fin+'</option>');
							$('#elementoComparadoGraficas')
								.append('<option value='+data[i].fecha_inicio+':'+data[i].fecha_fin+'>Del '
								+data[i].fecha_inicio+' al '+data[i].fecha_fin+'</option>');
						}
					}
				},
				error: function(){
					mostrarMensajeError('error');
				}
			});	
		}else if(tipo == 2){
			$.ajax({
				url:'Reportes/periodos',
				data:'tipo='+tipo,
				method:'POST',
				success: function(data){
					if(data == "fallo"){
						console.log('nice try');
					}else{
						$('#periodosSelectGraficas').empty();
						$('#elementoComparadoGraficas').empty();
						$('#periodosSelectGraficas').append('<option disabled selected value="0">Seleccione una opcion</option>');
						$('#elementoComparadoGraficas').append('<option disabled selected value="0">Seleccione una opcion</option>');	
						for(var i = 0; i<data.length; i++){
							$('#periodosSelectGraficas')
								.append('<option value='+data[i].anio+':'+data[i].semestre+'>Semestre '
								+data[i].semestre+' del '+data[i].anio+'</option>');
							$('#elementoComparadoGraficas')
								.append('<option value='+data[i].anio+':'+data[i].semestre+'>Semestre '
								+data[i].semestre+' del '+data[i].anio+'</option>');
						}
					}
				},
				error: function(){
					mostrarMensajeError('error');
				}
			});	
		}else if(tipo == 3){
			$.ajax({
				url:'Reportes/periodos',
				data:'tipo='+tipo,
				method:'POST',
				success: function(data){
					if(data == "fallo"){
						console.log('nice try');
					}else{
						$('#periodosSelectGraficas').empty();
						$('#elementoComparadoGraficas').empty();
						$('#periodosSelectGraficas').append('<option disabled selected value="0">Seleccione una opcion</option>');
						$('#elementoComparadoGraficas').append('<option disabled selected value="0">Seleccione una opcion</option>');	
						for(var i = 0; i<data.length; i++){
							$('#periodosSelectGraficas')
								.append('<option value='+data[i].anio+'>'
								+data[i].anio+'</option>');
							$('#elementoComparadoGraficas')
								.append('<option value='+data[i].anio+'>'
								+data[i].anio+'</option>');
						}
					}
				},
				error: function(){
					mostrarMensajeError('error');
				}
			});
		}
	}


	$('#rangoGraficas').change(function(){
		var rango = $('#rangoGraficas').val();
		if(rango == 1){
			$('#valorRangoGraficas').text('Por periodo');
			llenarPeriodoSelect(rango);
		}else if(rango == 2){
			$('#valorRangoGraficas').text('Por semestre');
			llenarPeriodoSelect(rango);
		}else if(rango == 3){
			$('#valorRangoGraficas').text('Por año');
			llenarPeriodoSelect(rango);
		}
	});
	


	$('#enviarGraficas').click(function(){
		var switchGraficas = $('#switchGraficas').val();
		if(switchGraficas != '0'){
		var periodo = $('#periodosSelectGraficas option:selected').val()!='0' ? $('#periodosSelectGraficas option:selected').val() : '0';
		var periodoTexto = $('#periodosSelectGraficas option:selected').val()!='0' ? $('#periodosSelectGraficas option:selected').text() : 'Periodo actual';
		var tipo = $('#tipoGraficas option:selected').val();
		var idgrafica = $('#idGrafica').val();
		var elemento = $('#medidoGraficas').val();
		var tipotg = $('#tipoTodoGraficas').val();

    		var filtro = $('#filtroGraficas').is(':checked') ? $('#filtroSelectGraficas option:selected').val() : '0';
    		var filtroContenido = $('#filtroGraficas').is(':checked') ? $('#filtroTextoGraficas').val() : '';
    		var comparado = $('#comparadorGraficas').is(':checked') ? $('#elementoComparadoGraficas option:selected').val() : '0';
    		var comparadoTexto = $('#comparadorGraficas').is(':checked') ? $('#elementoComparadoGraficas option:selected').text() : '0';
		if(elemento != null && tipotg == 1){
			crearGrafica1(tipotg,idgrafica,periodo,tipo,elemento,filtro,filtroContenido,comparado,periodoTexto,comparadoTexto);
		}else if(tipotg == 2 && periodo != 0){
			crearGrafica1(tipotg,idgrafica,periodo,tipo,elemento,filtro,filtroContenido,comparado,periodoTexto,comparadoTexto);
		}else if(elemento == null && tipotg == 1){
			mostrarMensajeError('Escoga un elemento para medir');
		}else if(tipotg == 2 && periodo == 0){
			mostrarMensajeError('Escoga un periodo');
		}else{
			mostrarMensajeError("Ocurrió un error inesperado, intente de nuevo más tarde 3");
			
		}
		}
	});	

function aleatorio(inferior,superior){
   numPosibilidades = superior - inferior
   aleat = Math.random() * numPosibilidades
   aleat = Math.floor(aleat)
   return parseInt(inferior) + aleat
} 

function colorAleatorio(){
   hexadecimal = new Array("9","A","B","C","D","E")
   color_aleatorio = "#";
   for (i=0;i<6;i++){
      posarray = aleatorio(0,hexadecimal.length)
      color_aleatorio += hexadecimal[posarray]
   }
   return color_aleatorio
} 

var informacionTabulada;

$('#descargarTabla').click(function(){
	$('#informacionTabulada').val(informacionTabulada.join('%'));
		var periodoTexto = $('#periodosSelectGraficas option:selected').val()!='0' ? $('#periodosSelectGraficas option:selected').text() : 'Periodo actual';
    		var comparadoTexto = $('#comparadorGraficas').is(':checked') ? $('#elementoComparadoGraficas option:selected').text() : '0';

	$('#fechasTabuladas').val(periodoTexto+':%'+comparadoTexto);
	$('#getExcel').submit();
});

$('#tipoGraficas').change(function(){
	var valor;
	$( "#tipoGraficas option:selected" ).each(function() {
		valor = $( this ).val();
    	});
	if(valor > 3){
		if($('#comparadorGraficas').is(':checked')){
				$('#comparadorGraficas').trigger('click');
		}
		$('#comparadorGraficas').parent('p').attr('style','display:none;');
	}else{

		$('#comparadorGraficas').parent('p').attr('style','display:block;');
	}
});

function crearGrafica1(tipotg,idgrafica,periodo,tipo,elemento,filtro,filtroContenido,comparado,periodoTexto,comparadoTexto){
		$.ajax({
			url:'Reportes/graficap',
			method:'POST',
			data: 'tipotg='+tipotg+'&idgrafica='+idgrafica+'&periodo='+periodo+'&tipo='+tipo+'&elemento='+elemento+'&filtro='+filtro+'&filtroc='+filtroContenido+'&comparado='+comparado,
			success: function(data){
				$('#canvas').remove();
				var tamano = $(window).width();
				if(tamano >= 1200){
			$('#contenedorCanvas').append('<canvas id="canvas" style="margin-left: 30%" width="300" height="300"></canvas>');
		}else if(tamano >= 992 && tamano < 1200){
			$('#contenedorCanvas').append('<canvas id="canvas" style="margin-left: 30%" width="300" height="300"></canvas>');
		}else if(tamano >=767 && tamano < 992){
			$('#contenedorCanvas').append('<canvas id="canvas" style="margin-left: 10%" width="300" height="300"></canvas>');
		}
				var ctx = document.getElementById("canvas").getContext("2d");
				var cantidadGraficada = [];
				var cantidadGraficada1 = [];
				var labelGraficada = [];
				var labelGraficada1 = [];
				informacionTabulada = data;
				console.log(data);
				var cantidad = data.length;
				var spliteado1 = data[0].split(':');
				var tipoGrafica = spliteado1[0];
				var comparacion = spliteado1[1];
				var cantidadMaxima;
				if(comparacion == 0){
					cantidadMaxima = cantidad-1;
					comparacion = false;
				}else{
					cantidadMaxima = (cantidad-1)/2;
					comparacion = true;
				}

				if(cantidadMaxima>6 && tipoGrafica > 1 && tipoGrafica < 4 ){
					mostrarMensajeError("Hay un número excesivo de elementos, filtre más información o cambie de gráfica");
				}else{
				for(var i=1; i<=cantidadMaxima;i++){
						var separadorCantidadLabel = data[i].split(':');
						cantidadGraficada.push(separadorCantidadLabel[1]);
						labelGraficada.push(separadorCantidadLabel[0]);
				}	
				if(comparacion == true){	
					for(var i=(cantidadMaxima+1); i<cantidad;i++){
						var separadorCantidadLabel = data[i].split(':');
						cantidadGraficada1.push(separadorCantidadLabel[1]);
						labelGraficada1.push(separadorCantidadLabel[0]);
					}
				}

				if(tipoGrafica == 1){
				var informacionGraficada = [];
				if(comparacion == true){
					informacionGraficada = [
						{
				            label: periodoTexto,
					    fillColor: colorAleatorio(),
        				    strokeColor: colorAleatorio(),
			        	    pointColor:colorAleatorio(),
					    pointStrokeColor:colorAleatorio(),
			        	    pointHighlightFill: colorAleatorio(),
					    pointHighlightStroke: colorAleatorio(),
				            data: cantidadGraficada
        					},
						{
				            label: comparadoTexto,
					    fillColor: colorAleatorio(),
        				    strokeColor: colorAleatorio(),
			        	    pointColor:colorAleatorio(),
					    pointStrokeColor:colorAleatorio(),
			        	    pointHighlightFill: colorAleatorio(),
					    pointHighlightStroke: colorAleatorio(),
				            data: cantidadGraficada1
        					}

					]; 
				}else if(comparacion == false){
						informacionGraficada.push({
				        	    label: labelGraficada,
						    fillColor: colorAleatorio(),
        					    strokeColor: colorAleatorio(),
			        		    pointColor:colorAleatorio(),
						    pointStrokeColor:colorAleatorio(),
				        	    pointHighlightFill: colorAleatorio(),
						    pointHighlightStroke: colorAleatorio(),
					            data: cantidadGraficada
						    });
				
				}
					var LinealInformacion = {
    labels: labelGraficada,
    
    datasets: informacionGraficada
};
	var myLineChart = new Chart(ctx).Line(LinealInformacion,{responsive:false});

			
	
				}else if(tipoGrafica == 2){
				var barInformacion;
				if(comparacion == false){
					var informacion = [];
					for(var i=0; i<(cantidad-1); i++){
						informacion.push({
        						    label: labelGraficada[i],
							    fillColor: colorAleatorio(),
							    strokeColor: colorAleatorio(),
						            highlightFill: colorAleatorio(),
						            highlightStroke: colorAleatorio(),
						            data: [cantidadGraficada[i]]
        						});
					}
					barInformacion = {
    						labels: [periodoTexto],
   						datasets: informacion
					};
				}else if(comparacion == true){
					barInformacion = {
    						labels: labelGraficada,
   						datasets: [
							{
							    label: periodoTexto,
							    fillColor: colorAleatorio(),
							    strokeColor: colorAleatorio(),
						            highlightFill: colorAleatorio(),
						            highlightStroke: colorAleatorio(),
						            data: cantidadGraficada
							},
							{
							    label: comparadoTexto,
							    fillColor: colorAleatorio(),
							    strokeColor: colorAleatorio(),
						            highlightFill: colorAleatorio(),
						            highlightStroke: colorAleatorio(),
						            data: cantidadGraficada1
							}
						]
					};
				}


				
	
				var myBarChart = new Chart(ctx).Bar(barInformacion,{responsive:false});
	
				}else if(tipoGrafica == 3){
				var radarInformacion;
					if(comparacion == true){
						radarInformacion = {
						labels:labelGraficada,
						datasets: [
								{
									label:periodoTexto,
									fillColor: colorAleatorio(),
								        strokeColor: colorAleatorio(),
			        		    			pointColor: colorAleatorio(),
	            							pointStrokeColor: colorAleatorio(),
				            				pointHighlightFill: colorAleatorio(),
        	    							pointHighlightStroke: colorAleatorio(),					
									data:cantidadGraficada,
								},
								{
									label:comparadoTexto,
									fillColor: colorAleatorio(),
								        strokeColor: colorAleatorio(),
			        		    			pointColor: colorAleatorio(),
	            							pointStrokeColor: colorAleatorio(),
				            				pointHighlightFill: colorAleatorio(),
        	    							pointHighlightStroke: colorAleatorio(),					
									data:cantidadGraficada1,
								}
							]
						};
					}else if(comparacion == false){
						var radarInformacion = {
						labels:labelGraficada,
						datasets: [
								{
									label:periodoTexto,
									fillColor: colorAleatorio(),
								        strokeColor: colorAleatorio(),
				        	    			pointColor: colorAleatorio(),
		            						pointStrokeColor: colorAleatorio(),
			            					pointHighlightFill: colorAleatorio(),
            								pointHighlightStroke: colorAleatorio(),					
									data:cantidadGraficada,
								}
							]
						};
					}
						
					
					var myRadarChart = new Chart(ctx).Radar(radarInformacion,{responsive:false});

				}else if(tipoGrafica == 4){

				var polarInfo  = []
				
				for(var i=0; i<(cantidad-1); i++){
					polarInfo.push(
						{
						        value: cantidadGraficada[i],
							color:colorAleatorio(),
						        highlight:colorAleatorio(),
						        label: labelGraficada[i]
						}
					);
				}

				var polarInformacion = polarInfo;
					
				new Chart(ctx).PolarArea(polarInformacion,{responsive:false});

				}else if(tipoGrafica == 5){

				pieInfo = [];

				for(var i=0; i<(cantidad-1); i++){
					pieInfo.push(
						{
						        value: cantidadGraficada[i],
							color:colorAleatorio(),
						        highlight:colorAleatorio(),
						        label: labelGraficada[i]
						}
					);
				}

				var pieInformacion = pieInfo;
					
				var myPieChart = new Chart(ctx).Pie(pieInformacion,{responsive:false});
		
				}else if(tipoGrafica == 6){
				
				var donaInfo = []

					for(var i=0; i<(cantidad-1); i++){
					donaInfo.push(
						{
						        value: cantidadGraficada[i],
							color:colorAleatorio(),
						        highlight: colorAleatorio(),
						        label: labelGraficada[i]
						}
					);
				}

				var donaInformacion = donaInfo;
					
				var myDoughnutChart = new Chart(ctx).Doughnut(donaInformacion,{responsive:false});

				}	
			}			
			},
			error: function(){
				mostrarMensajeError("Ocurrió un error inesperado, intente de nuevo más tarde 2");
			}
		});
}

function mostrarMensajeError(mensaje){
	$('#panel-messages').attr('style','vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder; opacity: 500; display: block;');
	$('#panel-messages').html('<div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">'+mensaje+'</div>');
	setTimeout(function(){
		$('#panel-messages').toggle();
	},3000);
}
</script>
@stop
