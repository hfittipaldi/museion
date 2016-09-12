<html>
<head>
<title>Laudo de Vistoria</title>
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
	$salto=0;
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
	$db2=new conexao();
	$db2->conecta();
	$db3=new conexao();
	$db3->conecta();
              $db4=new conexao();
	$db4->conecta();

               $db_museu=new conexao(); 
               $db_museu->conecta();

	$dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();
	$id= $_REQUEST['id'];

	$sql="SELECT a.* FROM exposicao as a  INNER JOIN  movimentacao_exposicao as b on (a.exposicao=b.exposicao) where b.movimentacao='$id' order by a.dt_inicial";
	$db3->query($sql);
	$x=0;
	while ($expo=$db3->dados())
		$expo_id[$x++]= $expo['exposicao'];
	$num_expo=$db3->contalinhas();
	if ($num_expo == 0)
		$num_expo= 1;
        
	$sql="SELECT a.* FROM obra as a  INNER JOIN  obra_movimentacao as b on (a.obra=b.obra) where b.movimentacao='$id' order by a.num_registro";
	$db4->query($sql);
	$x=0;
	while ($obraId=$db4->dados())
		$obra_Lista[$x++]= $obraId['obra'];
	$num_obra=$db4->contalinhas();
	if ($num_obra == 0)
		$num_obra= 1;

?>
<body>

