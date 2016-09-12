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
    if(radio_tipo[0].checked==false && radio_tipo[1].checked==false && radio_tipo[2].checked==false) {
	  alert('Informe a ação que deseja realizar!');
	  return false;
	}
 }
}
</script>  
</head>
<? 
if ($_REQUEST['ok'] <> '') {
	if ($_REQUEST['radio_tipo'] == '1')
		echo "<script>location.href='usuario_perm.php?op=insert&usuario=$_REQUEST[usuario]'</script>";
	elseif ($_REQUEST['radio_tipo'] == '2')
		echo "<script>location.href='usuario_copiar.php?op=update&usuario=$_REQUEST[usuario]'</script>";
	elseif ($_REQUEST['radio_tipo'] == '3')
	   echo "<script>location.href='usuario_colecao1.php?op=update&usuario=$_REQUEST[usuario]'</script>";
}
?>

<body>
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
echo $_SESSION['lnk'];
function converte()
{
global $db;
  $sql="select a.nome from usuario as a where a.usuario='$_REQUEST[usuario]'";
  $db->query($sql);
  $res=$db->dados();
return $res[0];
} 
?>
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" onSubmit='return valida()'>
<table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#f2f2f2">
        <tr>
          <td colspan="3" class="texto_bold"><div align="center">Administra&ccedil;&atilde;o de Itens de Menus: </div></td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="left"></div></td>
          <td width="11%" class="texto_bold">Usu&aacute;rio:</td>
          <td width="79%" class="texto"><? echo converte(); ?></td>
        </tr>
        <tr>
          <td colspan="3" class="texto_bold"> </td>
        </tr>
        <tr style="display: none;">
          <td style="display: none;">&nbsp;</td>
          <td colspan="2" class="texto_bold" style="display: none;">Selecione
            a a&ccedil;&atilde;o que deseja realizar para este usu&aacute;rio:</td>
        </tr>
        <tr style="display: none;">
          <td style="display: none;">&nbsp;</td>
          <td colspan="2" class="texto_bold" style="display: none;">&nbsp;</td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td colspan="2" class="texto_bold"><input type="radio" name="radio_tipo" value="1"> <label onClick="document.form1.radio_tipo[0].checked=true; document.form1.radio_tipo[0].focus();">Atribuir
            permiss&otilde;es de menu individualmente.</label></td>
        </tr>
        <tr>
		  <td width="10%">&nbsp;</td>
          <td colspan="2" class="texto_bold"><input type="radio" name="radio_tipo" value="2"> <label onClick="document.form1.radio_tipo[1].checked=true; document.form1.radio_tipo[1].focus();">Copiar
              permiss&otilde;es com base nas permiss&otilde;es de um usu&aacute;rio
              existente. </label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="2" class="texto_bold"> <input name="radio_tipo" type="radio" value="3">
Atribuir permiss&otilde;es a cole&ccedil;&otilde;es.
  <label onClick="document.form1.radio_tipo[2].checked=true; document.form1.radio_tipo[2].focus();"></label> </td>
        </tr>
        <tr>
          <td colspan="3" align="center"><br><input type="submit" name="ok" class="botao" id="ok" value="Avançar"><br><br></td>
        </tr>
		<tr>
			<td colspan="3" class="texto_bold"><input type="text" name="textfield" style="display:none "></td>
		</tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>