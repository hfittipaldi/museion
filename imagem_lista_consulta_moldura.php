<? include_once("seguranca.php") ?>
<html>
<head>
<title>Imagens vinculadas à obra</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
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
        $obraimg=$_REQUEST[obra];
        $id=$_REQUEST[id];
        $dirrotacao= diretorio_fisico_rotacao();
	$dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();


 ?>

  <table width="155" height="1" border="0" valign="top" align="center" cellpadding="0" cellspacing="0" >
      <tr width="100%" height="1" align="center" valign="top">
         <td valign="top" align="center">
 <?
	  /////Paginando
	  $pagesize= paginacao_imagem();
          $page=1;
        if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;
	  $sql="SELECT count(*) from restauro_fotografia as a,restauro as b where a.restauro=b.restauro and a.restauro='$_REQUEST[id]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
          $numlinhas=$numlinhas[0];
	
	  $sql2="SELECT a.* from restauro_fotografia as a,restauro as b where a.restauro=b.restauro and a.restauro='$_REQUEST[id]' 
	  order by tipo,ordem asc LIMIT $registroinicial,$pagesize ";echo $sql2;
	  $db->query($sql2);
	  ////////////////////
	  ////////////////////
	  
	   ?>
 		<? while($row=$db->dados()) {
  
				// Obtem as dimensoes da obra //
			$sql2="SELECT a.* from fotografia as a where  a.fotografia = '$row[fotografia]'";echo $sql2;
				$db2->query($sql2);
				$dim= $db2->dados();
				$principal= $dim['eh_principal'];
				$altu= number_format($dim['dim_obra_altura'],1,",",".");
				$larg= number_format($dim['dim_obra_largura'],1,",",".");
				$diam= number_format($dim['dim_obra_diametro'],1,",",".");
				if ($altu == '0,0')
					$altu= '';
				if ($larg == '0,0')
					$larg= '';
				if ($diam == '0,0')
					$diam= '';
				////*/
				
				//$sql2="SELECT * from restauro_fotografia where restauro = '$row[restauro]'";
				//$db2->query($sql2);
				if ($img!='') {
					//$imagem= '';
/*					$ext=$img['ext'];
					if ($img['restauro_fotografia'] <> '') {
						$imagem= $img['restauro_fotografia'].'.'.$ext;
						$noimage= '';
						if (file_exists($dir.$imagem)) {
							list($width, $height, $type, $attr)= getimagesize($dir_virtual.$imagem);
							$Ao= $height;
							$Lo= $width;*/
					$sql2="SELECT nome_arquivo, diretorio_imagem from fotografia where fotografia = '$img[fotografia]'";
					$db2->query($sql2);
					if ($img2=$db2->dados()) {
						$imagem= '';
						if ($img2['nome_arquivo'] <> '') {
							$imagem= $img2['nome_arquivo'];
							$diretorio_imagem=$img2['diretorio_imagem'];
							 $sql3="SELECT url from diretorio_imagem where diretorio_imagem='$diretorio_imagem'";
							 $db->query($sql3);
							 $url=$db->dados();
							 $noimage= '';
							 if (file_exists($dir.$url[0].'\\'.$imagem)) {
								list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
								$Ao= $height;
								$Lo= $width;

							//250 é a altura max da área de exibição da imagem; 350 é a largura máxima.//
							$cA= $Ao / 250;
							$cL= $Lo / 350;

							if ($Ao > 250 || $Lo > 350) {
								if (cL < cA) {
									$percent= (350 * 100) / $Lo;
									$Lo= 350;
									$Ao= ($Ao * $percent) / 100;
									if ($Ao > 250) {
										$percent= (250 * 100) / $Ao;
										$Ao= 250;
										$Lo= ($Lo * $percent) / 100;
									}

								} else {
									$percent= (250 * 100) / $Ao;
									$Ao= 250;
									$Lo= ($Lo * $percent) / 100;
									if ($Lo > 350) {
										$percent= (350 * 100) / $Lo;
										$Lo= 350;
										$Ao= ($Ao * $percent) / 100;
									}
								}
							}
						} else
							$noimage= "<br>Arquivo não encontrado no servidor: <br> <br> <font style='font-weight: normal;'> ".$dir.$url[0].'\\'.$imagem." </font>";
					}
				}
			}
		  ?>
                    <font style='font-family:arial; font-weight:normal; font-size:11px;'>N&ordm; de registro&nbsp;&nbsp;</font><b><?echo $dim['num_registro']?></b>

                    <? if (($imagem <> '') && ($numlinhas>0))
                     { ?>	
							
                       <img alt='<?echo $row['tit']?>' style="cursor:pointer;" src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0' onClick='document.getElementById("img_pop_imagem").click();'>								
                       <? echo $noimage; 
                    }?>
                
                    <? if (($imagem<>'') && ($noimage=='')&& ($numlinhas>0))?><a id="img_pop_imagem"  href="javascript:;" onClick="abrepop('pop_imagem.php?fotografia=<?echo $row['foto']?>&obra=<? echo $obraimg;?>&exibicao=<? echo $row2[forma_exibicao]; ?>&principal=<? echo $principal; ?>&imagem=<? echo $url[0].'/'.$imagem; ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>&profundidade=<? echo $prof; ?>', <? echo $height; ?>, <? echo $width; ?>);"></a>

              </tr>

        <?}?>
    </tr>


	<? if (($imagem=="")&&($noimage=="")) { ?>
            
            <tr align="center"><td align ="center"><font style='font-family:arial; font-weight:normal; font-size:11px;'>N&ordm; de registro&nbsp;&nbsp;</font><b><?echo $numreg?></b></td></tr>

           <? echo "<tr width='100%' class='texto' align='center'><td width='90%' class='texto' align='center' valign='middle'  style='border: 1px dashed #ABABAB; color:#444444;'><sup><br><br><br><br><br><br>Imagem não disponível<br><br><br><br><br><br></sup></td></tr>";
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

$a="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"imagem_lista_consulta.php?obra=$_REQUEST[obra]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
                             if (file_exists($dirrotacao.$_REQUEST[obra].'.zip')) {
   				echo "<b><a href='javascript:;' onClick=";
                                echo '"';
				echo "abrepop3D('rotate/rotacao.php?id=";
				echo $_REQUEST[obra];
				echo "'); ";
				echo '"';
				echo '"';
				echo " ><img src=imgs/icons/btn_3d_azul.gif title='Visualiza rotação...' border=0></a>";?>
                                <br></b><font font-size:3px> (Arquivo gerado: <?echo $_REQUEST['obra'].".zip"?>)</font>
                      <?}else{?>
                           <a><img src="imgs/icons/btn_3d_cinza.gif" title="Visualiza rotação..." border="0"></a>
                          <br><font font-size:3px><em> (Salvar como: <?echo $_REQUEST['obra'].".zip"?>)</em></font>
                      <?}
                    }?>
                    
                      </td>
</tr>	  

   </table>


</html>