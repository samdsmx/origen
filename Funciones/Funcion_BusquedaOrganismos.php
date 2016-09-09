<?
if ($Sesion){
	include("Datos_Comunicacion.php");
	$tmp=substr(mysql_real_escape_string($Sesion),0,5);
	$CadBusqueda="";
	if (count($Temas)>0 && $Temas[0] <> "-"){
		for ($i=0;$i<count($Temas);$i++){
			$CadBusqueda .="Tema LIKE '%".rs($Temas[$i])."%' AND ";
			}
		}  
	if (count($Palabras)>0){
		for ($i=0;$i<count($Palabras);$i++){
			$CadBusqueda .="(Institucion LIKE '%".rs($Palabras[$i])."%' OR Objetivo LIKE '%".rs($Palabras[$i])."%') AND ";
			}
		}  
	if ($Estado <> "-" AND $Estado <> "")
		$CadBusqueda .="Estado LIKE '%".rs($Estado)."%' AND ";
	if ($Institucion <> "-" AND $Institucion <> "")
		$CadBusqueda .="Institucion LIKE '%".rs($Institucion)."%' AND ";
	if ($Direccion <> "-" AND $Direccion <> "")
		$CadBusqueda .="Direccion LIKE '%".rs($Direccion)."%' AND ";
	if ($Telefono <> "-" AND $Telefono <> "")
		$CadBusqueda .="Telefono LIKE '%".rs($Telefono)."%' AND ";
	$sql ="drop table IF EXISTS ".rs($tmp)."";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$sql ="SELECT * FROM organismos WHERE $CadBusqueda Id>0 Order By Institucion Asc";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found = @mysql_num_rows($total_result);
	$display_block ="$total_found Resultados<BR>";
	while ($row = mysql_fetch_array($total_result)){
		$ID2=$row['ID'];
		$Tema2=$row['Tema'];
		$Estado2=$row['Estado'];
		$Institucion2=$row['Institucion'];
		$Direccion=$row['Direccion'];
		$Telefono=$row['Telefono']; 
     	$display_block .= 
	"<tr>
    <TD><a href=\"#\" onclick=\"return false;\" title=\"$Direccion\">$Institucion2<a></TD>
	<TD><a href=\"#\" onClick=\"ponOrganismo('$Institucion2','$Tema2'); return false;\"  title=\"$Telefono\"><IMG SRC=\"resc/seguimiento.gif\" BORDER=0 ALIGN=bottom></a></TD>
	<TD><a href=\"#\" onClick=\"window.open('?Accion=RegistraOrga&IDOrganismo=$ID2','mywindow2','top=0,left=500,width=750,height='+(screen.availHeight)+',toolbar=yes,menubar=yes,resizable=yes,scrollbars=yes,scrolling=yes,status=yes'); return false;\"><IMG SRC=\"resc/detalles.gif\" BORDER=0 ALIGN=bottom></a></TD>
	</tr>";
		}
	if ($total_found != 0){
		include("Paginas/organismos.php");
		}
		else{
			$Mensaje ="No hay resultados que coincidan con esa busqueda.";
			include("Paginas/Error.html");
			}
	mysql_close($connection);
	}
	else{
		header("Refresh: 0; URL= ");
		}
?>
