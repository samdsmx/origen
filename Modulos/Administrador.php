<?
include("Funciones/Funcion_Listas.php");
include("Funciones/Funcion_AgregaUsuarios.php");
		switch ($Accion){
				case "Agregar":
					include("Paginas/Usuarios_Agregar.html");
					break;
				case "Agregar2":
					include("Paginas/Campos_Agregar.html");
					break;
				case "AgregaUsuario":
					AgregaUsuario($Nombre, $Password, $NivelSeguridad, $internet, $casos);
					break;
				case "AgregaCampo":
					AgregaCampos($Nombre, $Tipo,$activo);
					break;
				case "Detalles":
					include("Funciones/Funcion_DetallesUsuario.php");
					break;
				case "Detalles2":
					include("Funciones/Funcion_DetallesCampos.php");
					break;
				case "Modificar":
					include("Funciones/Funcion_ModificaUsuarios.php");
					break;
				case "Eliminar":
					include("Funciones/Funcion_EliminaUsuarios.php");
					break;
				case "Modificar2":
					include("Funciones/Funcion_ModificaCampos.php");
					break;
				case "Eliminar2":
					include("Funciones/Funcion_EliminaCampos.php");
					break;
				default:
					ListaUsuarios();
					break;
				}
?>