<?
function preparaQuery($v, $name, &$CadBusqueda, &$criterio, $like=true, $b = "l", $mask=""){
	if ($mask) {
		$myname=$mask;
	} else {
		$myname=$name;					
	}
	if (is_array($v)){
		if (count($v)>0){
			if ($v[0] <> "Todos"){
				$CadBusqueda .="AND (";
				$criterio.="$myname = ";				
				for ($i=0;$i<count($v);$i++){
					if ($like){
						$CadBusqueda .="$b.$name LIKE '%".$v[$i]."%' ";
					} else {
						$CadBusqueda .="$b.$name = '".$v[$i]."' ";
					}
					$criterio.="$v[$i] ";						
					if ($i<count($v)-1){
						$CadBusqueda .="OR ";
						$criterio.="o ";
						}
					}
				$CadBusqueda .=") ";
				$criterio.="<br>";
				}
				else{
					$CadBusqueda .="AND $b.$name <> \"\" ";
					$criterio.="$myname = Todos";
					}
			}
		} else {
			if ($v <> "-" AND $v <> ""){
				$CadBusqueda .="AND $b.$name = '". rs($v) . "' ";
				$criterio.="$myname = $v<BR>";		
				}	
		}
}

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

function cod($Nombre,$campo){
	$campo=rs($campo);
	return crypt($Nombre,$campo);
	}
?>
