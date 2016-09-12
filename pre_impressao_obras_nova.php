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
	$id_obra= $_REQUEST['obra'];

function ret_colecao_obra($obrid)
{
 global $db2;
 $sql="SELECT nome from colecao as a, obra as b where a.colecao=b.colecao AND b.obra='$obrid'";
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

function parte_ass($obrid)
{
 global $db2;
 $sql="SELECT assinada,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['assinada'] == 'S') {
	$ass= "assinada <em>".$res['transc_assinatura']."</em>";
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

	$sql= "SELECT * from obra where obra= '$id_obra'";
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
<p align="left">
	<font style="font-family:times new roman,arial; font-size:32px;"><em>S</em></font><font style="font-family:times new roman,arial; font-size:18px;">imba</font>

<table width="95%"  border="0">
        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>
      <? $count= 0;
	   while($row=$db->dados()) { 
			$count++;
			$sql= "SELECT a.* from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' order by b.hierarquia";
			$db2->query($sql);
			$autor=$db2->dados();
			$obraID=$row[obra];
                        $seguro=$row[val_seguro];
	?>
  <tr>
    <td width="67%"><ol>
        <?     
	$sql="SELECT a.* from autor as a INNER JOIN autor_obra as b on (a.autor=b.autor) 
	where b.obra=$row[obra] order by b.hierarquia asc";
	$db->query($sql);
	$lista_autoria= "";
	while ($lista=$db->dados()) {
	        $nasc='';
	        $mort='';
		$sql= "SELECT nome from pais where pais = '$lista[pais_nasc]'";
		$db2->query($sql);
		$pais= $db2->dados();
		$pais= $pais['nome'];
		if (strtoupper($pais) == 'BRASIL') {
			$sql= "SELECT uf from estado where estado = '$lista[estado_nasc]'";
			$db2->query($sql);
			$estado= $db2->dados();
			$estado= ", ".$estado['uf'];
			$nasc.= $lista[cidade_nasc].$estado." ";
	}
		else {
			if ($lista[cidade_nasc]=='?' && $pais=='?')
				$nasc.= "? ";
			elseif ($row[cidade_nasc]==''&& $pais=='')
				$nasc.= "";
			else
				$nasc.= $lista[cidade_nasc].", ".$pais." ";
		}

		if ($lista[dt_nasc_tp] == 'circa')
			$nasc.= " circa ";
		if ($lista[dt_nasc_ano1] <> '0') {
			$nasc.= $lista[dt_nasc_ano1];
		}
		if ($lista[dt_nasc_ano2] <> '0') {
			if ($lista[dt_nasc_ano2] <> $lista[dt_nasc_ano1])
				$nasc.= " / ".$lista[dt_nasc_ano2];
		}
		if ($lista[dt_nasc_tp] == '?')
			$nasc.=" (?) ";
		if ($lista[cidade_nasc] <> $lista[cidade_morte]) {
			$sql= "SELECT nome from pais where pais = '$lista[pais_morte]'";
			$db2->query($sql);
			$pais= $db2->dados();
			$pais= $pais['nome'];
			if (strtoupper($pais) == 'BRASIL') {
				$sql= "SELECT uf from estado where estado = '$lista[estado_morte]'";
				$db2->query($sql);
				$estado= $db2->dados();
				$estado= ", ".$estado['uf'];
				$mort.= $lista[cidade_morte].$estado." ";
			}
			else {
				if ($lista[cidade_morte]=='?' && $pais=='?')
					$mort.= "? ";
				else
					$mort.= $lista[cidade_morte].", ".$pais." ";
			}
		}
		if ($lista[dt_morte_tp] == 'circa')
			$mort.= " circa ";
			if ($lista[dt_morte_ano1] <> '0') {
			$mort.= $lista[dt_morte_ano1];
			}
			if ($lista[dt_morte_ano2] <> '0') {
			if ($lista[dt_morte_ano2] <> $lista[dt_morte_ano1])
				$mort.= " / ".$lista[dt_morte_ano2];
		}
		if ($lista[dt_morte_tp] == '?')
			$mort.=" (?) ";
		$lista_autoria .= "<b>".$lista['nomeetiqueta']."<br></b><em>".$nasc." - ".$mort.  "</em></b><br>";
	}
		echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'>" . $lista_autoria . "</font>";
				?>
        <br>
        <font style="font-size:10px;">
        </font><font style="font-family:times new roman,arial; font-weight:normal; font-size:14px;"><em><? echo ret_colecao_obra($row[obra]); ?></em></font> 
        </font>
        <br>
        <? echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'>" ?><b><? echo $row[num_registro]; ?>
        <? if ($row['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(destaque do acervo)</font>"; ?>
        </b> <font style="font-size:8px;"><br>
        </font><font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'><b><? echo $row[titulo_etiq]; ?></b> 
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
		if ($row['texto_etiq'] <> '') {
			echo "<font style='font-size:8px;'><br><br></font><font style='font-family:times new roman,arial; font-weight:normal; font-size:14px;'><em>" . $row['texto_etiq'] . "</em></font>";
		}

	?>
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
	
	
            <? if ($imagem<>'' && $noimage=='') { ?>
	  <td width="33%" valign="top" align="right"><img src="<? echo 'http://'.$_SERVER[SERVER_ADDR].'/donato/'.$dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao; ?>" width="<? echo $Lo; ?>"></img></td>
            <? } else { 
			echo "<td width='33%' class='texto_bold' align='center' valign='middle' nowrap style='border: 1px dashed #ABABAB; color:#444444;'><sup>Imagem não disponível</sup></td>";
		   } ?> 
  </tr>
        <tr> 
    <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10">
      <?
					echo "<hr></font>";

					if ($row['desc_conteudo'] <> '') {
							echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><u><b>DESCRIÇÃO DE CONTEÚDO:</u><br></em></b>" . $row['desc_conteudo'] . "<br><br></em></font>";
					}


					$sql="SELECT a.premio,b.* from obra_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao) 
						where a.obra=$row[obra] order by a.exposicao asc";
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
					if ($exposicao <> '') {
							echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><u><b>EXPOSIÇÕES:</u><br></em></b>" . $exposicao . "<br></font>";
					}


					$sql="SELECT b.referencia,b.autoria,b.local,b.editora,a.observacao,b.ano from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
						where a.obra=$row[obra] order by b.ano asc";
					$db2->query($sql);
					$bibliografia= "";
					while ($bib=$db2->dados()) {
						$ano_bib= $bib['ano'];
						if ($ano_bib == 0)
							$ano_bib= 's/d';
						$bibliografia .= "- ".$bib['autoria'].". <b><em>".$bib['referencia'] ."</em></b>. ".$bib['local'].", ".$bib['editora'].", ".$ano_bib.". ".$bib['observacao'].  ". <br>";
					}
					if ($bibliografia <> '') {
							echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><b><u>REFERÊNCIAS BIBLIOGRÁFICAS:</u><br></b></em>" . $bibliografia . "<br></font>";
					}


			 ?>
    </td>
        </tr>

    <tr class="noprint"> 
  </tr>


<? } ?>
</table>
<p align="left">	
</p>
<p align="center">
	<font style='font-family:arial,times new roman; font-weight:normal; font-size:10px;'><em>Impresso por <? echo $_SESSION['snome']; ?> em <? echo date("d/m/Y"); ?> </em>&nbsp;
	</font>
</p>
</body>
</html>