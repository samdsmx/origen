<?
if ($Sesion){
function ListaUsuarios(){
	include("Datos_Comunicacion.php");
	$sql ="SELECT Nombre FROM Consejeros";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found = @mysql_num_rows($total_result);
	while ($row = mysql_fetch_array($total_result)){
	    	$Nombre=$row['Nombre'];
	    	$Usuarios .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
		}
	$sql2 ="SELECT * FROM Campos ORDER BY Nombre ASC";
	$total_result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found2 = @mysql_num_rows($total_result2);
	while ($row = mysql_fetch_array($total_result2)){
	    	$Nombre=$row['Nombre'];
		$Tipo=$row['Tipo'];
		if($Tipo == 'AYUDAPSICOLOGICO'){
			$Psicologico .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'AYUDALEGAL'){
			$Legal .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'AYUDAMEDICA'){
			$Medicos .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'AYUDANUTRICIONAL'){
			$Nutricional .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'AYUDAOTROS'){
			$Otros .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'ComoTeEnteraste'){
			$Enteraste .= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'CanaLegal'){
			$CanaLegal.= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'Tema'){
			$Tema.= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'TipoViolencia'){
			$TipoViolencia.= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'ModalidadViolencia'){
			$ModalidadViolencia.= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		if($Tipo == 'Violentometro'){
			$Violentometro.= "<OPTION VALUE='$Nombre'>$Nombre".chr(10);
			}
		   }
	mysql_close($connection);
	include("Paginas/Usuarios_Lista.html");
	}

function ListaConsejeras(){
	include("Datos_Comunicacion.php");
	$sql ="SELECT Nombre FROM Consejeros WHERE NivelSeguridad=1 OR NivelSeguridad=4";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found = @mysql_num_rows($total_result);
	mysql_close($connection);
	while ($row = mysql_fetch_array($total_result)){
		$Consejera=$row['Nombre'];
    		$Consejeras .= "<OPTION VALUE='$Consejera'>$Consejera".chr(10);
		}
	if ($total_found != 0){
		return $Consejeras;
		}
	}
}
?>
