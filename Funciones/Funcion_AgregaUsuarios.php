<?
function AgregaUsuario($Nombre, $Password, $NivelSeguridad, $internet, $casos){
include_once("Funciones/Funcion_ValidacionCampos.php");
if (RevisarNombre($Nombre)=="OK"){
	if (RevisarPassword($Password)=="OK"){
		$acceso=0;
		if ($internet)
			$acceso=2;
		if ($casos)
			$acceso+=1;
		include("Datos_Comunicacion.php");
		$sql = "INSERT INTO consejeros(Nombre,Password,NivelSeguridad,Acceso)
		VALUES
		('".rs($Nombre)."','".cod($Password)."','".rs($NivelSeguridad)."','".rs($acceso)."')";
		echo $sql."<br/>";
		$result = mysql_query($sql, $connection) or $Mensaje="El usuario ya existe" and die(include ("Paginas/Error.html"));
		mysql_close($connection);
		$Mensaje="Usuario Agregado";
		header("Location: ?Mensaje=$Mensaje");
		}
		else{
			$Mensaje= "Error: El Password contiene caracteres invalidos o es mayor a 8 caracteres";
			include ("Paginas/Error.html");
			}
	}
	else{
		$Mensaje= "Error: El Nombre contiene caracteres invalidos";
		include ("Paginas/Error.html");
		}	
	}

function AgregaCampos($Nombre,$Tipo,$activo){
include("Datos_Comunicacion.php");
$sql = "INSERT INTO Campos(Nombre,Tipo,activo)
		VALUES
		('".rs($Nombre)."','".rs($Tipo)."','".rs($activo)."')";
		$result = @mysql_query($sql, $connection) or $Mensaje="El campo ya existe" and die(include ("Paginas/Error.html"));
		mysql_close($connection);
		$Mensaje=$Tipo;
		header("Location: ?Mensaje=$Mensaje");
	}
	
function AgregaOrganismo($IDOrganismo,$Tema,$Institucion,$Estado,$Direccion,$Telefono,$Email,$Objetivo,$Referencia,$Observaciones,$Requisitos,$HorariosCostos){
include("Datos_Comunicacion.php");
if ($IDOrganismo){
		$sql ="UPDATE Organismos set Tema='".rs($Tema)."',Institucion='".rs($Institucion)."',Estado='".rs($Estado)."',Direccion='".rs($Direccion)."',Telefono='".rs($Telefono)."',
		Email='".rs($Email)."',Objetivo='".rs($Objetivo)."',Referencia='".rs($Referencia)."',Observaciones='".rs($Observaciones)."',Requisitos='".rs($Requisitos)."',HorariosCostos='".rs($HorariosCostos)."' WHERE ID='".rs($IDOrganismo)."'";
		}
		else{
			$sql = "INSERT INTO Organismos(Tema,Institucion,Estado,Direccion,Telefono,Email,Objetivo,Referencia,Observaciones,Requisitos,HorariosCostos)
			VALUES
			('".rs($Tema)."','".rs($Institucion)."','".rs($Estado)."','".rs($Direccion)."','".rs($Telefono)."','".rs($Email)."','".rs($Objetivo)."','".rs($Referencia)."','".rs($Observaciones)."','".rs($Requisitos)."','".rs($HorariosCostos)."')";
			}
		$result = @mysql_query($sql, $connection) or $Mensaje="El organismo ya existe" and die(include ("Paginas/Error.html"));
		mysql_close($connection);
		BorraCache();
		header("Refresh: 3; URL=?Accion=MenuPrincipal");
		$Mensaje="Listo! Organismo Agregado.";
		include("Paginas/Mensajes.html");
	}
	
function EliminaOrganismo($IDOrganismo){
	include("Datos_Comunicacion.php");
	$sql ="DELETE from Organismos WHERE ID='".rs($IDOrganismo)."'";
	$result = @mysql_query($sql, $connection) or $Mensaje="Error al eliminar el organismo" and die(include ("Paginas/Error.html"));
	mysql_close($connection);
	echo '<script type="text/javascript">window.close()</script>';
	}
?>
