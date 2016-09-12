<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>

<body>      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1">
  <tr>
    <th valign='top'>
	<?
		require("classes/classe_padrao.php");
		include("classes/funcoes_extras.php");
		$db=new conexao();
		$db->conecta();

		$museu= $_GET['museu'];
	    $sql="SELECT * from museu where museu = '".$museu."'";
    	$db->query($sql);
		$row=$db->dados();
	?>
	  <table width="100%"  border="0" cellpadding="1" cellspacing="0"  bgcolor=#ddddd5>
		<tr>
			<td align="center" height="24" bgcolor="#96ADBE" class="texto_bold">Instituições que Utilizam o Donato
			</td>
		</tr>
        <tr>
          <td align="center" class="combo_cadastro" style="border-width: 0px;"><? echo "<br><b>".$row['nome']."</b><br>".$row['endereco'].", ".$row['numero']." - ".$row['bairro']."<br>".$row['cep']." - ".$row['cidade'].", ".$row['uf']."<br>(".$row['ddd'].") ".$row['tel']."<br>"; ?>
			<a href="mailto:<? echo $row['email']; ?>"><? echo $row['email']; ?></a></td>
          </td>
        </tr>
		<tr>
		  <td align="left" class="combo_cadastro" style="border-width: 0px;">&nbsp;<a href="listamuseus.php"><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'></a></td>
		</tr>
	  </table>
     </th>
  </tr>
</table>
</body>
</html>