<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--

<script>

function valida() {
	if (document.form1.pesquisa[0].checked==false && document.form1.pesquisa[1].checked==false) {
		alert('Selecione a origem da bibliografia!');  return false;
	}
	if(document.form1.pesquisa[1].checked==true && document.form1.desc.value=='')
	{
	 alert('Preencha com a referência!'); 
	 document.form1.desc.focus();
	 return false;
	} 
}
-->
</script>
</head>
<?
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$bibliografia=$_REQUEST['bib'];
$obra=$_REQUEST['obra'];
 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" class="texto_bold">
	<form name="form1" method="post" onSubmit="return valida();">
	<tr>
		<td colspan="2" class="texto_bold"> </td>
	</tr>
	<tr>
		<td colspan="2" class="texto_bold"><input type="radio" name="pesquisa" value="1"> 
			<label onClick="document.form1.pesquisa[0].checked=true; document.form1.pesquisa[0].focus();">Novo item.</label> </td>
	</tr>
	<tr>
		<td colspan="2" class="texto_bold"><input type="radio" name="pesquisa" value="2" onClick="document.form1.desc.focus();"> 
			<label onClick="document.form1.pesquisa[1].checked=true; document.form1.desc.focus();">Item já cadastrado &nbsp;(informe o parâmetro de pesquisa):</label> </td>
	</tr>
	<tr>
	<td class="texto_bold" width="10%"></td>
	<td class="texto_bold" valign="top">Referência:
      <input name="desc" type="text" class="combo_cadastro" id="desc" onKeyDown="document.form1.pesquisa[1].checked=true;" value="<? echo $_REQUEST[desc] ?>" size="40"> 
			 <input type="text" name="oculto" style="display: none;">
    </td>
	</tr>
	<tr>
          <td valign="top"><br><? echo "<a href=\"bibliografia_insere2.php?obra=$obra\"><input type='submit' name='find' value='Avançar' class='botao'>"?></td>
	</tr>
   	</form>
	<tr>
          <td valign="top"><br><? echo "<a href=\"bibliografia_obra.php?obra=$obra\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></td>
	</tr>
</table>
</body>
</html>
<? 
if($_REQUEST[submit]<>'')
{ 
   if ($_POST['pesquisa'] == '1')
		echo "<script>location.href='bibliografia_obra2.php?op=insert&obra=$_REQUEST[obra]';</script>";
	if ($_POST['pesquisa'] == '2')
		echo "<script>location.href='bibliografia_insere2.php?id=$_REQUEST[id]&desc=$_REQUEST[desc]';</script>";
}

?>