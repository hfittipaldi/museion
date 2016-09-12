<? include_once("seguranca.php");
?>
<html>
<head>
<title>Untitled Document</title>
</head>
<? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");

$db=new conexao();
$db->conecta();

$db3=new conexao();
$db3->conecta();

$dir= diretorio_fisico();
$dir_virtual= diretorio_virtual();
		
echo "<table width='100%' height='100%'  border='1' cellpadding='0' cellspacing='6' bgcolor='#f2f2f2'><tr class='texto'>";
 
$sql="SELECT a.nome_arquivo,a.diretorio_imagem,a.forma_exibicao,b.eh_principal from fotografia as a, fotografia_obra as b 
					   where a.fotografia = b.fotografia AND b.obra = '$_REQUEST[img1]' order by b.eh_principal desc";

$db3->query($sql);
$dim= $db3->dados();
$principal= $dim['eh_principal'];
$forma_exibicao= $dim['forma_exibicao'];
$altu= number_format($row['dim_obra_altura'],1,",",".");
$larg= number_format($row['dim_obra_largura'],1,",",".");
$diam= number_format($row['dim_obra_diametro'],1,",",".");
$prof= number_format($row['dim_obra_profund'],1,",",".");
if ($altu == '0,0')
	$altu= '';
if ($larg == '0,0')
	$larg= '';
if ($diam == '0,0')
	$diam= '';
if ($prof == '0,0')
	$prof= '';
$aimp_altu= number_format($row['aimp_obra_altura'],1,",",".");
$aimp_larg= number_format($row['aimp_obra_largura'],1,",",".");
$aimp_diam= number_format($row['aimp_obra_diametro'],1,",",".");
$imagem= '';
if ($dim['nome_arquivo'] <> '') {
	$imagem= $dim['nome_arquivo'];
	$diretorio_imagem=$dim['diretorio_imagem'];
	 $sql="SELECT url from diretorio_imagem where diretorio_imagem='$diretorio_imagem'";
	 $db3->query($sql);
	 $url=$db3->dados();
	 $noimage= '';
	 if (file_exists($dir.$url[0].'\\'.$imagem)) {
		list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
		$Ao= $height;
		$Lo= $width;
		//150 é a altura max da área de exibição da imagem; 150 é a largura máxima.//
		$cA= $Ao / 150;
		$cL= $Lo / 150;
		if ($Ao > 150 || $Lo > 150) {
			if (cL < cA) {
				$percent= (150 * 100) / $Lo;
				$Lo= 200;
				$Ao= ($Ao * $percent) / 100;
				if ($Ao > 150) {
					$percent= (150 * 100) / $Ao;
					$Ao= 150;
					$Lo= ($Lo * $percent) / 100;
				} else {
					$percent= (150 * 100) / $Ao;
					$Ao= 150;
					$Lo= ($Lo * $percent) / 100;
					if ($Lo > 150) {
						$percent= (150 * 100) / $Lo;
						$Lo= 150;
						$Ao= ($Ao * $percent) / 100;
					}
				}
			}
		} else {
			$noimage= "<br>Arquivo não encontrado no servidor";
                }
	}

}

echo "<table border=1><tr><td>";

?>

            <? if ($imagem<>'' && $noimage=='') { ?>
			<td width="50%" valign="middle" align="center" nowrap class="texto"><img src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'></a></td>
            <? } else { 
			echo "<td width='50%' class='texto' align='center' valign='middle' nowrap style='border: 1px dashed #ABABAB; color:#444444;'><sup>Imagem não disponível</sup></td>";
		   } ?> 


<?

$sql="SELECT a.nome_arquivo,a.diretorio_imagem,a.forma_exibicao,b.eh_principal from fotografia as a, fotografia_obra as b 
					   where a.fotografia = b.fotografia AND b.obra = '$_REQUEST[img2]' order by b.eh_principal desc";

$db3->query($sql);
$dim= $db3->dados();
$principal= $dim['eh_principal'];
$forma_exibicao= $dim['forma_exibicao'];
$altu= number_format($row['dim_obra_altura'],1,",",".");
$larg= number_format($row['dim_obra_largura'],1,",",".");
$diam= number_format($row['dim_obra_diametro'],1,",",".");
$prof= number_format($row['dim_obra_profund'],1,",",".");
if ($altu == '0,0')
	$altu= '';
if ($larg == '0,0')
	$larg= '';
if ($diam == '0,0')
	$diam= '';
if ($prof == '0,0')
	$prof= '';
$aimp_altu= number_format($row['aimp_obra_altura'],1,",",".");
$aimp_larg= number_format($row['aimp_obra_largura'],1,",",".");
$aimp_diam= number_format($row['aimp_obra_diametro'],1,",",".");
$imagem= '';
if ($dim['nome_arquivo'] <> '') {
	$imagem= $dim['nome_arquivo'];
	$diretorio_imagem=$dim['diretorio_imagem'];
	 $sql="SELECT url from diretorio_imagem where diretorio_imagem='$diretorio_imagem'";
	 $db3->query($sql);
	 $url=$db3->dados();
	 $noimage= '';
	 if (file_exists($dir.$url[0].'\\'.$imagem)) {
		list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
		$Ao= $height;
		$Lo= $width;
		//150 é a altura max da área de exibição da imagem; 150 é a largura máxima.//
		$cA= $Ao / 150;
		$cL= $Lo / 150;
		if ($Ao > 150 || $Lo > 150) {
			if (cL < cA) {
				$percent= (150 * 100) / $Lo;
				$Lo= 200;
				$Ao= ($Ao * $percent) / 100;
				if ($Ao > 150) {
					$percent= (150 * 100) / $Ao;
					$Ao= 150;
					$Lo= ($Lo * $percent) / 100;
				} else {
					$percent= (150 * 100) / $Ao;
					$Ao= 150;
					$Lo= ($Lo * $percent) / 100;
					if ($Lo > 150) {
						$percent= (150 * 100) / $Lo;
						$Lo= 150;
						$Ao= ($Ao * $percent) / 100;
					}
				}
			}
		} else {
			$noimage= "<br>Arquivo não encontrado no servidor";
                }
	}

}


?>
 
            <? if ($imagem<>'' && $noimage=='') { ?>
            		<td width="50%" valign="middle" align="center" nowrap class="texto"><img src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'></a></td>
            <? } else { 
			echo "<td width='50%' class='texto' align='center' valign='middle' nowrap style='border: 1px dashed #ABABAB; color:#444444;'><sup>Imagem não disponível</sup></td>";
		   } ?> 

<?
echo "</td></tr></table>";
?>
</html>