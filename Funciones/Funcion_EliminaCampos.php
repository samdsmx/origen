<?
if ($Sesion){
	include("Datos_Comunicacion.php");
	$sql ="DELETE from Campos where Nombre ='".rs($Nombre)."'";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	BorraCache();
	$Mensaje="Campo Eliminado";
	header("Location: ?Mensaje=$Mensaje");
	}
?>
