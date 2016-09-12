<? include_once("seguranca.php") ?>
<html>
<head>
<title>Imagens vinculadas à obra</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script bgcolor=#f2f2f2>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('imagem_lista_consulta1.php?obra=<? echo $_REQUEST[obra] ?>&page='+ i);

}}

function abrepop(janela,alt,larg) {
	var h=screen.height-100,w=screen.width-50;
	win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
function abrepop3D(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-270)+',top='+((window.screen.height/2)-180)+',width=550,height=400, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4)
    {
        win.window.focus();
    }
 return true;
}

</script>

</head>
<?
	include("classes/classe_padrao.php");
	include("classes/funcoes_extras.php");
	$db=new conexao();
	$db->conecta();
	$db2=new conexao();
	$db2->conecta();
	$db4=new conexao();
	$db4->conecta();
	$db5=new conexao();
	$db5->conecta();

        $obraimg=$_REQUEST[obra];
        $dir= diretorio_fisico();
        $dir_virtual= diretorio_virtual();
        $dirrotacao= diretorio_fisico_rotacao();



 ?>

  <table width="155" height="1" border="0" valign="top" align="center" cellpadding="0" cellspacing="0">
      <tr width="100%" height="1" align="center" valign="top">
         <td valign="top" align="center">
 <?
	  /////Paginando
