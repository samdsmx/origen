<?
if ($Sesion){
	if ($Nombre){
		include("Datos_Comunicacion.php");
		$sql ="SELECT Nombre, Tipo, activo FROM Campos WHERE Nombre = '".rs($Nombre)."'";
		$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		while ($row = mysql_fetch_array($result))	{
			$Nombre=$row['Nombre'];
			$Tipo=$row['Tipo'];
			$Activo=$row['activo'];
			}
		$num = @mysql_num_rows($result);
		include("Paginas/Campos_Detalle.html");
		}
		else{
			$Mensaje="Debe seleccionar un campo";
			include("Paginas/Error.html");
			}
	}
?>
