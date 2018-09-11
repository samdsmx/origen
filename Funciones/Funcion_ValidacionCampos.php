<?
function RevisarNombre($Nombre){		
	if (eregi("^[a-z 0-9-]+$", $Nombre) & strlen($Nombre)<70){
		return ("OK");
		}
		else{
			return ("Error");
			}
	}

function RevisarPassword($Password){	
	if (eregi("^[a-z0-9-]+$", $Password) & strlen($Password)>0){
		return ("OK");
		}
		else{
			return ("Error");
			}
	}

function rs($campo){
	return mysql_real_escape_string($campo);
	}

function cod($campo){
	$campo=rs($campo);
	return crypt($campo,"qwertyuiop");
	}
?>
