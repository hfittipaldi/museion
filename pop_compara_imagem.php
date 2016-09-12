<? include_once("seguranca.php") ?>
<html>


<script>
function abrepop(janela,alt,larg) {
	var h=screen.height-100,w=screen.width-50;
	win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
</script>


<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>


<body>      
<? 
 include("classes/classe_padrao.php");
 include("classes/funcoes_extras.php");
 $db=new conexao();
 $db->conecta();

 $dir= diretorio_fisico();
 $dir_virtual= diretorio_virtual();

 $fotoAntes= $_REQUEST[img1];
 $fotoDepois= $_REQUEST[img2];

 // Foto Antes \\
 $sql="SELECT * from fotografia where fotografia = '$fotoAntes'";
 $db->query($sql);
 $msgA= '';
 if ($fotoA=$db->dados()) {
 	$imagemA= '';
	if ($fotoA['nome_arquivo'] <> '') {
		$imagemA= $fotoA['nome_arquivo'];
		$dirA= $fotoA['diretorio_imagem'];
		$sql="SELECT url from diretorio_imagem where diretorio_imagem = '$dirA'";
		$db->query($sql);
		$url=$db->dados();
		$urlA=$url[0];
		if (file_exists($dir.$urlA.'\\'.$imagemA)) {
			list($width, $height, $type, $attr)= getimagesize($dir_virtual.$urlA.'/'.$imagemA);
			$alturaA= $height;
			$larguraA= $width;

							$altmax= 420;
							$larmax= 340;
							$cA= $alturaA / $altmax;
							$cL= $larguraA / $larmax;

							if ($alturaA > $altmax || $larguraA > $larmax) {
								if (cL < cA) {
									$percent= ($larmax * 100) / $larguraA;
									$larguraA= $larmax;
									$alturaA= ($alturaA * $percent) / 100;
									if ($alturaA > $altmax) {
										$percent= ($altmax * 100) / $alturaA;
										$alturaA= $altmax;
										$larguraA= ($larguraA * $percent) / 100;
									}

								} else {
									$percent= ($altmax * 100) / $alturaA;
									$alturaA= $altmax;
									$larguraA= ($larguraA * $percent) / 100;
									if ($larguraA > $larmax) {
										$percent= ($larmax * 100) / $larguraA;
										$larguraA= $larmax;
										$alturaA= ($alturaA * $percent) / 100;
									}
								}
						}
		}
		else {
			$msgA= "<font style='color:white; font-weight: normal;'><br><br>Arquivo não encontrado no servidor: ".$dir.$urlA.'\\'.$imagemA."</font>";
		}
  }
}
else {
	$msgA= "<font style='color:white; font-weight: normal;'><br><br>Imagem não disponível</font>";
}

 // Foto Depois \\
 $sql="SELECT * from fotografia where fotografia = '$fotoDepois'";
 $db->query($sql);
 $msgD= '';
 if ($fotoD=$db->dados()) {
 	$imagemD= '';
	if ($fotoD['nome_arquivo'] <> '') {
		$imagemD= $fotoD['nome_arquivo'];
		$dirD= $fotoD['diretorio_imagem'];
		$sql="SELECT url from diretorio_imagem where diretorio_imagem = '$dirD'";
		$db->query($sql);
		$url=$db->dados();
		$urlD=$url[0];
		if (file_exists($dir.$urlD.'\\'.$imagemD)) {
			list($width, $height, $type, $attr)= getimagesize($dir_virtual.$urlD.'/'.$imagemD);
			$alturaD= $height;
			$larguraD= $width;

							$altmax= 420;
							$larmax= 340;
							$cA= $alturaD / $altmax;
							$cL= $larguraD / $larmax;

							if ($alturaD > $altmax || $larguraD > $larmax) {
								if (cL < cA) {
									$percent= ($larmax * 100) / $larguraD;
									$larguraD= $larmax;
									$alturaD= ($alturaD * $percent) / 100;
									if ($alturaD > $altmax) {
										$percent= ($altmax * 100) / $alturaD;
										$alturaD= $altmax;
										$larguraD= ($larguraD * $percent) / 100;
									}

								} else {
									$percent= ($altmax * 100) / $alturaD;
									$alturaD= $altmax;
									$larguraD= ($larguraD * $percent) / 100;
									if ($larguraD > $larmax) {
										$percent= ($larmax * 100) / $larguraD;
										$larguraD= $larmax;
										$alturaD= ($alturaD * $percent) / 100;
									}
								}
						}
		}
		else {
			$msgD= "<font style='color:white; font-weight: normal;'><br><br>Arquivo não encontrado no servidor: ".$dir.$urlD.'\\'.$imagemD."</font>";
		}
  }
}
else {
	$msgD= "<font style='color:white; font-weight: normal;'><br><br>Imagem não disponível</font>";
}
?>
<table width="100%" id=fundo bgcolor="#ffffff"  height="100%" border="0" align="left" cellpadding="0" cellspacing="0">
 <tr>
    <td height="2%" colspan="2" class="texto_bold" valign="top" nowrap><div align="left" class="texto_bold"><a style="color:blue "href="javascript: window.close();">&nbsp;FECHAR</a></div></td>
  </tr>
  <tr>

    <td height="48%" width="50%" valign="center" align="center" style="border-right: 1px solid blue;"><font color=blue >Imagem 1</font><br><a id="img_pop_imagem1" href="javascript:;" onClick="abrepop('pop_imagem.php?imagem=<? $img=$urlA.'/'.$imagemA; echo combarra_encode($img); ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>', <? echo $height; ?>, <? echo $width; ?>);"><img id="foto1" border='0' src="<? $img=$dir_virtual.$urlA.'/'.$imagemA; echo combarra_encode($img); ?>" height="<? echo $alturaA ?>" width="<? echo $larguraA ?>"></img></a><? echo $msgA; ?></td>
    <td height="48%" width="50%" valign="center" align="center" style="border-left: 1px solid blue;"><font color=blue>Imagem 2</font><br><a id="img_pop_imagem2" href="javascript:;" onClick="abrepop('pop_imagem.php?imagem=<? $img=$urlD.'/'.$imagemD; echo combarra_encode($img); ?>&altura=<? echo $altu; ?>&largura=<? echo $larg; ?>&diametro=<? echo $diam; ?>', <? echo $height; ?>, <? echo $width; ?>);"><img id="foto2" border='0'  src="<? $img=$dir_virtual.$urlD.'/'.$imagemD; echo combarra_encode($img); ?>" height="<? echo $alturaD ?>" width="<? echo $larguraD ?>"></img></a><? echo $msgD; ?></td>
  </tr>
 <tr>
   <td height="2%" colspan="2" class="texto_bold" valign="top" nowrap><br></td>
 </tr>
 
</table>
</body>
</html>