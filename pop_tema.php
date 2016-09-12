<html>
<head>
<title>Lista de Temas:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function fecha_pop()
{
 setTimeout('window.close()',60000);
 return true;
}
function cancela()
{
 document.form1.cancelar.submit=window.close();
return true;
}
</script>
<style type="text/css">
<!--
body {
	background-color: #ddddd5;
}
-->
</style></head>

<body onLoad="fecha_pop()">
<table width="259"  border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="ddddd5" >
  <tr>
    <td width="243" valign="top"><form name="form1" method="post">
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#ddddd5">
        <tr class="texto">
          <td colspan="4" align="center" class="texto"><?
		   include("classes/classe_padrao.php");
           include("classes/funcoes_extras.php");
           $db=new conexao();
           $db->conecta();
		   $sql="select DISTINCT tema,nome from tema ORDER by nome asc";
		   $db->query($sql);
		   echo" <select name='tema[]' id='tema' size='13' multiple  class='combo_cadastro' >";

		   $tipo_tema= $_GET[tipo_tema];
		   $tipo_tema= explode(',',$tipo_tema);
		   $totmembros= count($tipo_tema);
		   if ($tipo_tema[0] == '')
				$totmembros= 0;

		   while($row=$db->dados())
		   {

			 $sel= '';
			 for ($i=1;$i<=$totmembros;$i++) {
				 if ($row['nome'] == $tipo_tema[$i-1]) {
					 $sel= "selected";
					 break;
				 }
			 }

		     echo "<option value='$row[nome]' $sel>$row[nome]</option>";
			
			  $res[]=$row[1];
		   }
		    //
			function converte($valor){
			 global $db;
			 $sql="SELECT tema from tema where nome='".trim($valor)."'";
			 $db->query($sql);
			 $row=$db->dados();
			 return $row[0];
			}
            //
        if($_REQUEST[submit]<>'')
             {
			$res=$_REQUEST[tema];
 			if (strlen($res[0]) > 1) {
			
			 for($i=0;$i<count($res);$i++)
			 {
                     $var=$res[$i];
                   if($i+1 <count($res))
                      $var.=",";
                      $k.=$var;
					 
			   }
			   
			 for($j=0;$j<count($res);$j++)
			 {
                     $var2=converte($res[$j]);
                   if($j+1 <count($res))
                      $var2.=",";
                      $kk.=$var2;
					 
			   }
			}
			else {
				$k= "";
				$kk= "";
			}
         	if ($_REQUEST['consultaobra'] == '1'){
			     echo "<script>opener.window.document.form.tema.value='$k';</script>";
				 echo "<script>opener.window.document.form.idtemas.value='$kk';</script>";
				 echo"<script>window.close()</script>";
				}
				else {
			       echo "<script>opener.window.document.frmobra.tema.value='$k';</script>";
			       echo"<script>window.close()</script>";
		         }
		    /*   echo "<script>opener.window.document.frmobra.tema.value='$k';</script>";
			   echo"<script>window.close()</script>";*/
		}
		   ?>
            <div align="center"></div>              <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"></td>
        </tr>
        <tr class="texto">
          <td colspan="3" align="center" class="texto"><div align="center"><u>Obs</u>:
                Para selecionar mais de um tema,utilize a tecla &quot;<strong>Control</strong>&quot;</div></td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">&nbsp;</td>
          <td align="center" class="texto">&nbsp;</td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">
            <div align="center">
              <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar" onClick="cancela()">
            </div></td>
          <td align="center" class="texto">
              <div align="center">
                <input name="submit" type="submit" class="botao" value="Confirmar" >
              </div></td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="42%"></td>
          <td width="9%"></td>
          <td width="48%"></td>
          <td width="1%"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
       <span class="texto">       </span>
       <p>     
         <input name="usuario" type="hidden" id="usuario" value="<? echo $usuario ?>">
         <input name="op" type="hidden" id="op" value="<? echo $op ?>">
         <br>
        </p>
      <p></p>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>

