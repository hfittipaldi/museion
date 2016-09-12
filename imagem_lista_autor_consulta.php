<? include_once("seguranca.php") ?>
<html>
<head>
<title>Imagens vinculadas ao autor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function obtem_valor(qual) {
if (qual.selectedIndex.selected != '') {
var i = qual.value;
document.location=('imagem_lista_autor.php?id=<? echo $_REQUEST[id] ?>&page='+ i);

}}

function abrepop2(janela,alt,larg) {
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
	$db3=new conexao();
	$db3->conecta();

	//$dir= diretorio_fisico() . "acervo\\";
	//$dir_virtual= diretorio_virtual()."acervo/";
        $dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();
 ?>
<table width="111%" border="0" align="center" cellpadding="0" cellspacing="0" >
   <tr valign="top" align="center">
    <td valign="top" align="center">
 <?
	  /////Paginando
// 	  $pagesize=1;
	  $pagesize= paginacao_imagem();
      $page=1;
      if(!empty($_GET['page']))
         $page=$_GET['page'];
      $page--;
	  $registroinicial=$page* $pagesize;


	  $sql="SELECT count(*) from fotografia_autor as a, fotografia as b where a.fotografia = b.fotografia AND a.autor = '$_REQUEST[id]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
         $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	   $sql2="SELECT a.*,b.titulo as tit,b.fotografia as foto,b.forma_exibicao from fotografia_autor as a, fotografia as b where a.fotografia = b.fotografia
	   AND a.autor = '$_REQUEST[id]' order by a.eh_principal desc,a.fotografia asc LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" valign="top">
		<? while($row=$db->dados()) {
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
						// echo $dir.$url[0].'\\'.$imagem;
						 //exit;
						 if (file_exists($dir.$url[0].'\\'.$imagem)) {
							list($width, $height, $type, $attr)= getimagesize($dir_virtual.$url[0].'/'.$imagem);
							$Ao= $height;
							$Lo= $width;


				//110 é a altura max da área de exibição da imagem; 150 é a largura máxima.//
			$cA= $Ao / 200;
			$cL= $Lo / 120;
			if ($Ao > 200 || $Lo > 120) 
                        {
                            if (cL < cA) 
                            {   $percent= (200 * 100) / $Lo;
				$Lo= 120;
				$Ao= ($Ao * $percent) / 100;
				if ($Ao > 200) 
                                {
				   $percent= (200 * 100) / $Ao;
				   $Ao= 200;
				   $Lo= ($Lo * $percent) / 100;
				}

			} else {
			   $percent= (200 * 100) / $Ao;
			   $Ao= 200;
			   $Lo= ($Lo * $percent) / 100;
			   if ($Lo > 120) {
			      $percent= (110 * 100) / $Lo;
			      $Lo= 120;
			      $Ao= ($Ao * $percent) / 100;
									}
								}
							}
						} else
						 	
                                                 $noimage= "<tr width='100%' class='texto' align='center'><td width='90%' class='texto' align='center' valign='middle'  style='border: 1px dashed #ABABAB; color:#444444;'><sup><br><br><br><br><br><br>Imagem não disponível<br><br><br><br><br><br></sup></td></tr>";
					}
				}
		  ?>

    <?$sql="SELECT nomeetiqueta from autor where autor = '$_REQUEST[id]'";
          $db3->query($sql);
          $titaut=$db3->dados();
          $titaut=$titaut[0];?>

          <tr>
            <td align="center">                 
               <tr class="texto" align="center">
                   <br>
                   <td><font style='font-family:arial; font-weight:normal; font-size:11px;'><b><? echo $titaut?></b></font>
                   </td>
               </tr>
            </td>
         </tr>
         <tr class="texto" valign="top">
             <td align="center"  valign="top">
                <? if ($imagem <> '') 
                { ?>
                     <img alt='<?echo $row['tit']?>' style="cursor:pointer;" src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0' onClick='document.getElementById("img_pop_imagem").click();'>								
	      <? } ?>
              </td>
              <td align="left" valign="top">
                 <? if ($imagem<>'' && $noimage=='') 
                    { ?>
	            <a id="img_pop_imagem" href="javascript:;" onClick="abrepop2('pop_imagem.php?fotografia=<?echo $row['foto']?>&obra=<? echo $obraimg;?>&exibicao=<? echo $row2[forma_exibicao]; ?>&principal=<? echo $principal; ?>&imagem=<? echo $url[0].'/'.$imagem; ?>', <? echo $height; ?>, <? echo $width; ?>);"></a>
		   <? } ?>
              </td>
          <? } ?>
         </tr>


	<? if (($imagem=="")&&($noimage=="")) { 
          $sql="SELECT nomeetiqueta from autor where autor = '$_REQUEST[id]'";
          $db3->query($sql);
          $titaut=$db3->dados();
          $titaut=$titaut[0];?>
            
           <tr class="texto" align="center"> <br><td><font style='font-family:arial; font-weight:normal; font-size:11px;'><b><? echo $titaut?></b></font></td></tr>
           <tr align="center">
              <td align="center">
               <tr>
           <? echo "<tr width='100%' class='texto' align='center'>
                        <td width='90%' class='texto' align='center' valign='middle'  style='border: 1px dashed #ABABAB; color:#444444;'><sup><br><br><br><br><br><br>Imagem não disponível<br><br><br><br><br><br></sup></td>
                    </tr>";} ?>
               </td>
             </tr>
	 
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

$a="<a href=\"imagem_lista_autor_consulta.php?id=$_REQUEST[id]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"imagem_lista_autor_consulta.php?id=$_REQUEST[id]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"imagem_lista_autor_consulta.php?id=$_REQUEST[id]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"imagem_lista_autor_consulta.php?id=$_REQUEST[id]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
	</td>
  </tr>
</table>

</html>