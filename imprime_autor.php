<html>
<head>
<title>Ficha de Catalogação dos Autores</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
</head>
<style>
@media print {
	.noprint {
		display: none;
	}
}
@media screen {
	.noscreen {
		display: none;
	}
}
</style>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
	$db2=new conexao();
	$db2->conecta();

	$dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();

	$id= $_REQUEST['id'];
?>
<body>
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0" class="texto">
<?
	$sql="SELECT * FROM autor where autor = '$id'";
	$db->query($sql);
	if ($autor=$db->dados()) {
?>
  <tr> 
    <td colspan="3" align="center" style="border-bottom: 1px solid #ABABAB;"><br>
      <b>Ficha de Catalogação dos Autores</b></td>
  </tr>
  <tr> 
    <td width="80%" colspan="2">&nbsp;</td>
    <td align="right"><? echo date("d/m/Y"); ?>&nbsp;</td>
  </tr>
<?
	$sql2="SELECT b.nome_arquivo,b.diretorio_imagem from fotografia_autor as a, fotografia as b where a.fotografia = b.fotografia
		AND a.autor = '$id' order by a.eh_principal desc";
	$db2->query($sql2);
	$imagem=$db2->dados();
	$arquivo= $imagem['nome_arquivo'];
	$dir_img= $imagem['diretorio_imagem'];

	if ($arquivo == '')
		$arquivo= 'não tem imagem';

	if ($dir_img <> '') {
		$sql2="SELECT url from diretorio_imagem where diretorio_imagem = '$dir_img'";
		$db2->query($sql2);
		$url=$db2->dados();
		$url= $url['url'];
	}

	if (file_exists($dir.$url.'\\'.$arquivo)) {
		list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url.'/'.$arquivo);
		$Ao= $height;
		$Lo= $width;
		//120 é a altura max da área de exibição da imagem pequena; 180 é a largura máxima.//
		$num_alt= 120;
		$num_lar= 180;
		$cA= $Ao / $num_alt;
		$cL= $Lo / $num_lar;

		if ($Ao > $num_alt || $Lo > $num_lar) {
			if (cL < cA) {
				$percent= ($num_lar * 100) / $Lo;
				$Lo= $num_lar;
				$Ao= ($Ao * $percent) / 100;
				if ($Ao > $num_alt) {
					$percent= ($num_alt * 100) / $Ao;
					$Ao= $num_alt;
					$Lo= ($Lo * $percent) / 100;
				}
			} else {
				$percent= ($num_alt * 100) / $Ao;
				$Ao= $num_alt;
				$Lo= ($Lo * $percent) / 100;
				if ($Lo > $num_lar) {
					$percent= ($num_lar * 100) / $Lo;
					$Lo= $num_lar;
					$Ao= ($Ao * $percent) / 100;
				}
			}
		}
	} else {
		// imagem não disponível
		$Ao= 80;
		$Lo= 80;
	}
?>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
    <td rowspan="7" valign="bottom" align="right"><img src="<? echo $dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao; ?>" width="<? echo $Lo; ?>"></img></td>
  </tr>
  <tr> 
    <td height="20" colspan="2">Nome: <b><? echo $autor['nomeetiqueta']; ?></b></td>
  </tr>
  <tr> 
    <td height="20" colspan="2">Nome p/ catálogo: <b><? echo $autor['nomecatalogo']; ?></b></td>
  </tr>
<?
	$sql2="SELECT uf FROM estado where estado = '$autor[estado_nasc]'";
	$db2->query($sql2);
	$estado=$db2->dados();
	$sql2="SELECT nome FROM pais where pais = '$autor[pais_nasc]'";
	$db2->query($sql2);
	$pais=$db2->dados();
?>
  <tr> 
    <td height="20" colspan="2">Local de nascimento: <b><? echo $autor['cidade_nasc'].', '.$estado[0] . ' &nbsp;'.$pais[0]; ?></b></td>
  </tr>
  <tr> 
    <td height="20" colspan="2">Estados de atuação: <b><? echo $autor['estadoatua']; ?></b></td>
  </tr>
  <tr> 
    <td height="20" colspan="2">Paises de atuação: <b><? echo $autor['paisatua']; ?></b></td>
  </tr>
