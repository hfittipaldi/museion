<? include_once("seguranca.php");?>
<style type="text/css">
<!--
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
}
.divi {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
.divi1 {	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
	background-color: #f2f2f2;
}
-->
</style>
<script language="JavaScript">
function ajustaAbas(index) {
	numAbas= 6;

	if (index == 1)
		document.getElementById("aba1").style.borderLeftColor= "#34689A";
	else
		document.getElementById("aba1").style.borderLeftColor= "#34689A";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("link"+i).style.color= "#34689A";
	}
	document.getElementById("link"+index).style.color= "blue";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("aba"+i).style.borderBottomColor= "#34689A";
		document.getElementById("aba"+i).style.verticalAlign= "bottom";
		document.getElementById("aba"+i).style.backgroundColor= "";
	}
	document.getElementById("aba"+index).style.borderBottomColor= "#f2f2f2";
	document.getElementById("aba"+index).style.verticalAlign= "middle";
	document.getElementById("aba"+index).style.backgroundColor= "#f2f2f2";

	for (i=1;i<=numAbas;i++) {
		document.getElementById("quadro"+i).style.display= "none";
	}
	document.getElementById("quadro"+index).style.display= "";
}
function abrepop(janela) {
	win=window.open(janela,'lista_imagem','left='+((window.screen.width/2)-740/2)+',top='+((window.screen.height/2)-520/2)+',width=720,height=460,scrollbars=yes, resizable=yes');
	if(parseInt(navigator.appVersion)>=4) {
		win.window.focus();
	}
}
function abrepop2(janela,alt,larg)
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
<?php $aba=1; ?>
<link href="css/home.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.style2 {font-size: 10}
.style3 {font-size: 10px}
-->
</style>
<body onLoad='ajustaAbas(<? echo $aba ?>);' <? if ($_REQUEST[pop]) echo "style='background-color:#f2f2f2;'"; ?>>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$db2=new conexao();
$db2->conecta();

//$dir= diretorio_fisico() . "autores\\";
//$dir_virt= diretorio_virtual() . "autores/";
$dir= diretorio_fisico();
$dir_virtual= diretorio_virtual();

$sql="select a.nomeetiqueta from autor as a where a.autor='$_REQUEST[id]'";
$db->query($sql);
$res=$db->dados();
//echo $_SESSION['lnk'];
//if($_REQUEST[op]=='view') {
  $sql="INSERT INTO log_pesquisa(colecao,autor,obra,data_hora)values('0','$_REQUEST[id]','0',now())";
  $db->query($sql);
// }
echo "&nbsp;&nbsp;".ucfirst($res[0])."";
?>
</div></th>
  </tr>
<?
 if($_REQUEST[id]<>'')
 {
	$sql="SELECT b.* from fotografia_autor as a, fotografia as b where a.fotografia = b.fotografia
	   AND a.autor = '$_REQUEST[id]' order by a.eh_principal desc,a.fotografia asc";
    $db->query($sql);
    if($row=$db->dados()) {
		$foto= $row['fotografia'];
		$imagem= $row['nome_arquivo'];
	}
   $sql="SELECT * from autor as a where a.autor='$_REQUEST[id]'";
   $db->query($sql);
      while($row=$db->dados())
	  {
	   $nomecatalogo=$row['nomecatalogo'];
	   $biografia=$row['biografia'];
      }  
}
  ?>
 <?
function exibeDataNegativa($valor) {
	if ($valor < 0)
		return substr($valor,1) . " aC";
	else
		return $valor;
}

