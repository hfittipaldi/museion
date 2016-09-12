<html>
<head>
<title>Lista de molduras:</title>
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
<?             include("classes/classe_padrao.php");
             include("classes/funcoes_extras.php");
             $db=new conexao();
             $db->conecta();
             $moldura=$_REQUEST[moldura];
?>
    <td width="243" valign="top"><form name="form1" method="post">
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#ddddd5">
        <tr class="texto">
          <td colspan="3" align="center" class="texto"><div align="center"><u>Obs</u>:
              Moldura <?echo $_REQUEST[moldura]?> pertence a obra:</div></td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>

        <tr class="texto">
          <td colspan="4" align="center" class="texto"><?
             $sql="select a.moldura, b.titulo_etiq from moldura as a INNER JOIN obra as b ON (a.obra = b.obra) where a.moldura=$_REQUEST[moldura];";
             $db->query($sql);
              echo" <select name='moldura[]' id='moldura' size='13' multiple  class='combo_cadastro' >";

		   $tipo_col= $_GET[tipo_col];
		   $tipo_col= explode(',',$tipo_col);
		   $totmembros= count($tipo_col);
		   if ($tipo_col[0] == '')
				$totmembros= 0;
                 
		   while($row=$db->dados())
		   {

			 $sel= '';
			 for ($i=1;$i<=$totmembros;$i++) {
				 if ($row['nome'] == $tipo_col[$i-1]) {
					 $sel= "selected";
					 break;
				 }
			 }

		     echo "<option value='$row[moldura]' $sel>$row[moldura]$row[titulo_etiq]</option>";
			
			  $res[]=$row[1];
		   }
		    //
			function converte($valor){
			 global $db;
			 $sql="SELECT moldura from moldura where nome='".trim($valor)."'";
			 $db->query($sql);
			 $row=$db->dados();
			 return $row[0];
			}
            //
        if($_REQUEST[submit]<>'')
             {
			$res=$_REQUEST[moldura];
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
		     echo "<script>opener.window.document.form.moldura.value='$k';</script>";
			 echo "<script>opener.window.document.form.idmolduras.value='$kk';</script>";
			 echo"<script>window.close()</script>";
		}
		   ?>
            <div align="center"></div>              <div align="center"></div></td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"></td>
        </tr>
        <tr class="texto">
          <td colspan="3" align="center" class="texto"></td>
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