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
	$db5=new conexao();
	$db5->conecta();
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
 return formata_valor_3($altura) . " x " . formata_valor_3($largura) . " cm (".$tipo.")";
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
 return formata_valor_3($percent);
}

	$id_obras= $_SESSION['s_impressao'];
	$id_obras= substr($id_obras,1,-1);// acrescentado o parâmetro ,-1 para desprezar a ultima virgula da string (PBL - 1EXD1150908)

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
                        $sqlAutor="SELECT a.*, b.atribuido from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' order by b.hierarquia";

                        $dbAutor->query($sqlAutor);

                        while($autor=$dbAutor->dados()) 
                        {
                                //$nomeautor=$autor[nomeetiqueta];
                                //echo $nomeautor;

                                $atribuido=" ";
                                if ($autor[atribuido]=="S") { $atribuido=" (atribuído)";}
                                   echo '<font face="Arial, Helvetica, sans-serif" size="+1">'.$autor[nomeetiqueta].'</font><i>'.$atribuido.'</i><br>';
   


     ////////////////////////////inicio/////////////////////////////////////                        
                       
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


///////////////////////////////////////////////fim////////////////////////////

       <br><font style="font-size:10px;"><br>
        </font><font style="font-family:times new roman,arial; font-weight:normal; font-size:14px;"><em><? echo ret_colecao_obra($row[obra]); ?></em></font> 
        </font>
        <br>
        <? echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'>" ?><b><? echo $row[num_registro]; ?>
        <? if ($row['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(destaque do acervo)</font>"; ?>
        </b> <font style="font-size:8px;"><br>
        </font><font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'><? echo "<b>".$row[titulo_etiq]; ?></b><?
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
		echo $row[material_tecnica].", " . formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm"; 
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

	?><br>
      <? 
		if (trim($p_assinatura) == '') { echo "sem assinatura"; } else { echo "assinada <em>".$p_assinatura."</em>"; } 
					
		if ($aquisicao == '')
			$aquisicao= 'procedência desconhecida';
			echo "<br>".$aquisicao . ", " . $row['doador'];
		if (strlen($dataqui) > 3)
			echo ", " . $dataqui;

	?>


<br>
</td>
  </tr>

    <tr class="noprint"> 
  </tr>


<? } ?>
        <tr> 
          
    <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10">
    </td>
        </tr>
</table>
<p align="left">	
</p>
<p align="center">
	<font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'><? echo $count; ?> obra(s)
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<? echo percente_obras($count); ?> % do acervo
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Final de relatório
	</font>
	<br>
	<font style='font-family:arial,times new roman; font-weight:normal; font-size:10px;'><em>Impresso por <? echo $_SESSION['snome']; ?> em <? echo date("d/m/Y"); ?> </em>&nbsp;
	</font>
</p>
</body>
</html>