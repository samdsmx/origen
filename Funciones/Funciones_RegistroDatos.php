<?
	if($submit<>"Modificar"){
		$HoraTermino=date("h:i A");
		$Consejera=strtoupper($Consejera);
		}
	if (!$Nombre&&$Accion<>"ModificaVarias"){
		$Nombre="Anonimo";
	}
	list($DD, $MM, $AAAA) = split ('/', $FechaLlamada);
	if (!isset($Acceso))$Acceso=0;
	if (!isset($Duracion))$Duracion=0;
	$HoraInicio=date("H:i:s",strtotime($HoraInicio));
	$HoraTermino=date("H:i:s",strtotime($HoraTermino));
	$FechaLlamada="$AAAA-$MM-$DD";
	$Nombre=strtoupper($Nombre);
	$AYUDAPSICOLOGICO=implode(",",$AYUDAPSICOLOGICO);
	$AYUDALEGAL=implode(",",$AYUDALEGAL);
	$AYUDAMEDICA=implode(",",$AYUDAMEDICA);
	$AYUDANUTRICIONAL=implode(",",$AYUDANUTRICIONAL);
	$AYUDAOTROS=implode(",",$AYUDAOTROS);
	$TipoViolencia=implode(",",$TipoViolencia);
	$ModalidadViolencia=implode(",",$ModalidadViolencia);
	$Violentometro=implode(",",$Violentometro);
	include("Funciones/Funcion_RegistroLlamada.php");
?>