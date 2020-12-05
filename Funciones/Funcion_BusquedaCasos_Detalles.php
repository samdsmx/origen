<?
if ($Sesion){
	include("Datos_Comunicacion.php");
	$sql ="SELECT c.*,l.*, GROUP_CONCAT(CONCAT(f.Tipo,': ',f.Nombre)) as 'MotivosBienestar' FROM casos c, llamadas l LEFT JOIN llamadasBienestar b ON b.IdLlamada=l.id LEFT JOIN campos f ON b.IdCampo = f.IDCampo WHERE c.IDCaso = l.IDCaso AND c.IDCaso = '".rs($IDCaso)."' AND l.LlamadaNo='".rs($LlamadaNo)."' GROUP BY l.id";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	if ($row = mysql_fetch_assoc($result)){
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
		$MotivosBienestar=$row['MotivosBienestar'];
		$AyudaPsicologico = str_replace(',', "<BR>",$AyudaPsicologico);
		$AyudaLegal = str_replace(',', "<BR>",$AyudaLegal);
		$AyudaMedica = str_replace(',', "<BR>",$AyudaMedica);
		$AyudaNutricional = str_replace(',', "<BR>",$AyudaNutricional);
		$AyudaOtros = str_replace(',', "<BR>",$AyudaOtros);
		$TipoViolencia = str_replace(',', "<BR>",$TipoViolencia);
		$ModalidadViolencia = str_replace(',', "<BR>",$ModalidadViolencia);
		$Violentometro = str_replace(',', "<BR>",$Violentometro);
		$MotivosBienestar = str_replace(',', "<BR>",$MotivosBienestar);

		if ($Accion == "Modifica"){
			include("Paginas/CodigoMenuSinOpciones.html");
			include("Paginas/ModificaLlamada.html");
		} else {
			include("Paginas/BuscaCasos_Detalles.html");
		}
	} else {
		$Mensaje="No se encontro archivado un caso con esa identificacion.";
		include("Paginas/Error.html");
	}
	mysql_close($connection);	
} else {
	header("Refresh: 0; URL= ");
}
?>
