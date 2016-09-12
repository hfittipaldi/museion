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
        $dbAutor=new conexao();
        $dbAutor->conecta();

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
 $sql="SELECT dt_parte_ano1,dt_parte_ano2,dt_parte_tp,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0]."|".$res[1]."|".$res[2]."|".$res[3];
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
 return formata_valor_3($altura) . " x " . formata_valor_3($largura,1) . " cm (".$tipo.")";
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
	$id_obras= substr($id_obras,1,-1); // colocado o parametro ,-1 para desprezar a ultima virgula da string (PBL - 10/09/2008)
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
					where b.obra='$row[obra]' AND b.hierarquia = 1 order by b.hierarquia";
			$db2->query($sql);
			$autor=$db2->dados();
			$obraID=$row[obra];
                        $seguro=$row[val_seguro];
                        echo '<tr><td width="67%"><ol>';
                        echo '<font face="Arial, Helvetica, sans-serif" size="+1">'.$count.". ";    
                        $sqlAutor="SELECT a.*,b.atribuido from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' order by b.hierarquia";

                        $dbAutor->query($sqlAutor);
                        
                        while($autor=$dbAutor->dados()) 
                        {
                                //$nomeautor=$autor[nomeetiqueta];
                                //echo $nomeautor;

                                 $atribuido="";
                                if ($autor[atribuido]=="S") { $atribuido=" (atribuído)";}
                                   echo '<font face="Arial, Helvetica, sans-serif" size="+1">'.$autor[nomeetiqueta].'</font><i>'.$atribuido.'</i><br>';
                        

			        $nasc='';
                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
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
					echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'><em>".$nasc."</em></font>";

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
						echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'> - <em>" . $mort . "</em></font>";
                                        echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;";
                        }
				?>
        <br><font style="font-size:10px;"><br>
        </font><font style="font-family:times new roman,arial; font-weight:normal; font-size:14px;"><em><? echo ret_colecao_obra($row[obra]); ?></em></font> 
        </font>
        <br>
        <? echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'>" ?><b><? echo $row[num_registro]; ?>
        <? if ($row['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(destaque do acervo)</font>"; ?>
        </b> <font style="font-size:8px;"><br>
        </font><font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'><b><? echo $row[titulo_etiq];?></b><?
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
					$p_assinatura= $p_datas[3];

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
		echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
	   elseif ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm ; " . formata_valor_3($row['dim_obra_profund']) . " cm (profundidade)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm";
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " cm"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", " . "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)"; 
	   elseif ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
		echo $row[material_tecnica].", " . formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)" ; 
           else 
		echo $row[material_tecnica].", (ERRO - verificar dimensões na ficha técnica)"; 

	?>
        <!--<br>fotografia, <? /*echo number_format($row['aimp_obra_altura'],1,",",".") . " x " . number_format($row['aimp_obra_largura'],1,",",".") . " cm(área impressa); " . ret_dim_parte($row['obra']); */ ?>-->
        <br>
        <? 
		if (trim($p_assinatura) == '') { echo "sem assinatura"; } else { echo "assinada <em>".$p_assinatura."</em>"; } 
					
		if ($aquisicao == '')
			$aquisicao= 'procedência desconhecida';
			echo "<br>".$aquisicao . ", " . $row['doador'];
		if (strlen($dataqui) > 3)
			echo ", " . $dataqui;

	?>
        <br>


 <?
    global $db2;
	$sql2="SELECT b.nome_arquivo,b.diretorio_imagem from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
		AND  a.obra = ".$obraID." AND a.eh_mini=1 order by  a.eh_mini desc, a.eh_img_laudo desc";
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
		$Ao= 0;
		$Lo= 0;
		$Ao2= 0;
		$Lo2= 0;
	}
?>	
	
	
            <? if ($imagem<>'' && $noimage=='') { ?>
	  <td width="33%" valign="top" align="right"><img src="<? echo 'http://'.$_SERVER[SERVER_ADDR].'/donato/'.$dir_virtual.$url.'/'.combarra_encode($arquivo); ?>" height="<? echo $Ao; ?>" width="<? echo $Lo; ?>"></img></td>
            <? } else { 
			echo "<td width='33%' class='texto_bold' align='center' valign='middle' nowrap style='border: 1px dashed #ABABAB; color:#444444;'><sup>Imagem não disponível</sup></td>";
		   } ?> 

           
     
