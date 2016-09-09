<?
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
			case "RealizarBusqueda":
				switch ($submit){
					case "Buscar":
						switch ($AccionSec){
							case "Organismos":
								include("Funciones/Funcion_BusquedaOrganismos.php");
								break;
							default:	
								include("Funciones/Funcion_BusquedaCasos.php");
								break;
							}
						break;
					case "Reporte":
						include("Funciones/Funcion_ReporteCasosSupervisor.php");
						break;
					case "Graficar":
						include("Funciones/Grafica.php");
						break;
					default:	
						include("Paginas/BuscarCasosSupervisor.html");
						break;
					}
				break;
			case "RealizarBusquedaOrga":	
				include("Paginas/organismos.php");
				break;
			case "VerDetalles":
				if($submit=="Modificar")
					include("Funciones/Funciones_RegistroDatos.php");
					else
						include("Funciones/Funcion_BusquedaCasos_Detalles.php");
				break;
			case "ModificaVarias":
				if($submit=="Modificar")
					include("Funciones/Funciones_RegistroDatos.php");
					else{
						include ("Paginas/CodigoMenuSinOpciones.html");
						include("Paginas/ModificaLlamadas.html");
						}
				break;

			case "Modifica":
				include("Funciones/Funcion_ModificaLlamada.php");
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
				include("Paginas/Entrada_Supervisor.html");
				break;
			}
		}

?>