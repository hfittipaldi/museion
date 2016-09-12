<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function valida() {
	if (document.form1.pesquisa[0].checked==false && document.form1.pesquisa[1].checked==false) {
		alert('Selecione a origem da bibliografia!');  return false;
	}
}
-->
</script>
</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();
        $obra=$_REQUEST['obra'];
        $parametro="obra";


	$movid= $_REQUEST['movid'];
	$obrid= $_REQUEST['obrid'];
	$autid= $_REQUEST['autid'];
	if ($movid <> '') {
		$tipo= 'movimentacao';
		$valor= $movid;
		$parametro= 'movid';
	}
	elseif ($obrid <> '') {
		$tipo= 'obra';
		$valor= $obrid;
		$parametro= 'obrid';
	}
	elseif ($autid <> '') {
		$tipo= 'autor';
		$valor= $autid;
		$parametro= 'autid';
	}
	else
		echo "<script>alert('Tipo não informado!'); history.back();</script>";

	if ($_POST['pesquisa'] == '1')
		echo "<script>location.href='bibliografia_obra1.php?op=insert&".$parametro."=".$obrid."';</script>";
	if ($_POST['pesquisa'] == '2')
		echo "<script>location.href='bibliografia_insere2.php?".$parametro."=".$obrid."&nome=".$_POST[nome]."';</script>";
 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" class="texto_bold">
	<form name="form1" method="post" action="bibliografia_insere1.php" onSubmit="return valida();">
	   <tr>
		<td colspan="2" class="texto_bold"> </td>
	   </tr>
	   <tr>
		<td colspan="2" class="texto_bold"><input type="radio" name="pesquisa" value="1"> 
			<label onClick="document.form1.pesquisa[0].checked=true; document.form1.pesquisa[0].focus();">Nova bibliografia.</label> </td>
	   </tr>
	   <tr>
		<td colspan="2" class="texto_bold"><input type="radio" name="pesquisa" value="2" onClick="document.form1.nome.focus();"> 
			<label onClick="document.form1.pesquisa[1].checked=true; document.form1.nome.focus();">bibliografia já cadastrada &nbsp;(informe o parâmetro de pesquisa):</label> </td>
	   </tr>
	   <tr>
	      <td class="texto_bold" width="10%"></td>
	      <td class="texto_bold" valign="top">T&iacute;tulo da bibliografia: 
	         <input type="text" name="nome" size="40" class="combo_cadastro" onKeyDown="document.form1.pesquisa[1].checked=true;"> 
	         <input type="text" name="oculto" style="display: none;">
              </td>
	   </tr>
	   <tr>
	      <td colspan="2" class="texto_bold" align="center"><br><input type="submit" name="find" value="Avançar" class="botao"></td>
	      <input type="hidden" name="<? echo $parametro; ?>" value="<? echo $valor;?>">
	   </tr>
   	</form>
	<tr>
	   <td colspan="2" class="texto_bold"><? echo "<a href=\"bibliografia_obra.php?".$parametro."=".$obrid."\"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar' >"?></td>
	</tr>
</table>
</body>
</html>