<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0" class="texto">
  <?
 for ($i=0;$i<$num_obra;$i++) { 

        $sql="SELECT a.* FROM obra as a where obra = '$obra_Lista[$i]'";
        $db4->query($sql);
   
        $obra=$db4->dados();

   
     for ($j=0;$j<$num_expo;$j++) { 

	$sql="SELECT a.* FROM exposicao as a where exposicao = '$expo_id[$j]'";
	$db3->query($sql);
        $expo=$db3->dados();

        $sql="SELECT a.* FROM obra as a  INNER JOIN  obra_movimentacao as b on (a.obra=b.obra) where b.movimentacao='$id' order by a.num_registro";
        $db->query($sql);

	$sql="SELECT a.* FROM autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) where b.obra='$obra[obra]' order by b.hierarquia";
	$db2->query($sql);
	$autor=$db2->dados();
?>
<?
   $sql_museu="Select valor from parametro where parametro='LOCAL_INSTAL';";
   $db_museu->query($sql_museu);
   $museu=$db_museu->dados();

   $sql_museu="Select * from museu where museu='$museu[valor]'";
   $db_museu->query($sql_museu);   
   $museu=$db_museu->dados();
?>
    <tr> 
    <td colspan="3" align="center" style="border-bottom: 1px solid #ABABAB;"><b><? echo $museu[nome]?></b></td>
  </tr>

<?

   if ($salto>0) {
           echo '<tr> <td colspan="3" align="center"><b>Laudo de Vistoria</b></td></tr>';
      }
      $salto==($salto+1);
?>
    <tr> 
    <td colspan="3" align="center"><b>Laudo de Vistoria </b></td>
    </tr>
<tr> 
    <td width="80%" colspan="2">&nbsp;</td>
    <td align="right"><b><? echo $obra['num_registro']; ?></b>&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="2"><b><? echo $autor['nomeetiqueta']; ?></b></td>
    <td>&nbsp;</td>
  </tr>
<?
	$sql2="SELECT b.nome_arquivo,b.diretorio_imagem from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
		AND a.obra = '$obra[obra]' order by a.eh_mini desc, a.eh_img_laudo desc, a.eh_principal desc";
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
		//100 é a altura max da área de exibição da imagem pequena; 150 é a largura máxima.//
		$num_alt= 100;
		$num_lar= 150;
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

		$Ao2= $height;
		$Lo2= $width;
		//390 é a altura max da área de exibição da imagem grande; 520 é a largura máxima.//
		$num_alt= 390;
		$num_lar= 520;
		$cA= $Ao2 / $num_alt;
		$cL= $Lo2 / $num_lar;

		if ($Ao2 > $num_alt || $Lo2 > $num_lar) {
			if (cL < cA) {
				$percent= ($num_lar * 100) / $Lo2;
				$Lo2= $num_lar;
				$Ao2= ($Ao2 * $percent) / 100;
				if ($Ao2 > $num_alt) {
					$percent= ($num_alt * 100) / $Ao2;
					$Ao2= $num_alt;
					$Lo2= ($Lo2 * $percent) / 100;
				}
			} else {
				$percent= ($num_alt * 100) / $Ao2;
				$Ao2= $num_alt;
				$Lo2= ($Lo2 * $percent) / 100;
				if ($Lo2 > $num_lar) {
					$percent= ($num_lar * 100) / $Lo2;
					$Lo2= $num_lar;
					$Ao2= ($Ao2 * $percent) / 100;
				}
			}
		}

	} else {
		// imagem não disponível
		$Ao= 80;
		$Lo= 80;
		$Ao2= 160;
		$Lo2= 160;
	}
?>
  <tr> 
    <td colspan="2">&nbsp;</td>
    <td rowspan="8" valign="top" align="right"><img src="<? echo $dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao; ?>" width="<? echo $Lo; ?>"></img></td>
  </tr>
  <?
	$sql="SELECT nome FROM colecao where colecao = '$obra[colecao]'";
	$db2->query($sql);
	$colecao=$db2->dados();
?>
  <tr> 
    <td height="20" colspan="2"><? echo $colecao['nome']; ?></td>
  </tr>
  <tr> 
    <td height="20" colspan="2"><b><? echo $obra['titulo']; ?></b></td>
  </tr>
	<tr>
		<td>
	<? if ($obra['dim_obra_profund'] > 0 and $obra['dim_obra_diametro'] == 0 and $obra['aimp_obra_diametro'] == 0 and $obra['aimp_obra_altura'] == 0)
		echo $obra[material_tecnica].", " . number_format($obra['dim_obra_altura'],1,",",".") . " x " . number_format($obra['dim_obra_largura'],1,",","."). " x " . number_format($obra['dim_obra_profund'],1,",",".") . " cm"; 
	   elseif ($obra['dim_obra_profund'] > 0 and $obra['dim_obra_diametro'] > 0 and $obra['aimp_obra_diametro'] == 0 and $obra['aimp_obra_altura'] == 0)
		echo $obra[material_tecnica].", ". "&Oslash; = " . number_format($obra['dim_obra_diametro'],1,",",".") . " cm ; " . number_format($obra['dim_obra_profund'],1,",",".") . " cm (profundidade)"; 
	   elseif ($obra['dim_obra_profund'] == 0 and $obra['dim_obra_diametro'] > 0 and $obra['aimp_obra_diametro'] == 0 and $obra['aimp_obra_altura'] == 0)
		echo $obra[material_tecnica].", " . "&Oslash; = " . number_format($obra['dim_obra_diametro'],1,",",".") . " cm";
	   elseif ($obra['dim_obra_profund'] == 0 and $obra['dim_obra_diametro'] == 0 and $obra['aimp_obra_diametro'] == 0 and $obra['aimp_obra_altura'] == 0)
		echo $obra[material_tecnica].", " . number_format($obra['dim_obra_altura'],1,",",".") . " x " . number_format($obra['dim_obra_largura'],1,",",".") . " cm"; 
	   elseif ($obra['dim_obra_profund'] == 0 and $obra['dim_obra_diametro'] == 0 and $obra['aimp_obra_diametro'] == 0 and $obra['aimp_obra_altura'] > 0)
		echo $obra[material_tecnica].", " . number_format($obra['aimp_obra_altura'],1,",",".") . " x " . number_format($obra['aimp_obra_largura'],1,",",".") . " cm (área impressa); ". number_format($obra['dim_obra_altura'],1,",",".") . " x " . number_format($obra['dim_obra_largura'],1,",",".") . " cm (suporte)"; 
	   elseif ($obra['dim_obra_profund'] == 0 and $obra['dim_obra_diametro'] > 0 and $obra['aimp_obra_diametro'] > 0 and $obra['aimp_obra_altura'] == 0)
		echo $obra[material_tecnica].", " . "&Oslash; = " . number_format($obra['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". "&Oslash; = " . number_format($obra['dim_obra_diametro'],1,",",".") . " cm (suporte)"; 
	   elseif ($obra['dim_obra_profund'] == 0 and $obra['dim_obra_diametro'] == 0 and $obra['aimp_obra_diametro'] > 0 and $obra['aimp_obra_altura'] == 0)
		echo $obra[material_tecnica].", " . "&Oslash; = " . number_format($obra['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". number_format($obra['dim_obra_altura'],1,",",".") . " x " . number_format($obra['dim_obra_largura'],1,",",".") . " cm (suporte)"; 
	   elseif ($obra['dim_obra_profund'] == 0 and $obra['dim_obra_diametro'] > 0 and $obra['aimp_obra_diametro'] == 0 and $obra['aimp_obra_altura'] > 0)
		echo $obra[material_tecnica].", " . number_format($obra['aimp_obra_altura'],1,",",".") . " x " . number_format($obra['aimp_obra_largura'],1,",",".") . " cm (área impressa); ". "&Oslash; = " . number_format($obra['dim_obra_diametro'],1,",",".") . " cm (suporte)" ; 
           else 
		echo $obra[material_tecnica].", (ERRO - verificar dimensões na ficha técnica)"; 

	?>
		</td>
	</tr>
  <tr> 
    <td colspan="2">&nbsp;</td>
  </tr>
  <? if ($_REQUEST['pTipo']=='EE' || $_REQUEST['pTipo']=='EI') { ?>
  <tr> 
    <td height="20" colspan="2"><b><? echo $expo['nome']; ?></b> - <? echo $expo['instituicao']; ?> 
      - <? echo $expo['cidade']; ?></td>
  </tr>
  <?
	$dtini= explode("-", $expo['dt_inicial']);
	$dia=$dtini[2]; $mes=$dtini[1]; $ano=$dtini[0];
	$dtini= $dia."/".$mes."/".$ano;
	if ($dtini == '00/00/0000')
		$dtini= '';
	
	$dtfim= explode("-", $expo['dt_final']);
	$dia=$dtfim[2]; $mes=$dtfim[1]; $ano=$dtfim[0];
	$dtfim= $dia."/".$mes."/".$ano;
	if ($dtfim == '00/00/0000')
		$dtfim= '';
  ?>
  <tr> 
    <td height="20" colspan="2">Início: <? echo $dtini; ?>&nbsp;&nbsp;&nbsp;&nbsp;Fim: <? echo $dtfim; ?><br></td>
  </tr>
  <tr> 
    <td height="20" colspan="2">Período: <? echo $expo['periodo']; ?></td>
  </tr>
  <? } ?>
  <? if ($_REQUEST['pTipo'] == 'LE') { ?>
  <tr> 
    <td height="20" colspan="2"><? echo $_REQUEST['local']; ?></td>
  </tr>
  <tr> 
    <td height="20" colspan="2"><? echo $_REQUEST['fim']; ?></td>
  </tr>
  <? } ?>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="3">Data de retirada: ______/______/________</td>
  </tr>
	  <tr> 
    	<td height="20" colspan="3" style="border: 1px solid #ABABAB; border-bottom-width: 0px;">&nbsp;&nbsp;Local: </td>
	  </tr>
	  <tr> 
    	<td height="20" colspan="3" style="border-left: 1px solid #ABABAB; border-right: 1px solid #ABABAB;">&nbsp;&nbsp;Data da chegada: ______/______/________</td>
	  </tr>
	  <tr> 
    	
    <td height="125" colspan="3" style="border-left: 1px solid #ABABAB; border-right: 1px solid #ABABAB;">&nbsp;&nbsp;Condições 
      da obra: <br>
      <br><br><br><br><br><br></td>
	  </tr>
	  <tr> 
    	<td style="border-left: 1px solid #ABABAB;">&nbsp;&nbsp;___________________________________________</td>
    	<td colspan="2" align="right" style="border-right: 1px solid #ABABAB;">___________________________________________&nbsp;&nbsp;</td>
	  </tr>
	  <tr> 
    	<td style="border-left: 1px solid #ABABAB;">&nbsp;&nbsp;<sup>Técnico - MNBA</sup></td>
    	<td colspan="2" style="border-right: 1px solid #ABABAB;">&nbsp;&nbsp;<sup>Técnico da Instituição</sup></td>
	  </tr>
	  <tr> 
	    <td height="20" colspan="3" style="border-left: 1px solid #ABABAB; border-right: 1px solid #ABABAB;">&nbsp;</td>
	  </tr>
	  <tr> 
    	<td height="20" colspan="3" style="border-left: 1px solid #ABABAB; border-right: 1px solid #ABABAB;">&nbsp;&nbsp;Data de saída: ______/______/________</td>
	  </tr>
	  <tr> 
    	
    <td height="121" colspan="3" style="border-left: 1px solid #ABABAB; border-right: 1px solid #ABABAB;">&nbsp;&nbsp;Condições 
      da obra: <br>
      <br><br><br><br><br><br></td>
	  </tr>
	  <tr> 
    	<td style="border-left: 1px solid #ABABAB;">&nbsp;&nbsp;___________________________________________</td>
    	<td colspan="2" align="right" style="border-right: 1px solid #ABABAB;">___________________________________________&nbsp;&nbsp;</td>
	  </tr>
	  <tr> 
    	<td style="border-left: 1px solid #ABABAB; border-bottom: 1px solid #ABABAB;">&nbsp;&nbsp;<sup>Técnico - MNBA</sup></td>
    	<td colspan="2" style="border-right: 1px solid #ABABAB; border-bottom: 1px solid #ABABAB;">&nbsp;&nbsp;<sup>Técnico da Instituição</sup></td>
	  </tr>
  <? if ($j==($num_expo-1)) { ?>
	  <tr> 
	    <td height="22" colspan="3" valign="bottom">Data de chegada - MNBA: ______/______/________</td>
	  </tr>
	  <tr> 
    	<td colspan="3">Condições da obra:</td></tr>
  <? } ?>
	<tr>
    <td height="139" colspan=3> <br>
      <br><br><br><br><br><br></td>
	  </tr>
	  <tr> 
    	<td colspan="3" align="center">___________________________________________</td>
	  </tr>
	  <tr> 
    	<td colspan="3" align="center"><sup>Técnico - MNBA</sup></td>
	  </tr>
	  <tr class="noscreen"> 
	    
    <td height="15" colspan="3">&nbsp;</td>
	  </tr>


  <tr class="noscreen"> <td colspan="3" align="center" style="border-top: 1px solid #ABABAB; font-size: 11px;"><b><?echo $museu[nome]?></b></td></tr>
  <tr class="noscreen"> <td colspan="3" align="center" style=" font-size: 10px;"><sub><?echo $museu[endereco]?>, <?echo $museu[numero]?> - <?echo $museu[bairro]?> <?echo $museu[cep]?> <?echo $museu[cidade]?> <?echo $museu[uf]?> 
   Tel.: (<? echo $museu[ddd];?>) <?echo $museu[tel];?>  ( <?echo $museu[ddd];?>)  <?echo $museu[tel2];?>
 - Fax: (<?echo $museu[ddd]?>) <?echo $museu[fax];?></sub></td></tr>
  <tr class="noscreen"> <td colspan="3" align="center" style=" font-size: 11px;"><b><?echo $museu[internet]?></b></td> </tr>
    <tr class="noprint"> 
    <td colspan="3" align="center" nowrap><br>
      - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <sub>X</sub> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</td>
  </tr>  
       <tr> 
         <td colspan="3" style="page-break-after: always;"></td>
       </tr>



  <? if ($j==($num_expo-1)) { ?>



  <?

   
   	$sql2="SELECT b.nome_arquivo,b.diretorio_imagem from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
		AND a.obra = '$obra[obra]' order by a.eh_img_laudo desc, a.eh_principal desc";
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
		//100 é a altura max da área de exibição da imagem pequena; 150 é a largura máxima.//
		$num_alt= 100;
		$num_lar= 150;
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

		$Ao2= $height;
		$Lo2= $width;
		//390 é a altura max da área de exibição da imagem grande; 520 é a largura máxima.//
		$num_alt= 390;
		$num_lar= 520;
		$cA= $Ao2 / $num_alt;
		$cL= $Lo2 / $num_lar;

		if ($Ao2 > $num_alt || $Lo2 > $num_lar) {
			if (cL < cA) {
				$percent= ($num_lar * 100) / $Lo2;
				$Lo2= $num_lar;
				$Ao2= ($Ao2 * $percent) / 100;
				if ($Ao2 > $num_alt) {
					$percent= ($num_alt * 100) / $Ao2;
					$Ao2= $num_alt;
					$Lo2= ($Lo2 * $percent) / 100;
				}
			} else {
				$percent= ($num_alt * 100) / $Ao2;
				$Ao2= $num_alt;
				$Lo2= ($Lo2 * $percent) / 100;
				if ($Lo2 > $num_lar) {
					$percent= ($num_lar * 100) / $Lo2;
					$Lo2= $num_lar;
					$Ao2= ($Ao2 * $percent) / 100;
				}
			}
		}

	} else {
		// imagem não disponível
		$Ao= 80;
		$Lo= 80;
		$Ao2= 160;
		$Lo2= 160;
	}
	
	
	?>

   <tr> 
    <td colspan="3" align="center" style="border-bottom: 1px solid #ABABAB;"><b><? echo $museu[nome]?></b></td>
  </tr>

  <tr> <td colspan="3" align="center" ><b>Laudo de Vistoria</b></td></tr>
  <tr> 
    <td width="80%" colspan="2">&nbsp;</td>
    <td align="right"><? echo $obra['num_registro']; ?>&nbsp;</td>
  </tr>
    <tr> 
    <td colspan="3" align="center" style="border-bottom: 1px solid black;"><br>
      Empréstimo de Obras do acervo </td>
  </tr>
  <tr> 
    <td colspan="3" align="center" style="border-bottom: 1px solid black;"><br>
      Condições da Obra </td>
  </tr>
  <tr> 
    <td height="663" colspan="3" align="center" valign="middle"><img src="<? echo $dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao2; ?>" width="<? echo $Lo2; ?>"></td>
  </tr>
  <tr> 
    <td height="100" colspan="3">&nbsp;</td>
  </tr>
	  <tr> 
    	<td>Data da vistoria: ______/______/________</td>
    	<td colspan="2" align="right">___________________________________________</td>
	  </tr>
	  <tr> 
    	<td><sup>&nbsp;</sup></td>
    	<td colspan="2" align="center"><sup>Técnico Responsável - MNBA</sup></td>
	  </tr>
  <tr> 
    <td height="40" colspan="3">&nbsp;</td>
  </tr>
  <tr> <td colspan="3" align="center" style="border-top: 1px solid #ABABAB; font-size: 11px;"><b><?echo $museu[nome]?></b></td></tr>
  <tr> <td colspan="3" align="center" style=" font-size: 10px;"><sub><?echo $museu[endereco]?>, <?echo $museu[numero]?> - <?echo $museu[bairro]?> <?echo $museu[cep]?> <?echo $museu[cidade]?> <?echo $museu[uf]?> 
   Tel.: (<? echo $museu[ddd];?>) <?echo $museu[tel];?>  ( <?echo $museu[ddd];?>)  <?echo $museu[tel2];?>
 - Fax: (<?echo $museu[ddd]?>) <?echo $museu[fax];?></sub></td></tr>
  <tr> <td colspan="3" align="center" style=" font-size: 11px;"><b><?echo $museu[internet]?></b></td> </tr>

  <tr class="noprint"> 
    <td colspan="3" align="center" nowrap><br>
      - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <sub>X</sub> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</td>
  </tr>  

</table>

<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0" class="texto">

 <? } ?>



  
      <? } ?>


<!--
  <tr class="noprint"> 
    <td colspan="3" align="center" nowrap><br>
      - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <sub>X</sub> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</td>
  </tr>

-->
    <? } ?>
	

<table>
  <tr class="noprint">
    <td colspan="3" align="center"><br><br><input type="button" name="imprimir" value=" Imprimir " onClick="window.print();"><br><br><br></td>
  </tr>
</table>


<!-- PAGINA 2 -->
</body>
</html>
