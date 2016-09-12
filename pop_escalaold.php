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

 $dir_virtual=diretorio_virtual();

 $exibicao= $_REQUEST['exibicao'];
 $principal= $_REQUEST['principal'];

 $altura= $_REQUEST['altura'];
 $largura= $_REQUEST['largura'];
 $diametro= $_REQUEST['diametro'];
 $profundidade= $_REQUEST['profundidade'];
 if ($altura == '')
	$altura= 0;
 if ($largura == '')
	$largura= 0;
 if ($diametro == '')
	$diametro= 0;
 if ($profundidade == '')
	$profundidade= 0;
 $altura= str_replace(",",".",$altura);
 $largura= str_replace(",",".",$largura);
 $diametro= str_replace(",",".",$diametro);
 $profundidade= str_replace(",",".",$profundidade);

// testa-se altura e largura; se o MAIOR tiver ate 40 cm, mostra-se o busto;
// 							  se o MAIOR tiver de 41 a 80 cm, mostra-se o tronco;
// 							  se o MAIOR tiver de 81 a 180 cm, mostra-se o todo;
// 							  se o MAIOR tiver de 181 a 360 cm, mostra-se o todo com a altura pela metade;
// 							  se o MAIOR tiver mais de 360 cm, mostra-se o todo com 1/4 da altura.
 if ($altura > $largura)
	$maior= $altura;
 else
	$maior= $largura;
// se diametro for diferente de zero, usa-se este como o MAIOR.
 if ($diametro <> 0)
	$maior= $diametro;

// se forma de exibição for 'no chão', usa-se apenas o observador de corpo inteiro, logo:
 if ($exibicao == 'nchao') {
	$img= "imgs/observador c.gif";
	$valign_boneco= "bottom";
	$valign_obra= "bottom";
 }
// se não for Escultuta:
 elseif ($maior > 180) {
	$img= "imgs/observador c.gif";
	$valign_boneco= "bottom";
	$valign_obra= "middle";
 }
 elseif ($maior > 80) {
	$img= "imgs/observador c.gif";
	$valign_boneco= "bottom";
	$valign_obra= "top";
 }
 elseif ($maior > 40) {
	$img= "imgs/observador b.gif";
	$valign_boneco= "bottom";
	$valign_obra= "top";
 }
 else {
	$img= "imgs/observador a.gif";
	$valign_boneco= "bottom";
	$valign_obra= "middle";
 }


// $hid_boneco= 538;	// tamanho do boneco no donato 2..4
 $hid_boneco= 424;	// novo tamanho do boneco para não prejudicar a visualização em 800x600

// Obtem a altura do observador e a relação pixel/centímetro //
 if ($maior > 360) {
/*	$hid_boneco= 404;
	$h_boneco= 134;
	$w_boneco= 38;
	$percent= 0.74;		// => 134 (altura do boneco em pixel) div 180 (altura do boneco em cm)*/
	$hid_boneco= 318;
	$h_boneco= 106;
	$w_boneco= 30;
	$percent= 0.58;	// => 106 (altura do boneco em pixel) div 180 (altura do boneco em cm)
 }
 elseif ($maior > 180) {
/*	$h_boneco= 269;
	$w_boneco= 72;
	$percent= 1.49;		// => 269 (altura do boneco em pixel) div 180 (altura do boneco em cm)*/
	$h_boneco= 212;
	$w_boneco= 56;
	$percent= 1.17;	// => 212 (altura do boneco em pixel) div 180 (altura do boneco em cm)
 }
 elseif ($maior > 80) {
/*	$h_boneco= 538;
	$w_boneco= 145;
	$percent= 2.98;		// => 538 (altura do boneco em pixel) div 180 (altura do boneco em cm)*/
	$h_boneco= 424;
	$w_boneco= 114;
	$percent= 2.35;	// => 424 (altura do boneco em pixel) div 180 (altura do boneco em cm)
 }
 elseif ($maior > 40) {
/*	$h_boneco= 538;
	$w_boneco= 319;
	$percent= 5.97;		// => 538 (altura do boneco em pixel) div 90 (altura do boneco em cm)*/
	$h_boneco= 424;
	$w_boneco= 252;
	$percent= 4.71;	// => 424 (altura do boneco em pixel) div 90 (altura do boneco em cm)
 }
 else {
/*	$h_boneco= 538;
	$w_boneco= 319;
	$percent= 11.95;	// => 538 (altura do boneco em pixel) div 45 (altura do boneco em cm)*/
	$h_boneco= 424;
	$w_boneco= 252;
	$percent= 9.42;	// => 424 (altura do boneco em pixel) div 45 (altura do boneco em cm)
 }

// se forma de exibicao for 'no chao', usa-se apenas o observador de corpo inteiro, logo:
if ($exibicao == 'nchao') {
  if ($maior > 360) {
	$hid_boneco= 318;
	$h_boneco= 106;
	$w_boneco= 30;
	$percent= 0.58;
 }
 elseif ($maior > 180) {
	$h_boneco= 212;
	$w_boneco= 56;
	$percent= 1.17;
 }
 else {
	$h_boneco= 424;
	$w_boneco= 114;
	$percent= 2.35;
 }
}


