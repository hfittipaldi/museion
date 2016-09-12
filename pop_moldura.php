<html>
<head>
<title>Moldura:</title>
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
function seleciona()
{
	if (document.getElementById('selmoldura').value != '') {
		opener.window.document.getElementById('moldura').value= document.getElementById('selmoldura').value;
	}
	window.close();
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
<table width="259"  border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="ddddd5">
  <tr>
    <td width="243" valign="top"><form name="form1" method="post">
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#ddddd5">
        <tr class="texto">
          <td colspan="4" align="center" class="texto">
			<select size="10" name="selmoldura" id="selmoldura" class="combo_cadastro">
			<?
			   include("classes/classe_padrao.php");
    	       include("classes/funcoes_extras.php");
        	   $db=new conexao();
	           $db->conecta();
				$sql="select distinct(moldura) from pintura";
				$db->query($sql);
				while($res=$db->dados()){
					if ($res[0] <> '') { ?>
	                   <option value="<? echo $res[0] ?>"><? echo $res[0] ?></option>
            <?  }   } ?>
			</select>
		  </td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"></td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">&nbsp;</td>
          <td align="center" class="texto">&nbsp;</td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"><br>&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">
            <div align="center">
              <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar" onClick="cancela()">
            </div></td>
          <td align="center" class="texto">
              <div align="center">
                <input name="submit" type="submit" class="botao" value="Confirmar" onClick="seleciona()">
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
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>