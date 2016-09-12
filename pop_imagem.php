<? include_once("seguranca.php") ?>
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

// Dimensões da obra //
 $altura= $_REQUEST['altura'];
 $largura= $_REQUEST['largura'];
 $diametro= $_REQUEST['diametro'];
 $profundidade= $_REQUEST['profundidade'];
 $exibicao= $_REQUEST['exibicao'];
 $obra= $_REQUEST['obra'];
 $principal= $_REQUEST['principal'];
 $fotografia= $_REQUEST['fotografia'];

 $dir_virtual=diretorio_virtual();
 list($width, $height, $type, $attr)= getimagesize($dir_virtual.$_REQUEST['imagem']);

?>
<script>
alt_normal= <? echo $height; ?>;
altura= alt_normal;
function ajustaTamanho(zoom) {
	valor= (altura * 20) / 100;
	if (zoom == 'mais') {
		document.getElementById('foto').style.height= altura+valor;
		altura= altura+valor;
	} else if (zoom == 'menos') {
		if (altura > valor) {
			document.getElementById('foto').style.height= altura-valor;
			altura= altura-valor;
		}
	} else if (zoom == 'normal') {
		document.getElementById('foto').style.height= alt_normal;
		altura= alt_normal;
	}
}


function abrepop_Propriedade(janela)
{
h=screen.height/284,w=screen.width/500;

  win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}
function abrepop(janela)
{
 var h=screen.height-100,w=screen.width-50;
 
  win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}
</script>
<table width="100%" bgcolor="#FFFFFF"  height="100%" border="1" bordercolor="#cccccc"  align="left" cellpadding="0" cellspacing="0">
 <tr>
    <td valign="top" colspan="14" class="texto_bold" nowrap><div align="left" class="texto_bold"> <a style="color:green "href="javascript: window.close();">&nbsp;FECHAR</a>
		&nbsp;&nbsp;<font style="color:green">|</font>&nbsp;&nbsp;&nbsp;<a style="color:green" href="javascript:;" onClick="ajustaTamanho('mais');">AMPLIAR</a>&nbsp;
		&nbsp;|&nbsp;&nbsp;&nbsp;<a style="color:green" href="javascript:;" onClick="ajustaTamanho('menos');">REDUZIR</a>&nbsp;
                            &nbsp;|&nbsp;&nbsp;&nbsp;<a style="color:green" href="javascript: abrepop_Propriedade('pop_propriedade.php?fotografia=<?echo $fotografia;?>&exibicao=<? echo $exibicao; ?>&principal=<? echo $principal; ?>&imagem=<? echo $_REQUEST['imagem'];  ?>&altura=<? echo $altura; ?>&largura=<? echo $largura; ?>&diametro=<? echo $diametro; ?>&profundidade=<? echo $profundidade; ?>');">PROPRIEDADE</a>&nbsp;
		&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a style="color:green" href="javascript:;" onClick="ajustaTamanho('normal');">NORMAL</a>
                           		<? if (($altura<>'' && $largura<>'') || ($diametro <> '') || ($altura<>'' && $profundidade<>'') || ($largura<>'' && $profundidade<>'')) { ?>
			<? if ($principal) { ?>
			&nbsp;&nbsp;<font style="color:green">|</font>&nbsp;&nbsp;&nbsp;<a style="color:green "href="javascript: abrepop('pop_escala.php?fotografia=<?echo $fotografia;?>&exibicao=<? echo $exibicao; ?>&principal=<? echo $principal; ?>&imagem=<? echo $_REQUEST['imagem']; ?>&altura=<? echo $altura; ?>&largura=<? echo $largura; ?>&diametro=<? echo $diametro; ?>&profundidade=<? echo $profundidade; ?>');">ESCALA</a>
			<? } ?>
		<? } ?>

  
	</div></td>
  </tr>
     <td colspan="14" class="texto" nowrap><div  align="left" class="texto"><a style="color:green ">&nbsp;Posicione o ponteiro do mouse sobre as caixas coloridas abaixo para alterar a cor do fundo</a>
     </div></td>
  <tr>
    <td width="14%" height="10" valign="center" bgcolor="#FFFFFF" onmouseover="document.getElementById('fundo').style.backgroundColor='#FFFFFF'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#f8f4e5" onmouseover="document.getElementById('fundo').style.backgroundColor='#f8f4e5'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#fff4c5" onmouseover="document.getElementById('fundo').style.backgroundColor='#fff4c5'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#e4ca71" onmouseover="document.getElementById('fundo').style.backgroundColor='#e4ca71'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#e7ecf5" onmouseover="document.getElementById('fundo').style.backgroundColor='#e7ecf5'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#CCCCCC" onmouseover="document.getElementById('fundo').style.backgroundColor='#CCCCCC'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#999999" onmouseover="document.getElementById('fundo').style.backgroundColor='#999999'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#87AA87" onmouseover="document.getElementById('fundo').style.backgroundColor='#87AA87'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#324f32" onmouseover="document.getElementById('fundo').style.backgroundColor='#324f32'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#d09b79" onmouseover="document.getElementById('fundo').style.backgroundColor='#d09b79'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#662706" onmouseover="document.getElementById('fundo').style.backgroundColor='#662706'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#443300" onmouseover="document.getElementById('fundo').style.backgroundColor='#443300'" ></td>
    <td width="6%" height="10" valign="center" bgcolor="#0e2245" onmouseover="document.getElementById('fundo').style.backgroundColor='#0e2245'" ></td>
    <td width="14%" height="10" valign="center" bgcolor="#000000" onmouseover="document.getElementById('fundo').style.backgroundColor='#000000'" ></td>
  </tr>
  <tr>
    <td height="96%" id=fundo colspan="14" valign="center" align="center"><img id="foto" src="<? $img=$dir_virtual.$_REQUEST['imagem']; echo combarra_encode($img); ?>" ></img></td>
  </tr>
</table>
</body>
</html>