function monta_nascimento(){
global $db;
$sql="SELECT *from autor where autor='$_REQUEST[id]'";
$db->query($sql);
while($row=$db->dados()){
 $nasc='';   
 $sql2= "SELECT nome from pais where pais = '$row[pais_nasc]'";
   $db->query($sql2);
   $pais= $db->dados();
   $pais= $pais['nome'];
if (strtoupper($pais) == 'BRASIL') {
    $sql3= "SELECT uf from estado where estado = '$row[estado_nasc]'";
    $db->query($sql3);
    $estado= $db->dados();
    $estado= $estado['uf'];
      $nasc.= $row[cidade_nasc].", ".$estado." ";}
else {
 if ($row[cidade_nasc]=='?' && $pais=='?')
   $nasc.= "? ";
     else
 $nasc.= $row[cidade_nasc].", ".$pais." ";
 }
 if ($row[dt_nasc_tp] == 'circa')
    $nasc.= " circa ";
 if ($row[dt_nasc_ano1] <> '0') {
   $nasc.= exibeDataNegativa($row[dt_nasc_ano1]);
}
  if ($row[dt_nasc_ano2] <> '0') {
    if ($row[dt_nasc_ano2] <> $row[dt_nasc_ano1])
        $nasc.= " / ".exibeDataNegativa($row[dt_nasc_ano2]);
}
  if ($row[dt_nasc_tp] == '?') 
    $nasc.=" (?) ";
echo $nasc;
 }
}
function monta_falecimento(){
global $db;
$sql="SELECT *from autor where autor='$_REQUEST[id]'";
$db->query($sql);
while($row=$db->dados()){
 $morte='&nbsp;-&nbsp;';
 $sql2= "SELECT nome from pais where pais = '$row[pais_morte]'";
   $db->query($sql2);
   $pais= $db->dados();
   $pais= $pais['nome'];
if (strtoupper($pais) == 'BRASIL') {
    $sql3= "SELECT uf from estado where estado = '$row[estado_morte]'";
    $db->query($sql3);
    $estado= $db->dados();
    $estado= $estado['uf'];
      $morte.= $row[cidade_morte].", ".$estado." ";}
else {
 if ($row[cidade_morte]=='?' && $pais=='?')
   $morte.= "? ";
     else
 $morte.= $row[cidade_morte].", ".$pais." ";
 }
 if ($row[dt_morte_tp] == 'circa')
    $morte.= " circa ";
 if ($row[dt_morte_ano1] <> '0') {
   $morte.= exibeDataNegativa($row[dt_morte_ano1]);
}
  if ($row[dt_morte_ano2] <> '0') {
    if ($row[dt_morte_ano2] <> $row[dt_morte_ano1])
        $morte.= " / ".exibeDataNegativa($row[dt_morte_ano2]);
}
  if ($row[dt_morte_tp] == '?') 
    $morte.=" (?) ";
echo $morte;
 }
}
function conta_total()
{
 global $db;
 $sql="SELECT sum(quantidade) T from log_pesquisa where autor='$_REQUEST[id]'";
 $db->query($sql);
 $row=$db->dados();
 echo $row[T];
}
?>
 <br>

  <form name="frmautor" method="post" onSubmit='' enctype="multipart/form-data">
  <table border="0"  cellpadding="0" cellspacing="0">
    <tr>
      <td width="96" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto style2" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();">Biografia</a></div></td>
      <td width="116" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto style2" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();">Bibliografia</a></div></td>
      <td width="176" align="center" valign="bottom" id="aba3" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto style2" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();">Expo. Individuais</a></div></td>
      <td width="156" align="center" valign="bottom" id="aba4" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto style2" id="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();">Expo. Coletivas</a></div></td>
      <td width="96" align="center" valign="bottom" id="aba5" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="texto style2" id="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();">Imagens</a></div></td>
      <td width="62" align="center" valign="bottom" id="aba6" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="texto style2" id="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();">Obras</a></div></td>
	  <td width="80" class="texto_bold" style="border-bottom: 1px solid #34689A;"><div align="center" class="texto">&nbsp;<? /*if($_REQUEST[op]!='view'){*/ if (!$_REQUEST[pop]) echo "<a href=\"javascript:history.go(-1);\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"; ?></div></td>
    </tr>
      <td colspan="7" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none; border-bottom-width: 1px;">
         <table height="250"  bgcolor="f2f2f2" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="606">
			    <!-- ABA 1 : Biografia -->
              <div id="quadro1" class="divi1" style="display:; width:540px; overflow: auto;">
                  <table width="100%"  bgcolor="f2f2f2" height="50%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
                    <tr>
                      <td colspan="2" align="center" valign="top"><? echo $nomecatalogo ?><br><? monta_nascimento();monta_falecimento();?></td>
                    </tr>
                    <tr>
                      <td align="justify" valign="top" class="texto"><p align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo "$biografia"; ?></p></td>
                      <td align="right" valign="top" class="texto">
					<? if ($imagem <> '') { 
						$sql2="SELECT nome_arquivo,diretorio_imagem from fotografia where fotografia = '$foto'";
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

								//200 é a altura max da área de exibição da imagem; 220 é a largura máxima.//
								$cA= $Ao / 220;
								$cL= $Lo / 220;

								if ($Ao > 220 || $Lo > 220) {
									if (cL < cA) {
										$percent= (220 * 100) / $Lo;
										$Lo= 220;
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
										if ($Lo > 220) {
											$percent= (220 * 100) / $Lo;
											$Lo= 220;
											$Ao= ($Ao * $percent) / 100;
										}
									}
								}
							} ?>
						<!--<a href="javascript:;" onClick="abrepop('imagem_lista_autor.php?id=<? echo $_REQUEST['id']; ?>');">--><img src='<? echo $dir_virtual.$url[0].'/'.combarra_encode($imagem); ?>' height="<? echo $Ao; ?>" width="<? echo $Lo; ?>" border='0'><!--</a>-->
                      <? } } } ?></td>
                    </tr>
                </table>
              </div>                
			  <!-- ABA 3 : BiBliografia -->
			  <div id="quadro2" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
					<? if($_REQUEST['id']<>''){ 
					echo "<iframe name='abas' align='middle' src='consulta_bibliografia.php?id=$_REQUEST[id]' width='520' height='280' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
                  <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;">É necessário salvar o autor <br>para poder incluir uma bibliografia. </td>
   	              </tr>
					<? } ?>
				</table>
              </div>
				 <!-- ABA 4 : Exposição Ind.-->  
				 <div id="quadro3" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
					<? if ($_REQUEST['id'] <> '') {
						echo "<iframe name='abas' align='middle' src='consulta_exposicao_ind.php?autid=$_REQUEST[id]' width='520' height='280' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
                  <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;">É necessário salvar o autor <br>para poder incluir uma exposição. </td>
   	              </tr>
					<? } ?>
                </table>
              </div>
			 <!-- ABA 4 : Exposição Col. -->  
				 <div id="quadro4" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
					<? if ($_REQUEST['id'] <> '') {
						echo "<iframe name='abas' align='middle' src='consulta_exposicao_col.php?autid=$_REQUEST[id]' width='520' height='280' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
                  <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;">É necessário salvar o autor <br>para poder incluir uma exposição. </td>
   	              </tr>
					<? } ?>
                </table>
              </div>
			 <!-- ABA 5 : Imagem -->  
				 <div id="quadro5" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
					<? if ($_REQUEST['id'] <> '') {
						echo "<iframe name='abas' align='middle' src='imagem_lista_autor.php?id=$_REQUEST[id]' width='520' height='280' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} ?>
                </table>
              </div>
			 <!-- ABA 6 : Obras do autor -->  
				 <div id="quadro6" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="95%"  height="50%" border="0" cellpadding="6" cellspacing="3" bgcolor="f2f2f2" class="texto_bold">
                    <tr>
                  </tr>
                    <tr>
					<? if ($_REQUEST['id'] <> '') {
						echo "<iframe name='abas' align='middle' src='lista_obras_autor.php?id=$_REQUEST[id]' width='520' height='280' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} ?>
                </table>
              </div>
			</td>
          </tr>
        </table>



     <table align="left" bgcolor="f2f2f2" border="0"><td width="455" align="left"><form name="form2" method="post" action=""> 

     <span class="texto_bold">Consultas realizadas:
     <input name="textfield" align="middle" type="text" class="combo_cadastro" readonly="1" size="7" value="<? conta_total() ?>">
     </span>   </form>     </td>
       <td width="200">
	    <form name="form1" method="post" action="autorconsulta.php">
         <? if($_REQUEST[op]=='view'){ ?>
		   <input name="Submit" type="submit" class="combo_cadastro" value="Nova Consulta">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <? } ?><img src='imgs/icons/ic_salvar_impressao.gif' style="cursor:pointer;" border='0'  alt='Imprimir' onClick="window.open('imprime_autor.php?id=<? echo $_REQUEST[id]; ?>','','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-300)+',height=560, width=740,toolbar=yes,resizable=yes,scrollbars=yes');">
	   </form></td>
   </table>
  </form> 
</body>
