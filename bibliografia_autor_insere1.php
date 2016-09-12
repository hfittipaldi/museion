<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--

function obtem_valor(qual) {
	if (qual.selectedIndex.selected != '') {
                document.location=('bibliografia_autor_insere1.php?<? echo $parametro; ?>=<? echo $valor; ?>&page='+ i);
	}
}
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

              $parametro="autor";
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



    if ($_REQUEST['find']<>''){
    $sql="SELECT count(*) total FROM bibliografia WHERE referencia like'%$_POST[nome]%'";
        $db->query($sql);
        $reg=$db->dados();

	if ($reg['total'] == '0')
		echo "<script>location.href='bibliografia1.php?tipo=autor&op=insert&".$parametro."=".$autid."&nome=".$_POST[nome]."';</script>";
	if ($reg['total'] <> '0')
		echo "<script>location.href='bibliografia_insere2.php?tipo=autor&".$parametro."=".$autid."&nome=".$_POST[nome]."';</script>";


        }

 ?>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" class="texto_bold">
	<form name="form1" method="post" action="bibliografia_autor_insere1.php" onSubmit="return valida();">
	   <tr>
		<td colspan="2" class="texto_bold"> </td>
	   </tr>
	   <tr>
	      <td class="texto_bold" width="10%"></td>
	      <td class="texto_bold" valign="top">T&iacute;tulo da bibliografia: 
	         <input type="text" name="nome" size="40" class="combo_cadastro" onKeyDown="document.form1.pesquisa[1].checked=true;"> 
	         <input type="text" name="oculto" style="display: none;">
	         <input type="submit" name="find" value="Avançar" class="botao">
	         <input type="hidden" name="<? echo $parametro; ?>" value="<? echo $valor;?>">

              </td>
	   </tr>
   	</form>
	<tr>
	   <td colspan="2" class="texto_bold"><? echo "<a href=\"bibliografia.php?".$parametro."=".$autid."\"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar' >"?></td>
	</tr>
</table>
</body>
</html>