//	  $pagesize=1;
	  $pagesize= paginacao_imagem();
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
       $registroinicial=$page* $pagesize;
          $sql="SELECT dim_obra_altura,dim_obra_largura,dim_obra_profund from obra where (obra = '$_REQUEST[obra]')";
          $db->query($sql);
          $numreg=$db->dados();
          $altu=  $numreg['dim_obra_altura'];
          $larg= $numreg['dim_obra_largura'];
          $prof= $numreg['dim_obra_profund'];
  
      
          $sql="SELECT num_registro from obra where (obra = '$_REQUEST[obra]')";
          $db->query($sql);
          $numreg=$db->dados();
          $numreg=$numreg[0];


          
          $sql="SELECT count(*) from fotografia_obra as a, fotografia as b where (a.fotografia = b.fotografia) AND (a.obra = '$_REQUEST[obra]')";
          $db->query($sql);
          $numlinhas=$db->dados();
          $numlinhas=$numlinhas[0];
          $sql2="SELECT a.*,b.titulo as tit,b.fotografia as foto, b.fotografia as foto,b.forma_exibicao from fotografia_obra as a, fotografia as b where (a.fotografia = b.fotografia) AND (a.obra = '$_REQUEST[obra]') order by a.eh_mini desc, a.eh_principal desc LIMIT $registroinicial,$pagesize";
          $db->query($sql2);
          while($row=$db->dados()) 
          {
                  // Obtem as dimensoes da obra //
	     $sql2="SELECT a.*,b.eh_mini,b.eh_principal from obra as a, fotografia_obra as b where a.obra = b.obra AND b.fotografia = '$row[foto]' ";
	     $db2->query($sql2);
	     $dim= $db2->dados();
	     $eh_mini= $dim['eh_mini'];
                   $eh_principal= $dim['eh_principal'];
	     $altu= number_format($dim['dim_obra_altura'],1,",",".");  if ($altu == '0,0')$altu= '';
	     $larg= number_format($dim['dim_obra_largura'],1,",","."); if ($larg == '0,0')$larg= '';
	     $diam= number_format($dim['dim_obra_diametro'],1,",",".");if ($diam == '0,0')$diam= '';
                   $prof= number_format($dim['dim_obra_profund'],1,",","."); if ($prof == '0,0')$prof= '';	     
	     $sql2="SELECT nome_arquivo,diretorio_imagem from fotografia where fotografia = '$row[foto]'";
	     $db2->query($sql2);
	     if ($img=$db2->dados()) {
	        $imagem= '';
		if ($img['nome_arquivo'] <> '') {
		   $imagem= $img['nome_arquivo'];
		   $diretorio_imagem=$img['diretorio_imagem'];
		   $sql3="SELECT url from diretorio_imagem where diretorio_imagem='$diretorio_imagem'";
		   $db->query($sql3);
		   $url=$db->dados();
		   $noimage= '';
		   if (file_get_contents($dir.$url[0].'/'.$imagem)) {
		      list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
		          $Ao= $height;
		         $Lo= $width;
                                     //160 é a altura max da área de exibição da imagem; 110 é a largura máxima.//
		         $cA= $Ao / 190;
		         $cL= $Lo / 140;
		       if ($Ao > 190 || $Lo > 140) 
                                  {if (cL < cA) 
                                    { $percent= (190 * 100) / $Lo; 
                                      $Lo= 140;
                                      $Ao= ($Ao * $percent) / 100;
	                        if ($Ao > 190) 
                                      {$percent= (190 * 100) / $Ao;
                                       $Ao= 190;
		           $Lo= ($Lo * $percent) / 100;
                                     }
                                 } else {
                                    $percent= (190 * 100) / $Ao; 
                                    $Ao= 190;
                                   $Lo= ($Lo * $percent) / 100;
                                   if ($Lo > 140){  
                                   $percent= (140 * 100) / $Lo;
                                   $Lo= 140;  
                                   $Ao= ($Ao * $percent) / 100;								
                                  }
                              }
                          
                       }
		      $noimage= "";  
                    } else {
                      $noimage= "<tr width='100%' class='texto' align='center'><td width='90%' class='texto' align='center' valign='middle'  style='border: 1px dashed #ABABAB; color:#444444;'><sup><br><br><br><br><br><br>Imagem não disponível<br><br><br><br><br><br></sup></td></tr>";
	      }
                 }
          } ?>
           <font style='font-family:arial; font-weight:normal; font-size:11px;'>N&ordm; de registro&nbsp;&nbsp;</font><b><?echo $dim['num_registro']?></b><br>

               <?////////// EXIBE A IMAGEM e CLICK IMAGEM eh_mini///////////////////?>

                     <? if ($noimage <> '') 
                     { ?>								
                         <? echo $noimage; 
                    }?>


                <?if ($imagem <> '' && $numlinhas>0 ){
                    if   ($eh_mini==0 and $eh_principal==0)
                         { ?> 
                             <img alt='<?echo $row['tit']?>' style="cursor:pointer;" src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'onClick='document.getElementById("img_pop_imagem").click();'>								
                          <?}
                    if ($eh_mini==1 or $eh_principal==1)
                       {  
                              $tit_mini=$row['tit'];
                              $imagem_mini=$imagem;
                              $Ao_mini=$Ao;
                              $Lo_mini=$Lo; ?>       

   
                               <?   if ($eh_mini==1){ 

	                               $sql4="SELECT a.*,b.titulo as tit,b.fotografia as foto, b.fotografia as foto,b.forma_exibicao from fotografia_obra as a, fotografia as b where (a.fotografia = b.fotografia)
	                               AND (a.obra = '$_REQUEST[obra]') order by a.eh_principal desc,a.fotografia asc LIMIT $registroinicial,$pagesize";
	                               $db->query($sql4);
 	                               $row4=$db->dados();
	                               $sql4="SELECT a.*,b.eh_principal from obra as a, fotografia_obra as b where a.obra = b.obra AND b.fotografia = '$row4[foto]' ";
	                               $db4->query($sql4);
	                               $dim4     = $db4->dados();
	                               $eh_principal_mini = $dim4['eh_principal'];
     	                               $altu  = number_format($dim4['dim_obra_altura'],1,",",".");  if ($altu == '0,0')$altu= '';
	                               $larg  = number_format($dim4['dim_obra_largura'],1,",","."); if ($larg == '0,0')$larg= '';
	                               $diam= number_format($dim4['dim_obra_diametro'],1,",",".");if ($diam == '0,0')$diam= '';
                                             $prof  = number_format($dim4['dim_obra_profund'],1,",","."); if ($prof == '0,0')$prof= '';	     
	                               $sql4 = "SELECT nome_arquivo,diretorio_imagem from fotografia where fotografia = '$row4[foto]'";
	                               $db4->query($sql4);
	                               if ($img4=$db4->dados()) 
                                             {
	                                  $imagem_principal= '';
		                    if ($img4['nome_arquivo'] <> '') 
                                                {
		                       $imagem_principal=$img4['nome_arquivo']; $diretorio_imagem=$img4['diretorio_imagem'];
		                       $sql5="SELECT url as url5 from diretorio_imagem where diretorio_imagem='$diretorio_imagem'";
		                       $db5->query($sql5);
		                       $url5=$db5->dados();
		                       $noimage= ''; 
		                       if (file_get_contents($dir.$url5[0].'/'.$imagem_principal)) 
                                                   {   
                                                        list($width_princ, $height_princ, $type_princ, $attr_princ)= getimagesize($dir_virtual.$url5[0].'/'.$imagem_principal);
		                            $Ao_princ= $height_princ;$Lo= $width_princ;
                                                        //160 é a altura max da área de exibição da imagem; 110 é a largura máxima.//
		                            $cA_princ= $Ao_princ / 190; $cL_princ= $Lo_princ / 140;
		                            if ($Ao_princ > 190 || $Lo_princ > 140) 
                                                        { 
                                                             if (cL_princ < cA) 
                                                             { 
                                                               $percent_princ= (190 * 100) / $Lo_princ; 
                                                               $Lo_princ= 140;
                                                               $Ao_princ= ($Ao_princ * $percent_princ) / 100;
			                      if ($Ao_princ > 190) 
                                                                {
                                                                   $percent_princ= (190 * 100) / $Ao_princ;
                                                                   $Ao_princ= 190;
			                         $Lo_princ= ($Lo_princ * $percent_princ) / 100;
                                                                 }
                                                             } else {
                                                                 $percent_princ= (190 * 100) / $Ao_princ; 
                                                                 $Ao_princ= 190;
                                                                 $Lo_princ= ($Lo_princ * $percent_princ) / 100;
                                                                 if ($Lo_princ > 140)
                                                                 {
                                                                     $percent_princ= (140 * 100) / $Lo_princ;
                                                                     $Lo_princ= 140;  
                                                                     $Ao_princ= ($Ao_princ * $percent_princ) / 100;								
                                                                 }
                                                            }                                       
                                                       }
		                            $noimage= "";    
   		                       } 
                                               }
                                             }	
                                $noimage= "";    ?>                           
                            <?  }  ///////fim mini?>                   
                       <?}?>  

                         <? if (($imagem<>'') && ($noimage=='')&& ($numlinhas>0)){?>
                              <img alt='<?echo $tit_mini?>' style="cursor:pointer;" src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao_mini; ?>" width="<? echo $Lo_mini; ?>"border='0' onClick='document.getElementById("img_pop_imagem").click();'>															

                            <? if ($eh_mini==1 ){ $principal=$eh_mini;?>
                                  <a id="img_pop_imagem"  href="javascript:;" onClick="abrepop('pop_imagem.php?fotografia=<?echo $row4['foto']?>&obra=<? echo $obraimg;?>&exibicao=<? echo $row4[forma_exibicao]; ?>&principal=<? echo $principal; ?>&imagem=<? echo $url5[0].'/'.$imagem_principal; ?>&altura=<? echo $altu; ?>&largura=<? echo $larg;  ?>&diametro=<? echo $diam;  ?>&profundidade=<? echo $prof;  ?>', <? echo $height;  ?>, <? echo $width;  ?>);"></a>
                            <?}else{ $principal=$eh_principal;?>
                                 <a id="img_pop_imagem"  href="javascript:;" onClick="abrepop('pop_imagem.php?fotografia=<?echo $row['foto']?>&obra=<? echo $obraimg;?>&exibicao=<? echo $row[forma_exibicao]; ?>&principal=<? echo $principal; ?>&imagem=<? echo $url[0].'/'.$imagem; ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>&profundidade=<? echo $prof; ?>', <? echo $height; ?>, <? echo $width; ?>);"></a>
                            <?}?>
                       <?}?>
              <?}?> 
       <? }?>

         <? if (($imagem=="")&&($noimage=="")) { ?>
            
            <tr align="center"><td align ="center"><font style='font-family:arial; font-weight:normal; font-size:11px;'>N&ordm; de registro&nbsp;&nbsp;</font><b><?echo $numreg?></b></td></tr>

           <? echo "<tr width='100%' class='texto' align='center'><td width='50%' class='texto' align='center' valign='middle'  style='border: 1px dashed #ABABAB; color:#444444;'><sup><br><br><br><br><br><br>Imagem não disponível<br><br><br><br><br><br></sup></td></tr>";
	?>	
        <tr>
          <td height="1" colspan="1" bgcolor="#003366"><img src="imgs/transp.gif" width="1" height="1"></td>
        </tr><? } ?>
        <tr class="texto">
          <td width="120%" align="center" colspan="0" height="110%"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'   border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif' border='0'  alt='Registro Anterior' ></a>";

