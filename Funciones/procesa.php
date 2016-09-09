<?php
	include("../Datos_Comunicacion.php");
	$estados="";
	$municipios="";
	$colonias="";
	if (isset($CP) && $CP <> ""){
		$sql ="select * from catalogocp where CP = '".rs($CP)."'";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		while ($row = mysql_fetch_array($total_result)){
			$estados.= '<option>'.$row["Estado"].'</option>';
			$municipios.= '<option>'.$row["Municipio"].'</option>';
			$colonias.= '<option>'.$row["Colonia"].'</option>';
			}
		echo $estados."|".$municipios."|".$colonias;
		}
	else if(isset($Estado) && $Estado <> "-"){
		if (isset($Municipio) && $Municipio <> "-"){
			if (isset($Colonia) && $Colonia <> "-"){
				$sql ="select CP from catalogocp where Estado = '".rs($Estado)."' and Municipio = '".rs($Municipio)."' and Colonia = '".rs($Colonia)."'";
				$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				$row = mysql_fetch_array($total_result);
				echo $row["CP"];
				}
				else{
					$sql ="select Colonia from catalogocp where Estado = '".rs($Estado)."' and Municipio = '".rs($Municipio)."' group by Colonia";
					$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
					while ($row = mysql_fetch_array($total_result)){
						$colonias.= '<option>'.$row["Colonia"].'</option>';
						}
					echo $colonias;
					}
			}
			else{
				$sql ="select Municipio from catalogocp where Estado = '".rs($Estado)."' group by Municipio";
				$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				while ($row = mysql_fetch_array($total_result)){
					$municipios.= '<option>'.$row["Municipio"].'</option>';
					}
				echo $municipios;
				}
		}	
	else{
		$sql ="select Estado from catalogocp group by Estado";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		while ($row = mysql_fetch_array($total_result)){
			$estados.= '<option>'.$row["Estado"].'</option>';
			}
		echo $estados;
		}
 ?>