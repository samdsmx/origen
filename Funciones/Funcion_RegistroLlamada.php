<?
if ($Sesion){
	include("Datos_Comunicacion.php");
	if($medio<>"" and $medio<>"-"){
		if($medio2<>"" and $medio2<>"-")
			$ComoTeEnteraste = $medio2 . ": ". $OtrosEnteraste;
			else
				$ComoTeEnteraste = $medio . ": ". $OtrosEnteraste;
		}
	if($Voluntario){
		if($CanaOtro)
			$CanaOtro=$CanaOtro." (Voluntario)";
		if($CanaLegal)
			$CanaLegal=$CanaLegal." (Voluntario)";
		}
	if($submit=="Modificar"){
		if($Accion=="ModificaVarias"){
			$sql = "UPDATE casos SET ";
			$cuenta=0;
			if ($Nombre <> ""){
				$sql=$sql."Nombre='".rs($Nombre)."'";
				$cuenta=$cuenta+1;
				}
			if ($Edad <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Edad='".rs($Edad)."'";
				$cuenta=$cuenta+1;
				}
			if ($Sexo <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Sexo='".rs($Sexo)."'";
				$cuenta=$cuenta+1;
				}
			if ($EstadoCivil <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."EstadoCivil='".rs($EstadoCivil)."'";
				$cuenta=$cuenta+1;
				}
			if ($Telefono <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Telefono='".rs($Telefono)."'";
				$cuenta=$cuenta+1;
				}
			if ($Municipio <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Municipio='".rs($Municipio)."'";
				$cuenta=$cuenta+1;
				}
			if ($Estado <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Estado='".rs($Estado)."'";
				$cuenta=$cuenta+1;
				}
			if ($Ocupacion <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Ocupacion='".rs($Ocupacion)."' '".rs($Ocupacion2)."'";
				$sql = trim ($sql);
				$cuenta=$cuenta+1;
				}
			if ($Religion <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Religion='".rs($Religion)."'";
				$cuenta=$cuenta+1;
				}
			if ($VivesCon <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."VivesCon='".rs($VivesCon)."'";
				$cuenta=$cuenta+1;
				}
			if ($ComoTeEnteraste <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."ComoTeEnteraste='".rs($ComoTeEnteraste)."'";
				$cuenta=$cuenta+1;
				}
			if ($TipoCaso <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."TipoCaso='".rs($TipoCaso)."'";
				$cuenta=$cuenta+1;
				}
			if ($NivelViolencia <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."NivelViolencia='".rs($NivelViolencia)."'";
				$cuenta=$cuenta+1;
				}
			if ($PosibleSolucion <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."PosibleSolucion='".rs($PosibleSolucion)."'";
				$cuenta=$cuenta+1;
				}
			if ($Estatus <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Estatus='".rs($Estatus)."'";
				$cuenta=$cuenta+1;
				}
			if ($NivelEstudios <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."NivelEstudios='".rs($NivelEstudios)."'";
				$cuenta=$cuenta+1;
				}
			if ($LenguaIndigena <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."LenguaIndigena='".rs($LenguaIndigena)."'";
				$cuenta=$cuenta+1;
				}
			if ($CP <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."CP='".rs($CP)."'";
				$cuenta=$cuenta+1;
				}
			if ($Colonia <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Colonia='".rs($Colonia)."'";
				$cuenta=$cuenta+1;
				}
			if ($CorreoElectronico <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."CorreoElectronico='".rs($CorreoElectronico)."'";
				$cuenta=$cuenta+1;
				}
			if ($MedioContacto <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."MedioContacto='".rs($MedioContacto)."'";
				$cuenta=$cuenta+1;
				}
			$ids=explode(",",$seleccion);
			$sql=$sql." where ";
			$NumElementos = count($ids);
			$union = "";
			for ($i=0; $i<$NumElementos; $i++ ){
				$ini=strpos($ids[$i],'[')+1;
				$fin=strpos($ids[$i],']');
				$sql=$sql.$union."IDCaso =".substr($ids[$i],$ini,$fin-$ini);
				$union=" OR ";
				}
			if ($cuenta>0){
				$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());			
				}
			$sql = "UPDATE llamadas SET ";
			$cuenta=0;
			if ($ComentariosAdicionales <> ""){
				$sql=$sql."ComentariosAdicionales='".rs($ComentariosAdicionales)."'";
				$cuenta=$cuenta+1;
				}
			if ($AyudaPsicologico <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."AyudaPsicologico='".rs($AYUDAPSICOLOGICO)."'";
				$cuenta=$cuenta+1;
				}
			if ($AyudaLegal <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."AyudaLegal='".rs($AYUDALEGAL)."'";
				$cuenta=$cuenta+1;
				}
			if ($AyudaOtros <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."AyudaOtros='".rs($AYUDAOTROS)."'";
				$cuenta=$cuenta+1;
				}
			if ($TipoViolencia <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."TipoViolencia='".rs($TipoViolencia)."'";
				$cuenta=$cuenta+1;
				}
			if ($ModalidadViolencia <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."ModalidadViolencia='".rs($ModalidadViolencia)."'";
				$cuenta=$cuenta+1;
				}
			if ($Violentometro <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."Violentometro='".rs($Violentometro)."'";
				$cuenta=$cuenta+1;
				}
			if ($DesarrolloCaso <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."DesarrolloCaso='".rs($DesarrolloCaso)."'";
				$cuenta=$cuenta+1;
				}
			if ($CanaLegal <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."CanaLegal='".rs($CanaLegal)."'";
				$cuenta=$cuenta+1;
				}
			if ($CanaOtro <> ""){
				if ($cuenta>0)
					$sql=$sql.",";
				$sql=$sql."CanaOtro='".rs($CanaOtro)."'";
				$cuenta=$cuenta+1;
				}
			$sql=$sql." where ";
			$union = "";
			for ($i=0; $i<$NumElementos; $i++ ){
				$ini=strpos($ids[$i],'[')+1;
				$fin=strpos($ids[$i],']');
				$sql=$sql.$union."(IDCaso = ".rs(substr($ids[$i],$ini,$fin-$ini));
				$ini=strpos($ids[$i],'[',$ini)+1;
				$fin=strpos($ids[$i],']',$ini);
				$sql=$sql." and LlamadaNo = ".rs(substr($ids[$i],$ini,$fin-$ini)).")";
				$union=" OR ";
				}
			if ($cuenta>0){
				$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				}
			}
			else{			
				$sql = "UPDATE casos SET Nombre='".rs($Nombre)."',Edad='".rs($Edad)."',Sexo='".rs($Sexo)."',EstadoCivil='".rs($EstadoCivil)."',Telefono='".rs($Telefono)."',Municipio='".rs($Municipio)."',Estado='".rs($Estado)."',Ocupacion='".rs($Ocupacion)."' '".rs($Ocupacion2)."',Religion='".rs($Religion)."',VivesCon='".rs($VivesCon)."',ComoTeEnteraste='".rs($ComoTeEnteraste)."',TipoCaso='".rs($TipoCaso)."',NivelViolencia='".rs($NivelViolencia)."',PosibleSolucion='".rs($PosibleSolucion)."',Estatus='".rs($Estatus)."',HorasInvertidas='".rs($HorasInvertidas)."',NivelEstudios='".rs($NivelEstudios)."',LenguaIndigena='".rs($LenguaIndigena)."',CP='".rs($CP)."',Colonia='".rs($Colonia)."',CorreoElectronico='".rs($CorreoElectronico)."',MedioContacto='".rs($MedioContacto)."' where IDCaso='".rs($IDCaso)."'";
				$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				$sql = "UPDATE llamadas SET ComentariosAdicionales='".rs($ComentariosAdicionales)."',AyudaPsicologico='".rs($AYUDAPSICOLOGICO)."',AyudaLegal='".rs($AYUDALEGAL)."',AyudaOtros='".rs($AYUDAOTROS)."',TipoViolencia='".rs($TipoViolencia)."',ModalidadViolencia='".rs($ModalidadViolencia)."',Violentometro='".rs($Violentometro)."',DesarrolloCaso='".rs($DesarrolloCaso)."',CanaLegal='".rs($CanaLegal)."',CanaOtro='".rs($CanaOtro)."' where IDCaso='".rs($IDCaso)."' and LlamadaNo='".rs($LlamadaNo)."'";
				$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				}
		}
		else{
			if(!$IDCaso){
				$HorasInvertidas=0;
				if ($Edad == ""){
					$Edad = 0;
			     	}
				$sql = "INSERT INTO casos (Nombre,Edad,Sexo,EstadoCivil,Telefono,Municipio,Estado,Ocupacion,Religion,VivesCon,ComoTeEnteraste,TipoCaso,PosibleSolucion,Estatus,HorasInvertidas,NivelEstudios,LenguaIndigena,CP,Colonia,CorreoElectronico,MedioContacto,NivelViolencia) VALUES ('".rs($Nombre)."','".rs($Edad)."','".rs($Sexo)."','".rs($EstadoCivil)."','".rs($Telefono)."','".rs($Municipio)."','".rs($Estado)."','".rs($Ocupacion)."' '".rs($Ocupacion2)."','".rs($Religion)."','".rs($VivesCon)."','".rs($ComoTeEnteraste)."','".rs($TipoCaso)."','".rs($PosibleSolucion)."','".rs($Estatus)."','".rs($HorasInvertidas)."','".rs($NivelEstudios)."','".rs($LenguaIndigena)."','".rs($CP)."','".rs($Colonia)."','".rs($CorreoElectronico)."','".rs($MedioContacto)."', '".rs($NivelViolencia)."')";
				$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				$sql = "SELECT MAX(IDCaso) IDCaso from Casos";
				$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				$row = mysql_fetch_array($result);
			        $IDCaso=$row['IDCaso'];
				}
			$sql = "UPDATE casos SET TipoCaso='".rs($TipoCaso)."',NivelViolencia='".rs($NivelViolencia)."',PosibleSolucion='".rs($PosibleSolucion)."',Estatus='".rs($Estatus)."',HorasInvertidas='".rs($HorasInvertidas)."' where IDCaso='".rs($IDCaso)."'";
			$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			$sql = "INSERT INTO Llamadas
			(IDCaso,FechaLlamada,Consejera,HoraInicio,HoraTermino,ComentariosAdicionales,AyudaPsicologico,AyudaLegal,AyudaOtros,DesarrolloCaso,CanaLegal,CanaOtro,LlamadaNo,Duracion,Acceso,TipoViolencia,ModalidadViolencia,Violentometro)
			VALUES
			('".rs($IDCaso)."','".rs($FechaLlamada)."','".rs($Consejera)."','".rs($HoraInicio)."','".rs($HoraTermino)."','".rs($ComentariosAdicionales)."','".rs($AYUDAPSICOLOGICO)."','".rs($AYUDALEGAL)."','".rs($AYUDAOTROS)."','".rs($DesarrolloCaso)."','".rs($CanaLegal)."', '".rs($CanaOtro)."','".rs($LlamadaNo)."', '".rs($Duracion)."', '".rs($Acceso)."', '".rs($TipoViolencia)."', '".rs($ModalidadViolencia)."', '".rs($Violentometro)."')";
			$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			}
	$sql="UPDATE llamadas SET Duracion=((time_to_sec('".rs($HoraTermino)."')-time_to_sec('".rs($HoraInicio)."'))/60) where IDCaso='".rs($IDCaso)."' and LlamadaNo='".rs($LlamadaNo)."'";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$sql="UPDATE llamadas Set Duracion=(((time_to_sec('".rs($HoraTermino)."')-time_to_sec('00:00:00'))+(time_to_sec('23:59:59')-time_to_sec('".rs($HoraInicio)."')))/60) where IDCaso='".rs($IDCaso)."' and LlamadaNo='".rs($LlamadaNo)."' and duracion < 0";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$sql="UPDATE llamadas Set Duracion=1 where IDCaso='".rs($IDCaso)."' and LlamadaNo='".rs($LlamadaNo)."' and duracion = 0";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	BorraCache();
	header("Refresh: 1; URL=Funciones/close_window_script.php");
	$Mensaje="Listo! Caso registrado.";
	include("Paginas/Mensajes.html");
	mysql_close($connection);
	}
	else{
		header("Refresh: 0; URL= ");
		}
?>
