<? include_once("seguranca.php");
include("classes/funcoes_extras.php"); ?>
<html>

<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('obra_lista_pesquisa.php?tipo=<? echo $_REQUEST[tipo]?>&movid=<? echo $_REQUEST[movid] ?>&page='+ i);

}}
</script>

</head>
<?
        include("classes/classe_padrao.php");
        $db=new conexao();
        $db->conecta();
        $db1=new conexao();
        $db1->conecta();
        $db2=new conexao();
        $db2->conecta();
        $db3=new conexao();
        $db3->conecta();
        $dbobra=new conexao();
        $dbobra->conecta();
        $dbautor=new conexao();
        $dbautor->conecta();



//////////////////////
 /////FUNÇÕES/////
////////////////////

function ret_cidade_estado($val,$tab,$id)
{
 global $db2;
 $sql="SELECT nome from ".$tab." as b where b.".$id."=".$val;
 $db2->query($sql);
 $res=$db2->dados();
 return $res[0];
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
 return number_format($altura,1,",",".") . " x " . number_format($largura,1,",",".") . " cm (".$tipo.")";
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

 ?>


<body>
      <?
      $pagesize=9;
      if(!empty($_GET['pagesize']))
         $pagesize=$_GET['pagesize'];
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
      $registroinicial=$page* $pagesize;

      $movid= $_REQUEST['movid'];
      $tipo= 'movimentacao';
      $valor= $movid;
      $parametro= 'movid';
      $numlinhas=$numlinhas[0];
	?>




          <?
    /////////////////////////////////
   //////DADOS DA EXPOSICAO/////////
  /////////////////////////////////

	  $sql2="SELECT DISTINCT a.nome 
                   FROM exposicao as a  INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao)  
                   where $tipo='$valor'order by a.nome,a.dt_inicial,a.dt_final LIMIT $registroinicial,$pagesize";
	           $db->query($sql2);?> 
	  




  <table width="95%" border=0 align=left cellpadding="10" cellspacing="0"> 
   <tr><td>

    <?////////////////////////
     ///1ºCABEÇALHO//////////
    ////////////////////////?>

         <tr><td>
            <table align=left width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
               <tr width="100%" >
                
                  <td  width="35%" align=left>
                     <font style="font-family:times new roman,arial; font-size:32px;"><em>S</em></font><font style="font-family:times new roman,arial; font-size:18px;">imba</font>
                  </td>
                  <td  width="35%" align=right>
                     <font style="font-family:times new roman,arial; font-size:32px;"><em>M</em></font><font style="font-family:times new roman,arial; font-size:18px;">ovimentação do Acervo</font>


                  <?///////////////////////////////////////
                   ////3ª linha         movimentação//////
                  /////////////////////////////////////////?>
                        <?if ($movid <>"") {?>
    	             <? $sql= "SELECT * from movimentacao as a  where movimentacao=".$movid; 
 	           	    $db1->query($sql);
		    $movi=$db1->dados();?>
                           <font style="font-size:10px;"></font>
                            <font style="font-family:arial,times new roman; font-weight:normal; font-size:13px;">
                            <?
                               if ($movi[movimentacao]<>"") { 
			       $dtsaida= explode("-", $movi['data_saida']);
			       $dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			       $dtsaida= $dia."/".$mes."/".$ano;
			       if ($dtsaida=="00/00/0000" || $dtsaida=="//")
			          $dtsaida= "--/--/----";
			       $dtretorno= explode("-", $movi['retorno_provavel']);
			       $dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
			       $dtretorno= $dia."/".$mes."/".$ano;
			       if ($dtretorno=="00/00/0000" || $dtretorno=="//")
			          $dtretorno= "--/--/----";
                              }
                            ?><br>
 		            <b><? if ($movi[tipo_mov]=='EI')  echo "Exposição Interna";
		                if ($movi[tipo_mov]=='EE')  echo "Exposição Externa";
		                if ($movi[tipo_mov]=='LI')  echo "Local Interno";
		                if ($movi[tipo_mov]=='LE')  echo "Local Externo";

                                echo ", ".$movi[movimentacao];?></b>                                             
                                <br>
                                <? echo "Saída prevista: ".$dtsaida?></b><br>
                              <? echo "Retorno provável: ".$dtretorno?><br>


                           <? }?>
                           </font>                           

 

                  </td>
               </tr>
               <tr>
                   <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
               </tr>
            </table>
        </td><tr>

   <?////////////////////////
   /////2ºCABEÇALHO/////////
  /////////////////////////?>

        <tr><td>
            <table align=left width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
             <tr width="100%">
              </tr>
              <?
              while($row=$db->dados()){
	         $sql3="SELECT a.*, b.* 
                 FROM exposicao as a  INNER JOIN  ".$tipo."_exposicao as b on (a.exposicao=b.exposicao)  
                 Where ($tipo='$valor') and (nome='".$row[nome]."') order by a.nome,a.dt_inicial,a.dt_final LIMIT $registroinicial,$pagesize";
	         $db3->query($sql3);?> 
                
                    
                                           
                                              
                  <tr width="100%" >
                     <?///////////////////
                      /////EXPOSIÇÕES//////
                      ///////////////////  
                         ?>	            
 
                      <td  width="100%" align="Left">
                        <font style="font-family:arial,times new roman; font-weight:normal; font-size:14px;">


                         <?echo '<font face="Arial, Helvetica, sans-serif" size="+1">'.$row[nome].'</font>';?>                           
                        </font>
                   
                   <? while($row3=$db3->dados()){?>
                      <tr>
                       <td width="100%" align="Left>
                                  <? 
			       $dtsaida= explode("-", $row3[dt_inicial]);
			       $dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			       $dtsaida= $dia."/".$mes."/".$ano;
			       if ($dtsaida=="00/00/0000" || $dtsaida=="//")
			          $dtsaida= "--/--/----";
			       $dtretorno= explode("-", $row3[dt_final]);
			       $dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
			       $dtretorno= $dia."/".$mes."/".$ano;
			       if ($dtretorno=="00/00/0000" || $dtretorno=="//")
			          $dtretorno= "--/--/----";
 
                                          ?>                                  
                           <font style="font-family:arial,times new roman; font-weight:normal; font-size:12px;">
                            <? echo $row3[instituicao].", ";?><? echo "Período:".$row3[periodo];?>
                             <? if (($row3[dt_inicial]<>"")or($row3[dt_final]<>"")){?><? echo "de ".$dtsaida." a ".$dtretorno;?><?}?>                                  
                          </font>
                        <font style="font-family:arial,times new roman; font-weight:normal; font-size:12px;">
                             <? if (($row3[cidade]<>"")and($row3[estado]<>"")){?><? echo $row3[cidade].", ".ret_cidade_estado($row3[estado],"estado","estado");?><?}?> 
                             <? if ($row3[pais]<>""){?>&nbsp;<? echo ret_cidade_estado($row3[pais],"pais","pais");?><br><?}?>
                        </font> 
                         <br>
                        </td>
                      </tr>
                   <?}?>
                     </td>

                  </tr>
               <tr> 
                  <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
              </tr>
            <? }?>
            </table>
        </td><tr>

     <?  ////PRIMEIRO WHILE - PRIMEIRO CABEÇALHO////?>



   <?//////////////////
   /////DADOS/////////
  ///////////////////?>
 
        <tr><td>
            <table align=left width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
               <?//////////OBRA//////////////////////
                 $sqlobra="SELECT a.*,b.*,b.data_saida as saida_obra,b.data_retorno as retorno_obra, a.material_tecnica FROM obra as a  INNER JOIN  obra_movimentacao as b on (a.obra=b.obra) where movimentacao='$_REQUEST[movid]' order by a.titulo LIMIT $registroinicial,$pagesize";
	         $dbobra->query($sqlobra);
                 $count= 0;
                 while($rowobra=$dbobra->dados()){?>
               <tr width="100%" >
                  <td  width="50%" align=left>
                   <?///////////////////
                   /////1ª coluna//////
                  ////////////////////?>


               <?//////// AUTOR ///////////////////
	             $count++;
		     $sqlautor= "SELECT a.* from autor as a  INNER JOIN  autor_obra as b on (a.autor=b.autor) where b.obra='$rowobra[obra]' AND b.hierarquia = 1 order by b.hierarquia";
		     $dbautor->query($sqlautor);
                      while($autor=$dbautor->dados()) 
                        {                        
   	              $lista_autoria= "";
     	              $nasc='';
	              $mort='';
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
			elseif ($rowobra[cidade_nasc]==''&& $pais=='')
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
		$lista_autoria .= "<b>".$autor['nomeetiqueta']."<br></b><em>".$nasc." - ".$mort.  "</em></b><br>";
	
		echo "<font style='font-family:arial; font-weight:normal; font-size:14px;'>" . $lista_autoria . "</font>";
		
			}	?>

      
        <font style="font-size:10px;"><br>
        </font><font style="font-family:times new roman,arial; font-weight:normal; font-size:14px;"><em><? echo ret_colecao_obra($rowobra[obra]); ?></em></font> 
        <br>
        <? echo "<font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'>" ?><b><? echo $rowobra[num_registro]; ?> 
        <? if ($rowobra['eh_destaque_acervo'] == 'S') echo "<b><font style='color:maroon;'>&nbsp;&nbsp;&nbsp;(destaque do acervo)</font>"; ?>
        </b> <font style="font-size:8px;"><br>
        </font><font style='font-family:arial,times new roman; font-weight:normal; font-size:13px;'><b><? echo $rowobra[titulo_etiq]; ?></b> 
        <?
 		      $dataqui='';
		      if ($rowobra['dt_aquisicao_tp'] == 'circa')$dataqui.= " circa ";

		      if ($rowobra['dt_aquisicao_ano1'] <> '0')$dataqui.= $rowobra['dt_aquisicao_ano1'];
		
		      if ($rowobra['dt_aquisicao_ano2'] <> '0') {
		      if ($rowobra['dt_aquisicao_ano2'] <> $rowobra['dt_aquisicao_ano1'])
							$dataqui.= " / ".$rowobra['dt_aquisicao_ano2'];}

		      if ($rowobra['dt_aquisicao_tp'] == '?') $dataqui.=" (?) ";
		      $aquisicao= strtolower(ret_aquisicao($rowobra[forma_aquisicao]));
		      if ($rowobra[periodo] <> '') echo ', '.$rowobra[periodo];
		      else
                        $p_datas= ret_data_obra($rowobra['obra']);
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
	      		   if ($p_data_extra1 <> $p_data) $dat.= " / ".$p_data_extra1;
			}

		      if ($p_data_extra2 == '?')$dat.=" (?) ";
		      if (strlen($dat) > 3)echo ", " . $dat;
                         ?>
                       <br>
                       <? if ($rowobra['dim_obra_profund'] > 0 and $rowobra['dim_obra_diametro'] == 0 and $rowobra['aimp_obra_diametro'] == 0 and $rowobra['aimp_obra_altura'] == 0)
		          echo $rowobra[material_tecnica].", " . formata_valor_3($rowobra['dim_obra_altura']) . " x " . formata_valor_3($rowobra['dim_obra_largura']). " x " . formata_valor_3($rowobra['dim_obra_profund']) . " cm"; 	           
                          elseif ($rowobra['dim_obra_profund'] > 0 and $rowobra['dim_obra_diametro'] > 0 and $rowobra['aimp_obra_diametro'] == 0 and $rowobra['aimp_obra_altura'] == 0)
		          echo $rowobra['material_tecnica'].", ". "&Oslash; = " . formata_valor_3($rowobra['dim_obra_diametro']) . " cm ; " . formata_valor_3($rowobra['dim_obra_profund']) . " cm (profundidade)"; 
	                  elseif ($rowobra['dim_obra_profund'] == 0 and $rowobra['dim_obra_diametro'] > 0 and $rowobra['aimp_obra_diametro'] == 0 and $rowobra['aimp_obra_altura'] == 0)
		          echo $rowobra['material_tecnica'].", " . "&Oslash; = " . formata_valor_3($rowobra['dim_obra_diametro']) . " cm";
	                  elseif ($rowobra['dim_obra_profund'] == 0 and $rowobra['dim_obra_diametro'] == 0 and $rowobra['aimp_obra_diametro'] == 0 and $rowobra['aimp_obra_altura'] == 0)
		          echo $rowobra['material_tecnica'].", " . formata_valor_3($rowobra['dim_obra_altura']) . " x " . formata_valor_3($rowobra['dim_obra_largura']) . " cm"; 
	                  elseif ($rowobra['dim_obra_profund'] == 0 and $rowobra['dim_obra_diametro'] == 0 and $rowobra['aimp_obra_diametro'] == 0 and $rowobra['aimp_obra_altura'] > 0)
		          echo $rowobra['material_tecnica'].", " . formata_valor_3($rowobra['aimp_obra_altura']) . " x " . formata_valor_3($rowobra['aimp_obra_largura']) . " cm (área impressa); ". formata_valor_3($rowobra['dim_obra_altura']) . " x " . formata_valor_3($rowobra['dim_obra_largura']) . " cm (suporte)"; 
	                  elseif ($rowobra['dim_obra_profund'] == 0 and $rowobra['dim_obra_diametro'] > 0 and $rowobra['aimp_obra_diametro'] > 0 and $rowobra['aimp_obra_altura'] == 0)
		          echo $rowobra['material_tecnica'].", " . "&Oslash; = " . formata_valor_3($rowobra['aimp_obra_diametro']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($rowobra['dim_obra_diametro']) . " cm (suporte)"; 
	                  elseif ($rowobra['dim_obra_profund'] == 0 and $rowobra['dim_obra_diametro'] == 0 and $rowobra['aimp_obra_diametro'] > 0 and $rowobra['aimp_obra_altura'] == 0)
		          echo $rowobra[material_tecnica].", " . "&Oslash; = " . number_format($rowobra['aimp_obra_diametro'],1,",",".") . " cm (área impressa); ". formata_valor_3($rowobra['dim_obra_altura']) . " x " . formata_valor_3($rowobra['dim_obra_largura']) . " cm (suporte)"; 
	                  elseif ($rowobra['dim_obra_profund'] == 0 and $rowobra['dim_obra_diametro'] > 0 and $rowobra['aimp_obra_diametro'] == 0 and $rowobra['aimp_obra_altura'] > 0)
		          echo $rowobra[material_tecnica].", " . formata_valor_3($rowobra['aimp_obra_altura']) . " x " . formata_valor_3($rowobra['aimp_obra_largura']) . " cm (área impressa); ". "&Oslash; = " . formata_valor_3($rowobra['dim_obra_diametro']) . " cm (suporte)" ; 
                          else 
		          echo $rowobra[material_tecnica].", (ERRO - verificar dimensões na ficha técnica)"; 


	?>
        <!--<br>fotografia, <? /*echo number_format($rowobra['aimp_obra_altura'],1,",",".") . " x " . number_format($rowobra['aimp_obra_largura'],1,",",".") . " cm(área impressa); " . ret_dim_parte($rowobra['obra']); */ ?>-->
        <br>
        <? 
		echo parte_ass($rowobra['obra']);
					
		if ($aquisicao == '')
			$aquisicao= 'procedência desconhecida';
			echo "<br>".$aquisicao . ", " . $rowobra['doador'];
		if (strlen($dataqui) > 3)
			echo ", " . $dataqui;
		if ($row['texto_etiq'] <> '') {
			echo "<font style='font-size:8px;'><br><br><br></font><font style='font-family:times new roman,arial; font-weight:normal; font-size:14px;'><em>" . $rowobra['texto_etiq'] . "<br></em></font>";
					}

	?>



                                          
                     </td>
                   <?///////////////////
                   /////2ª coluna//////
                  ////////////////////?>
               
                      <td  width="50%" align=right>
                          <font style="font-size:10px;">
                          <?
			     $dtsaida= explode("-", $rowobra['data_saida']);
			     $dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
			     $dtsaida= $dia."/".$mes."/".$ano;
			     if ($dtsaida=="00/00/0000" || $dtsaida=="//")
				$dtsaida= "--/--/----";

			     $dtretorno= explode("-", $rowobra['data_retorno']);
			     $dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
			     $dtretorno= $dia."/".$mes."/".$ano;
			     if ($dtretorno=="00/00/0000" || $dtretorno=="//")
				$dtretorno= "--/--/----";
                           ?>

                             <font style="font-family:arial,times new roman; font-weight:normal; font-size:14px;"><? echo "</em><br>Saída:   <em>".$dtsaida."</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;retorno:   <em>".$dtretorno."</em><br>"; ?></font>
                          </font> 
                          </b> 
                     <tr> 
                       <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
                    </tr>

                  </td>
               </tr>
             <?}?>
            </table>
        </td><tr>

   <?//////////////////
   /////PAGINANDO/////
  ///////////////////?>

      <?$pagesize=9;
        if(!empty($_GET['pagesize'])) $pagesize=$_GET['pagesize'];
        $page=1;
        if(!empty($_GET['page'])) $page=$_GET['page'];
        $page--;
	$registroinicial=$page* $pagesize;
	$sql="SELECT count(*) as total from obra_movimentacao where movimentacao='$_REQUEST[movid]'";
	$db->query($sql);
	$numlinhas=$db->dados();
        $numlinhas=$numlinhas[0];?>
 

      <?//////////////////////////////////
     /////RETOMANDO A PAGINAÇÃO/////////
     ///////////////////////////////////?>
		   
      <?$numpages=ceil($numlinhas/$pagesize);  
        $page_atual=$page+1;
        $mais=$page_atual+1;
        $menos=$page_atual-1;
        $first=1;  
        $last=$numpages;
        if($mais>$numpages)$mais=$numpages;

        $a="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";
        $b="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";
        $c="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";
        $d="<a href=\"obra_lista_pesquisa.php?movid=".$_REQUEST[movid]."&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
        $combo="";

        for($i=1;$i<=$numpages;$i++)
           { if ($i==$page_atual) {
           $combo = $combo . "<option value='$i' selected >$i</option>";}
           else{ $combo.="<option value='$i'>$i</option>";}
         } 
        $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
        if ($last < 2) {
	   $lista_combo= "";$a= "";$b= "";$c= "";$d= "";
         }
        $txtpagina= "";
        if ($_REQUEST[pagesize] < 999) {
	   $txtpagina= "- Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;";
         }
         $g= " $numlinhas ".$txtpagina.$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";?>


      <?//////////////////
     /////RODAPÉ/////////
     ///////////////////?>


        <tr><td>
            <table align=left width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
                  <tr width="100%" >
                  <td  width="50%" align=right>
                   <p align="center">
	                <font style='font-family:arial,times new roman; font-weight:bold; font-size:10px;'><? echo $numlinhas; ?> obra(s)
	                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                   <? echo percente_obras($numlinhas); ?> % do acervo
	                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                   Final de relatório
	                </font>
	                <br>
	                <font style='font-family:arial,times new roman; font-weight:normal; font-size:10px;'><em>Impresso por <? echo $_SESSION['snome']; ?> em <? echo date("d/m/Y"); ?> </em>&nbsp;</font>
                      </p>   
                  </td>
               </tr>
            </table>
        </td><tr>
    </td></tr>
</table>
</body>
</html>