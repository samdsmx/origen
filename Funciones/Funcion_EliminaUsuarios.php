<?
if ($Sesion){
	if ($Nombre=="Administrador"){
		$Mensaje= "Error: El Administrador no puede ser eliminado.";
		include ("Paginas/Error.html");
		}
		else{
			include("Datos_Comunicacion.php");
			$sql ="DELETE from Consejeros where Nombre ='".rs($Nombre)."'";
			$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			BorraCache();
			$Mensaje="Usuario Eliminado";
			header("Location: ?Mensaje=$Mensaje");
			}
	}
?>
