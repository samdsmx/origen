<?
if ($Sesion){
	include("Datos_Comunicacion.php");
	$tmp=substr(mysql_real_escape_string($Sesion),0,5);
	if ($Ano OR $IDCaso OR $Nombre OR $Telefono){
		$criterio="";
		$CadBusqueda2="";
		$CadBusqueda="";
		$SecureCad=base64_decode($Sesion);
		list($Nombre_Consejera, $Password)= split("@", $SecureCad);
		$sql ="SELECT Acceso FROM Consejeros WHERE Nombre='".rs($Nombre_Consejera)."' AND Password2='".rs($Password)."'";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$row = mysql_fetch_array($total_result);
		$access=$row['Acceso'];
		if ($access==0 OR $access==2)
			$Consejera[0]=$Nombre_Consejera;
		if ($Ano <> "-" AND $Ano <> ""){
			if (!isset($Ano2)) $Ano2=$Ano;
			$CadBusqueda2 .="AND Year(l.FechaLlamada)>='".rs($Ano)."' AND Year(l.FechaLlamada)<='".rs($Ano2)."' ";
			$criterio.="Año	>= $Ano y Año <= $Ano2<BR>";
			}
		if ($Mes <> "-" AND $Mes <> ""){
			if (!isset($Mes2)) $Mes2=$Mes;
			$CadBusqueda2 .="AND Month(l.FechaLlamada)>='".rs($Mes)."' AND Month(l.FechaLlamada)<='".rs($Mes2)."' ";
			$criterio.="Mes	>= $Mes y Mes<= $Mes2<BR>";			
			}
		if ($Dias <> "-" AND $Dias <> ""){
			$CadBusqueda2 .="AND DayOfMonth(l.FechaLlamada)>='".rs($Dias)."' AND DayOfMonth(l.FechaLlamada)<='".rs($Dias2)."' ";
			$criterio.="Dia	>= $Dias y Dia <= $Dias2<BR>";			
			}
		if ($Horas <> "-" and $Horas <> ""){
			$CadBusqueda2 .="AND Hour(l.HoraInicio)>='".rs($Horas)."' AND Hour(l.HoraTermino)<='".rs($Horas2)."' ";
			$criterio.="Hora >= $Horas y Hora<= $Horas2<BR>";			
			}
		if ($Duracion <> "-" and $Duracion <> ""){
			$CadBusqueda .= "AND ((time_to_sec(l.Horatermino)-time_to_sec(l.Horainicio))/60)>='".rs($Duracion)."' AND ((time_to_sec(l.Horatermino)-time_to_sec(l.Horainicio))/60)<='".rs($Duracion2)."' ";
			$criterio.="Duracion >= $Duracion y Duracion<= $Duracion2<BR>";			
			}	

		if (is_array($Consejera)){
			if (count($Consejera)>0 && $Consejera[0] <> "-"){
				$CadBusqueda .="AND (";
				$criterio.="Consejera = ";
				for ($i=0;$i<count($Consejera);$i++){
					$CadBusqueda .="l.Consejera = \"$Consejera[$i]\" ";
					$criterio.="$Consejera[$i] ";
					if ($i<count($Consejera)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
			}
			else{
				if ($Consejera <> "-" AND $Consejera <> ""){
					$CadBusqueda .="AND l.Consejera = '".rs($Consejera)."' ";
					$criterio.="Consejera = $Consejera<BR>";		
					}
				}
		if ($Edad <> "-" AND $Edad <> ""){
			$CadBusqueda .="AND c.Edad >= '".rs($Edad)."' AND c.Edad <= '".rs($Edad2)."' ";
			$criterio.="Edad >= $Edad y Edad<= $Edad2<BR>";			
			}
		if (count($ComoTeEnteraste)>0 && $ComoTeEnteraste[0] <> "-"){
			$CadBusqueda .="AND (";
			$criterio.="ComoTeEnteraste = ";
			for ($i=0;$i<count($ComoTeEnteraste);$i++){
				$CadBusqueda .="c.ComoTeEnteraste LIKE '%".rs($ComoTeEnteraste[$i])."%' ";
				$criterio.="$ComoTeEnteraste[$i] ";
				if ($i<count($ComoTeEnteraste)-1){
					$CadBusqueda .="OR ";
					$criterio.="o ";
					}
				}
			$CadBusqueda .=") ";
			$criterio.="<br>";
			}  
		if ($Sexo <> "-" AND $Sexo <> ""){
			$CadBusqueda .="AND c.Sexo = '".rs($Sexo)."' ";
			$criterio.="Genero = $Sexo<BR>";					
			}
		if (count($Ocupacion)>0 && $Ocupacion[0] <> "-"){
			$CadBusqueda .="AND (";
			$criterio.="Ocupacion = ";			
			for ($i=0;$i<count($Ocupacion);$i++){
				$CadBusqueda .="c.Ocupacion = '".rs($Ocupacion[$i])."' ";
				$criterio.="$Ocupacion[$i] ";
				if ($i<count($Ocupacion)-1){
					$CadBusqueda .="OR ";
					$criterio.="o ";
					}
				}
			$CadBusqueda .=") ";
			$criterio.="<br>";
			}
		if (count($Municipio)>0 && $Municipio[0] <> "-"){
			$CadBusqueda .="AND (";
			$criterio.="Municipio = ";			
			for ($i=0;$i<count($Municipio);$i++){
				$CadBusqueda .="c.Municipio LIKE '%".rs($Municipio[$i])."%' ";
				$criterio.="$Municipio[$i] ";				
				if ($i<count($Municipio)-1){
					$CadBusqueda .="OR ";
					$criterio.="o ";
					}
				}
			$CadBusqueda .=") ";
			$criterio.="<br>";
			}  	
		if (count($Estado)>0 && $Estado[0] <> "-"){
			$CadBusqueda .="AND (";
			$criterio.="Estado = ";				
			for ($i=0;$i<count($Estado);$i++){
				$CadBusqueda .="c.Estado LIKE '%".rs($Estado[$i])."%' ";
				$criterio.="$Estado[$i] ";					
				if ($i<count($Estado)-1){
					$CadBusqueda .="OR ";
					$criterio.="o ";
					}
				}
			$CadBusqueda .=") ";
			$criterio.="<br>";
			}

			 				
		if (count($EstadoCivil)>0 && $EstadoCivil[0] <> "-"){
			$CadBusqueda .="AND (";
			$criterio.="EstadoCivil = ";					
			for ($i=0;$i<count($EstadoCivil);$i++){
				$CadBusqueda .="c.EstadoCivil LIKE '%".rs($EstadoCivil[$i])."%' ";
				$criterio.="$EstadoCivil[$i] ";
				if ($i<count($EstadoCivil)-1){
					$CadBusqueda .="OR ";
					$criterio.="o ";
					}
				}
			$CadBusqueda .=") ";
			$criterio.="<br>";
			} 			
		if (count($AyudaPsicologico)>0 && $AyudaPsicologico[0] <> "-"){
			if ($AyudaPsicologico[0] <> "Todos"){
				$CadBusqueda .="AND (";
				$criterio.="AyudaPsicologico = ";				
				for ($i=0;$i<count($AyudaPsicologico);$i++){
					$CadBusqueda .="l.AyudaPsicologico LIKE '%".rs($AyudaPsicologico[$i])."%' ";
					$criterio.="$AyudaPsicologico[$i] ";					
					if ($i<count($AyudaPsicologico)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
				else{
					$CadBusqueda .="AND l.AyudaPsicologico <> \"\" ";
					$criterio.="AyudaPsicologico = Todos";
					}
			} 			
		if (count($AyudaLegal)>0 && $AyudaLegal[0] <> "-"){
			if ($AyudaLegal[0] <> "Todos"){
				$CadBusqueda .="AND (";
				$criterio.="AyudaLegal = ";							
				for ($i=0;$i<count($AyudaLegal);$i++){
					$CadBusqueda .="l.AyudaLegal LIKE '%".rs($AyudaLegal[$i])."%' ";
					$criterio.="$AyudaLegal[$i] ";					
					if ($i<count($AyudaLegal)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
				else{
					$CadBusqueda .="AND l.AyudaLegal <> \"\" ";
					$criterio.="AyudaLegal = Todos";
					}
			} 					
		if (count($AyudaMedica)>0 && $AyudaMedica[0] <> "-"){
			if ($AyudaMedica[0] <> "Todos"){
				$CadBusqueda .="AND (";
				$criterio.="AyudaMedica = ";					
				for ($i=0;$i<count($AyudaMedica);$i++){
					$CadBusqueda .="l.AyudaMedica LIKE '%".rs($AyudaMedica[$i])."%' ";
					$criterio.="$AyudaMedica[$i] ";						
					if ($i<count($AyudaMedica)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
				else{
					$CadBusqueda .="AND l.AyudaMedica <> \"\" ";
					$criterio.="AyudaMedica = Todos";
					}
			}
		if (count($AyudaNutricional)>0 && $AyudaNutricional[0] <> "-"){
			if ($AyudaNutricional[0] <> "Todos"){
				$CadBusqueda .="AND (";
				$criterio.="AyudaNutricional = ";					
				for ($i=0;$i<count($AyudaNutricional);$i++){
					$CadBusqueda .="l.AyudaNutricional LIKE '%".rs($AyudaNutricional[$i])."%' ";
					$criterio.="$AyudaNutricional[$i] ";						
					if ($i<count($AyudaNutricional)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
				else{
					$CadBusqueda .="AND l.AyudaNutricional <> \"\" ";
					$criterio.="AyudaNutricional = Todos";
					}
			} 			
		if (count($AyudaOtros)>0 && $AyudaOtros[0] <> "-"){
			if ($AyudaOtros[0] <> "Todos"){
				$CadBusqueda .="AND (";
				$criterio.="AyudaOtros = ";				
				for ($i=0;$i<count($AyudaOtros);$i++){
					$CadBusqueda .="l.AyudaOtros LIKE '%".rs($AyudaOtros[$i])."%' ";
					$criterio.="$AyudaOtros[$i] ";						
					if ($i<count($AyudaOtros)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
				else{
					$CadBusqueda .="AND l.AyudaOtros <> \"\" ";
					$criterio.="AyudaOtros = Todos";
					}
			} 	
		if ($Palabra <> "-" AND $Palabra <> "")
			$CadBusqueda .="AND l.DesarrolloCaso LIKE '%".rs($Palabra)."%' ";
		if ($IDCaso <> "")
			$CadBusqueda .="AND l.IDCaso LIKE '%".rs($IDCaso)."%' ";
		if ($Nombre <> "")
			$CadBusqueda .="AND c.Nombre LIKE '%".rs($Nombre)."%' ";
		if ($Telefono <> "")
			$CadBusqueda .="AND c.Telefono LIKE '%".rs($Telefono)."%' ";
		$sql ="drop table IF EXISTS $tmp";
		$total_result = @mysql_query($sql, $connection);
		$sql ="create table $tmp SELECT DISTINCT l.*, c.Nombre, c.Telefono, c.Edad, c.Sexo, c.ComoTeEnteraste, c.Ocupacion, c.Municipio, c.Estado, c.EstadoCivil FROM Llamadas l, Casos c WHERE c.IDCaso=l.IDCaso $CadBusqueda2 $CadBusqueda Order By l.LlamadaNo Desc";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		}
	if(!$Correlacion){
		$Correlacion="IDCaso";
		}
	$sql ="SELECT * FROM ".rs($tmp)." group by ".rs($Correlacion)."";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found = @mysql_num_rows($total_result);
	$inicio=(($Pagina-1)*50);

	$sql ="SELECT * FROM ".rs($tmp)." group by ".rs($Correlacion)." Order By FechaLlamada Desc limit ".rs($inicio).",50";

	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	while ($row = mysql_fetch_array($total_result)){
		$IDCaso=$row['IDCaso'];
		$FechaLlamada=$row['FechaLlamada'];
		$HoraInicio=$row['Horainicio'];
		$Consejera=$row['Consejera'];
		$Nombre=$row['Nombre'];
		$Telefono=$row['Telefono'];
		$LlamadaNo=$row['LlamadaNo'];
		$HoraTermino=$row['Horatermino'];
		$Acc=$row['Acceso'];
	 	list($AAAA, $MM, $DD) = split ('-', $FechaLlamada);
		$FechaLlamada="$DD/$MM/$AAAA";

		$sql3 ="SELECT Nombre, NivelSeguridad FROM consejeros WHERE Nombre='".rs($Consejera)."'";
		$total_result3 = @mysql_query($sql3, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$row3=mysql_fetch_array($total_result3);
		$Seg=$row3['NivelSeguridad'];
		if($Seg==4){
			$Color ="<FONT COLOR=\"#D80808\">";
			}
		    	else{
				$Color ="<FONT COLOR=\"#000000\">";	
				}
switch ($Correlacion){
	case "IDCaso":	
		$sql2 = "SELECT IDCaso, FechaLlamada, HoraInicio, Consejera, LlamadaNo, Acceso FROM Llamadas WHERE IDCaso='".rs($IDCaso)."' AND LlamadaNo<>'".rs($LlamadaNo)."' Order By FechaLlamada Desc";		
		break;
	case "Nombre":	
		$sql2 = "SELECT IDCaso, FechaLlamada, HoraInicio, Consejera, LlamadaNo, Acceso FROM ".rs($tmp)." WHERE Nombre='".rs($Nombre)."' Order By FechaLlamada Desc";		
		break;
	case "Telefono":	
		$sql2 = "SELECT IDCaso, FechaLlamada, HoraInicio, Consejera, LlamadaNo, Acceso FROM ".rs($tmp)." WHERE Telefono='".rs($Telefono)."' Order By FechaLlamada Desc";		
		break;
	}

		$total_result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$total_found2 = @mysql_num_rows($total_result2);
	 	while ($row2 = mysql_fetch_array($total_result2)){
			$IDCasoRef2=$row2['IDCaso'];
    		$FechaSeg2=$row2['FechaLlamada'];
   			$HoraInicioSeg2=$row2['HoraInicio'];
			$Consejera2=$row2['Consejera'];
   			$LlamadaNo2=$row2['LlamadaNo'];
			$Acc2=$row2['Acceso'];
			list($AAAA, $MM, $DD) = split ('-', $FechaSeg2);
			$FechaSeg2="$DD/$MM/$AAAA";
			$sql3 ="SELECT Nombre, NivelSeguridad FROM consejeros WHERE Nombre='".rs($Consejera2)."'";
			$total_result3 = @mysql_query($sql3, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			$row3=mysql_fetch_array($total_result3);
			$Seg=$row3['NivelSeguridad'];


		if($Seg==4&&$Acc2==0){
			$Color2 ="<FONT COLOR=\"#D80808\">";
			}
		else if($Seg==4&&$Acc2==1){
			$Color2 ="<FONT COLOR=\"#00AA00\">";
			}
	    	else if($Seg!=4&&$Acc2==0){
			$Color2 ="<FONT COLOR=\"#000000\">";	
			}
	    	else if($Seg!=4&&$Acc2==1){
			$Color2 ="<FONT COLOR=\"#555555\">";	
			}
//		$Seguimientos .="<LI><input type= checkbox name=\"Casilla[$IDCasoRef2][$LlamadaNo2]\" value=\"OFF\">Caso No. <a href=\"javascript: openwindow('?Accion=VerDetalles&IDCaso=$IDCasoRef2&LlamadaNo=$LlamadaNo2');\">".$Color2.$IDCasoRef2.", $FechaSeg2, $HoraInicioSeg2, $Consejera2</A></LI></FONT>";			    
		$Seguimientos .="<LI>Caso No. <a href=\"javascript: openwindow('?Accion=VerDetalles&IDCaso=$IDCasoRef2&LlamadaNo=$LlamadaNo2');\">".$Color2.$IDCasoRef2.", $FechaSeg2, $HoraInicioSeg2, $Consejera2</A></LI></FONT>";			    
			}

		$sql2 = "SELECT Consejera FROM Llamadas WHERE IDCaso='".rs($IDCaso)."' AND LlamadaNo=1";
		$total_result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$row2 = mysql_fetch_array($total_result2);
		$ConsejeraP=$row2['Consejera'];
	if (strcmp($Consejera,$ConsejeraP)<>0)
		$Consejera .= "</FONT><P>-- $ConsejeraP --</P>";
		else
			$Consejera .= "</FONT>";
	     	$display_block .= "<tr><TD VALIGN=top NOWRAP BGCOLOR=\"#FFFFFF\"><input type= checkbox name=\"Casilla[$IDCaso][$LlamadaNo]\" value=\"OFF\" onClick=\"DesChequearTodos(this);\"></TD><td VALIGN=top NOWRAP BGCOLOR=\"#FFFFFF\"><FONT SIZE=\"-1\">$FechaLlamada<BR><FONT SIZE=\"-2\">($HoraInicio - $HoraTermino)</FONT></FONT></TD><td VALIGN=top NOWRAP BGCOLOR=\"#FFFFFF\"><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=\"100%\">
           	<TR><TD><P><FONT SIZE=\"-1\"><B>$Nombre</B>($Telefono)</FONT></P></TD></TR>
           	<TR><TD><FONT SIZE=\"-2\">Seguimientos ($total_found2)</FONT><BR><BR><FONT SIZE=\"-2\">$Seguimientos</FONT><BR></TD></TR>
	     	</TABLE>
		</td><td VALIGN=top NOWRAP BGCOLOR=\"#FFFFFF\"><FONT SIZE=\"-1\">$Color $Consejera</td><TD VALIGN=top BGCOLOR=\"#FFFFFF\">
		<a href=\"javascript: openwindow('?Accion=Seguimiento&IDCaso=$IDCaso&Nombre=$Nombre&LlamadaNo=".($total_found2+1)."');\"><IMG SRC=\"resc/seguimiento.gif\" BORDER=0 ALIGN=bottom></a></TD><TD VALIGN=top NOWRAP BGCOLOR=\"#FFFFFF\">
		<a href=\"javascript: openwindow('?Accion=VerDetalles&IDCaso=$IDCaso&LlamadaNo=$LlamadaNo');\"><IMG SRC=\"resc/detalles.gif\" BORDER=0 ALIGN=bottom><a></TD></tr>";
		$Seguimientos ="";
		}
	if ($total_found != 0){
		include("Paginas/BuscarCasos_Resultados.html");
		}
		else{
			$Mensaje ="No hay resultados que coincidan con esa busqueda.";
			include("Paginas/CodigoMenuSinOpciones.html");
			include("Paginas/Error.html");
			}
	mysql_close($connection);
	}
	else{
		header("Refresh: 0; URL= ");
		}
?>
