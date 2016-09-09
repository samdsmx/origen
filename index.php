<?
$contexto="ORIGEN";//"SEGOB"
include("Funciones/Funciones_Seguridad.php");
header('Pragma: no-cache');
header("Content-Type: text/html; charset=UTF-8");
if ($Sesion){
	if ($CerrarSesion){
		include("Datos_Comunicacion.php");
		$tmp=substr(mysql_real_escape_string($Sesion),0,5);
		$sql ="drop table $tmp";
		$total_result = @mysql_query($sql, $connection);
		mysql_close($connection);	
		setcookie("Sesion","", time() - 3600);
		BorraCache();
		header("Refresh: 0; URL= .");
		$Mensaje="Saliendo del sistema";
		include ("Paginas/Mensajes.html");
		die;
		}
	BorraCache();
	switch (RevisaSesion($Sesion, "verifica")){
		case "1":
			include("Modulos/Operador.php");
			break;
		case "2":
			include("Modulos/Supervisor.php");
			break;
		case "3":
			include("Modulos/Administrador.php");
			break;
		case "4":
			include("Modulos/Abogado.php");
			break;
		case "5":
			include("Modulos/Servicio.php");
			break;
		}
	}
	else{
		switch ($Accion){
			case "Autentifica":
				Autentifica($Nombre, $Password, "login");
				break;
			default:
				include("Paginas/Login.html");
				break;
			}
		}
?>