<? include_once("seguranca.php") ?>

<script>
/*	if (top.location.href.search("principal.php") == -1)
		location.href= 'principal.php';*/
</script>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>

<body>      
<table width="542" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <th valign='top'>
	<?
		require("classes/classe_padrao.php");
		include("classes/funcoes_extras.php");
		$db=new conexao();
		$db->conecta();

		$mus= nome_instituicao();
	    $sql="SELECT * from museu where nome = '".$mus."'";
    	$db->query($sql);
		$museulocal=$db->dados();

	    $sql="SELECT * from museu where nome <> '".$mus."' order by nome";
   		$db->query($sql);
		$totmuseus=$db->contalinhas();
	?>
	  <table width="100%"  border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" height="24" bgcolor="#96ADBE" class="texto_bold">Instituições que Utilizam o Donato (<? echo $totmuseus + 1; ?>)
			</td>
		</tr>
        <tr>
          <td align="center" class="combo_cadastro" style="border-width: 0px; border-bottom: 1px solid #96ADBE;"><? echo "<br><b>".$museulocal['nome']."</b><br>".$museulocal['cidade']."  ".$museulocal['uf']."<br>"; ?>
			<br>
          </td>
        </tr>
	  </table>
	  <table width="100%" border="1" cellpadding="6" cellspacing="1" bgcolor="#ddddd5">
		<?
			while($museus=$db->dados()) { ?>
		<tr>
		  <td align="center" class="texto_bold" style="font-weight: normal;"><br><a style="color: #000000;" href="listamuseus2.php?museu=<? echo $museus['museu']; ?>"><? echo "<b>".$museus['nome']."</b>"; ?></a><br> 
			<? echo $museus['cidade']; ?> &nbsp; <? echo $museus['uf']; ?>
		  </td>
		</tr>
		<? } ?>
	  </table>
    <p>&nbsp;</p></th>
  </tr>
</table>
</body>
</html>