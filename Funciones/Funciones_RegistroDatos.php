<?
	include("Funciones/Funciones_RevisionArreglo.php");
	if($submit<>"Modificar"){
		$HoraTermino=date("h:i A");
		$Consejera=strtoupper($Consejera);
		}
	if (!$Nombre&&$Accion<>"ModificaVarias")
		$Nombre="Anonimo";
	list($DD, $MM, $AAAA) = split ('/', $FechaLlamada);
	if (!isset($Acceso))$Acceso=0;
	if (!isset($Duracion))$Duracion=0;
	$HoraInicio=date("H:i:s",strtotime($HoraInicio));
	$HoraTermino=date("H:i:s",strtotime($HoraTermino));
	$FechaLlamada="$AAAA-$MM-$DD";
	$Nombre=strtoupper($Nombre);
	$AYUDAPSICOLOGICO=METEELEMENTOS($AYUDAPSICOLOGICO);
	$AYUDALEGAL=METEELEMENTOS($AYUDALEGAL);
	$AYUDAMEDICA=METEELEMENTOS($AYUDAMEDICA);
	$AYUDANUTRICIONAL=METEELEMENTOS($AYUDANUTRICIONAL);
	$AYUDAOTROS=METEELEMENTOS($AYUDAOTROS);
	$TipoViolencia=METEELEMENTOS($TipoViolencia);
	$ModalidadViolencia=METEELEMENTOS($ModalidadViolencia);
	$NivelViolencia=METEELEMENTOS($NivelViolencia);
	include("Funciones/Funcion_RegistroLlamada.php");
?>