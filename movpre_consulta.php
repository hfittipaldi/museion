<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function valida() {
	for (i=0; i<document.form1.length; i++) {
		var tempobj= document.form1.elements[i];
		if (tempobj.type=='text' && tempobj.value!='') {
			return true;
		}
	}
	if (document.form1.prazo.checked || document.form1.ausente.checked)
		return true;
	alert('Informe pelo menos um parâmetro.');
	return false;
}
</script>  
</head>

<body>      
<table width="542" border="1" align="center" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="center" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
montalinks();
$_SESSION['lnk']=$link;
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="get" onSubmit='return valida()' action="movimentacao3.php">
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td colspan="2" class="texto"><em><div align="center">Informe o(s) parâmetro(s) de pesquisa:</em><br><br></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="center"><span class="tit_interno"> </span>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"> </td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Registro de obra: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="registro" size="31" class="combo_texto"></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Saída prevista: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;de <input type="text" name="prevde" size="10" class="combo_texto" maxlength="10"> até <input type="text" name="prevate" size="10" class="combo_texto" maxlength="10"></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Retorno provável: de <input type="text" name="rde" size="10" class="combo_texto" maxlength="10"> até <input type="text" name="rate" size="10" class="combo_texto" maxlength="10"></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Data da saída: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;de <input type="text" name="sde" size="10" class="combo_texto" maxlength="10"> até <input type="text" name="sate" size="10" class="combo_texto" maxlength="10"></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Data do retorno: &nbsp;&nbsp;&nbsp;de <input type="text" name="retde" size="10" class="combo_texto" maxlength="10"> até <input type="text" name="retate" size="10" class="combo_texto" maxlength="10"></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Instituição/Local: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="local" size="50" class="combo_texto"></td>
        </tr>
<!--        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Nome de exposição <input type="text" name="nome" size="50" class="combo_texto"></td>
        </tr>-->
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Movimentações com prazo vencido: <input type="checkbox" name="prazo" value="marcou" onClick="document.form1.ausente.checked = false;"></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td class="texto_bold">Obras ausentes: <input type="checkbox" name="ausente" value="marcou" onClick="document.form1.prazo.checked = false;"></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><br><input type="submit" name="ok" class="botao" id="ok" value="Procurar"><br></td>
        </tr>
		<tr>
			<td colspan="2" class="texto_bold"><input type="text" name="textfield" style="display:none "></td>
		</tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>