// Define o tamanho da imagem em pixel //
 if ($altura > 0)
	 $altura= $altura * $percent;
 else {
	 $altura= $diametro * $percent;
 }
?>

<script>
h=screen.height-100,w=screen.width-50;
function abrepop(janela)
{
  win=window.open(janela,'imagem','left='+((window.screen.width/2)-w/2)+',top=10,width='+w+',height='+h+',scrollbars=yes, resizable=yes');
 if(parseInt(navigator.appVersion)>=4)
{
   win.window.focus();
 }
 return true;
}
</script>

<table width="100%" id=fundo bgcolor="#FFFFFF"  height="100%" border="0" align="left" cellpadding="8" cellspacing="0">
   <tr>
      <td valign="top" colspan="8" class="texto_bold" nowrap>
         <div align="left" class="texto_bold"> 
            <a style="color:blue "href="javascript: window.close();">&nbsp;FECHAR</a>
	       &nbsp;&nbsp;<font color="green">|</font>&nbsp;&nbsp;&nbsp;
             <a style="color:blue  "href="javascript: abrepop('pop_imagem.php?exibicao=<? echo $exibicao; ?>&principal=<? echo $principal; ?>&imagem=<? echo rawurlencode($_REQUEST['imagem']); ?>&altura=<? echo $_REQUEST['altura']; ?>&largura=<? echo $_REQUEST['largura']; ?>&diametro=<? echo $_REQUEST['diametro']; ?>&profundidade=<? echo $_REQUEST['profundidade']; ?>');">VISUALIZAÇÃO</a>
         </div>
     </td>
 </tr>
   <td valign="top" colspan="8" nowrap class="texto"> 
      <div  align="left" class="texto"><a style="color:green ">&nbsp;Posicione o ponteiro do mouse sobre as caixas coloridas abaixo para alterar a cor do fundo</a>
	</div></td>

<tr>
    <td width="10%" height="10" valign="center" bgcolor="#FFFFFF" onmouseover="document.getElementById('fundo').style.backgroundColor='#FFFFFF'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#F4ECD0" onmouseover="document.getElementById('fundo').style.backgroundColor='#F4ECD0'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#CCCCCC" onmouseover="document.getElementById('fundo').style.backgroundColor='#CCCCCC'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#999999" onmouseover="document.getElementById('fundo').style.backgroundColor='#999999'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#87AA87" onmouseover="document.getElementById('fundo').style.backgroundColor='#87AA87'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#802F04" onmouseover="document.getElementById('fundo').style.backgroundColor='#802F04'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#443300" onmouseover="document.getElementById('fundo').style.backgroundColor='#443300'" ></td>
    <td width="10%" height="10" valign="center" bgcolor="#000000" onmouseover="document.getElementById('fundo').style.backgroundColor='#000000'" ></td>
  </tr>


  <tr>
    <td colspan="4" id="area_boneco" height="<? echo $hid_boneco; ?>" width="252" style="border-bottom: 1px solid #A1B2BB;" valign="<? echo $valign_boneco; ?>" align="center"><img id="observador" src="<? echo $img; ?>" height="<? echo $h_boneco; ?>" width="<? echo $w_boneco; ?>" title="Gonzaga Duque Estrada"></img></td>
    <td colspan="8" id="area_obra" style="border-bottom: 1px solid #A1B2BB; border-right: 1px solid #A1B2BB;" valign="<? echo $valign_obra; ?>" align="center">&nbsp;&nbsp;<img id="obra" src="<? echo $dir_virtual.combarra_encode($_REQUEST['imagem']); ?>" height="<? echo $altura; ?>"></img>&nbsp;</td>
  </tr>
	<?  $Y= $_REQUEST['altura'];
		$X= $_REQUEST['largura'];
		$Z= $_REQUEST['diametro'];
		$W= $_REQUEST['profundidade'];

		$altu= explode(",",$Y);
		if ($altu[1] == '0')
			$Y= $altu[0];

		$larg= explode(",",$X);
		if ($larg[1] == '0')
			$X= $larg[0];

		$diam= explode(",",$Z);
		if ($diam[1] == '0')
			$Z= $diam[0];

		$prof= explode(",",$W);
		if ($prof[1] == '0')
			$W= $prof[0];
	?>
  <tr>
	<td colspan="4" height="*" width="252">&nbsp;</td>
    <td colspan="4" align="center" valign="top" class="texto_bold" style="font-weight: normal; color: green;"><br>
      Dimensões da obra: <? if ($diametro == 0) { echo $Y." x ".$X; if ($profundidade <> 0) { echo " x ".$W; } } else { echo "&Oslash; = ".$Z; } ?> cm<br>&nbsp;</td></tr>
  </tr>
 </table>
</body>
</html>
