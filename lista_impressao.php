<? include_once("seguranca.php") ?>
<html>
<head>
<title>Lista de obras para impressão</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<? 
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();

	if ($_REQUEST['op'] == 'del') {
		$_SESSION['s_impressao']= str_replace(",".$_REQUEST['obra'],"",$_SESSION['s_impressao']);
		$_SESSION['s_imp_total']--;
	}

	$id_obras= $_SESSION['s_impressao'];
	$id_obras= substr($id_obras,1);

	if ($id_obras == '')
		$id_obras= 0;

	$sql= "SELECT * from obra where obra in ($id_obras) order by titulo";
	$db->query($sql);
?>
<body>
<table border="0" align="left" cellpadding="0" cellspacing="4" class="texto_bold">
	<? $count= 1;
	   while($row=$db->dados()) { ?>
       <tr>
         <td><? echo $count. ") " . $row['titulo'] . " - " . $row['num_registro'];  $count++; ?>
		<div align="right"><a href="lista_impressao.php?op=del&obra=<? echo $row[obra] ?>" style="color:#883377; text-decoration:none;" title="Remover a obra da lista de impressão">Remover</a>&nbsp;&nbsp;</div></td>
       </tr>
       <tr>
         <td nowrap>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - </td></td>
       </tr>
	<? } ?>
		<tr>
			<td align="left"><br>&nbsp;<img src="imgs/icons/ic_remover.gif">&nbsp;<a href="javascript:;"  class="texto_bold" style="color:red;" onClick="window.close();">Fechar</a><br>&nbsp;</td>
		</tr>
</table>
</body>
</html>