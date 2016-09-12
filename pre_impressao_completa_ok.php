<? 
    include_once("seguranca.php")
?>
<html>
<head>
<title>Impressão de obras</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<? 
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
	$dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();
function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	elseif ($valor == 0)
		return "&nbsp;&nbsp;&nbsp;";
	else
		return $valor;
}
		  

$op=$_REQUEST[op];
$obra=$_REQUEST[obra];
 if(isset($_REQUEST[obra]))
 {
  if($op=='view')
   {
    $sql="SELECT a.* from parte as a where a.obra='$_REQUEST[obra]' and parte='$_REQUEST[parte]'";
	$db->query($sql);
    $res=$db->dados();
//data
/*		$datacao= $res['data'];
		$datacao_extra1= $res['data_extra1'];
		$dt_extra2= $res['data_extra2'];
		dtformato_externo($datacao, $datacao_extra1, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
		$dt_dia= $data['dia'];
		$dt_mes= $data['mes'];
		$dt_ano= $data['ano'];
		$dt_extra1= $data['ano2'];*/
		$dt_dia= $res['dt_parte_dia'];
		$dt_mes= $res['dt_parte_mes'];
		$dt_ano= $res['dt_parte_ano1'];
		$dt_extra1= $res['dt_parte_ano2'];
		$dt_extra2= $res['data_extra2'];
		$transc_ass= $res['transc_assinatura'];

//
	}
}

function ret_colecao_obra($obrid)
{
 global $db2;
 $sql="SELECT nome from colecao as a, obra as b where a.colecao=b.colecao AND b.obra='$obrid'";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
}
function ret_museu($obrid)
{
 global $db2;
 $sql="SELECT nome from museu as a, obra as b where a.museu=b.museu AND b.obra='$obrid'";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
}
function ret_data_obra($obrid)
{
 global $db2;
 $sql="SELECT dt_parte_ano1,dt_parte_ano2,dt_parte_tp from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0]."|".$res[1]."|".$res[2];
}
function ret_dim_parte($obrid)
{
 global $db2;
 $sql="SELECT dim_mold_possui,dim_base_possui,dim_mold_altura,dim_mold_largura,dim_base_altura,dim_base_largura 
		from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['dim_base_possui'] == 'S') {
	$altura= $res['dim_base_altura'];
	$largura= $res['dim_base_largura'];
	$tipo= "base";
 }
 else {
	$altura= $res['dim_mold_altura'];
	$largura= $res['dim_mold_largura'];
	$tipo= "moldura";
 }
 return number_format($altura,1,",",".") . " x " . number_format($largura,1,",",".") . " cm (".$tipo.")";
}



function temas_obra($obrid)
{
 global $db2;
 $sql="SELECT a.nome FROM tema AS a INNER JOIN tema_obra AS b, obra AS c 
 WHERE (b.obra = c.obra and b.tema=a.tema) AND b.obra = '$obra'";
 $db2->query($sql);
 while($temas=$db->dados())
 {
  $t[]=$temas[0];
 }
 $tot=count($t);
 for($i=0;$i<=$tot;$i++){
 $tema.=$t[$i];
 if($i<$tot-1)
   {
    $tema.=',';
    }
 return $tema;
 }
}

function parte_ass($obrid)
{
 global $db2;
 $sql="SELECT assinada,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['assinada'] == 'S') {
	$ass= "assinada <em>(".$res['transc_assinatura'].")</em>";
 }
 else {
	$ass= "sem assinatura";
 }
 return $ass;
}


function ret_aquisicao($sigla)
{
 global $db2;
 $sql="SELECT nome from forma_aquisicao where forma_aquisicao = '$sigla'";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
}
function percente_obras($marcadas)
{
 global $db;
 $sql="SELECT count(*) from obra where status = 'P'";
 $db->query($sql);
 $res=$db->dados();
 $tot= $res[0];
 $percent= ($marcadas * 100) / $tot;
 return number_format($percent,2,",",".");
}

	$id_obras= $_SESSION['s_impressao'];
	$id_obras= substr($id_obras,1);

	if ($id_obras == '')
		$id_obras= 0;

	$sql= "SELECT * from obra where obra in ($id_obras) order by num_registro + 0";
	$db->query($sql);
?>
<body>
<? if ($_POST['modelo'] == 0) { ?>
<form name="pega_modelo" method="post">
	<input type="hidden" name="modelo" value="">
	<script>
		if (window.opener.document.getElementById('modelo1').checked)
			document.pega_modelo.modelo.value= '1';
		else if (window.opener.document.getElementById('modelo2').checked)
			document.pega_modelo.modelo.value= '2';
		else if (window.opener.document.getElementById('modelo3').checked)
			document.pega_modelo.modelo.value= '3';
		else if (window.opener.document.getElementById('modelo4').checked)
			document.pega_modelo.modelo.value= '4';
		else if (window.opener.document.getElementById('modelo5').checked)
			document.pega_modelo.modelo.value= '5';

		document.pega_modelo.submit();
	</script>
</form>
<? } ?>
<p align="left"> <font style="font-family:times new roman,arial; font-size:32px;"><em>S</em></font><font style="font-family:times new roman,arial; font-size:14px;">imba</font><font face="Arial, Helvetica, sans-serif"> 
  - <font size="3">Ficha catalográfica</font></font> 
