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
              $dbAutor=new conexao();
              $dbAutor->conecta();
              $db_trid=new conexao();
              $db_trid->conecta();



              $usuario=$_REQUEST[usuario];
              $tridimencional=$_REQUEST[tridimencional];
              $etapas=$_REQUEST[etapas];
              $modelo1=$_REQUEST[modelo1];
              $modelo2=$_REQUEST[modelo2];
              $modelo3=$_REQUEST[modelo3];
              $modelo4=$_REQUEST[modelo4];
              $modelo5=$_REQUEST[modelo5];
              $modelo6=$_REQUEST[modelo6];
              $modelo7=$_REQUEST[modelo7];
              $tf=$_REQUEST[tf]."px";        
              $tfa=$_REQUEST[tfa]."px";    
    
	$dirfisico= diretorio_fisico();
	$dir_virtual= diretorio_virtual();



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
 

 if ($tridimencional=='true')  
    {           
       $id_obras_t='';
       $sql= "SELECT * from obra where obra in ($id_obras) order by num_registro + 0";
       $db->query($sql);
       while($row=$db->dados())
       { set_time_limit(70);
          if (($row[dim_obra_altura] <> '0.00') and ($row[dim_obra_profund] <> '0.00') and ($row[dim_obra_largura] <> '0.00'))
          {
              if ($id_obras_t=='') { $id_obras_t=$row[obra]; }else{$id_obras_t=$id_obras_t.",".$row[obra]; }
            }
        }
        $id_obras=$id_obras_t;
        
      }
   $count= 0;
   if ($etapas<>'' and ($etapas<>'/Todas'))
   {
     $id_obras_etapas=",".$id_obras;
     $id_obras_etapas=$id_obras_etapas.",";
     $str=stristr($etapas, '/'); 

     $tfim=strlen($str);
     $tini=strlen($etapas)-$tfim;
 
   
     $tini_str=substr($etapas, 0, $tini);
     $tfim_str=substr($etapas, ($tini+1));
     $id_obras_str=split(',', $id_obras_etapas);


     for ($i = $tini_str; $i <= $tfim_str; $i++) 
     {
        $id_obras_temp=$id_obras_temp.",".$id_obras_str[$i];
     }
  
	$id_obras_result='-1'.$id_obras_temp;
	$id_obras=$id_obras_result;
}
    






















   
	 $sql= "SELECT * from obra where obra in ($id_obras) order by num_registro + 0";
	 $db->query($sql);

?>


         <?

            $cor= "";
            $cor= "";

            $sql3="SELECT caminho,url from diretorio_imagem where diretorio_imagem = '$diretorio_imagem'";
            $db3->query($sql3);
            $rowimg=$db3->dados();
            $local=$rowimg['url'];
            $caminho=$rowimg[caminho];



        ?>
<body>



<p align="left">
<? 

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
                        $dat='';
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
					                    $mort= $autor[cidade_morte].", ".$pais." ";
                                                        }
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


 
                $sqlaut1="select * from autor_obra where obra=".$row[obra]." and autor=".$autorEs;
                $db3->query($sqlaut1);
                $lista1=$db3->dados();
                $atribuido="";
                if ($lista1[atribuido] == "S") {
                    $atribuido=" (atribuido)";
                }
		if ($autor[dt_morte_tp] == '?') $mort.=" (?) ";
		$lista_autoria .= $autor['nomeetiqueta'];
                 if ($mort<>'') {$nascimentotxt.=$nasc." - ".$mort;}
                 else{$nascimentotxt.=$nasc;}


          }
			


 ?> 
<tr><td>  
<?echo "<font style='font-family:arial,Helvetica, sans-serif; font-weight:normal; font-size:$tfa;'>$lista_autoria</font><font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'><i>$atribuido</i></font>"?><br>
<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$nascimentotxt</font>"?><br><br>
<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'><b>$row[titulo_etiq]</b>"?>
<? $titulo_etiq_ing=$row[titulo_ingles];?>
<?if ( $row[titulo_ingles]=='')
 { 
     $titulo_etiq_ing=$row[titulo_etiq];} ?><?
                                    $dat.="";
                                    $dat_ing='';
 		        if ($row[periodo] <> '')
                                        { 
                                          echo ", ".$row[periodo];
                                          $titulo_etiq_ing=$titulo_etiq_ing.", ".$row[periodo];
		           }else{
			$p_datas= ret_data_obra($row['obra']);
                                        }
		           $p_datas= explode("|",$p_datas);
		           $p_data= $p_datas[0];
		           $p_data_extra1= $p_datas[1];
		           $p_data_extra2= $p_datas[2];

		            if ($p_data_extra2 == 'circa') { $dat.= " circa ";}

		             if ($p_data <> '0')
                                          {
			          $dat.= " ".exibeDataNegativa($p_data);
			}
			if ($p_data_extra1 <> '0') 
                                         {
			    if ($p_data_extra1 <> $p_data) { $dat.= " / ".exibeDataNegativa($p_data_extra1);}
			}
			if ($p_data_extra2 == '?') $dat.=" (?) ";
			if (strlen($dat) > 3)
                                           {
			     
                                               echo ", ".$dat;
  
                                                if ($modelo4=='true')$dat_ing =", ". $dat;
                                         }
                                      
			
?></font>

</td></tr><br>