<?
	$sql2="SELECT uf FROM estado where estado = '$autor[estado_morte]'";
	$db2->query($sql2);
	$estado=$db2->dados();
	$sql2="SELECT nome FROM pais where pais = '$autor[pais_morte]'";
	$db2->query($sql2);
	$pais=$db2->dados();
?>
  <tr> 
    <td height="20" colspan="2">Local de falecimento: <b><? echo $autor['cidade_morte'].', '.$estado[0] . ' &nbsp;'.$pais[0]; ?></b></td>
  </tr>
  <tr> 
    <td height="20" colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="3" style="border-bottom: 1px solid black;"><b>Biografia</b></td>
  </tr>
  <tr> 
    <td height="20" colspan="3"><p align="justify"><? echo $autor['biografia']; ?></p></td>
  </tr>
  <tr> 
    <td height="20" colspan="3" style="border-bottom: 1px solid black;"><br><b>Bibliografia</b></td>
  </tr>
<?
	$sql2="SELECT a.*,b.* from autor_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	  where a.autor='$id' order by b.ano asc";
	$db2->query($sql2);
	while ($biblio=$db2->dados()) { ?>
	  <tr> 
	    <td height="20" colspan="3"><p align="left"><? echo "- ".$biblio['autoria'].". "."<b><em>"; ?><? echo $biblio['referencia']."</b></em>. "; 
		if ($biblio['sub_titulo']!='') echo $biblio['sub_titulo'].".&nbsp;";
		if ($biblio['local']!='') echo $biblio['local'].":&nbsp;";
		if ($biblio['editora']!='') echo $biblio['editora'].",&nbsp;";
		if ($biblio[ano]!='0'){echo $biblio[ano].". ";} else {echo "s/d. ";}
		if ($biblio['notas']!='') echo $biblio['notas'].".&nbsp;";
		if ($biblio['observacao']!='') echo $biblio['observacao'].".";
            ?><br></p></td>
	  </tr>
  <? } ?>
  <tr> 
    <td height="20" colspan="3" style="border-bottom: 1px solid black;"><br><b>Exposições Coletivas</b></td>
<?
	$sql2="SELECT a.*,b.* from autor_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao) 
	  where a.autor='$id' AND b.tipo = 'C' order by b.dt_inicial asc";
	$db2->query($sql2);
	while ($expo=$db2->dados()) { ?>
	  <tr> 
	    <td height="20" colspan="3"><p align="left"><b><? echo "- ".$expo['nome']."</b>"; ?>, <? echo $expo['instituicao'].", ". $expo['cidade'].", ". $expo['periodo']."."; ?>
		<em><? if ($expo['premio']!='') echo "&nbsp;".$expo['premio']."."; ?></em><br></p></td>
	  </tr>
  <? } ?>
  </tr>
  <tr> 
    <td height="20" colspan="3" style="border-bottom: 1px solid black;"><br><b>Exposições Individuais</b></td>
  </tr>
<?
	$sql2="SELECT a.*,b.* from autor_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao) 
	  where a.autor='$id' AND b.tipo = 'I' order by b.dt_inicial asc";
	$db2->query($sql2);
	while ($expo=$db2->dados()) { ?>
	  <tr> 
	    <td height="20" colspan="3"><p align="left"><b><? echo "- ".$expo['nome']."</b>"; ?>, <? echo $expo['instituicao'].", ". $expo['cidade'].", ". $expo['periodo']."."; ?>
		<em><? if ($expo['premio']!='') echo "&nbsp;".$expo['premio']."."; ?></em><br></p></td>
	  </tr>
  <? } ?>
  <tr> 
    <td height="20" colspan="3"></td>
  </tr>
  <tr> 
    <td height="20" colspan="3"></td>
  </tr>
  <tr class="noscreen"> 
   	<td colspan="3" align="center" style="border-top: 1px solid #ABABAB; font-size: 10px;">Museu Nacional de Belas Artes<br><sub>Av. Rio Branco, 199 - Centro<br>20040-008 Rio de Janeiro RJ Tel.: (21) 2240-0068 - Fax: (21) 2262-6067</sub></td>
  </tr>
  <tr class="noscreen"> 
    <td colspan="3" style="page-break-after: always;"></td>
  </tr>
  <? } ?>
        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>

  <tr class="noprint">
    <td colspan="3" align="center"><br><br><input type="button" name="imprimir" value=" Imprimir " onClick="window.print();"><br><br><br></td>
  </tr>
</table>

</body>
</html>