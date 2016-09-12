<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">

<script>
function valida()
{
 with(document.form1){
    if(radio_tipo[0].checked==false && radio_tipo[1].checked==false && radio_tipo[2].checked==false && radio_tipo[3].checked==false) {
	  alert('Informe o tipo da movimentação!');
	  return false;
	}
 }
}
</script>  
</head>

<? 
if ($_REQUEST['ok'] <> '') {
	if ($_REQUEST['radio_tipo'] == '1')
		echo "<script>location.href='movimentacao.php?rTipo=EI';</script>";
	elseif ($_REQUEST['radio_tipo'] == '2')
		echo "<script>location.href='movimentacao.php?rTipo=EE';</script>";
	elseif ($_REQUEST['radio_tipo'] == '3')
		echo "<script>location.href='movimentacao.php?rTipo=LI';</script>";
	elseif ($_REQUEST['radio_tipo'] == '4')
		echo "<script>location.href='movimentacao.php?rTipo=LE';</script>";
}
?>

<body>
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
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
    <td valign="top"><form name="form1" method="post" onSubmit='return valida()' action="movpre_insere.php">
<table width="100%"  border="0" cellpadding="0" cellspacing="1" >
        <tr>
          <td height="18" colspan="3">
            <div align="center" class="texto"><em>Selecione o tipo da movimentação:</em><br><br></div></td>
        </tr>
        <tr class="texto_bold">
          <td colspan="2"><div align="center"><span class="tit_interno"> </span>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"> </td>
        </tr>
        <tr>
		  <td width="30%">&nbsp;</td>
          <td class="texto_bold">Para exposição:</td>
        </tr>
        <tr>
		  <td width="30%">&nbsp;</td>
          <td class="texto_bold"><input type="radio" name="radio_tipo" value="1"> <label onClick="document.form1.radio_tipo[0].checked=true; document.form1.radio_tipo[0].focus();">Interna</label></td>
        </tr>
        <tr>
		  <td width="30%">&nbsp;</td>
          <td class="texto_bold"><input type="radio" name="radio_tipo" value="2"> <label onClick="document.form1.radio_tipo[1].checked=true; document.form1.radio_tipo[1].focus();">Externa</label></td>
        </tr>
        <tr>
          <td colspan="2" class="texto_bold"> </td>
        </tr>
        <tr>
		  <td width="30%">&nbsp;</td>
          <td class="texto_bold">Outras movimentações:</td>
        </tr>
        <tr>
		  <td width="30%">&nbsp;</td>
          <td class="texto_bold"><input type="radio" name="radio_tipo" value="3"> <label onClick="document.form1.radio_tipo[2].checked=true; document.form1.radio_tipo[2].focus();">Para local interno</label></td>
        </tr>
        <tr>
		  <td width="30%">&nbsp;</td>
          <td class="texto_bold"><input type="radio" name="radio_tipo" value="4"> <label onClick="document.form1.radio_tipo[3].checked=true; document.form1.radio_tipo[3].focus();">Para local externo</label></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><br><input type="submit" name="ok" class="botao" id="ok" value="Avançar"><br><br></td>
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