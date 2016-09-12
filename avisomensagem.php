<? 
include_once("seguranca.php");
include_once("classes/classe_padrao.php");
?>

<html>
<head>
<title> </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Refresh" content="300;URL=avisomensagem.php">
<script>
	window.status= "Verificando agenda...";
</script>
<?php 
	$dbnovamsg= new conexao();
	$dbnovamsg->conecta();
	$hoje= date("Y-m-d");
	$sqlnovamsg= "SELECT count(*) as total from agenda where usuario = '$_SESSION[susuario]' AND eh_lida = '0' AND data_aviso = '$hoje'";
	$dbnovamsg->query($sqlnovamsg);
	$totMSG= $dbnovamsg->dados();
	if ($totMSG['total'] > 0)
		echo "<script>top.document.getElementById('iconemsg').style.display= '';</script>";
	else
		echo "<script>top.document.getElementById('iconemsg').style.display= 'none';</script>";
?>
</head>
<script>
	window.status= "";
</script>
</html>