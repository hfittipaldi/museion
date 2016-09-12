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
<table width="180%"  border="1">
<tr>
<td>


      <? $count= 0;
           while($row=$db->dados()) {     
              $count++;
	$sql= "SELECT a.* from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) where b.obra='$row[obra]' AND b.hierarquia = 1 order by b.hierarquia";
	$db2->query($sql);
	$autor=$db2->dados();
	$obraID=$row[obra];
              $seguro=$row[val_seguro];
              echo '<tr><td width="67%"><ol>';
              $sqlAutor="SELECT a.*, b.atribuido from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) where b.obra='$row[obra]' order by b.hierarquia";
              $dbAutor->query($sqlAutor);
              while($autor=$dbAutor->dados()) 
              {
                  $atribuido=" ";
                   if ($autor[atribuido]=="S") { $atribuido=" (atribuído)";}
                      echo '<font face="format, bold, Helvetica, sans-serif" size="+22">'.$autor[nomeetiqueta].'</font><i>'.$atribuido.'</i><br>';                                                      
                }				
           ?>
               <font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'><? echo "<b>".$row[titulo_etiq]; ?></b> 
               <?$dataqui='';
	     if ($row['dt_aquisicao_tp'] == 'circa')$dataqui.= " circa ";
                   if ($row['dt_aquisicao_ano1'] <> '0') {$dataqui.= $row['dt_aquisicao_ano1'];}
	     if ($row['dt_aquisicao_ano2'] <> '0') {
                      if ($row['dt_aquisicao_ano2'] <> $row['dt_aquisicao_ano1']) $dataqui.= " / ".$row['dt_aquisicao_ano2'];
                    }
                   if ($row['dt_aquisicao_tp'] == '?') $dataqui.=" (?) ";
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
	     if ($p_data_extra2 == 'circa') $dat.= " circa ";
                   if ($p_data <> '0') { $dat.= $p_data;}
	     if ($p_data_extra1 <> '0') {
                       if ($p_data_extra1 <> $p_data) $dat.= " / ".$p_data_extra1;
	       }
	      if ($p_data_extra2 == '?') $dat.=" (?) ";
                    if (strlen($dat) > 3)echo ", " . $dat;
                  ?>
        <br>
       <? if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
		echo $row[material_tecnica].", ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
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

	?><br><br>
  </tr>

    <tr class="noprint"> 
  </tr>


<? } ?>

</td>
</tr>
</table>
<p align="left">	
</p>
</body>
</html>