<?
if ($Sesion){
	include("Funciones_RevisionArreglo.php");
	include("Datos_Comunicacion.php");
	$sql ="SELECT c.*,l.* FROM Llamadas l, Casos c WHERE c.IDCaso = l.IDCaso AND c.IDCaso = '".rs($IDCaso)."' AND l.LlamadaNo='".rs($LlamadaNo)."'";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	while ($row = mysql_fetch_array($result)){
		$ID=$row['IDCaso'];
		$FechaLlamada=$row['FechaLlamada'];
		$Consejera=$row['Consejera'];
		$HoraInicio=$row['Horainicio'];
		$HoraTermino=$row['Horatermino'];
		$ComentariosAdicionales=$row['ComentariosAdicionales'];
		$Nombre=$row['Nombre'];
		$Edad=$row['Edad'];
		$Sexo=$row['Sexo'];
		$EstadoCivil=$row['EstadoCivil'];
		$Telefono=$row['Telefono'];
		$Municipio=$row['Municipio'];
		$Estado=$row['Estado'];
		$CP=$row['CP'];
		$MedioContacto=$row['MedioContacto'];
		$NivelEstudios=$row['NivelEstudios'];
		$LenguaIndigena=$row['LenguaIndigena'];
		$CorreoElectronico=$row['CorreoElectronico'];
		$Colonia=$row['Colonia'];
		$Pais=$row['Pais'];
		$Ocupacion=$row['Ocupacion'];
		$Religion=$row['Religion'];
		$VivesCon=$row['VivesCon'];
		$AyudaPsicologico=$row['AyudaPsicologico'];
		$AyudaLegal=$row['AyudaLegal'];
		$AyudaMedica=$row['AyudaMedica'];
		$AyudaNutricional=$row['AyudaNutricional'];
		$AyudaOtros=$row['AyudaOtros'];
		$TipoViolencia=$row['TipoViolencia'];
		$ModalidadViolencia=$row['ModalidadViolencia'];
		$NivelViolencia=$row['NivelViolencia'];
		$Nacionalidad=$row['Nacionalidad'];		
		$Violentometro=$row['Violentometro'];		
		$DesarrolloCaso=$row['DesarrolloCaso'];
		$ComoTeEnteraste=$row['ComoTeEnteraste'];
		$CanaLegal=$row['CanaLegal'];
		$CanaOtro=$row['CanaOtro'];
		$AcudeInstitucion=$row['AcudeInstitucion'];
		$LlamadaNo=$row['LlamadaNo'];
		$Duracion=$row['Duracion'];
		$TipoCaso=$row['TipoCaso'];
		$PosibleSolucion=$row['PosibleSolucion'];
		$Estatus=$row['Estatus'];
		$HorasInvertidas=$row['HorasInvertidas'];
		}
	$num = @mysql_num_rows($result);
	if ($num != 0){
		$AyudaPsicologico = SacaElementos($AyudaPsicologico);
		$AyudaLegal = SacaElementos($AyudaLegal);
		$AyudaMedica = SacaElementos($AyudaMedica);
		$AyudaNutricional = SacaElementos($AyudaNutricional);
		$AyudaOtros = SacaElementos($AyudaOtros);
		$TipoViolencia = SacaElementos($TipoViolencia);
		$ModalidadViolencia = SacaElementos($ModalidadViolencia);
		$Violentometro = SacaElementos($Violentometro);
		$Marcador='<FONT SIZE="1" FACE="Arial" COLOR="#000000"><B><U>X</U>_</B></FONT>';
		include("Paginas/BuscaCasos_Detalles.html");
		}
		else{
			$Mensaje="No se encontro archivado un caso con esa identificacion.";
			include("Paginas/Error.html");
			}
	mysql_close($connection);	
	}
	else{
		header("Refresh: 0; URL= ");
		}
?>