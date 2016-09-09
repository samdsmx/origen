<?
include("Funciones/Funcion_AgregaUsuarios.php");
switch ($Accion){
	case "RealizarBusqueda":
		switch ($AccionSec){
			case "Organismos":
				include ("Paginas/CodigoMenu.html");
				echo "  <center><br>";
				include("Funciones/Funcion_BusquedaOrganismos.php");
				break;
			default:
				include ("Paginas/CodigoMenu.html");
				echo "  <center><br>";
				include("Paginas/organismos.php");
				break;
			}
		break;
	case "RegistraOrga":	
				include ("Paginas/CodigoMenuSinOpciones.html");
				include("Paginas/RegistroOrganismos.html");
				break;
	case "RegistraOrga2":	
				include ("Paginas/CodigoMenu.html");
				include("Paginas/RegistroOrganismos.html");
				break;
	case "GuardaCambios":
				AgregaOrganismo($IDOrganismo,$Tema,$Institucion,$Estado,$Direccion,$Telefono,$Email,$Objetivo,$Referencia,$Observaciones,$Requisitos,$HorariosCostos);
				break;
	case "Elimina":
			EliminaOrganismo($IDOrganismo);
			break;
	default:	
		include("Paginas/Entrada_Servicio.html");
		break;
	}
?>