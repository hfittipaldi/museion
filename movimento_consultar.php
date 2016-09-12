<? include_once("seguranca.php") ?>

<style type="text/css">
#abas a {
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
}
.divi1 {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
	background-color: #f2f2f2;
}
</style>

<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script language="JavaScript">
function ajustaAbas(index) {
	numAbas= 3;

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
<body onLoad='ajustaAbas(<? echo $aba; ?>);'>
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
      <? 
		include("classes/classe_padrao.php");
		include("classes/funcoes_extras.php");
		$db=new conexao();
		$db->conecta();
		echo $_SESSION['lnk'];
		echo "<br><br>";

		$movid= $_REQUEST['movid'];

		if ($movid <> '') {
			$sql= "SELECT * from movimentacao where movimentacao = '$movid'";
			$db->query($sql);
			if ($row=$db->dados()) {
				$rtipo= $row['tipo_mov'];
				$dtsaida= explode("-", $row['data_saida']);
				$dia=$dtsaida[2]; $mes=$dtsaida[1]; $ano=$dtsaida[0];
				$dtsaida= $dia."/".$mes."/".$ano;
				$dtretorno= explode("-", $row['retorno_provavel']);
				$dia=$dtretorno[2]; $mes=$dtretorno[1]; $ano=$dtretorno[0];
				$dtretorno= $dia."/".$mes."/".$ano;
				$dtret2= explode("-", $row['data_retorno']);
				$dia=$dtret2[2]; $mes=$dtret2[1]; $ano=$dtret2[0];
				$dtret2= $dia."/".$mes."/".$ano;
				$local_ext= $row['local_externo'];
				$finalidade= $row['finalidade'];
				$local_origem= $row['local_origem'];
				$local_destino= $row['local_destino'];
				$local_legado= $row['local_int_legado'];
			}
		}
		else
			$rtipo= $_REQUEST['rTipo'];

		// EI -> Exposição Interna | EE -> Exposição Externa | LI -> Local Interno | LE -> Local Externo \\
		if ($rtipo=='EI' || $rtipo=='EE')
			$numAbas= 3;
		else
			$numAbas= 2;
	  ?>
    </div></th>
  </tr>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Movimenta&ccedil;&atilde;o</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Obras</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba3" style="display: <? if($numAbas == 2) { echo "none"; } ?>;  border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Exposições</span></a></div></td>
	  <td width="<? if($numAbas == 2) { echo "340"; } else { echo "240"; } ?>" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
    </tr>
      <td colspan="4" align="left" class="texto" style="background-color: #f2f2f2; border: 1px solid #34689A; border-top: none;">
         <table height="340" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td valign="top">
			<!-- ABA 1 : Movimentação -->
                <div id="quadro1" class="divi1" style="display: none; width:540px; overflow: auto;">
                  <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td class="texto_bold" style="font-weight:normal;"><br><b><? echo "Nº da movimentação: </b>" .$row['movimentacao']?><b><br><br><br>Saída prevista:</b> <? echo $dtsaida; ?></td>
                      <td align="right" class="texto_bold" style="font-weight:normal;"><br><br><br><br><b>Retorno provável:</b> <? echo $dtretorno; ?></td>
						<input type="hidden" name="rTipo" value="<? echo $rtipo; ?>">
                    </tr>
					<? if ($dtret2 <> '00/00/0000') { ?>
					<tr>
					  <td class="texto_bold" align="right" colspan="2" style="font-weight:normal;"><b>Retorno da última obra:</b> <? echo $dtret2; ?></td>
					</tr>
					<? } ?>
					<? if ($rtipo == 'LE') { ?>
					<tr>
					  <td class="texto_bold" colspan="2" style="font-weight:normal;"><b>Local:</b> <? echo $local_ext; ?></td>
					</tr>
					<tr>
					  <td class="texto_bold" colspan="2" style="font-weight:normal;"><b>Finalidade:</b> <? echo $finalidade; ?></td>
					</tr>
					<? } elseif ($rtipo=='LI' || $rtipo=='EI') { ?>
						<? if ($rtipo=='LI' && $local_legado<>'') { ?>
							<tr>
							  <td class="texto_bold" colspan="2" style="font-weight:normal;"><b>Local:</b> <? echo $local_legado; ?></td>
							</tr>
						<? } else { ?>
					<tr>
					  <td class="texto_bold" colspan="2" style="font-weight:normal;"><b>Local de origem:</b> 
		                  <? 
							$sql= "SELECT nome from local where local = '$local_origem'";
							$db->query($sql);
							$local= $db->dados();
							echo $local['nome'];
							?>
					  </td>
					</tr>
					<tr>
					  <td class="texto_bold" colspan="2" style="font-weight:normal;"><b>Local de destino:</b> 
		                  <? 
							$sql= "SELECT nome from local where local = '$local_destino'";
							$db->query($sql);
							$local= $db->dados();
							echo $local['nome'];
							?>
					  </td>
					</tr>
					<? } ?>
					<? if ($rtipo == 'LI') { ?>
					<tr>
					  <td class="texto_bold" colspan="2" style="font-weight:normal;"><b>Finalidade:</b> <? echo $finalidade; ?></td>
					</tr>
					<? }} ?>
					<tr>
					  <td class="texto_bold" style="font-weight:normal;" colspan="2"><b>Tipo:</b> <? if($rtipo=='EI' || $rtipo=='LI') { echo "<font style='color:navy;'>Interna</font>"; } else { echo "<font style='color:maroon;'>Externa</font>"; } ?></td>
					</tr>
                                        <tr>
                                           <td><input type="button" class="botao" name="laudo_vis" value="Laudo de Vistoria" onClick="window.open('imprime_laudo.php?id=<? echo $movid; ?>&pTipo=<? echo $rtipo; ?>&local=<? echo htmlentities($local_ext, ENT_QUOTES); ?>&fim=<? echo htmlentities($finalidade, ENT_QUOTES); ?>','','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-300)+',height=560, width=740,menubar=yes,toolbar=yes,resizable=yes,scrollbars=yes');"></td>
                                        </tr>
					<tr>
						<td colspan="2" class="texto_bold"><br><? echo "<a href='javascript:history.back();'><img src='imgs/icons/btn_voltar.gif' border='0' alt='Voltar'></a>"; ?></td>
					</tr>
                  </table>
            	</div>
                <!-- ABA 2 : Obras -->
              <div id="quadro2" class="divi1" style="display: none; width:540px; overflow: auto;">
                <table width="100%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
					<? echo "<iframe name='abas' src='obra_lista_pesquisa.php?movid=$movid' width='540' height='330' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>"; ?>
                </table>
  		      </div>                
			  <!-- ABA 3 : Exposições -->
			  <div id="quadro3" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="100%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
					<? echo "<iframe name='abas' src='exposicao_lista_retorno.php?movid=$movid' width='540' height='330' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>"; ?>
                </table>
              </div>
			</td>
          </tr>
        </table>
  </table>
</form>
</body>