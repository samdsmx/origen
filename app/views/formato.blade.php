<head>
    <meta charset="utf-8">
</head>
<table>
    <tr style="background-color: #1974A9; text-align: center;  color: #FFFFFF;">
	<td>ID</td>
	<td>PROPIEDAD</td>
	<td>RESPUESTA</td>
    </tr>
    <?php
    $z = 1;
    ?>
    @foreach($propiedadesRes as $pro)
    <tr>
	<td style="text-align: left;">{{$z}}</td>
	<td style="width:50px; text-align: left;">{{$pro->propiedad}}</td>
	<td style="width:50px; text-align: left;" >{{$pro->respuesta}}</td>
    </tr>
    <tr>
	<td></td>
	<td></td>
	<td></td>
    </tr>
    <?php
    $z++;
    ?>
    @endforeach
</table>