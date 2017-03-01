<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
	<style>
	    .titulo{
		    background-color: #1974A9;
		    text-align: left;
		    color: #FFFFFF;
	    }
	    .seccion{
		    background-color: #A4A4A4; 
		    text-align: center; 
		    color: #FFFFFF;
	    }
	    #footer {
		    bottom: 0;
		    border-top: 0.1pt solid #aaa;
	    }
	    #footer {
		    position: fixed;
		    left: 0;
		    right: 0;
		    color: #aaa;
		    font-size: 0.9em;
	    }
	    .page-number {
		    text-align: center;
	    }

	    .page-number:before {
		    content: counter(page);
	    }
	</style>
    </head>
    <body>
	<p><img src="{{asset('images/logo_sep.png')}}" alt="LOGO SEP" > <img src="{{asset('images/logo_ipn.png')}}" alt="LOGO IPN" style="margin-left:20%;"></p>
	<p> 
	    <span style="text-align:left;" >{{fechaLarga($fecha["year"].'-'.$fecha["mon"].'-'.$fecha["mday"])}} </span>
	    <span style="margin-left: 40%;">Periodo del {{fechaLarga($periodo[0]->fecha_inicio).' al '.fechaLarga($periodo[0]->fecha_fin)}}</span>
	</p>

	<p style="text-align:center;">
	    <b>SISTEMA:</b> {{$propiedadesRes[4]->valor}}
	</p>
	<p style="text-align:center;"><b>EN FASE:</b> {{$sistema[0]->fase}} <b>Y ESTATUS:</b> {{$sistema[0]->observacion}}</p>
	<div id="footer">
	    <div class="page-number"></div>
	</div>
	<table style="margin-top:5%; margin-bottom: 10%;">
	    <tr class="titulo">
		<td>ID</td>
		<td>PROPIEDAD</td>
		<td>RESPUESTA</td>
	    </tr>
	    <?php
	    $z = 1;
	    $grupoTem = "";
	    ?>
	    @foreach($propiedadesRes as $pro)
	    @if($grupoTem != $pro->grupo)
	    {{$grupoTem = $pro->grupo}}
	    <tr class="seccion"> 
		<td colspan="3">{{$pro->grupo}}</td>
	    </tr>
	    @endif
	    <tr style="padding-top:10%;">
		<td>{{$z}}</td>
		<td style="width:40%;">{{$pro->descripcion}}</td>
		<td style="width:40%;">{{$pro->valor}}</td>
	    </tr>
	    <?php
	    $z++;
	    ?>
	    @endforeach
	</table>
	<p style="text-align:center;"><b>Usuario solicitante:</b> {{$autor->persona->primer_apellido.' '.$autor->persona->segundo_apellido.' '.$autor->persona->nombres}}</p>
    </body>
</html>