<tr><td class="texto">
<?

          
         if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)

          {
                $material=$row[material_tecnica].", ";
                $medidas_ing= formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']). " x " . formata_valor_3($row['dim_obra_profund']) . " cm"; 
               
           }

           if ($row['dim_obra_profund'] > 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
           {
                $material=$row[material_tecnica].", ";
                $medidas_ing= "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm ; " . formata_valor_3($row['dim_obra_profund']) . " cm (profundidade)";
            }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
           {
                $material=$row[material_tecnica].", ";
                $medidas_ing="&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm";
           }

	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] == 0)
           {
                $material=$row[material_tecnica].", ";
                $medidas_ing= formata_valor_3($row['dim_obra_altura']) ." x " . formata_valor_3($row['dim_obra_largura']) . " cm";   
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
           {
                $material=$row[material_tecnica].", ";
                $medidas_ing= formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)";
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
            {
                $material=$row[material_tecnica].", ";
                $medidas_ing="&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) ." cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)";
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] == 0 and $row['aimp_obra_diametro'] > 0 and $row['aimp_obra_altura'] == 0)
	   {
                $material=$row[material_tecnica].", ";
                $medidas_ing= "&Oslash; = " . formata_valor_3($row['aimp_obra_diametro']) . " cm (área impressa); ". formata_valor_3($row['dim_obra_altura']) . " x " . formata_valor_3($row['dim_obra_largura']) . " cm (suporte)";
           }
	   if ($row['dim_obra_profund'] == 0 and $row['dim_obra_diametro'] > 0 and $row['aimp_obra_diametro'] == 0 and $row['aimp_obra_altura'] > 0)
           {
                $material=$row[material_tecnica].", ";
                $medidas_ing=formata_valor_3($row['aimp_obra_altura']) . " x " . formata_valor_3($row['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($row['dim_obra_diametro']) . " cm (suporte)";
           } 
  	?>

<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$material</font>"?>      
<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$medidas_ing<font>"?><br>
  	
<?
$parteass=parte_ass($row['obra']);
?>
<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$parteass</font>"?><br>
<?

 

					$dat_2=''; 
                                                                      
                                                                     $aquisicao_ing='';
					if ($row['dt_aquisicao_tp'] == 'circa') if ($modelo4=='true' ) $dat_ing.= " circa ";                                
					if ($row['dt_aquisicao_ano1'] <> '0') {  $dat_2.= exibeDataNegativa($row['dt_aquisicao_ano1']);  }
					if ($row['dt_aquisicao_ano2'] <> '0') {  if ($row['dt_aquisicao_ano2'] <> $row['dt_aquisicao_ano1'] )
							                              $dat_2.= " / ".exibeDataNegativa($row['dt_aquisicao_ano2']);  }
					if ($row['dt_aquisicao_tp'] == '?') $dat_2.=" (?) ";
					$aquisicao= strtolower(ret_aquisicao($row[forma_aquisicao]));
					$aquisicao_ing= strtolower(ret_aquisicao_ing($row[forma_aquisicao]));
					if ($aquisicao == ''){
					   $aquisicao= 'procedência desconhecida';
					   $aquisicao_ing= 'Origin unknown';
                                                                       }
                                                                      $aquisicao_ing=$aquisicao_ing . ", " . $row['doador'];
                                                                      $aquisicao=$aquisicao. ", " . $row['doador'];
					if (strlen($dat_2) > 3)
                                                                       {    
                                                                               $aquisicao_ing=$aquisicao_ing.", " . $dat_2;
                                                                           $aquisicao=$aquisicao.", " . $dat_2;
					  }

					$dat_2="";
?>
<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$aquisicao</font>"?><br><br>

</td></tr>


<tr><td class="texto">
<?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$row[texto_etiq]</font>"?><br><br>

</td></tr>


<tr><td class="texto">
<?$medidas_ing=formata_ing($medidas_ing);?>

<?if ($modelo4=='true') {?><?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'><b>$titulo_etiq_ing</b>$dat_ing</font>"?><?}?><br>
<?if ($modelo4=='true') {?><?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$material</font>"?><?}?>               
<?if ($modelo4=='true') {?><?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$medidas_ing<br></font>"?><?}?>
</td></tr>

<?
$parteass_ing=parte_ass_ing($row['obra']);

?>
<?if ($modelo4=='true') {?><?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$parteass_ing<br></font>"?><?}?>
<?if ($modelo4=='true') {?><?echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:$tf;'>$aquisicao_ing<br><br></font>"?><?}?>

<?$sql_seq="SELECT fotografia from fotografia_obra where (obra = '$obra_id') order by eh_mini='1' desc";
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




if ($imgexiste ==1){
   $dirimg= 'http://'.$_SERVER[SERVER_ADDR].'/donato/'.$dir_virtual.$url.'/'.combarra_encode($nomearq);

  if ( $modelo7=='true'){

       $sql_trid= "SELECT * from obra where obra in ($obra_id) order by num_registro + 0";
       $db_trid->query($sql_trid);
       $row_trid=$db_trid->dados();
          if (($row_trid[dim_obra_altura] <> '0.00') and ($row_trid[dim_obra_profund] <> '0.00') and ($row_trid[dim_obra_largura] <> '0.00')){
?>
     <table height="50%" width="100%" border="0">
        <tr>      
           <td  class="texto" width="100%" id=fundo colspan="0" valign="top" align="center">  
		    
             <p align="center"><img src="<?  echo 'http://'.$_SERVER[SERVER_ADDR].'/donato/'.$dir_virtual.$url.'/'.combarra_encode($nomearq); ?>" height="<?   echo $Ao; ?>" width="<?  echo $Lo; ?>"></p>

           </td>
        </tr>
      </table>
      <?}
     }
   }?>





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
				

  ?>

    <tr class="noprint"> 
  </tr>


<? } 





?>
</body>
</html>