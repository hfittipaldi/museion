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
	$db6=new conexao();
	$db6->conecta();
	$dbseq=new conexao();
	$dbseq->conecta();
        $usuario=$_REQUEST[usuario];
	$dirfisico= diretorio_fisico();
	$dir_virtual= diretorio_virtual();
             $dbAutor=new conexao();
             $dbAutor->conecta();




function formata_ing($valor)
{
 $valor=str_replace(",", ".", $valor);
 return $valor;
}
function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	else
		return $valor;
}

function parte_ass_ing($obrid)
{
 global $db2;
 $sql="SELECT assinada,transc_assinatura from parte where obra='$obrid' order by controle";
 $db2->query($sql);
 $res=$db2->dados();
 if ($res['assinada'] == 'S') {
        $assing="signed <em>".$res['transc_assinatura']."</em>";
 }
 else {
        $assing= "no signature";
 }
 return $assing;
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
function ret_aquisicao_ing($sigla)
{
 global $db2;
 $sql="SELECT nome_ing from forma_aquisicao where forma_aquisicao = '$sigla'";
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


         <?

            $cor= "";
            $cor= "";

            $sql3="SELECT caminho,url from diretorio_imagem where diretorio_imagem = '$diretorio_imagem'";
            $db3->query($sql3);
            $row=$db3->dados();
            $local=$row['url'];
            $caminho=$row[caminho];



        ?>
<body>



<p align="left">
<? 
$sqldir="SELECT valor from parametro where parametro='DIR_ETIQUETA'";
$db4->query($sqldir);
$url=$db4->dados();
$dir=$url[0]."etiqueta_".$usuario.".xls";

$sqldir="SELECT valor from parametro where parametro='URL_ETIQUETA'";
$db4->query($sqldir);
$url=$db4->dados();
$dirurl=$url[0]."etiqueta_".$usuario.".xls";


$fh=fopen($dir,"wx");
fwrite($fh,"<table width='100%'  border='1' align='left'>");
fwrite($fh,"<tr>");
fwrite($fh,"<td>AUTOR</td><td>NASCIMENTO</td><td>TITULO</td><td>TECNICA/MEDIDAS</td><td>ASSINATURA</td><td>AQUISIÇÃO</td><td>TITLE</td><td>TECH MEASURE</td><td>SIGNATURE</td><td>ACQUISITION</td>");
fwrite($fh,"</tr>");

      $count= 0;
	   while($row=$db->dados()) { 
                                          $obra_id = $row[obra];
			$count++;
			$sql= "SELECT a.* from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' AND b.hierarquia = 1 order by b.hierarquia";
			$db2->query($sql);
			$autor=$db2->dados();
			$obraID=$row[obra];
                        $seguro=$row[val_seguro];
                        $lista_autoria='';
                        $nascimentotxt='';
                        $titulo_etiq_ing='';
                        $medidas_ing='';
                        $sqlAutor="SELECT a.*, b.atribuido from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) 
					where b.obra='$row[obra]' order by b.hierarquia";

                        $dbAutor->query($sqlAutor);

                        while($autor=$dbAutor->dados()) 
                        {
                                 $autorEs=$autor[autor];
                                 $atribuido=" ";
                                if ($autor[atribuido]=="S") { $atribuido=" (atribuído)";}
	        		$nasc='';
	        		$mort='';
				$sqlpais= "SELECT nome from pais where pais = '$autor[pais_nasc]'";
				$db6->query($sqlpais);
				$pais= $db6->dados();
				$pais= $pais['nome'];
                		if (strtoupper($pais) == 'BRASIL') {
					$sql= "SELECT uf from estado where estado = '$autor[estado_nasc]'";
					$db6->query($sql);
					$estado= $db6->dados();
					$estado= ", ".$estado['uf'];
					$nasc.= $autor[cidade_nasc].$estado." ";
           			}else {
					if ($autor[cidade_nasc]=='?' && $pais=='?')
						$nasc.= "? ";
					elseif ($row[cidade_nasc]==''&& $pais=='')
						$nasc.= "";
					else
						$nasc.= $autor[cidade_nasc].", ".$pais." ";
		  		}               




		if ($autor[dt_nasc_tp] == 'circa')
			$nasc.= " circa ";
		if ($autor[dt_nasc_ano1] <> '0') {$nasc.= $autor[dt_nasc_ano1];}
		if ($autor[dt_nasc_ano2] <> '0') {
			if ($autor[dt_nasc_ano2] <> $autor[dt_nasc_ano1])
				$nasc.= " / ".$autor[dt_nasc_ano2];
		}
		if ($autor[dt_nasc_tp] == '?')
			$nasc.=" (?) ";
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
                                                        {
					$mort.= "? ";
                                                        }else{
                                                                      $mort.= $autor[cidade_morte];
                                                                      if ($pais<>'')
					   $mort.= $autor[cidade_morte].", ".$pais." ";
                                                        }
			}


		}
 



		if ($autor[dt_morte_tp] == 'circa')
			$mort.= " circa ";
			if ($autor[dt_morte_ano1] <> '0') {
			$mort.= $lista[dt_morte_ano1];
			}
			if ($autor[dt_morte_ano2] <> '0') {
			if ($autor[dt_morte_ano2] <> $autor[dt_morte_ano1])
				$mort.= " / ".$autor[dt_morte_ano2];
		}


 
                $sqlaut1="select * from autor_obra where obra=".$row[obra]." and autor=".$autorEs;
                $db3->query($sqlaut1);
                $lista1=$db3->dados();
                $atribuido="";
                if ($lista1[atribuido] == "S") {
                    $atribuido=" (atribuido)";
                }
		if ($autor[dt_morte_tp] == '?') $mort.=" (?) ";
		$lista_autoria .= "<b>".$autor['nomeetiqueta']."</b>";
                 if ($mort<>'') {$nascimentotxt.="<em>".$atribuido.$nasc." - ".$mort.  "</em></b>";}
                 else{$nascimentotxt.="<em>".$atribuido.$nasc."</em></b>";}


          }
			






	
fwrite($fh,"<tr>");

fwrite($fh,"<td>");
?>
     
<tr><td>  
<?

fwrite($fh,"$lista_autoria</td>");
fwrite($fh,"<td>$nascimentotxt</td>");
fwrite($fh,"<td>$row[titulo_etiq]");
$titulo_etiq_ing=$row[titulo_etiq];

 					if ($row[periodo] <> '')
                                        {
                                          fwrite($fh,", ".$row[periodo]);
                                          $titulo_etiq_ing=$titulo_etiq_ing.", ".$row[periodo];
					}else{
					$p_datas= ret_data_obra($row['obra']);


                                        }
					$p_datas= explode("|",$p_datas);
					$p_data= $p_datas[0];
					$p_data_extra1= $p_datas[1];
					$p_data_extra2= $p_datas[2];

					if ($p_data_extra2 == 'circa')
						$dat.= " circa ";

					if ($p_data <> '0') {
						$dat.= " ".exibeDataNegativa($p_data);
					}
					if ($p_data_extra1 <> '0') {
						if ($p_data_extra1 <> $p_data)
							$dat.= " / ".exibeDataNegativa($p_data_extra1);
					}

					if ($p_data_extra2 == '?')
						$dat.=" (?) ";

					if (strlen($dat) > 3){
						fwrite($fh," , ". $dat);
                                                 $titulo_etiq_ing=$titulo_etiq_ing." , ". $dat;

                                         }
			
?></b>
<br></td></tr>

<tr><td>
<?
fwrite($fh,"</td>");

            

   
fwrite($fh,"<td>");

          
         if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)

          {
		fwrite($fh," $row[material_tecnica], ");
                fwrite($fh, formata_valor_3($row['dim_obra_altura']) . ' x ' . formata_valor_3($row['dim_obra_largura']). ' x ' . formata_valor_3($row['dim_obra_profund']) . ' cm');   
                $material=$row[material_tecnica].", ";
                $medidas_ing= formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
               
           }

           if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
           {
		fwrite($fh,$row[material_tecnica].', '. '&Oslash; = ' . formata_valor_3($row['dim_obra_diametro']) . ' cm ; ' . formata_valor_3($row['dim_obra_profund']) . ' cm (profundidade)'); 
                $material=$row[material_tecnica].", ";
                $medidas_ing= "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm ; " . formata_valor_3($row['dim_obra_profund']) . " cm (profundidade)";
            }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
           {
		fwrite($fh,$row[material_tecnica].', ' . '&Oslash; = ' . formata_valor_3($row['dim_obra_diametro']) . ' cm');
                $material=$row[material_tecnica].", ";
                $medidas_ing="&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm";
           }

	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
           {
		fwrite($fh,$row[material_tecnica].', ' . formata_valor_3($row['dim_obra_altura']) . ' x ' . formata_valor_3($row['dim_obra_largura']) . ' cm'); 
                $material=$row[material_tecnica].", ";
                $medidas_ing= formata_valor_3($row['dim_obra_altura']) ." x " . formata_valor_3($row['dim_obra_largura']) . " cm";   
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
           {
		fwrite($fh,$row[material_tecnica].', ' . formata_valor_3($row['aimp_obra_altura']) . ' x ' . formata_valor_3($row['aimp_obra_largura']) . ' cm (área impressa); '. formata_valor_3($row['dim_obra_altura']) . ' x ' . formata_valor_3($row['dim_obra_largura']) . ' cm (suporte)');
                $material=$row[material_tecnica].", ";
                $medidas_ing= formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)";
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
            {
		fwrite($fh,$row[material_tecnica].', ' . '&Oslash; = ' . formata_valor_3($row['aimp_obra_diametro']) . ' cm (área impressa); '. '&Oslash; = ' . formata_valor_3($row['dim_obra_diametro']) . ' cm (suporte)'); 
                $material=$row[material_tecnica].", ";
                $medidas_ing="&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) ." cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)";
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
	   {
        	fwrite($fh,$row[material_tecnica].', ' . '&Oslash; = ' . formata_valor_3($row['aimp_obra_diametro']) . ' cm (área impressa); '. formata_valor_3($row['dim_obra_altura']) . ' x ' . formata_valor_3($row['dim_obra_largura']) . ' cm (suporte)'); 
                $material=$row[material_tecnica].", ";
                $medidas_ing= "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)";
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
           {
		fwrite($fh,$row[material_tecnica].', ' . formata_valor_3($row['aimp_obra_altura']) . ' x ' . formata_valor_3($row['aimp_obra_largura']) . ' cm (área impressa); '. '&Oslash; = ' . formata_valor_3($row['dim_obra_diametro']) . ' cm (suporte)'); 
                $material=$row[material_tecnica].", ";
                $medidas_ing=formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)";
           } 
  	?>
      
  	
<?
fwrite($fh,"</td>");
 

fwrite($fh,"<td>");

$parteass=parte_ass($row['obra']);
fwrite($fh,"$parteass");
?>
<?
fwrite($fh,"</td>");
fwrite($fh,"<td>");

 

					$dat=''; 
                                        $aquisicao_ing='';
					if ($row['dt_aquisicao_tp'] == 'circa')
                                        
						$dat.= " circa ";
                                   

					if ($row['dt_aquisicao_ano1'] <> '0') {
						$dat.= exibeDataNegativa($row['dt_aquisicao_ano1']);
                                                
					}
					if ($row['dt_aquisicao_ano2'] <> '0') {
						if ($row['dt_aquisicao_ano2'] <> $row['dt_aquisicao_ano1'])
							$dat.= " / ".exibeDataNegativa($row['dt_aquisicao_ano2']);
					}

					if ($row['dt_aquisicao_tp'] == '?')
						$dat.=" (?) ";

					$aquisicao= strtolower(ret_aquisicao($row[forma_aquisicao]));
					$aquisicao_ing= strtolower(ret_aquisicao_ing($row[forma_aquisicao]));
					if ($aquisicao == ''){
						$aquisicao= 'procedência desconhecida';
						$aquisicao_ing= 'Origin unknown';
                                                                       }
					fwrite($fh,$aquisicao . ', ' . $row['doador']);
                                                                      $aquisicao_ing=$aquisicao_ing . ", " . $row['doador'];
                                                                      $aquisicao=$aquisicao. ", " . $row['doador'];

					if (strlen($dat) > 3)
                                                                       {
			 		      fwrite($fh, ', ' . $dat);
                                                                            $aquisicao_ing=$aquisicao_ing.", " . $dat;
                                                                            $aquisicao=$aquisicao.", " . $dat;
					}

					if ($row['texto_etiq'] <> '') {
						fwrite($fh,  $row['texto_etiq']);
                                                                                   $aquisicao_ing=$aquisicao_ing.", ".$row['texto_etiq'];
                                                                                   $aquisicao=$aquisicao.", ".$row['texto_etiq'];
						
					}
					
?>

<?
fwrite($fh,"</td>");
fwrite($fh,"<td>");
fwrite($fh,"$titulo_etiq_ing");
?>
</td></tr>
<tr><td>
<?$medidas_ing=formata_ing($medidas_ing);?>

</td></tr>

<?
fwrite($fh,"</td>");

fwrite($fh,"<td>");
fwrite($fh,"$medidas_ing");
fwrite($fh,"</td>");

fwrite($fh,"<td>");
$parteass_ing=parte_ass_ing($row['obra']);
fwrite($fh,$parteass_ing);
fwrite($fh,"</td>");


fwrite($fh,"<td>");
fwrite($fh,"$aquisicao_ing");
fwrite($fh,"</td>");
?>
<?

 $sqltrid="SELECT dim_obra_altura, dim_obra_largura, dim_obra_profund from obra where obra = '$obra_id'";
 $dbseq->query($sqltrid);
 $res=$dbseq->dados();
 $alt= $res[0];
 $larg= $res[1];
 $prof= $res[2];
 $ret=0;
 if  (($alt>0)and($larg>0)and($prof>0)) $ret=1;

     $sql_seq="SELECT fotografia from fotografia_obra where (obra = '$obra_id') order by eh_mini='1' desc";   
             $dbseq->query($sql_seq);
             $row_seq=$dbseq->dados();
             $fotografia=$row_seq[0];

             $sql_seq="SELECT diretorio_imagem, nome_arquivo from fotografia where (fotografia = '$fotografia')";
             $dbseq->query($sql_seq);
             $row_seq=$dbseq->dados();
             $dirfoto=$row_seq[0];
             $nomearq=$row_seq[1];  

             $sql_seq="SELECT url,caminho from diretorio_imagem where (diretorio_imagem = '$dirfoto')";
             $dbseq->query($sql_seq);
             $row_seq=$dbseq->dados();
             $url=$row_seq[0];
             $caminho=$row_seq[1];

              //284 é a altura max da área de exibição da imagem; 500 é a largura máxima.//
	$cA= $Ao / 264;
	$cL= $Lo / 480;
              $imgexiste =0;
               if (file_exists($dirfisico.$url.'\\'.$nomearq)) {
                  $imgexiste =1;
	    list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url.'/'.$nomearq);
	    $Ao= $height;
	    $Lo= $width;
	    $cA= $Ao / 264;
	    $cL= $Lo /480;
	    if ($Ao > 264 || $Lo > 480) {
	       if (cL < cA) {
	          $percent= (480 * 100) / $Lo;
		  $Lo= 480;
		  $Ao= ($Ao * $percent) / 100;
		  if ($Ao > 264) {
		     $percent= (264 * 100) / $Ao;
		     $Ao= 264;
		     $Lo= ($Lo * $percent) / 100;
		   }

		} else {
		   $percent= (264 * 100) / $Ao;
		   $Ao= 264;
		   $Lo= ($Lo * $percent) / 100;
		   if ($Lo > 480) {
		      $percent= (480 * 100) / $Lo;
		      $Lo= 480;
		      $Ao= ($Ao * $percent) / 100;
		    }
	        }
	   }
       }

 



