<?
function MeteElementos($elementos){
	$NumElementos=count($elementos);
	if ($NumElementos>0){
		$elementos=(array_values($elementos));
		for ($i=0; $i<$NumElementos; $i++ ){
			$Salida .=$elementos[$i];
			if($i<$NumElementos-1)
			$Salida .=",";
			}
		return $Salida;
		}
		else{
			return "";
			}
	}

function SacaElementos($Arreglo){
	$Arreglo = str_replace(',', "<BR>", "$Arreglo");
	return $Arreglo;
	}
?>