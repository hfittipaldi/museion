<? include_once("seguranca.php") ?>
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
document.location=('imagem_lista_consulta_mold.php?id=<? echo $_REQUEST[id] ?>&op=<? echo $_REQUEST[op] ?>&page='+ i);

}}

function abrepop(janela,alt,larg) {
	var h=screen.height-100,w=screen.width-50;
	win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
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
        $obraid=$_REQUEST[obraid];
        
//	$dir= diretorio_fisico() . "restauro\\";
//	$dir_virtual= diretorio_virtual()."restauro/";
	$dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();

/*	//complemento dos diretorios; necessário pois as imagens de restauro não estão 
	//sendo obtidas pela tabela de fotografia, e sim pela de restauro_fotografia; 
	//(apesar de ter um registro de fotografia para cada imagem salva em restauro)
	 $sql="SELECT tipo from restauro where restauro='$_REQUEST[id]'";
	 $db->query($sql);
	 $tipo=$db->dados();
	 if ($tipo['tipo'] == 2) {
		$dir= $dir . "pintura\\";
		$dir_virtual= $dir_virtual . "pintura/";
		$url= "Pintura";
	 }
	 if ($tipo['tipo'] == 3) {
		$dir= $dir . "obra3d\\";
		$dir_virtual= $dir_virtual . "obra3d/";
		$url= "Pintura";
	 }

	 if ($tipo['tipo'] == 4) {
		$dir= $dir . "moldura\\";
		$dir_virtual= $dir_virtual . "moldura/";
		$url= "Pintura";
	 }
	 else {
		$dir= $dir . "papel\\";
		$dir_virtual= $dir_virtual . "papel/";
		$url= "Papel";
	 }
	//////*/
 ?>
  <table width="155" height="1" border="0" valign="top" align="center" cellpadding="0" cellspacing="0" >
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
	  $sql="SELECT count(*) from restauro_fotografia as a,restauro as b where a.restauro=b.restauro and a.restauro='$_REQUEST[id]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	
	  $sql2="SELECT a.* from restauro_fotografia as a,restauro as b where a.restauro=b.restauro and a.restauro='$_REQUEST[id]' 
	   order by ordem asc LIMIT $registroinicial,$pagesize";
	   $db->query($sql2);
	  ////////////////////
	  
                      while($img=$db->dados()) {
                  // Obtem as dimensoes da obra //


      if ($obraid>0)
      {
	    $sql2="SELECT a.*,b.*,b.tipo as tipo_rest,c.* from obra as a, restauro_fotografia as b, restauro as c
                   where a.obra = c.obra AND c.restauro='$_REQUEST[id]' and b.fotografia = '$img[fotografia]' and b.restauro=c.restauro";


	     $db2->query($sql2);
	     $dim= $db2->dados();
	     $eh_mini= $dim['eh_mini'];
                   $eh_principal= $dim['eh_principal'];
	     $altu= number_format($dim['dim_obra_altura'],1,",",".");  if ($altu == '0,0')$altu= '';
	     $larg= number_format($dim['dim_obra_largura'],1,",","."); if ($larg == '0,0')$larg= '';
	     $diam= number_format($dim['dim_obra_diametro'],1,",",".");if ($diam == '0,0')$diam= '';
                   $prof= number_format($dim['dim_obra_profund'],1,",","."); if ($prof == '0,0')$prof= '';
             $num_registro=$dim[num_registro];	
	     


       } else {
          $sql2="SELECT a.*,b.*,b.tipo as tipo_rest,c.* from moldura as a, restauro_fotografia as b, restauro as c
                   where c.restauro='$_REQUEST[id]'  and a.moldura=c.moldura and b.fotografia = '$img[fotografia]' and b.restauro=c.restauro";

	  $db2->query($sql2);
	  $dim= $db2->dados();
	  $eh_mini= $dim['eh_mini'];
          $eh_principal= $dim['eh_principal'];
	  $altu= '';$larg= '';$diam= '';$prof= '';
          $num_registro=$dim[num_registro];

       }     
	  $sql2="SELECT nome_arquivo,diretorio_imagem from fotografia where fotografia = '$dim[fotografia]'";
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
		 if (file_exists($dir.$url[0].'\\'.$imagem)) 
                 {
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
                }
               $noimage= "";  
               } else {                      
                 $noimage= "<tr width='100%' class='texto' align='center'><td width='90%' class='texto' align='center' valign='middle'  style='border: 1px dashed #ABABAB; color:#444444;'><sup><br><br><br><br><br><br>Imagem não disponível<br><br><br><br><br><br></sup></td></tr>";
	       }
            }
             }?>
           <tr align="center"><td align="center"><font style='font-family:arial; font-weight:normal; font-size:11px;'>N&ordm; de registro&nbsp;&nbsp;</font><b><?echo $num_registro;?></b>
           </td>
           </tr>
            <tr><td align="center">&nbsp;</td></tr>

            <tr align="center">
                     <td align="center"><img alt='<?echo $dim['descricao']?>' style="cursor:pointer;" src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'>								
          
              </td></tr> 


  



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

$a="<a href=\"imagem_lista_consulta_mold.php?id=$_REQUEST[id]&tipo2=$tipo2&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'   border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"imagem_lista_consulta_mold.php?id=$_REQUEST[id]&tipo2=$tipo2&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif' border='0'  alt='Registro Anterior' ></a>";

$c="<a href=\"imagem_lista_consulta_mold.php?id=$_REQUEST[id]&tipo2=$tipo2&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'   border='0'  alt='Proximo Registro' ></a> ";

$d="<a href=\"imagem_lista_consulta_mold.php?id=$_REQUEST[id]&tipo2=$tipo2&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'    border='0'  alt='Ultimo Registro' ></a>";
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

<tr><td align="center"><?if ($dim[tipo_rest]==1){echo"<font color=''>Antes</font>";}if ($dim[tipo_rest]==2){echo"<font color=''>Intermediário</font>";}if ($dim[tipo_rest]==3){echo"<font color=''>Depois</font>";}?><td></tr>               
                       
      </td>
   </tr>
	  

   </table>


</html>