if (($ret==1) and ($imgexiste ==1)) {?>
   <table height="50%" width="100%" border="0">
    <tr>      
      <td  width="100%" id=fundo colspan="0" valign="top" align="center">  
		    

       </td>
   </tr>
</table>
<?}?>
<br><br><br><br>
          


<?

					if ($_REQUEST['marcar_todas'] == 0) {
						// verifica/monta variavel de sessao das obras marcadas para impressao //
						if ($_REQUEST['imprime'] == 'marcou') {
							If ($_SESSION['s_impressao'] == '') {
								$_SESSION['s_impressao'] = ",";
							}
							$_SESSION['s_impressao']= $_SESSION['s_impressao'] . $row['obra'] . ",";
							$_SESSION['s_imp_total']++;
						}

						$marcou= "";
						if (stristr($_SESSION['s_impressao'], ",".$row['obra'].",")) {
							$marcou= "checked";
							if ($_REQUEST['clicou_marcar'] && $_REQUEST['imprime']=='') {
								$marcou= "";
								$_SESSION['s_impressao']= str_replace(",".$row['obra'].",",",",$_SESSION['s_impressao']);
								$_SESSION['s_imp_total']--;
							}
						}
					}
				

  fwrite($fh,"</tr>");?>

    <tr class="noprint"> 
  </tr>


<? } 


fwrite($fh,"</tr>");
fwrite($fh,"</table>");
fclose($fh);
$dirxls=$dir_virtual."etiqueta_".$usuario.".xls";

echo "<a href=download.php?file=".$dir.">download</a>";
?>

</body>
</html>