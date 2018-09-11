<?
include_once("Funciones/Funcion_ValidacionCampos.php");
if (RevisarNombre($Nombre)=="OK"){
	if (RevisarPassword($Password)=="OK"){
		include("Datos_Comunicacion.php");
		$acceso=$internet + $casos; 
		$sql ="UPDATE Consejeros set Nombre='".rs($Nombre)."', Password='".cod($Password)."', NivelSeguridad='".rs($NivelSeguridad)."', acceso='".rs($acceso)."' WHERE Nombre='".rs($NombreViejo)."'";
		$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		BorraCache();
		mysql_close($connection);
		$Mensaje="Datos actualizados";
		header("Location: ?Mensaje=$Mensaje");
		}
		else{
			$Mensaje= "Error: el Password contiene caracteres invalidos o es mayor a 8 caracteres";
			include ("Paginas/Error.html");
			}
	}
	else{
		$Mensaje= "Error: el Nombre contiene caracteres invalidos";
		include ("Paginas/Error.html");
		}
?>
