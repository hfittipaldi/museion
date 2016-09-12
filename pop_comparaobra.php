<? include_once("seguranca.php") ?>

<script>

function abrepop(janela)
{
  win=window.open(janela,'lista','left='+((window.screen.width/2)-125)+',top='+((window.screen.height/2)-150)+',width=280,height=300, scrollbars=no, resizable=no');
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
}
 return true;
}  

</script>

<html>
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

 $restauro='2338';



 $sql="SELECT fotografia from restauro_fotografia where tipo = 1 AND restauro = $restauro order by ordem";
 $db->query($sql);
 $rest=$db->dados();
 $fotoAntes= $rest['fotografia'];

 $sql="SELECT fotografia from restauro_fotografia where tipo = 3 AND restauro = $restauro order by ordem";
 $db->query($sql);
 $rest=$db->dados();
 $fotoDepois= $rest['fotografia'];

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


<!-- OBRA 1 -->


   <table width="50%" id=fundo bgcolor="#ffffff"  height="100%" border="0" align="left" cellpadding="0" cellspacing="0">
   
     <tr><!--OBRA 1 E OBRA 2-->
        <td height="90%" width="50%" valign="center" align="center"  style="border-right: 1px solid blue;"><font color=blue >obra 1</font><br><img id="foto" src="<? $img=$dir_virtual.$urlA.'/'.$imagemA; echo combarra_encode($img); ?>" height="<? echo $alturaA ?>" width="<? echo $larguraA ?>"></img><? echo $msgA; ?></td>
     </tr>


     <tr> <!--TITULO-->
        <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">T&iacute;tulo:<input name="titulo" type="text" class="combo_cadastro" id="titulo" size="30"></td>
     </tr>


     <tr><!--TEMA-->
        <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Tema:<input name="tema" type="text" class="combo_cadastro"  readonly="true" id="tema" size="30">
           <span 
              class="texto_bold"><a href='javascript:;' onClick="abrepop('pop_tema.php?');""><img src="imgs/icons/lupa.gif" title="Selecionar..." width="27" border=0 height="16")"></a>
              <input name="idtemas" type="hidden" id="idtemas">
           </span>
        </td>
      </tr>


      <tr><!--SUB_TEMA-->  
         <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Sub-Temas:<input name="sub_tema" type="text" class="combo_cadastro" id="sub_tema" size="30"></td>
      </tr>


        <tr><!--MATERIAL/TECNICA-->
           <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Material/ t&eacute;cnica:<input name="material_tecnica" type="text" class="combo_cadastro" id="material_tecnica" size="25"></td>
        </tr>


        <tr><!--DESCRICAO DE CONTEUDO-->
           <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Descri&ccedil;&atilde;o de conte&uacute;do:<input name="desc_conteudo" type="text" class="combo_cadastro" id="desc_conteudo" size="17"></td>
        </tr>

</table>



<!-- OBRA 2 -->


   <table width="50%" id=fundo bgcolor="#ffffff"  height="100%" border="0" align="left" cellpadding="0" cellspacing="0">
     <tr><!--OBRA 1 E OBRA 2-->
        <td height="90%" width="50%" valign="center" align="center"  style="border-right: 1px solid blue;"><font color=blue >obra 1</font><br><img id="foto" src="<? $img=$dir_virtual.$urlA.'/'.$imagemA; echo combarra_encode($img); ?>" height="<? echo $alturaA ?>" width="<? echo $larguraA ?>"></img><? echo $msgA; ?></td>
     </tr>


     <tr> <!--TITULO-->
        <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">T&iacute;tulo:<input name="titulo" type="text" class="combo_cadastro" id="titulo" size="30"></td>
     </tr>


     <tr><!--TEMA-->
        <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Tema:<input name="tema" type="text" class="combo_cadastro"  readonly="true" id="tema" size="30">
           <span 
              class="texto_bold"><a href='javascript:;' onClick="abrepop('pop_tema.php?');""><img src="imgs/icons/lupa.gif" title="Selecionar..." width="27" border=0 height="16")"></a>
              <input name="idtemas" type="hidden" id="idtemas">
           </span>
        </td>
      </tr>

      <tr><!--SUB_TEMA-->  
         <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Sub-Temas:<input name="sub_tema" type="text" class="combo_cadastro" id="sub_tema" size="30"></td>
      </tr>


        <tr><!--MATERIAL/TECNICA-->
           <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Material/ t&eacute;cnica:<input name="material_tecnica" type="text" class="combo_cadastro" id="material_tecnica" size="25"></td>
        </tr>

        <tr><!--DESCRICAO DE CONTEUDO-->
           <td height="2%" width="50%" id=fundo bgcolor="#f2f2f2"  valign="center" align="left" colspan="0">Descri&ccedil;&atilde;o de conte&uacute;do:<input name="desc_conteudo" type="text" class="combo_cadastro" id="desc_conteudo" size="17"></td>
        </tr>

</table>
     


</body>
</html>