<?

if ($Sesion){
	include("Datos_Comunicacion.php");

	$MesL[1]="Enero";
	$MesL[2]="Febrero";
	$MesL[3]="Marzo";
	$MesL[4]="Abril";
	$MesL[5]="Mayo";
	$MesL[6]="Junio";
	$MesL[7]="Julio";
	$MesL[8]="Agosto";
	$MesL[9]="Septiembre";
	$MesL[10]="Octubre";
	$MesL[11]="Noviembre";
	$MesL[12]="Diciembre";

	function CuentaEsto($CadBusc){
		if($CadBusc){
			$CadBusc ="where $CadBusc";
			}
		$sql ="select * from reporte $CadBusc";
		$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
		$Total=@mysql_num_rows($total_result);
		return $Total;
		}

	function CuentaAyuda($Tipo){
		$sql ="SELECT Nombre FROM campos WHERE tipo='$Tipo'";
		$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
		$t=0;
		$u=0;
		while ($row = mysql_fetch_assoc($total_result)){
			$Ayuda=$row['Nombre'];		
			$sql2 ="Select c.Nombre, COUNT(*) 'llamadas', COUNT(Distinct(l.idcaso)) 'Usuarios' FROM reporte l, campos c WHERE c.Nombre='$Ayuda' AND c.Tipo='$Tipo' AND l.$Tipo LIKE \"%$Ayuda%\" Group By c.Nombre ORDER BY llamadas DESC";
			$total_result2 = @mysql_query($sql2, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
			while ($row2 = mysql_fetch_assoc($total_result2)){
				$Ayuda2=$row2['Nombre'];
				$CantAyu=$row2['llamadas'];
				$Usu=$row2['Usuarios'];
				$u=$u+$Usu;
				$t=$t+$CantAyu;		
				}
			}
		$v=array('l' => $t, 'u' => $u);
		return $v;
		}

	function MuestraTiposBienestar(){ //Esto podria servir para mostrar todas las ayudas y no por separado.
		$Programa='Bienestar';
		$sql ="SELECT Tipo FROM campos WHERE Programa='$Programa' Group by Tipo";
		$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
		$Seguimientos="<TR><TH></TH><TH>Llamadas</TH><TH>Usuarios</TH><TR>";
		while ($row = mysql_fetch_assoc($total_result)){
			$Tipo=$row['Tipo'];
			$sql2 ="SELECT '$Tipo' as t, COUNT(*) 'llamadas', COUNT(Distinct(l.idcaso)) 'Usuarios' FROM reporte l WHERE l.MotivosBienestar LIKE \"%$Tipo:%\" Group By t";
			$total_result2 = @mysql_query($sql2, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
			if ($row2 = mysql_fetch_assoc($total_result2)){
				$CantAyu=$row2['llamadas'];
				$Usu=$row2['Usuarios'];
				$data .= $Tipo.",";
				$datag .= $CantAyu.",";
				$Seguimientos .= "<TR><TD>$Tipo</TD><TD>$CantAyu</TD><TD>$Usu</TD><TR>";
			}
		}
		$data = trim($data, ",");
		$datag = trim($datag, ",");
		$Seguimientos .= "<TR><TD COLSPAN=13><CENTER>";
		$Seguimientos .= '<img src="Funciones/grafico_bar.php?Nom='.$Tipo.'&datax='.$data.'&datagx='.$datag.'">';
		$Seguimientos .= "</CENTER></TD></TR>";
		return $Seguimientos;
	}

	function MuestraMotivosBienestar(){
		$Programa='Bienestar';
		$sql ="SELECT Nombre FROM campos WHERE Programa='$Programa'";
		$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
		$Seguimientos="<TR><TH></TH><TH>Llamadas</TH><TH>Usuarios</TH><TR>";
		while ($row = mysql_fetch_assoc($total_result)){
			$Tipo=$row['Nombre'];
			$sql2 ="SELECT '$Tipo' as t, COUNT(*) 'llamadas', COUNT(Distinct(l.idcaso)) 'Usuarios' FROM reporte l WHERE l.MotivosBienestar LIKE \"%: $Tipo%\" Group By t";
			$total_result2 = @mysql_query($sql2, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
			if ($row2 = mysql_fetch_assoc($total_result2)){
				$CantAyu=$row2['llamadas'];
				$Usu=$row2['Usuarios'];
				$data .= $Tipo.",";
				$datag .= $CantAyu.",";
				$Seguimientos .= "<TR><TD>$Tipo</TD><TD>$CantAyu</TD><TD>$Usu</TD><TR>";
			}
		}
		$data = trim($data, ",");
		$datag = trim($datag, ",");
		$Seguimientos .= "<TR><TD COLSPAN=13><CENTER>";
		$Seguimientos .= '<img src="Funciones/grafico_bar.php?Nom='.$Tipo.'&datax='.$data.'&datagx='.$datag.'">';
		$Seguimientos .= "</CENTER></TD></TR>";
		return $Seguimientos;
	}

	function MuestraAyuda($Tipo){
		$sql ="SELECT Nombre FROM campos WHERE tipo='$Tipo'";
		$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
		$Seguimientos="<TR><TH></TH><TH>Llamadas</TH><TH>Usuarios</TH><TR>";
		while ($row = mysql_fetch_assoc($total_result)){
			$Ayuda=$row['Nombre'];
			$sql2 ="SELECT '$Ayuda' as t, COUNT(*) 'llamadas', COUNT(Distinct(l.idcaso)) 'Usuarios' FROM reporte l WHERE l.$Tipo LIKE \"%$Ayuda%\" Group By t";	
			$total_result2 = @mysql_query($sql2, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
			if ($row2 = mysql_fetch_assoc($total_result2)){
				$CantAyu=$row2['llamadas'];
				$Usu=$row2['Usuarios'];
				$data .= $Ayuda.",";
				$datag .= $CantAyu.",";
				$Seguimientos .= "<TR><TD>$Ayuda</TD><TD>$CantAyu</TD><TD>$Usu</TD><TR>";
			}
		}
		$data = trim($data, ",");
		$datag = trim($datag, ",");
		$Seguimientos .= "<TR><TD COLSPAN=13><CENTER>";
		$Seguimientos .= '<img src="Funciones/grafico_bar.php?Nom='.$Tipo.'&datax='.$data.'&datagx='.$datag.'">';
		$Seguimientos .= "</CENTER></TD></TR>";
		return $Seguimientos;
	}

	function Muestra($Tipo,$Clausula="",$Order="llamadas DESC",$Other=""){ 
		$sql ="SELECT $Tipo, COUNT(*) 'llamadas', COUNT(Distinct(idcaso)) 'Usuarios' FROM reporte WHERE $Clausula 1=1 GROUP BY $Tipo ORDER BY $Order $Other";
		$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
		$Seguimientos="<TR><TH></TH><TH>Llamadas</TH><TH>Usuarios</TH></TR>";
		$i=0;
		$Total=@mysql_num_rows($total_result);
	 	while ($row = mysql_fetch_assoc($total_result)){
			$Nombre=$row[$Tipo];
			$Llam=$row['llamadas'];
			$Usu=$row['Usuarios'];
			$i=$i+1;
			if($i<20)
				if($i<19&&$i<$Total){
					$data .= $Nombre.",";
					$datag .= $Llam.",";
					}
					else{
						$data .= $Nombre;
						$datag .= $Llam;
						}
       		$Seguimientos .= "<TR><TD>$Nombre</TD><TD>$Llam</TD><TD>$Usu</TD></TR>";
			}

			$Seguimientos .= "<TR><TD COLSPAN=13><CENTER>";
			$Seguimientos .= '<img src="Funciones/grafico_bar.php?Nom='.$Tipo.'&datax='.$data.'&datagx='.$datag.'">';
			$Seguimientos .= "</CENTER></TD></TR>";
		return $Seguimientos;
		}

	$criterio="";
	$CadBusqueda2="";
	$CadBusqueda="";
	if ($Ano <> "-"){
		$CadBusqueda2 .="AND Year(l.FechaLlamada)>='$Ano' AND Year(l.FechaLlamada)<='$Ano2' ";
		$criterio.="A&ntilde;o	>= $Ano y A&ntilde;o <= $Ano2<BR>";
		}
	if ($Mes <> "-"){
		$CadBusqueda2 .="AND Month(l.FechaLlamada)>='$Mes' AND Month(l.FechaLlamada)<='$Mes2' ";
		$criterio.="Mes	>= $Mes y Mes<= $Mes2<BR>";			
		}
	if ($Dias <> "-"){
		$CadBusqueda2 .="AND DayOfMonth(l.FechaLlamada)>='$Dias' AND DayOfMonth(l.FechaLlamada)<='$Dias2' ";
		$criterio.="Dia	>= $Dias y Dia <= $Dias2<BR>";			
		}
	if ($Horas <> "-"){
		$CadBusqueda2 .="AND Hour(l.HoraInicio)>='$Horas' AND Hour(l.HoraTermino)<='$Horas2' ";
		$criterio.="Hora >= $Horas y Hora<= $Horas2<BR>";			
		}
	if ($Duracion <> "-"){
		$CadBusqueda .= "AND ((time_to_sec(l.Horatermino)-time_to_sec(l.Horainicio))/60)>='$Duracion' AND ((time_to_sec(l.Horatermino)-time_to_sec(l.Horainicio))/60)<='$Duracion2' ";
		$criterio.="Duracion >= $Duracion y Duracion<= $Duracion2<BR>";			
		}
	if ($Edad <> "-"){
		$CadBusqueda .="AND c.Edad >= \"$Edad\" AND c.Edad <= \"$Edad2\" ";
		$criterio.="Edad >= $Edad y Edad<= $Edad2<BR>";			
		}
	preparaQuery($Consejera, "Consejera", &$CadBusqueda, &$criterio, false);
	preparaQuery($ComoTeEnteraste, "ComoTeEnteraste", &$CadBusqueda, &$criterio, true, "c");
	preparaQuery($Sexo, "Sexo", &$CadBusqueda, &$criterio, false, "c");
	preparaQuery($LenguaIndigena, "LenguaIndigena", &$CadBusqueda, &$criterio, false, "c");			
	preparaQuery($MedioContacto, "MedioContacto", &$CadBusqueda, &$criterio, false, "c");			
	preparaQuery($Ocupacion, "Ocupacion", &$CadBusqueda, &$criterio, false, "c");
	preparaQuery($Municipio, "Municipio", &$CadBusqueda, &$criterio, false, "c");				
	preparaQuery($Estado, "Estado", &$CadBusqueda, &$criterio, false, "c");
	preparaQuery($EstadoCivil, "EstadoCivil", &$CadBusqueda, &$criterio, false, "c");
	preparaQuery($NivelEstudios, "NivelEstudios", &$CadBusqueda, &$criterio, false, "c");
	preparaQuery($AyudaPsicologico, "AyudaPsicologico", &$CadBusqueda, &$criterio);	
	preparaQuery($AyudaLegal, "AyudaLegal", &$CadBusqueda, &$criterio);
	preparaQuery($AyudaMedica, "AyudaMedica", &$CadBusqueda, &$criterio);
	preparaQuery($AyudaNutricional, "AyudaNutricional", &$CadBusqueda, &$criterio);	
	preparaQuery($MotivosBienestar, "Nombre", &$CadBusqueda, &$criterio, true, "f","MotivosBienestar");	
	preparaQuery($Dimension, "Nombre", &$CadBusqueda, &$criterio, true, "f","Dimension");	
	preparaQuery($AyudaOtros, "AyudaOtros", &$CadBusqueda, &$criterio);	
	preparaQuery($TipoViolencia, "TipoViolencia", &$CadBusqueda, &$criterio);	
	preparaQuery($ModalidadViolencia, "ModalidadViolencia", &$CadBusqueda, &$criterio);	
	preparaQuery($Violentometro, "Violentometro", &$CadBusqueda, &$criterio);	
	preparaQuery($NivelViolencia, "NivelViolencia", &$CadBusqueda, &$criterio);

	$sql ="Drop Table reporte";
	$total_result = @mysql_query($sql, $GLOBALS['connection']);
	$sql ="Create table reporte select GROUP_CONCAT(CONCAT(f.Tipo,': ',f.Nombre)) as 'MotivosBienestar', GROUP_CONCAT(CONCAT(f2.Tipo,': ',f2.Nombre)) as 'Dimension', l.*, c.Edad,c.Religion,c.NivelEstudios,c.Sexo,c.Municipio,c.EstadoCivil,c.LenguaIndigena,c.Estado,c.Ocupacion,c.ComoTeEnteraste,c.MedioContacto,c.CP,c.NivelViolencia,c.Nacionalidad from casos c, llamadas l LEFT JOIN llamadasBienestar b ON l.id=b.IdLlamada LEFT JOIN dimension d ON l.id=d.IdLlamada LEFT JOIN campos f ON b.IdCampo = f.IDCampo LEFT JOIN campos f2 ON d.IdCampo = f2.IDCampo where c.IDCaso=l.IDCaso $CadBusqueda2 $CadBusqueda group by l.id";
	$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
	
	//Totales
	$TotalLlamadasMes  = CuentaEsto("");
	$TotalCasos = CuentaEsto("LlamadaNo=1");
	$TotalPersonas = CuentaEsto("LlamadaNo>0 group by IDCaso");
	$TotalSeguimiento = CuentaEsto("LlamadaNo>1");

	$TotalCasosCana = CuentaEsto("CanaLegal <> \"\" or CanaOtro <> \"\"");

	$TotalCasosSeguimiento = CuentaEsto("LlamadaNo>1 group by IDCaso");

	$TotalCasossinCana = $TotalCasos-$TotalCasosCana;
	
	//CasosResueltos
	if($Mes>1){
		$MesP=$Mes-1;	
		$AnoP=$Ano;
		}
		else{
			$MesP=12;
			$AnoP=$Ano-1;
			}
	
	
	$sql ="SELECT DISTINCT l.IDCaso FROM llamadas l, casos c, llamadas l2 LEFT JOIN dimension d ON l2.id=d.IdLlamada LEFT JOIN llamadasBienestar b ON l2.id=b.IdLlamada LEFT JOIN campos f ON b.IdCampo = f.IDCampo LEFT JOIN campos f2 ON d.IdCampo = f2.IDCampo WHERE l.IDCaso=l2.IDCaso AND l.IDCaso=c.IDCaso AND Year(l.FechaLlamada)='$AnoP' AND Month(l.FechaLlamada)='$MesP' AND Year(l2.FechaLlamada)='$Ano' AND Month(l2.FechaLlamada)='$Mes' $CadBusqueda";
	$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
	$TotalNoResueltos=@mysql_num_rows($total_result);
	$sql ="SELECT DISTINCT l.IDCaso FROM casos c, llamadas l LEFT JOIN dimension d ON l.id=d.IdLlamada LEFT JOIN llamadasBienestar b ON l.id=b.IdLlamada LEFT JOIN campos f ON b.IdCampo = f.IDCampo LEFT JOIN campos f2 ON d.IdCampo = f2.IDCampo WHERE l.IDCaso=c.IDCaso AND Year(FechaLlamada)='$AnoP' AND Month(FechaLlamada)='$MesP' $CadBusqueda";
	$total_result = @mysql_query($sql, $GLOBALS['connection']) or die("Error #". mysql_errno() . ": " . mysql_error());
	$TotalMesAnterior=@mysql_num_rows($total_result);
	$TotalResueltos=$TotalMesAnterior-$TotalNoResueltos;

	//Duracion
	$De0a10=CuentaEsto("((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)<=10");
	$De10a20=CuentaEsto("((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)>10 AND ((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)<=20");
	$De20a30=CuentaEsto("((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)>20 AND ((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)<=30");
	$De30a45=CuentaEsto("((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)>30 AND ((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)<=45");
	$MasDe45=CuentaEsto("((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)>45");

	//Llamadas45
	$TotalMas45=Muestra("Consejera","((time_to_sec(Horatermino)-time_to_sec(Horainicio))/60)>45 AND ");

	//PorDia
	$PorDia=Muestra("FechaLlamada","","FechaLlamada DESC","LIMIT 31");

	//MedioContacto
	$MedioContacto=Muestra("MedioContacto");

	//Religion
	$TotalReligion=Muestra("Religion");

	//Edad
	$NoDada=CuentaEsto("Edad = '0'");
	$De1a12=CuentaEsto("Edad >='1' AND Edad <='12'");
	$De13a17=CuentaEsto("Edad >= '13' AND Edad <='17'");
	$De18a29=CuentaEsto("Edad >= '18' AND Edad <='29'");
	$De30a39=CuentaEsto("Edad >= '30' AND Edad <='39'");
	$De40a49=CuentaEsto("Edad >= '40' AND Edad <='49'");
	$De50a59=CuentaEsto("Edad >= '50' AND Edad <='59'");
	$De60a69=CuentaEsto("Edad >= '60' AND Edad <='69'");
	$MasDe70=CuentaEsto("Edad >= '70'");

	//Edad por Casos
	$CNoDada=CuentaEsto("LlamadaNo=1 AND Edad = '0'");
	$CDe1a12=CuentaEsto("LlamadaNo=1 AND Edad >='1' AND Edad <='12'");
	$CDe13a17=CuentaEsto("LlamadaNo=1 AND Edad >= '13' AND Edad <='17'");
	$CDe18a29=CuentaEsto("LlamadaNo=1 AND Edad >= '18' AND Edad <='29'");
	$CDe30a39=CuentaEsto("LlamadaNo=1 AND Edad >= '30' AND Edad <='39'");
	$CDe40a49=CuentaEsto("LlamadaNo=1 AND Edad >= '40' AND Edad <='49'");
	$CDe50a59=CuentaEsto("LlamadaNo=1 AND Edad >= '50' AND Edad <='59'");
	$CDe60a69=CuentaEsto("LlamadaNo=1 AND Edad >= '60' AND Edad <='69'");
	$CMasDe70=CuentaEsto("LlamadaNo=1 AND Edad >= '70'");

	//Genero
	$TotalGenero=Muestra("Sexo");

	//Ocupacion
	$TotalOcu=Muestra("Ocupacion"); // Muestra las llamadas con otros.. 

	//Estado Civil
	$TotalEstadoCivil=Muestra("EstadoCivil");

	//Nivel de estudios
	$TotalNivelEstudios=Muestra("NivelEstudios");

	//Lengua Indigena
	$TotalLenguaIndigena=Muestra("LenguaIndigena");
	
	//Nivel de Violencia
	$TotalNViol=Muestra("NivelViolencia","NivelViolencia <> '' AND ");

	//Nacionalidad
	$TotalNacionalidad=Muestra("Nacionalidad");

	//Acude Institucion
	$TotalAInst=Muestra("AcudeInstitucion","AcudeInstitucion <> '' AND ");

	//Informacion Prestada
	$psicologico=CuentaAyuda("AyudaPsicologico");
	$legal=CuentaAyuda("AyudaLegal");
	$medico=CuentaAyuda("AyudaMedica");
	$nutricional=CuentaAyuda("AyudaNutricional");
	$otros=CuentaAyuda("AyudaOtros");
	$dimension=CuentaAyuda("Dimension");

	$TotalEst=Muestra("Estado");
	$TotalDele=Muestra("Municipio","Municipio <> '' AND ","llamadas DESC","LIMIT 10");

	$TotalAyuP=MuestraAyuda("AyudaPsicologico");
	$TotalAyuL=MuestraAyuda("AyudaLegal");
	$TotalAyuM=MuestraAyuda("AyudaMedica");
	$TotalAyuN=MuestraAyuda("AyudaNutricional");
	$TotalAyuO=MuestraAyuda("AyudaOtros");
	$TotalTViol=MuestraAyuda("TipoViolencia");
	$TotalMViol=MuestraAyuda("ModalidadViolencia");
	$TotalViolentometro=MuestraAyuda("Violentometro");
	$TotalDimension=MuestraAyuda("Dimension");

	$TotalTipB=MuestraTiposBienestar();
	$TotalMotB=MuestraMotivosBienestar();
	
	$TotalCP=Muestra("CP","CP <> '' AND ","llamadas DESC","LIMIT 10");
	$TotalEnteraste=MuestraAyuda("ComoTeEnteraste");

	//Canalizacion
	$TotalCanaLegal=Muestra("CanaLegal","CanaLegal Not Like \"%Voluntario%\" And ","llamadas DESC","LIMIT 10");
	$TotalCanaLegalV=Muestra("CanaLegal","CanaLegal Like \"%Voluntario%\" And ","llamadas DESC","LIMIT 10");
	$TotalCanaOtro=Muestra("CanaOtro","CanaOtro Not Like \"%Voluntario%\" And ","llamadas DESC","LIMIT 10");
	$TotalCanaOtroV=Muestra("CanaOtro","CanaOtro Like \"%Voluntario%\" And ","llamadas DESC","LIMIT 10");

	include ("Paginas/BuscarCasos_Reporte.html");
	}
	else{
		header("Refresh: 0; URL= ");
		}
	
	mysql_close($GLOBALS['connection']);

?>