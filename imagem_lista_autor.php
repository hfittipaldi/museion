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

	//$dir= diretorio_fisico() . "acervo\\";
	//$dir_virtual= diretorio_virtual()."acervo/";
    $dir= diretorio_fisico();
	$dir_virtual= diretorio_virtual();
 ?>
<body style="background-color: #f2f2f2;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" >
  <tr>
    <td valign="top"><form name="form1" method="post" action="">
 <?
	  /////Paginando
//	  $pagesize=1;
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
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#ddddd5">
          <td width="40%" height="24" bgcolor="#ddddd5" class="texto_bold" style="border-left: 1px solid #121212;><div align="left">&nbsp;Título </div></td>
          <td width="60%" bgcolor="#ddddd5" class="texto_bold" style="border-right: 1px solid #121212;><div align="center">&nbsp;&nbsp;&nbsp;Imagem</div></td>
         </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2">
		<? while($row=$db->dados()) {
				//$sql2="SELECT nome_arquivo from fotografia where fotografia = '$row[foto]'";
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

							//220 é a altura max da área de exibição da imagem; 360 é a largura máxima.//
							$cA= $Ao / 220;
							$cL= $Lo / 360;

							if ($Ao > 220 || $Lo > 420) {
								if (cL < cA) {
									$percent= (360 * 100) / $Lo;
									$Lo= 360;
									$Ao= ($Ao * $percent) / 100;
									if ($Ao > 220) {
										$percent= (220 * 100) / $Ao;
										$Ao= 220;
										$Lo= ($Lo * $percent) / 100;
									}

								} else {
									$percent= (220 * 100) / $Ao;
									$Ao= 220;
									$Lo= ($Lo * $percent) / 100;
									if ($Lo > 360) {
										$percent= (360 * 100) / $Lo;
										$Lo= 360;
										$Ao= ($Ao * $percent) / 100;
									}
								}
							}
						} else
							$noimage= "<br>Arquivo não encontrado no servidor: <br> <br> <font style='font-weight: normal;'> ".$dir.$imagem." </font>";
					}
				}
		  ?>
        <tr class="texto">
          <td width="30%"></td>
          <td width="40%"></td>
          <td width="15%"></td>
          <td width="15%"></td>
        </tr>
        <tr class="texto">
          <td valign="top"><? echo $row['tit'] ?></td>
          <td align="center"><? if ($imagem <> '') { ?>
								&nbsp;<img style="cursor:pointer;" src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0' onClick='document.getElementById("img_pop_imagem").click();'>
								<? echo $noimage; ?>
							<? } ?>
		  &nbsp;</td>
          <td>&nbsp;</td>
          <td align="left"><? if ($imagem<>'' && $noimage=='') { ?>
								<a id="img_pop_imagem" href="javascript:;" onClick="abrepop2('pop_imagem.php?imagem=<? echo $url[0].'/'.$imagem; ?>', <? echo $height; ?>, <? echo $width; ?>);"></a>
							<? } ?>&nbsp;</td>
		<? } ?>
        </tr>
		<? if ($imagem == '') { ?>
        <tr class="texto">
          <td colspan="4" height="10">&nbsp;</td>
        </tr>
		<? } ?>
        <tr>
          <td height="1" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr class="texto">
          <td colspan="4" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"imagem_lista_autor.php?id=$_REQUEST[id]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"imagem_lista_autor.php?id=$_REQUEST[id]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"imagem_lista_autor.php?id=$_REQUEST[id]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"imagem_lista_autor.php?id=$_REQUEST[id]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
//echo"$lista_combo";
$g= " Total de imagens do autor: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='003366'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
          </tr>
        <tr>
          <td height="2" colspan="4" bgcolor="#003366"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>