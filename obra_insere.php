<? include_once("seguranca.php") ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<?
	include("classes/classe_padrao.php");
	$db=new conexao();
	$db->conecta();

	$movid= $_REQUEST['movid'];

	if ($_REQUEST['op'] == 'add') {
		$sql= "SELECT count(*) from obra_movimentacao where obra = '$_REQUEST[obra]' AND movimentacao = '$movid'";
		$db->query($sql);
		$tot= $db->dados();
		$tot= $tot[0];
		if ($tot == 0) {
			$sql= "SELECT data_saida from movimentacao where movimentacao = '$movid'";
			$db->query($sql);
			$data= $db->dados();
			$sql= "INSERT into obra_movimentacao(obra,movimentacao,data_saida) values('$_REQUEST[obra]', '$movid', '$data[data_saida]')";
			$db->query($sql);
		}
		echo "<script>location.href='obra_lista.php?movid=".$movid."';</script>";
	}
	elseif ($_REQUEST['op'] == 'del') {
		$sql= "DELETE from obra_movimentacao where obra_movimentacao = '$_REQUEST[id]'";
		$db->query($sql);
		echo "<script>location.href='obra_lista.php?movid=".$movid."';</script>";
	}
 ?>
<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="8" class="texto_bold">
	<form name="form1" method="post" action="obra_insere1.php">
	<tr>
    <td colspan="2" class="texto_bold" align="center" valign="top"><br>Informe o título da obra ou o número de registro: </td>
	</tr>
	<tr>
	<td class="texto_bold" width="20%"></td>
	<td class="texto_bold" valign="top">Registro da obra: &nbsp;&nbsp;<input type="text" name="registro" size="26" class="combo_cadastro"> 
			 <br>Título: <input type="text" name="titulo" size="40" class="combo_cadastro">
			 <input type="hidden" name="movid" value="<? echo $movid; ?>">
		<script>document.form1.registro.focus();</script>
    </td>
	</tr>
	<tr>
	<td colspan="2" class="texto_bold" align="center"><br><input type="submit" name="find" value="Procurar" class="botao"></td>
	</tr>
   	</form>
	<tr>
	<td colspan="2" class="texto_bold"><? echo "<a href=\"obra_lista.php?movid=".$movid."\"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar' >"?></td>
	</tr>
</table>
</body>
</html>