<table width="95%"  border="0">
        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>

      <? 
	   while($row=$db->dados()) { 
			
			$sql= "SELECT a.* from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' order by b.hierarquia";
			$db2->query($sql);
			$autor=$db2->dados();
			$obraID=$row[obra];
                        $seguro=$row[val_seguro];
			$dim_obra_formato=$row['dim_obra_formato'];
			$forma_aquisicao=$row['forma_aquisicao'];



	?>
  <tr>


    <td width="80%"><ol>
        <font face="Arial, Helvetica, sans-serif" size="+1"><? echo $autor[nomeetiqueta]; ?></font><br>
        <?     
			        $nasc='';
					$sql= "SELECT nome from pais where pais = '$autor[pais_nasc]'";
					$db2->query($sql);
					$pais= $db2->dados();
					$pais= $pais['nome'];
					if (strtoupper($pais) == 'BRASIL') {
						$sql= "SELECT uf from estado where estado = '$autor[estado_nasc]'";
						$db2->query($sql);
						$estado= $db2->dados();
						$estado= ", ".$estado['uf'];
						$nasc.= $autor[cidade_nasc].$estado." ";
					}
					else {
						if ($autor[cidade_nasc]=='?' && $pais=='?')
							$nasc.= "? ";
						elseif ($row[cidade_nasc]==''&& $pais=='')
							$nasc.= "";
						else
							$nasc.= $autor[cidade_nasc].", ".$pais." ";
					}

					if ($autor[dt_nasc_tp] == 'circa')
						$nasc.= " circa ";

					if ($autor[dt_nasc_ano1] <> '0') {
						$nasc.= $autor[dt_nasc_ano1];
					}
					if ($autor[dt_nasc_ano2] <> '0') {
						if ($autor[dt_nasc_ano2] <> $autor[dt_nasc_ano1])
							$nasc.= " / ".$autor[dt_nasc_ano2];
					}

					if ($autor[dt_nasc_tp] == '?')
						$nasc.=" (?) ";
					echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;'><em>".$nasc."</em></font>";

			        $mort='';
					if ($autor[cidade_nasc] <> $autor[cidade_morte]) {
						$sql= "SELECT nome from pais where pais = '$autor[pais_morte]'";
						$db2->query($sql);
						$pais= $db2->dados();
						$pais= $pais['nome'];
						if (strtoupper($pais) == 'BRASIL') {
							$sql= "SELECT uf from estado where estado = '$autor[estado_morte]'";
							$db2->query($sql);
							$estado= $db2->dados();
							$estado= ", ".$estado['uf'];
							$mort.= $autor[cidade_morte].$estado." ";
						}
						else {
							if ($autor[cidade_morte]=='?' && $pais=='?')
								$mort.= "? ";
							else
								$mort.= $autor[cidade_morte].", ".$pais." ";
						}
					}

					if ($autor[dt_morte_tp] == 'circa')
						$mort.= " circa ";

					if ($autor[dt_morte_ano1] <> '0') {
						$mort.= $autor[dt_morte_ano1];
					}
					if ($autor[dt_morte_ano2] <> '0') {
						if ($autor[dt_morte_ano2] <> $autor[dt_morte_ano1])
							$mort.= " / ".$autor[dt_morte_ano2];
					}

					if ($autor[dt_morte_tp] == '?')
						$mort.=" (?) ";

					if (strlen($mort) > 3)
						echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;'> - <em>" . $mort . "</em></font>";
				?>
        <br>
        <font style="font-size:10px;"><br>
        </font><font style="font-family:arial,times new roman; font-weight:normal; font-size:12px;"><em><? echo ret_colecao_obra($row[obra]); ?></em></font> 
        </font>
        <br>
        <? echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;'>" ?><b><? echo $row[num_registro]; ?>
        <? if ($row['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;(destaque do acervo)</font>"; ?>
        </b> <font style="font-size:8px;"><br>
        </font><font style='font-family:arial,times new roman; font-weight:normal; font-size:12px;'><b><? echo $row[titulo_etiq];?></b> 
        <?
					$dataqui='';
					if ($row['dt_aquisicao_tp'] == 'circa')
						$dataqui.= " circa ";

					if ($row['dt_aquisicao_ano1'] <> '0') {
						$dataqui.= $row['dt_aquisicao_ano1'];
					}
					if ($row['dt_aquisicao_ano2'] <> '0') {
						if ($row['dt_aquisicao_ano2'] <> $row['dt_aquisicao_ano1'])
							$dataqui.= " / ".$row['dt_aquisicao_ano2'];
					}

					if ($row['dt_aquisicao_tp'] == '?')
						$dataqui.=" (?) ";

					$aquisicao= strtolower(ret_aquisicao($row[forma_aquisicao]));
					if ($row[periodo] <> '')
						echo ', '.$row[periodo];
					else
					$p_datas= ret_data_obra($row['obra']);
					$p_datas= explode("|",$p_datas);
					$p_data= $p_datas[0];
					$p_data_extra1= $p_datas[1];
					$p_data_extra2= $p_datas[2];

					$dat= '';
					if ($p_data_extra2 == 'circa')
						$dat.= " circa ";

					if ($p_data <> '0') {
						$dat.= $p_data;
					}
					if ($p_data_extra1 <> '0') {
						if ($p_data_extra1 <> $p_data)
							$dat.= " / ".$p_data_extra1;
					}

					if ($p_data_extra2 == '?')
						$dat.=" (?) ";

					if (strlen($dat) > 3)
						echo ", " . $dat;

				?>
        <br>
        <? if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",","."). " x " . number_format($row['dim_obra_profund'],1,",",".") . " cm"; 
	   elseif ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", ". "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm ; " . number_format($row['dim_obra_profund'],1,",",".") . " cm (profundidade)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm";
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",",".") . " cm"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm (área impressa); ". number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",",".") . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . number_format($row['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . number_format($row['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". number_format($row['dim_obra_altura'],1,",",".") . " x " . number_format($row['dim_obra_largura'],1,",",".") . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm (área impressa); ". "&Oslash; = " . number_format($row['dim_obra_diametro'],1,",",".") . " cm (suporte)" ; 
           else 
		echo $row[material_tecnica].", (ERRO - verificar dimensões na ficha técnica)"; 

	?>
        <!--<br>fotografia, <? /*echo number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm(área impressa); " . ret_dim_parte($row['obra']); */ ?>-->
        <br>
        <? 
		echo parte_ass($row['obra']);
					
		if ($aquisicao == '')
			$aquisicao= 'procedência desconhecida';
			echo "<br>".$aquisicao . ", " . $row['doador'];
		if (strlen($dataqui) > 3)
			echo ", " . $dataqui;

	?>
        <br>
	</li>
        </ol></td>

 <?
    global $db2;
	$sql2="SELECT b.nome_arquivo,b.diretorio_imagem from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
		AND a.obra = ".$obraID." order by  a.eh_principal desc, a.eh_img_laudo desc";
	$db4->query($sql2);
	$imagem=$db4->dados();
	$arquivo= $imagem['nome_arquivo'];
	$dir_img= $imagem['diretorio_imagem'];

	if ($arquivo == '')
		$arquivo= 'não tem imagem';

	if ($dir_img <> '') {
		$sql2="SELECT url from diretorio_imagem where diretorio_imagem = '$dir_img'";
		$db4->query($sql2);
		$url=$db4->dados();
		$url= $url['url'];
	}

	if (file_exists($dir.$url.'\\'.$arquivo)) {
		list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url.'/'.$arquivo);
		$Ao= $height;
		$Lo= $width;
		//100 é a altura max da área de exibição da imagem pequena; 150 é a largura máxima.//
		$num_alt= 150;
		$num_lar= 200;
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
	
	
  <td width="20%" valign="top" align="right"><img src="<? echo 'http://'.$_SERVER[SERVER_ADDR].'/donato/'.$dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao; ?>" width="<? echo $Lo; ?>"></img></td>
  </tr>
        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>
        <tr> 
          
     <td height="10" colspan="2">
      <? 
					if($row['status'] == 'C') echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><b><em>( FICHA EM CATALOGAÇÃO )</em></b><br><br></span>"; 
					elseif($row['status'] == 'P') echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><b><em>( FICHA PUBLICADA )</em></b><br><br></span>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'>Nº de registro: <b>" . $row['num_registro']." ". "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Destaque do acervo?: ";
					if($row['eh_destaque_acervo'] == 'S') echo "<span class='texto'><b>SIM</b></span>"; 
					   elseif($row['eh_destaque_acervo'] == 'N') echo "<span class='texto'><b>NÃO</b></span>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br><br>Nº de inventário: <b>" . $row['inventario']." ". $row['controle_inv'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Coleção: <b>" . ret_colecao_obra($row[obra]) . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Museu: <b>" . ret_museu($row[obra]) . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Nome do objeto: <b>" . $row['objeto'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Título/Título da série: <b>" . $row['titulo'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Nº da série: <b>" . $row['num_serie'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Título em inglês: <b>" . $row['titulo_ingles'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Título para etiqueta: <b>" . $row['titulo_etiq'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Cópia: <b>" . $row['copia'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Período: <b>" . $row['periodo'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Impressor/Fundição/Fabricante: <b>" . $row['impressor'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Editor: <b>" . $row['editor'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Nº de edição: <b>" . $row['num_edicao'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Material/técnica: <b>" . $row['material_tecnica'] . "</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br><em> - Dimensões -</em><br>Altura: <b>" . $row['dim_obra_altura'] ."</b> cm - Largura: <b>". $row['dim_obra_largura']."</b> cm - Diâmetro: <b>". $row['dim_obra_diametro'] . "</b> cm - Profundidade: <b>". $row['dim_obra_profund'] ."</b> cm";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Peso: <b>" . $row['dim_obra_peso'] ."</b> kg - Formato: <b>";
					if($dim_obra_formato=='C') echo "<span class='texto'>Circular</span></b>"; 
					   elseif($dim_obra_formato=='I') echo "<span class='texto'>Irregular</span></b>";
					   elseif($dim_obra_formato=='L') echo "<span class='texto'>Los&acirc;ngico</span></b>";
					   elseif($dim_obra_formato=='0') echo "<span class='texto'>Oval</span></b>";
					   elseif($dim_obra_formato=='T') echo "<span class='texto'>Triangular</span></b>"; 
					if ($row['aimp_obra_altura'] == 0 AND $row['aimp_obra_largura'] == 0 AND $row['aimp_obra_diametro'] == 0) {
						$area_impressa= "<br>";
					}
					else {
					if($row['aimp_obra_formato']=='C')
						$formato_area_impressa= 'Circular'; 
					   elseif($row['aimp_obra_formato']=='I')
						$formato_area_impressa= 'Irregular'; 
					   elseif($row['aimp_obra_formato']=='L')
						$formato_area_impressa= 'Losângico'; 
					   elseif($row['aimp_obra_formato']=='O')
						$formato_area_impressa= 'Oval'; 
					   elseif($row['aimp_obra_formato']=='T')
						$formato_area_impressa= 'Triangular'; 
					$area_impressa= "<br><br><em>- Dimensões da área impressa -</em><br>Altura: <b>" . $row['aimp_obra_altura'] ."</b> cm - Largura: <b>". $row['aimp_obra_largura']."</b> cm - Diâmetro: <b>". $row['aimp_obra_diametro'] ."</b> cm - Formato: <b>". $formato_area_impressa."</b><br>";					
					 }
					echo $area_impressa;

					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Descrição de conteúdo: <b>" . $row['desc_conteudo'] ."</b><br>";


					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Temas: <b>" . $tema."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Sub-temas: <b>" . $row['sub_tema'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Forma de aquisição: <b>";
					if($forma_aquisicao=='C') echo "<span class='texto'>Compra</span>"; 
					   elseif($forma_aquisicao=='D') echo "<span class='texto'>Doação</span>";
					   elseif($forma_aquisicao=='E') echo "<span class='texto'>Empréstimo/Depósito</span>";
					   elseif($forma_aquisicao=='L') echo "<span class='texto'>Legado</span>";
					   elseif($forma_aquisicao=='P') echo "<span class='texto'>Permuta</span></b>"; 
					   elseif($forma_aquisicao=='R') echo "<span class='texto'>Premiação</span></b>"; 
					   elseif($forma_aquisicao=='T') echo "<span class='texto'>Transferência</span></b>"; 
					   elseif($forma_aquisicao=='Z') echo "<span class='texto'>Outros</span></b>"; 
					   elseif($forma_aquisicao=='') echo "<span class='texto'>Sem informação</span></b>"; 
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br><br>Doador/Vendedor: <b>" . $row['doador'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Nº do processo: <b>" . $row['num_processo'] ."</b><br>";
			/*		$dt_aq_di= $row['dt_aquisicao_di']."-";
					$dt_aq_df= $row['dt_aquisicao_df'];
					$dt_aq_extra2= $row['dt_aquisicao_tp'];
					dtformato_externo($dt_aq_di, $dt_aq_df, '', $data['dia'], $data['mes'], $data['ano'], $data['ano2']);
					$dt_aqdia= $data['dia'];
					$dt_aqmes= $data['mes'];
					$dt_aqano= $data['ano'];
					$dt_aq_extra1= $data['ano2'];*/
					$dt_aqdia= $row['dt_aquisicao_dia'];
					$dt_aqmes= $row['dt_aquisicao_mes'];
					$dt_aqano= $row['dt_aquisicao_ano1'];
					$dt_aq_extra1= $row['dt_aquisicao_ano2'];
					$dt_aq_extra2= $row['dt_aquisicao_tp'];

					$dat='';
					if ($dt_aqdia > '0' and $dt_aqmes >'0' and $dt_aq_extra1 == '0000')
	           				$dat = $dt_aqdia."/".$dt_aqmes."/".$dt_aqano;
					if ($dt_aqdia == '0' and $dt_aqmes >'0' and $dt_aq_extra1 == '0000')
				           	$dat = $dt_aqmes."/".$dt_aqano;
					if ($dt_aqdia == '0' and $dt_aqmes =='0' and $dt_aq_extra1 == '0000')
						$dat = $dt_aqano;
					if ($dt_aqano == '0000' and $dt_aq_extra1 <> '0000')
				           	$dat = $dt_aq_extra1." (data no campo errado - corrigir ficha)";
					if ($dt_aqano <> '0000' and $dt_aq_extra1 <> '0000')
				           	$dat = $dt_aqano."-". $dt_aq_extra1;
					if ($dt_aq_extra2 == 'circa')
						$dat.= " (circa) ";
					if ($dt_aq_extra2 == '?')
						$dat.=" (?) ";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Data de aquisição: <b>" . $dat ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Valor de compra: <b>" . $row['val_compra'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Valor de seguro: <b>" . $row['val_seguro'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Ex-proprietários <b><br>" . $row['ex_proprietarios'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Localização fixa: <b>" . $row['local_fixo'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Trainel/Gaveta/Estante: <b>" . $row['trainel_gaveta'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Escola/Grupo cultural: <b>" . $row['escola'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Movimento: <b>" . $row['movimento'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Estilo: <b>" . $row['estilo'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Observaçôes: <br><b>" . $row['obs'] ."</b><br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br>Texto para etiqueta: <b>" . $row['texto_etiq'] ."</b><br>";


					echo "_________________________________________________________________________________________<br>";
					echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><b> PARTES</em></b><br><br>";

					$sql="SELECT b.* from parte as a inner join parte as b on (a.parte=b.parte) 
						where a.obra=$row[obra] order by b.controle asc";
					$db2->query($sql);
					$parte= "";
					$parte_ass= "";
					while ($par=$db2->dados()) {
						if ($par['assinada'] == 'S') {
							$parte_ass= "Sim";
						}
						else {
							$parte_ass= "Não";
						 }
						if ($par['assinada_onde']=='c')
							$parte_ass_onde= "centro ";
						elseif ($par['assinada_onde']=='cd')
							$parte_ass_onde= "centro à direita ";
						elseif ($par['assinada_onde']=='ce')
							$parte_ass_onde= "centro à esquerda ";
						elseif ($par['assinada_onde']=='cid')
							$parte_ass_onde= "canto inferior direito ";
						elseif ($par['assinada_onde']=='cie')
							$parte_ass_onde= "canto inferior esquerdo ";
						elseif ($par['assinada_onde']=='csd')
							$parte_ass_onde= "canto superior direito ";
						elseif ($par['assinada_onde']=='cse')
							$parte_ass_onde= "canto superior esquerdo ";
						elseif ($par['assinada_onde']=='ebc')
							$parte_ass_onde= "embaixo no centro ";
						elseif ($par['assinada_onde']=='ebd')
							$parte_ass_onde= "embaixo à direita ";
						elseif ($par['assinada_onde']=='ebe')
							$parte_ass_onde= "embaixo à esquerda ";
						elseif ($par['assinada_onde']=='ecc')
							$parte_ass_onde= "em cima no centro ";
						elseif ($par['assinada_onde']=='ecd')
							$parte_ass_onde= "em cima à direita ";
						elseif ($par['assinada_onde']=='ece')
							$parte_ass_onde= "em cima à esquerda ";
						elseif ($par['assinada_onde']=='vc')
							$parte_ass_onde= "verso, centro ";
						elseif ($par['assinada_onde']=='vcd')
							$parte_ass_onde= "verso, centro à direita ";
						elseif ($par['assinada_onde']=='vce')
							$parte_ass_onde= "verso, centro à esquerda ";
						elseif ($par['assinada_onde']=='vcid')
							$parte_ass_onde= "verso, canto inferior direito ";
						elseif ($par['assinada_onde']=='vcie')
							$parte_ass_onde= "verso, canto inferior esquerdo ";
						elseif ($par['assinada_onde']=='vcsd')
							$parte_ass_onde= "verso, canto superior direito ";
						elseif ($par['assinada_onde']=='vcse')
							$parte_ass_onde= "verso, canto superior esquerdo ";
						elseif ($par['assinada_onde']=='vebc')
							$parte_ass_onde= "verso, embaixo no centro ";
						elseif ($par['assinada_onde']=='vebd')
							$parte_ass_onde= "verso, embaixo à direita ";
						elseif ($par['assinada_onde']=='vebe')
							$parte_ass_onde= "verso, embaixo à esquerda ";
						elseif ($par['assinada_onde']=='vecc')
							$parte_ass_onde= "verso, em cima no centro ";
						elseif ($par['assinada_onde']=='vecd')
							$parte_ass_onde= "verso, em cima à direita ";
						elseif ($par['assinada_onde']=='vece')
							$parte_ass_onde= "verso, em cima à esquerda ";
						else
							$parte_ass_onde= " ";
						if ($par['marcada'] == 'S') {
							$parte_marca= "Sim";
						}
						else {
							$parte_marca= "Não";
						 }
						if ($par['marcada_onde']=='c')
							$parte_marca_onde= "centro ";
						elseif ($par['marcada_onde']=='cd')
							$parte_marca_onde= "centro à direita ";
						elseif ($par['marcada_onde']=='ce')
							$parte_marca_onde= "centro à esquerda ";
						elseif ($par['marcada_onde']=='cid')
							$parte_marca_onde= "canto inferior direito ";
						elseif ($par['marcada_onde']=='cie')
							$parte_marca_onde= "canto inferior esquerdo ";
						elseif ($par['marcada_onde']=='csd')
							$parte_marca_onde= "canto superior direito ";
						elseif ($par['marcada_onde']=='cse')
							$parte_marca_onde= "canto superior esquerdo ";
						elseif ($par['marcada_onde']=='ebc')
							$parte_marca_onde= "embaixo no centro ";
						elseif ($par['marcada_onde']=='ebd')
							$parte_marca_onde= "embaixo à direita ";
						elseif ($par['marcada_onde']=='ebe')
							$parte_marca_onde= "embaixo à esquerda ";
						elseif ($par['marcada_onde']=='ecc')
							$parte_marca_onde= "em cima no centro ";
						elseif ($par['marcada_onde']=='ecd')
							$parte_marca_onde= "em cima à direita ";
						elseif ($par['marcada_onde']=='ece')
							$parte_marca_onde= "em cima à esquerda ";
						elseif ($par['marcada_onde']=='vc')
							$parte_marca_onde= "verso, centro ";
						elseif ($par['marcada_onde']=='vcd')
							$parte_marca_onde= "verso, centro à direita ";
						elseif ($par['marcada_onde']=='vce')
							$parte_marca_onde= "verso, centro à esquerda ";
						elseif ($par['marcada_onde']=='vcid')
							$parte_marca_onde= "verso, canto inferior direito ";
						elseif ($par['marcada_onde']=='vcie')
							$parte_marca_onde= "verso, canto inferior esquerdo ";
						elseif ($par['marcada_onde']=='vcsd')
							$parte_marca_onde= "verso, canto superior direito ";
						elseif ($par['marcada_onde']=='vcse')
							$parte_marca_onde= "verso, canto superior esquerdo ";
						elseif ($par['marcada_onde']=='vebc')
							$parte_marca_onde= "verso, embaixo no centro ";
						elseif ($par['marcada_onde']=='vebd')
							$parte_marca_onde= "verso, embaixo à direita ";
						elseif ($par['marcada_onde']=='vebe')
							$parte_marca_onde= "verso, embaixo à esquerda ";
						elseif ($par['marcada_onde']=='vecc')
							$parte_marca_onde= "verso, em cima no centro ";
						elseif ($par['marcada_onde']=='vecd')
							$parte_marca_onde= "verso, em cima à direita ";
						elseif ($par['marcada_onde']=='vece')
							$parte_marca_onde= "verso, em cima à esquerda ";
						else
							$parte_marca_onde= " ";
						if ($par['datada'] == 'S') {
							$parte_data= "Sim";
						}
						else {
							$parte_data= "Não";
						 }
						if ($par['datada_onde']=='c')
							$parte_data_onde= "centro ";
						elseif ($par['datada_onde']=='cd')
							$parte_data_onde= "centro à direita ";
						elseif ($par['datada_onde']=='ce')
							$parte_data_onde= "centro à esquerda ";
						elseif ($par['datada_onde']=='cid')
							$parte_data_onde= "canto inferior direito ";
						elseif ($par['datada_onde']=='cie')
							$parte_data_onde= "canto inferior esquerdo ";
						elseif ($par['datada_onde']=='csd')
							$parte_data_onde= "canto superior direito ";
						elseif ($par['datada_onde']=='cse')
							$parte_data_onde= "canto superior esquerdo ";
						elseif ($par['datada_onde']=='ebc')
							$parte_data_onde= "embaixo no centro ";
						elseif ($par['datada_onde']=='ebd')
							$parte_data_onde= "embaixo à direita ";
						elseif ($par['datada_onde']=='ebe')
							$parte_data_onde= "embaixo à esquerda ";
						elseif ($par['datada_onde']=='ecc')
							$parte_data_onde= "em cima no centro ";
						elseif ($par['datada_onde']=='ecd')
							$parte_data_onde= "em cima à direita ";
						elseif ($par['datada_onde']=='ece')
							$parte_data_onde= "em cima à esquerda ";
						elseif ($par['datada_onde']=='vc')
							$parte_data_onde= "verso, centro ";
						elseif ($par['datada_onde']=='vcd')
							$parte_data_onde= "verso, centro à direita ";
						elseif ($par['datada_onde']=='vce')
							$parte_data_onde= "verso, centro à esquerda ";
						elseif ($par['datada_onde']=='vcid')
							$parte_data_onde= "verso, canto inferior direito ";
						elseif ($par['datada_onde']=='vcie')
							$parte_data_onde= "verso, canto inferior esquerdo ";
						elseif ($par['datada_onde']=='vcsd')
							$parte_data_onde= "verso, canto superior direito ";
						elseif ($par['datada_onde']=='vcse')
							$parte_data_onde= "verso, canto superior esquerdo ";
						elseif ($par['datada_onde']=='vebc')
							$parte_data_onde= "verso, embaixo no centro ";
						elseif ($par['datada_onde']=='vebd')
							$parte_data_onde= "verso, embaixo à direita ";
						elseif ($par['datada_onde']=='vebe')
							$parte_data_onde= "verso, embaixo à esquerda ";
						elseif ($par['datada_onde']=='vecc')
							$parte_data_onde= "verso, em cima no centro ";
						elseif ($par['datada_onde']=='vecd')
							$parte_data_onde= "verso, em cima à direita ";
						elseif ($par['datada_onde']=='vece')
							$parte_data_onde= "verso, em cima à esquerda ";
						else
							$parte_data_onde= " ";
						$pt_data = $par['dt_parte_dia']."/".$par['dt_parte_mes']."/".$par['dt_parte_ano1']." - ".$par['dt_parte_ano2']." ( ".$par['dt_parte_tp']." )";
						if ($par['localizada'] == 'S') {
							$parte_local= "Sim";
						}
						else {
							$parte_local= "Não";
						 }
						if ($par['localizada_onde']=='c')
							$parte_local_onde= "centro ";
						elseif ($par['localizada_onde']=='cd')
							$parte_local_onde= "centro à direita ";
						elseif ($par['localizada_onde']=='ce')
							$parte_local_onde= "centro à esquerda ";
						elseif ($par['localizada_onde']=='cid')
							$parte_local_onde= "canto inferior direito ";
						elseif ($par['localizada_onde']=='cie')
							$parte_local_onde= "canto inferior esquerdo ";
						elseif ($par['localizada_onde']=='csd')
							$parte_local_onde= "canto superior direito ";
						elseif ($par['localizada_onde']=='cse')
							$parte_local_onde= "canto superior esquerdo ";
						elseif ($par['localizada_onde']=='ebc')
							$parte_local_onde= "embaixo no centro ";
						elseif ($par['localizada_onde']=='ebd')
							$parte_local_onde= "embaixo à direita ";
						elseif ($par['localizada_onde']=='ebe')
							$parte_local_onde= "embaixo à esquerda ";
						elseif ($par['localizada_onde']=='ecc')
							$parte_local_onde= "em cima no centro ";
						elseif ($par['localizada_onde']=='ecd')
							$parte_local_onde= "em cima à direita ";
						elseif ($par['localizada_onde']=='ece')
							$parte_local_onde= "em cima à esquerda ";
						elseif ($par['localizada_onde']=='vc')
							$parte_local_onde= "verso, centro ";
						elseif ($par['localizada_onde']=='vcd')
							$parte_local_onde= "verso, centro à direita ";
						elseif ($par['localizada_onde']=='vce')
							$parte_local_onde= "verso, centro à esquerda ";
						elseif ($par['localizada_onde']=='vcid')
							$parte_local_onde= "verso, canto inferior direito ";
						elseif ($par['localizada_onde']=='vcie')
							$parte_local_onde= "verso, canto inferior esquerdo ";
						elseif ($par['localizada_onde']=='vcsd')
							$parte_local_onde= "verso, canto superior direito ";
						elseif ($par['localizada_onde']=='vcse')
							$parte_local_onde= "verso, canto superior esquerdo ";
						elseif ($par['localizada_onde']=='vebc')
							$parte_local_onde= "verso, embaixo no centro ";
						elseif ($par['localizada_onde']=='vebd')
							$parte_local_onde= "verso, embaixo à direita ";
						elseif ($par['localizada_onde']=='vebe')
							$parte_local_onde= "verso, embaixo à esquerda ";
						elseif ($par['localizada_onde']=='vecc')
							$parte_local_onde= "verso, em cima no centro ";
						elseif ($par['localizada_onde']=='vecd')
							$parte_local_onde= "verso, em cima à direita ";
						elseif ($par['localizada_onde']=='vece')
							$parte_local_onde= "verso, em cima à esquerda ";
						else
							$parte_local_onde= " ";
						if ($par['estado_conserv']=='0')
							$parte_estado_conserv= "Sem informação";
						elseif ($par['estado_conserv']=='1')
							$parte_estado_conserv= "Bom";
						elseif ($par['estado_conserv']=='2')
							$parte_estado_conserv= "Razoável";
						elseif ($par['estado_conserv']=='3')
							$parte_estado_conserv= "Ruim";
						if ($par['tem_foto'] == 'S') {
							$parte_foto= "Sim";
						}
						else {
							$parte_foto= "Não";
						 }
						if ($par['tem_negativo'] == 'S') {
							$parte_neg= "Sim";
						}
						else {
							$parte_neg= "Não";
						 }
						if ($par['tem_diapositivo'] == 'S') {
							$parte_diapositivo= "Sim";
						}
						else {
							$parte_diapositivo= "Não";
						 }
						if ($par['tem_restauro'] == 'S') {
							$parte_restauro= "Sim";
						}
						else {
							$parte_restauro= "Não";
						 }
						if ($par['dim_parte_formato']=='C')
							$parte_formato= "Circular";
						elseif ($par['dim_parte_formato']=='I')
							$parte_formato= "Irregular";
						elseif ($par['dim_parte_formato']=='L')
							$parte_formato= "Logângico";
						elseif ($par['dim_parte_formato']=='O')
							$parte_formato= "Oval";
						elseif ($par['dim_parte_formato']=='T')
							$parte_formato= "Triangular";
						else
							$parte_formato= " - ";
						if ($par['dim_aimp_formato']=='C')
							$parte_aimp_formato= "Circular";
						elseif ($par['dim_aimp_formato']=='I')
							$parte_aimp_formato= "Irregular";
						elseif ($par['dim_aimp_formato']=='L')
							$parte_aimp_formato= "Logângico";
						elseif ($par['dim_aimp_formato']=='O')
							$parte_aimp_formato= "Oval";
						elseif ($par['dim_aimp_formato']=='T')
							$parte_aimp_formato= "Triangular";
						else
							$parte_aimp_formato= " - ";

						if ($par['dim_aimp_altura'] == 0 AND $par['dim_aimp_largura'] == 0 AND $par['dim_aimp_diametro'] == 0) {
							$dim_parte= "";
						}
						else {
							$dim_parte= "<em>- Dimensões da área impressa -<br></em>".
						"Altura: <b>" . $par['dim_aimp_altura']." </b>cm - Largura: <b>".$par['dim_aimp_largura']." </b>cm - Diâmetro: <b>".$par['dim_aimp_diametro']." </b>cm - Formato: <b>".$parte_aimp_formato."</b><br><br>";
						 }


						if ($par['dim_mold_possui'] == 'S') {
							$parte_mold= "<b> SIM </b><br> Altura: <b>" . $par['dim_mold_altura']." </b>cm - Largura: <b>".$par['dim_mold_largura']." </b>cm - Diâmetro: <b>".$par['dim_mold_diametro']." </b>cm - Profundidade: <b>".$par['dim_mold_profund']."</b> - Peso: <b>".$par['dim_mold_peso']." </b>kg<br>";
						}
						else {
							$parte_mold= "<b> NÃO</b><br>";
						 }
						if ($par['dim_base_possui'] == 'S') {
							$parte_base= "<b> SIM </b><br> Altura: <b>" . $par['dim_base_altura']." </b>cm - Largura: <b>".$par['dim_base_largura']." </b>cm - Diâmetro: <b>".$par['dim_base_diametro']." </b>cm - Profundidade: <b>".$par['dim_base_profund']."</b> - Peso: <b>".$par['dim_base_peso']." </b>kg<br>";
						}
						else {
							$parte_base= "<b> NÃO</b><br>";
						 }
						if ($par['dim_pasp_possui'] == 'S') {
							$parte_pasp= "<b> SIM </b><br> Altura: <b>" . $par['dim_pasp_altura']." </b>cm - Largura: <b>".$par['dim_pasp_largura']." </b>cm - Diâmetro: <b>".$par['dim_pasp_diametro']." </b>cm - Profundidade: <b>".$par['dim_pasp_profund']."</b> - Peso: <b>".$par['dim_pasp_peso']." </b>kg";
						}
						else {
							$parte_pasp= "<b> NÃO</b>";
						 }

						$parte .= "<b>[ </b>Controle: <b> ". $par['controle']."</b> - Nome do objeto: <b>".$par['nome_objeto']. " ]</b><br>".
						"Assinada: <b>".$parte_ass."</b> - Transcrição da assinatura: <b>".$par['transc_assinatura']."</b> - Onde: <b>".$parte_ass_onde."</b><br>".
						"Marcada: <b>".$parte_marca."</b> - Onde: <b>".$parte_marca_onde."</b><br>".
						"Datada: <b>".$parte_data."</b> - Onde: <b>".$parte_data_onde."</b> - Data: <b>".$pt_data."</b><br>".
						"Localizada: <b>".$parte_local."</b> - Onde: <b>".$parte_local_onde."</b> - Local: <b>".$par['local']."</b><br>".
						"Outras inscrições: <b>" . $par['outras_inscricoes'] ."</b><br>".
						"Material / técnica: <b>" . $par['material_tecnica'] ."</b><br>".
						"Descrição formal: <b>" . $par['descr_formal'] ."</b><br>".
						"Localização atual: <b>" . $par['local_atual'] ."</b><br>".
						"Estado de conservação: <b>" . $parte_estado_conserv ."</b>".
						" - Data da última avaliação: <b>" . formata_data($par['data_ult_aval']) ."</b><br>".
						"Fotografia: <b>" . $parte_foto ."</b>".
						" - Negativo: <b>" . $parte_neg ."</b>".
						" - Diapositivo: <b>" . $parte_diapositivo ."</b>".
						" - Restaurada: <b>" . $parte_restauro ."</b><br><br><em>
						- Dimensões - <br></em>".
						"Altura: <b>" . $par['dim_parte_altura']." </b>cm - Largura: <b>".$par['dim_parte_largura']." </b>cm - Diâmetro: <b>".$par['dim_parte_diametro']." </b>cm - Profundidade: <b>".$par['dim_parte_profund']."</b> cm<br>Peso: <b>".$par['dim_parte_peso']." </b>kg - Formato: <b>".$parte_formato."</b><br><br>".
						$dim_parte.
						"Moldura: ".$parte_mold."<br>".
						"Base: ".$parte_base."<br>".
						"Passe partout: ".$parte_pasp."<br>
 						_________________________________________________________________________________________<br>";

						}	
						echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'>" . $parte ."</font>";

	
//	  $db->query($sql3);


					$sql="SELECT b.referencia,b.autoria,b.local,b.editora,b.observacao,b.ano from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
						where a.obra=$row[obra] order by b.ano asc";
					$db2->query($sql);
					$bibliografia= "";
					while ($bib=$db2->dados()) {
						$ano_bib= $bib['ano'];
						if ($ano_bib == 0)
							$ano_bib= 's/d';
						$bibliografia .= "- ".$bib['autoria'].". <b><em>".$bib['referencia'] ."</em></b>. ".$bib['local'].", ".$bib['editora'].", ".$ano_bib.". ".$bib['observacao'].  ". <br>";
					}
						echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><b> REFERÊNCIAS BIBLIOGRÁFICAS<br></b></em>" . $bibliografia . "</font>";
					echo "_________________________________________________________________________________________<br>";

					$sql="SELECT a.premio,b.* from obra_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao) 
						where a.obra=$row[obra] order by b.dt_inicial asc";
					$db2->query($sql);
					$exposicao= "";
					while ($exp=$db2->dados()) {
						$pais=$exp['pais'];
						$sqlPais="select nome from pais where pais=$pais";
						$db3->query($sqlPais);
						$dados=$db3->dados();
						$pais=$dados['nome'];
						$exposicao .= "- "."<b>".$exp['nome']."</b>". ",&nbsp;" . $exp['instituicao'] . ",&nbsp;" .$exp['cidade'].$estado.", &nbsp;". $pais.". &nbsp;".$exp['periodo'] . ".&nbsp;" ."<em>".$exp['premio']. "</em><br>";
					}
							echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><b> EXPOSIÇÕES<br></em></b>" . $exposicao . "</font>";


					echo "_________________________________________________________________________________________<br>";

					$sql="SELECT b.* from obra_movimentacao as a inner join movimentacao as b on (a.movimentacao=b.movimentacao) 
						where a.obra=$row[obra] order by b.data_saida";
					$db2->query($sql);
					$movimentacao= "";
					while ($movi=$db2->dados()) {


			$local="";
			if ($movi['tipo_mov']=='EI' || $movi['tipo_mov']=='LI') {
				if ($movi['tipo_mov']=='LI' && $movi['local_int_legado']<>'') {
					$txtTipo= '<font style="color:navy;">INTERNA</font>';
					$local= $movi['local_int_legado'];
				} else {
					$txtTipo= '<font style="color:navy;">INTERNA</font>';
					$sql= "SELECT nome from local where local = '$movi[local_destino]'";
					$db2->query($sql);
					$local= $db2->dados();
					$local= $local['nome'];
				}
			}
			elseif ($movi['tipo_mov'] == 'EE') {
				$txtTipo= '<font style="color:maroon;">EXTERNA</font>';
				$sql= "SELECT a.instituicao from exposicao as a, movimentacao_exposicao as b where a.exposicao = b.exposicao AND b.movimentacao = '$movi[movimentacao]'";
				$db2->query($sql);
				$local= $db2->dados();
				$local= $local['instituicao'];
			}
			elseif ($movi['tipo_mov'] == 'LE') {
				$txtTipo= '<font style="color:maroon;">EXTERNA</font>';
				$local= $movi['local_externo'];
			}

			$dtsaida= explode("-", $movi['saida_obra']);
			$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			$dtsaida= $dia."/".$mes."/".$ano;
			if ($dtsaida=='00/00/0000' || $dtsaida=="//")
				$dtsaida= "--/--/----";
			$dtretp= explode("-", $movi['retorno_provavel']);
			$dia=$dtretp[2]; $mes=$dtretp[1]; $ano=$dtretp[0];
			$dtretp= $dia."/".$mes."/".$ano;
			if ($dtretp=='00/00/0000' || $dtretp=="//")
				$dtretp= "--/--/----";
			$dtrete= explode("-", $movi['data_retorno']);
			$dia=$dtrete[2]; $mes=$dtrete[1]; $ano=$dtrete[0];
			$dtrete= $dia."/".$mes."/".$ano;
			if ($dtrete=='00/00/0000' || $dtrete=="//")
				$dtrete= "--/--/----";

						$data_saida= $movi['data_saida'];
						$movimentacao .= "- ".$txtTipo." - Saída: ".formata_data($movi['data_saida'])." - <b>".$local."</b> - Retorno: <b>".$dtrete."</b><br>";
					}

						echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><b> MOVIMENTAÇÃO<br></b></em>" . $movimentacao . "</font>";



			 ?>
    </td>
        </tr>

    <tr class="noprint"> 
  </tr>

<? } ?>
        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>

</table>
<p align="left">	
</p>
<p align="center">
	<font style='font-family:arial,times new roman; font-weight:normal; font-size:10px;'><em>Impresso por <? echo $_SESSION['snome']; ?> em <? echo date("d/m/Y"); ?> </em>&nbsp;
	</font>
</p>
</body>
</html>