$c="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'   border='0'  alt='Proximo Registro' ></a> ";

$d="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'    border='0'  alt='Ultimo Registro' ></a>";
$combo="";


 for($i=1;$i<=$numpages;$i++)
 {
 if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
  if ($last < 2) {
	$lista_combo= "";
	$a= "";
	$b= "";
	$c= "";
	$d= "";
  }

 if (strtoupper($_SESSION[snome]) != 'VISITANTE') 
{ 
      $g= "Total: $numlinhas";
      $g1="Página: $page_atual de $numpages";
      $g2= $lista_combo;
      $g3= $a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
      ?></td>
      
      <tr><td align="center">
   <?    if (($menos+1)==($first)) {
                     $g3= "&nbsp;&nbsp;&nbsp;&nbsp".$c."&nbsp".$d."";
            echo"<font color='003366'>$g3</font>";
         }else{           
               if (($menos+1)==($last)) {
                    $g3= $a."&nbsp".$b."&nbsp;&nbsp;&nbsp;&nbsp";
                    echo"<font color='003366'>$g3</font>";
                } else{                
                     if (($menos+1)<($last)) {
                        $g3= $a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
                         echo"<font color='003366'>$g3</font>";
                      }
                }                    
        }
        
}?>
      </td></tr>		  

               
                       
      </td>
   </tr>
<tr>
                    <td class="texto" align="center" valign="top">
             
                       
	 <? if ( ($larg>0) and ($altu>0) and ($prof >0) ){
                             if (file_get_contents($dirrotacao.$_REQUEST[obra].'.zip')) {
   				echo "<b><a href='javascript:;' onClick=";
                                echo '"';
				echo "abrepop3D('rotate/rotacao.php?id=";
				echo $_REQUEST[obra];
				echo "'); ";
				echo '"';
				echo '"';
				echo " ><img src=imgs/icons/btn_3d_azul.gif title='Visualiza rotação...' border=0></a>";?>
                                <br></b><font font-size:3px> Arquivo 3D (<?echo $_REQUEST['obra'].".zip"?>)</font>
                      <?}else{?>
                           <a><img src="imgs/icons/btn_3d_cinza.gif" title="Visualiza rotação..." border="0"></a>
                          <br><font font-size:3px><em>Para gerar 3D salvar como: <?echo $_REQUEST['obra'].".zip"?></em></font>
                      <?}
                    }?>
                    
                      </td>
</tr>	  

   </table>


</html>