<tr>
 <td width="67%"><ol>     
             <?                     
               if ($_POST['modelo']=='2'  || $_POST['modelo']=='4')
                  {
                      if ($row['desc_conteudo'] <> '')  echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br><em><b>DESCRIÇÃO:<br></em></b>" . $row['desc_conteudo'] . "<br></em></font>";
	    }

                  if ($_POST['modelo']=='4')
                  {                  
                       $sql="SELECT b.exposicao, a.premio,b.* from obra_exposicao as a inner join exposicao as b on (a.exposicao=b.exposicao)   where a.obra=$row[obra] order by a.exposicao asc";
	         $db2->query($sql);
	         $exposicao= "";
	         while ($exp=$db2->dados())
                       {
                         if ($exp['exposicao']<>'')
                         {
	           $pais=$exp['pais'];
	           $sqlPais="select nome from pais where pais=$pais";
	           $db3->query($sqlPais);
	           $dados=$db3->dados();
	           $pais=$dados['nome'];
	           $exposicao .= "- "."<b>".$exp['nome']."</b>". ",&nbsp;" . $exp['instituicao'] . ",&nbsp;" .$exp['cidade'].$estado.", &nbsp;". $pais.". &nbsp;".$exp['periodo'] . ".&nbsp;" ."<em>".$exp['premio']. "</em><br>";
	           if ($exposicao <> '')  echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><br><em><b>EXPOSIÇÕES:<br></em></b>" . $exposicao . "</font>";	       
	           }
                        }
                     }       


                 if ($_POST['modelo']=='3'  || $_POST['modelo']=='4')
                  {                  
                      $sql="SELECT b.bibliografia, b.referencia,b.autoria,b.local,b.editora,a.observacao,b.ano from obra_bibliografia as a inner join bibliografia as b on (a.bibliografia=b.bibliografia) 
	                  where a.obra=$row[obra] order by b.ano asc";
	        $db2->query($sql);
	        $bibliografia= "";
	        while ($bib=$db2->dados()) 
                       {
                         if ($bib['bibliografia'] <>'' ){
                          $ano_bib= $bib['ano'];
	            if ($ano_bib == 0)
	               $ano_bib= 's/d';
		 $bibliografia .= "- ".$bib['autoria'].". <b><em>".$bib['referencia'] ."</em></b>. ".$bib['local'].", ".$bib['editora'].", ".$ano_bib.". ".$bib['observacao'].  ". <br>";
	           }
	           if ($bibliografia <> '') echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em><b><br>REFERÊNCIAS BIBLIOGRÁFICAS:<br></b></em>" . $bibliografia . "</font>";
                         if ($row['texto_etiq'] <> '') echo "<font style='font-size:8px;'><br><br></font><font style='font-family:times new roman,arial; font-weight:normal; font-size:14px;'><em>" . $row['texto_etiq'] . "<br></em></font>";
	          }

                        }

                   if ($_POST['modelo']=='5')
                      {                     
	            if ($seguro <> '') 
                           {
                             if ($_POST['modelo']=='5')  echo "<font style='font-family:arial; font-weight:normal; font-size:12px;'><em>Valor do Seguro:" ."&nbsp;". $seguro . "</em></font>";
	              }
                       }
                      ?>
         </font>
    </td>
  </tr>

   <tr><td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></tr>

    <tr class="noprint"> 
  </tr>
<? } ?>
</table>
   <table width="95%"  border="0">
      <tr width="95%">
         <td width="30%" align="right"><font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'><? echo $count; ?> obra(s)</font></td>
         <td width="35%" align="center"><font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'><? echo percente_obras($count); ?> % do acervo</font></td>
         <td width="30%" align="left"><font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'>Final de relatório</font></td>
      </tr>
   </table>
   <table width="95%"  border="0">
      <tr width="95%">
        <td width="95%" align="center"><font style='font-family:arial,times new roman; font-weight:normal; font-size:10px;'><em>Impresso por <? echo $_SESSION['snome']; ?> em <? echo date("d/m/Y"); ?> </em></font></td>
      </tr>
    </table>
</body>
</html>