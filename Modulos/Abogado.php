<?
switch ($Accion){
	case "RealizarBusquedaOrga":	
		include("Paginas/organismos.php");
		break;
	case "RegistraOrga":	
		include ("Paginas/CodigoMenuSinOpciones.html");
		include("Paginas/RegistroOrganismos.html");
		break;
	case "GuardaCambios":
		AgregaOrganismo($IDOrganismo,$Tema,$Institucion,$Estado,$Direccion,$Telefono,$Email,$Objetivo,$Referencia,$Observaciones,$Requisitos);
		break;
	case "RealizarBusqueda":
		switch ($AccionSec){
			case "Organismos":
				include("Funciones/Funcion_BusquedaOrganismos.php");
				break;
			case "General":
				include("Funciones/Funcion_BusquedaCasos.php");
				break;
			default:
				include("Paginas/BuscarCasosOperador.html");
				break;
			}
		break;
	case "VerDetalles":
		include("Funciones/Funcion_BusquedaCasos_Detalles.php");
		break;
	case "Seguimiento":
		switch ($AccionSec){
			case "Registrar":
				include("Funciones/Funciones_RegistroDatos.php");
				break;
			default:
				include("Paginas/RegistroSeguimiento.html");
				break;
			}
		break;
	default:	
		include("Paginas/Entrada_Abogado.html");
		break;
	}
?>