<HEAD>
<TITLE>Busqueda de organismos</TITLE>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link href="css/select2.css" rel="stylesheet" />
<script src="js/select2.js"></script>
<script>
$(document).ready(function() {
  $('.js-example-basic-multiple').select2();
  $(".js-example-tokenizer").select2({
    tags: true,
    tokenSeparators: [',']
    })
  });
function ponOrganismo(pref,tema){
  if (tema == 'ASESORIA LEGAL')
      opener.document.forma.CanaLegal.value = pref;
    else
      opener.document.forma.CanaOtro.value = pref;
      window.close();
  return false;
  }
</script> 
<link href="css/cusco.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<FORM ACTION="" METHOD=GET enctype="multipart/form-data">
<INPUT TYPE=hidden NAME=Accion VALUE=RealizarBusqueda>
<INPUT TYPE=hidden NAME=Pagina VALUE=1>
<?
include("Datos_Comunicacion.php");
?>
  <table width="200" border="0">
    <tr>
      <td>Temas: </td>
      <td>
      <select name="Temas[]" class="js-example-basic-multiple" multiple style="width: 210px;">
          <? 
          $sql ="select Nombre from campos where Tipo = 'Tema' and activo = 1 Order By Nombre";
          $total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
          $total_found = @mysql_num_rows($total_result);
          while ($row = mysql_fetch_array($total_result)){
            $Nombre=$row['Nombre'];
            echo '<OPTION VALUE="'.$Nombre.'":>'.$Nombre.'</option>';
            }
          ?>
      </select>
    </td>
    </tr>
    <tr>
      <td>Estado:</td>
      <td><select name="Estado" style="width: 210px;">
        <option value="">-
          <? 
            $sql ="select estado from organismos group by estado order by estado Asc";
            $total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
            $total_found = @mysql_num_rows($total_result);
            $i=1;
            while ($row = mysql_fetch_array($total_result)){
              $Nombre=$row['estado'];
              echo '<OPTION VALUE="'.$Nombre.'":>'.$Nombre;
              $i=$i+1;
              }
          ?>
        </option>
      </select></td>
    </tr>
    <tr>
      <td>Palabras Clave:</td>
      <td>
        <select name="Palabras[]" class="js-example-tokenizer" multiple style="width: 210px;">
        </select>
    </tr>
    <tr>
      <td>Institucion:</td>
      <td><INPUT TYPE=text NAME=Institucion VALUE="" SIZE=30 MAXLENGTH=255></td>
    </tr>
    <tr>
      <td>Direccion:</td>
      <td><INPUT TYPE=text NAME=Direccion VALUE="" SIZE=30 MAXLENGTH=255></td>
    </tr>
    <tr>
      <td>Telefono:</td>
      <td><INPUT TYPE=text NAME=Telefono VALUE="" SIZE=30 MAXLENGTH=255></td>
    </tr>
   <tr>
      <td>&nbsp;</td>
      <td><div align="right">
    <INPUT TYPE=submit NAME=submit VALUE="Buscar">
    <INPUT TYPE=hidden NAME=AccionSec VALUE=Organismos>
      </div></td>
    </tr>
  </table>
</FORM>
<FORM ACTION="" METHOD=GET enctype="multipart/form-data">
<TABLE BORDER=0 BGCOLOR="#EEEEEE" CELLSPACING=3 CELLPADDING=3 WIDTH=320>
   <TR>
      <TD NOWRAP BGCOLOR="#FFFFFF">
         <P><B>Institucion</B></P>
      </TD>
      <TD BGCOLOR="#FFFFFF">
         <P></P>
      </TD>
      <TD BGCOLOR="#FFFFFF">
         <P></P>
      </TD>
   </TR><?php echo"$display_block<br>"; ?>
   </FORM>
   
   
</TABLE>

</BODY>
