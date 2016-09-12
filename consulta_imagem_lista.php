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
document.location=('consulta_imagem_lista.php?obra=<? echo $_REQUEST[obra] ?>&page='+ i);

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

	$dir= diretorio_fisico() . "acervo\\";
	$dir_virtual= diretorio_virtual()."acervo/";
 ?>
<body style="background-color: #CCCCFF;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="#CCCCFF">
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
	  $sql="SELECT count(*) from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia AND a.obra = '$_REQUEST[obra]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	  $sql2="SELECT a.*,b.titulo as tit,b.fotografia as foto from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
	   AND a.obra = '$_REQUEST[obra]' order by b.titulo LIMIT $registroinicial,$pagesize";
	  $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="30%" height="24" bgcolor="#96ADBE" class="texto_bold"><div align="left">&nbsp;Título </div></td>
          <td width="40%" bgcolor="#96ADBE" class="texto_bold"><div align="center">&nbsp;Imagem</div></td>
          <td width="15%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
          <td width="15%" bgcolor="#96ADBE" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
		<? while($row=$db->dados()) {
				// Obtem as dimensoes da obra //
				$sql2="SELECT a.dim_obra_altura,a.dim_obra_largura,a.dim_obra_diametro,a.dim_obra_profund from obra as a, fotografia_obra as b 
					where a.obra = b.obra AND b.fotografia = '$row[foto]'";
				$db2->query($sql2);
				$dim= $db2->dados();
				$altu= number_format($dim['dim_obra_altura'],1,",",".");
				$larg= number_format($dim['dim_obra_largura'],1,",",".");
				$diam= number_format($dim['dim_obra_diametro'],1,",",".");
				$prof= number_format($dim['dim_obra_profund'],1,",",".");
				if ($altu == '0,0')
					$altu= '';
				if ($larg == '0,0')
					$larg= '';
				if ($diam == '0,0')
					$diam= '';
				if ($prof == '0,0')
					$prof= '';
				////
				$sql2="SELECT nome_arquivo from fotografia where fotografia = '$row[foto]'";
				$db2->query($sql2);
				if ($img=$db2->dados()) {
					$imagem= '';
					if ($img['nome_arquivo'] <> '') {
						$imagem= $img['nome_arquivo'];
						$noimage= '';
						if (file_exists($dir.$imagem)) {
							list($width, $height, $type, $attr)= getimagesize($dir_virtual.$imagem);
							$Ao= $height;
							$Lo= $width;

							//284 é a altura max da área de exibição da imagem; 500 é a largura máxima.//
							$cA= $Ao / 284;
							$cL= $Lo / 500;

							if ($Ao > 284 || $Lo > 500) {
								if (cL < cA) {
									$percent= (500 * 100) / $Lo;
									$Lo= 500;
									$Ao= ($Ao * $percent) / 100;
									if ($Ao > 284) {
										$percent= (284 * 100) / $Ao;
										$Ao= 284;
										$Lo= ($Lo * $percent) / 100;
									}

								} else {
									$percent= (284 * 100) / $Ao;
									$Ao= 284;
									$Lo= ($Lo * $percent) / 100;
									if ($Lo > 500) {
										$percent= (500 * 100) / $Lo;
										$Lo= 500;
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
								&nbsp;<img src='<? echo $dir_virtual.$imagem; ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'>
								<? echo $noimage; ?>
							<? } ?>
		  &nbsp;</td>
          <td>&nbsp;</td>
          <td align="left"><? if ($imagem<>'' && $noimage=='') { ?>
								<a href="javascript:;" onClick="abrepop('pop_imagem.php?imagem=<? echo "acervo/".$imagem; ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>&profundidade=<? echo $prof; ?>', <? echo $height; ?>, <? echo $width; ?>);"><img src='imgs/icons/visualiza.gif' border='0' alt='Visualizar'></a>
							<? } ?>&nbsp;</td>
		<? } ?>
        </tr>
		<? if ($imagem == '') { ?>
        <tr class="texto">
          <td colspan="4" height="10">&nbsp;</td>
        </tr>
		<? } ?>
        <tr bgcolor="#336799" class="texto">
          <td colspan="4"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;

$a="<a href=\"consulta_imagem_lista.php?obra=$_REQUEST[obra]&page=".$first."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"consulta_imagem_lista.php?obra=$_REQUEST[obra]&page=".$menos."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"consulta_imagem_lista.php?obra=$_REQUEST[obra]&page=".$mais."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"consulta_imagem_lista.php?obra=$_REQUEST[obra]&page=".$last."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
$combo="";

 for($i=1;$i<=$numpages;$i++)
 {
 if ($i==$page_atual) {
    $combo = $combo . "<option value='$i' selected >$i</option>";}
  else{
  $combo.="<option value='$i'>$i</option>";}
 } 
  $lista_combo="<select name=i value=$i onChange='obtem_valor(this)'; >$combo</select>";  
//echo"$lista_combo";
$g= " Total de imagens para esta obra:$numlinhas - Pagina:$page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='ffffff'>$g</font>"; 		  
?>               
            <div align="center"></div></td>
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