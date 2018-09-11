<?
if ($Sesion){
	if ($Nombre){
		include("Datos_Comunicacion.php");
		$sql ="SELECT Nombre, Password, NivelSeguridad, Acceso FROM Consejeros WHERE Nombre = '".rs($Nombre)."'";
		$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		while ($row = mysql_fetch_array($result))	{
			$Nombre=$row['Nombre'];
			$Password=$row['Password'];
			$NivelSeguridad=$row['NivelSeguridad'];
			$acceso=$row['Acceso'];
			}
		$num = @mysql_num_rows($result);
		include("Paginas/Usuarios_Detalle.html");
		}
		else{
			$Mensaje="Debe seleccionar un usuario";
			include("Paginas/Error.html");
			}
	}
?>
