<?
include("Funciones/Funcion_AgregaUsuarios.php");
include("Funciones/Funcion_Listas.php");
if($Pagina && $submit <> "Reporte"){
	switch ($AccionSec){
		case "Organismos":
			include("Funciones/Funcion_BusquedaOrganismos.php");
			break;
		default:
			include("Funciones/Funcion_BusquedaCasos.php");
			break;
		}
	}
	else{
		switch ($Accion){	
			case "RegistrarNuevoCaso":
				switch ($AccionSec){
					case "Registrar":
						include("Funciones/Funciones_RegistroDatos.php");
						break;
					default:
						include("Paginas/CodigoMenuSinOpciones.html");
						include("Paginas/RegistroLlamada.html");
						break;
					}
				break;
			case "RealizarBusqueda":
				switch ($AccionSec){
					case "General":
						include("Funciones/Funcion_BusquedaOrganismos.php");
						break;
					case "Organismos":
						include("Funciones/Funcion_BusquedaOrganismos.php");
						break;
					default:
						include("Paginas/BuscarCasosOperador.html");
						break;
					}
				break;
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
				include("Paginas/Entrada_Operador.html");
				break;
			}
	}
?>