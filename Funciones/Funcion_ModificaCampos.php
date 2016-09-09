<?
if (RevisarNombre($Nombre)=="OK"){
		include("Datos_Comunicacion.php");
		$sql ="UPDATE Campos set Nombre='".rs($Nombre)."', activo='".rs($activo)."' WHERE Nombre='".rs($NombreViejo)."'";
		$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		BorraCache();
		mysql_close($connection);
		$Mensaje="Datos actualizados";
		header("Location: ?Mensaje=$Mensaje");
		}
		else{
			$Mensaje= "Error: el Campo contiene caracteres invalidos";
			include ("Paginas/Error.html");
			}
?>
