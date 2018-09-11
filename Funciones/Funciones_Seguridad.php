<?
function Autentifica($Nombre, $Password, $Estado){
	include("Datos_Comunicacion.php");
	if ($Estado == "login"){
		$Password=cod($Password);
		}
	$ip = substr($_SERVER['REMOTE_ADDR'],0,3); 
	if ($ip!="192" && $ip!="127")
		$sql ="SELECT NivelSeguridad FROM Consejeros WHERE Nombre='".rs($Nombre)."' AND Password='".$Password."' AND Acceso > 1";
		else
			$sql ="SELECT NivelSeguridad FROM Consejeros WHERE Nombre='".rs($Nombre)."' AND Password='".$Password."'";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found = @mysql_num_rows($total_result);
	if ($total_found == "1"){
		$row = mysql_fetch_array($total_result);
		$NivelSeguridad=$row['NivelSeguridad'];
		switch ($Estado){
			case "login":
				$SecureCad="$Nombre@$Password";
				$SecureCad=base64_encode($SecureCad);
				setcookie ("Sesion", $SecureCad, time()+60*60*24);
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Refresh: 0; URL= ?Accion=MenuPrincipal");
				$Mensaje= "Procesando entrada";
				include("Paginas/Mensajes.html");
				break;
			case "verifica":
				return("$NivelSeguridad");
				break;
			case "identidad":
				return $Nombre;
				break;
			}
		}
		else{
			setcookie("Sesion","", time() - 3600);
			unset($_COOKIE[Sesion]);
			$Mensaje= "Permiso denegado.";
			include("Paginas/CodigoMenuSinOpciones.html");
			include("Paginas/Error.html");
			}
	mysql_close($connection);
	}

function RevisaSesion($DatosSesion, $verificacion){
	$SecureCad=base64_decode($DatosSesion);
	list($Nombre, $Password)= split("@", $SecureCad);
	return Autentifica($Nombre, $Password, "$verificacion");
	}

function BorraCache(){
	header("Pragma: public");
	header("Expires: 0"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	}
?>
