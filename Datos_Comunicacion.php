<?
include_once("Funciones/Funcion_ValidacionCampos.php");
$db_name = "X";
$connection = @mysql_connect("localhost:3306","x","x") or die("Sin acceso a el servidor de BD");
$db = @mysql_select_db($db_name, $connection) or die("No se puede encontrar la BD");
@mysql_query("SET NAMES 'UTF8'", $connection);
?>

