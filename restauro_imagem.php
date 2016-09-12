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
document.location=('restauro_imagem.php?id=<? echo $_REQUEST[id] ?>&op=<? echo $_REQUEST[op] ?>&page='+ i);

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
	 elseif ($tipo['tipo'] == 1) {
		$dir= $dir . "papel\\";
		$dir_virtual= $dir_virtual . "papel/";
		$url= "Papel";
	 }
	 elseif ($tipo['tipo'] == 3) {
		$dir= $dir . "obra 3D\\";
		$dir_virtual= $dir_virtual . "Obra 3D/";
		$url= "Obra 3D";
	 }
	 elseif ($tipo['tipo'] == 4) {
		$dir= $dir . "moldura\\";
		$dir_virtual= $dir_virtual . "moldura/";
		$url= "moldura";
	 }
	//////*/
 ?>
<body style="background-color: #f2f2f2;">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="#f2f2f2">
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
	//  $sql="SELECT count(*) from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia AND a.obra = '$_REQUEST[obra]'";
	  $sql="SELECT count(*) from restauro_fotografia as a,restauro as b where a.restauro=b.restauro and a.restauro='$_REQUEST[id]'";
	  $db->query($sql);
	  $numlinhas=$db->dados();
      $numlinhas=$numlinhas[0];
	 
	  /////////////////////
	 // $sql2="SELECT a.*,b.titulo as tit,b.fotografia as foto from fotografia_obra as a, fotografia as b where a.fotografia = b.fotografia
	   //AND a.obra = '$_REQUEST[obra]' order by b.titulo LIMIT $registroinicial,$pagesize";
	
	  $sql2="SELECT a.* from restauro_fotografia as a,restauro as b where a.restauro=b.restauro and a.restauro='$_REQUEST[id]' 
	   order by tipo,ordem asc LIMIT $registroinicial,$pagesize ";
	   $db->query($sql2);
	  ////////////////////
	  
	   ?>
      <table width="100%" height="20"  border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="4" align="right"><input class="combo_cadastro" style="width: 160px;" type="button" name="antes_depois" value="Visualizar Antes/Depois" onClick="abrepop('pop_antesdepois.php?restauro=<? echo $_REQUEST['id'] ?>');"></td>
		</tr>
        <tr bgcolor="#96ADBE">
          <td colspan="4" bgcolor="#000000" class="texto_bold"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
        <tr bgcolor="#96ADBE">
          <td width="30%" height="24" bgcolor="#ddddd5" class="texto_bold"><div align="left">&nbsp;Descrição </div></td>
          <td width="40%" bgcolor="#ddddd5" class="texto_bold"><div align="center">&nbsp;Imagem</div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
          <td width="15%" bgcolor="#ddddd5" class="texto_bold"><div align="center"></div></td>
        </tr>
        <tr>
          <td colspan="4" bgcolor="#000000"><img src="imgs/transp.gif" width="100" height="1"></td>
        </tr>
      </table>       
      <table width="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#f2f2f2">
		<? while($img=$db->dados()) {
				/*// Obtem as dimensoes da obra //
				$sql2="SELECT a.dim_obra_altura,a.dim_obra_largura,a.dim_obra_diametro from obra as a, fotografia_obra as b 
					where a.obra = b.obra AND b.fotografia = '$row[foto]'";
				$db2->query($sql2);
				$dim= $db2->dados();
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
        <tr class="texto">
          <td width="30%"></td>
          <td width="42%"></td>
          <td width="10%"></td>
          <td colspan="2"></td>
        </tr>
        <tr class="texto">
          <td valign="top"><? echo $img['descricao'] ?></td>
          <td align="center"><? if ($imagem <> '') { ?>
								&nbsp;<img src='<? echo $dir_virtual.$url[0].'/'.$imagem; ?>?<?=time() ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0' style='cursor:pointer;' onClick="document.getElementById('img_pop_imagem').click();">
								<? echo $noimage; ?>
							<? } ?>
		  &nbsp;</td>
          <td><br>
            <? if ($imagem<>'' && $noimage=='') { ?>
            <a style="display:none;" id="img_pop_imagem" href="javascript:;" onClick="abrepop('pop_imagem.php?imagem=<? echo $url[0]."/".$imagem; ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>', <? echo $height; ?>, <? echo $width; ?>);"><img src='imgs/icons/visualiza.gif' alt='Visualizar' border='0'></a></td>
		  <? } ?>
          <td align="left" valign="middle">
            <? if ($_REQUEST[op] <> 'view') {
				 echo "<a href=\"restauro_imagem1.php?op=del&rest=$img[restauro_fotografia]&id=".$_REQUEST[id]."\"
				onClick='return confirm(".'"Confirma Exclusão do Registro ?"'.")'><img src='imgs/icons/ic_excluir.gif' width='20' height='20' border='0' alt='Excluir' >"; } ?>
          </td>
          <td align="left" valign="middle">
            <? if ($_REQUEST[op] <> 'view') {
				 echo "<a href=\"restauro_imagem1.php?op=update&rest=$img[restauro_fotografia]&id=".$_REQUEST[id]."\">
				 <img src='imgs/icons/ic_alterar.gif' width='20' height='20' border='0' alt='Alterar' >"; } ?>
            <? } ?></td>
        </tr>
		<? if ($imagem == '') { ?>
        <tr class="texto">
          <td colspan="2" height="10">&nbsp;</td>
          <td height="10">&nbsp;</td>
          <td width="9%" height="10">&nbsp;</td>
          <td width="9%">&nbsp;</td>
        </tr>
		<? } ?>
        <tr bgcolor="#ddddd5" class="texto">	
          <td colspan="5" height="20"><? 
		   
   //////Retomando a Paginacao
   $numpages=ceil($numlinhas/$pagesize);
  
   $page_atual=$page+1;
   $mais=$page_atual+1;
   $menos=$page_atual-1;
   $first=1;  
   $last=$numpages;
if($mais>$numpages)
   $mais=$numpages;
$a="<a href=\"restauro_imagem.php?id=$_REQUEST[id]&page=".$first."&op=".$_REQUEST[op]."\"><img src='imgs/icons/btn_inicio.gif'  border='0'  alt='Registro Inicial' ></a>";

$b="<a href=\"restauro_imagem.php?id=$_REQUEST[id]&page=".$menos."&op=".$_REQUEST[op]."\"><img src='imgs/icons/btn_anterior.gif'  border='0' alt='Registro Anterior' ></a>";

$c="<a href=\"restauro_imagem?id=$_REQUEST[id]&page=".$mais."&op=".$_REQUEST[op]."\"><img src='imgs/icons/btn_proximo.gif'  border='0' alt='Proximo Registro' ></a> ";

$d="<a href=\"restauro_imagem?id=$_REQUEST[id]&page=".$last."&op=".$_REQUEST[op]."\"><img src='imgs/icons/btn_ultimo.gif'  border='0' alt='Ultimo Registro' ></a>";
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
$g= " Total de imagens do restauro: $numlinhas - Página: $page_atual de $numpages &nbsp $lista_combo &nbsp;
".$a."&nbsp".$b."&nbsp".$c."&nbsp".$d."";
echo"&nbsp";

echo"<font color='000000'>$g</font>"; 		  
?>               
            <? 
				if ($_REQUEST[op] <> 'view')
					echo "<a href=\"restauro_imagem1.php?op=insert&id=$_REQUEST[id]\"><img src='imgs/icons/btn_plus.gif' width='13' height='13' border='0' alt='Novo Registro' ></a>";
			?>&nbsp;&nbsp;&nbsp;&nbsp;             <div align="center"></div></td>
          </tr>
        <tr>
          <td colspan="5"></td>
        </tr>
      </table>
    </form>
	</td>
  </tr>
</table>
</body>
</html>