<? include_once("seguranca.php") ?>

<style type="text/css">
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
}
</style>

<script language="JavaScript" src="js/funcoes_padrao.js"></script>
<script language="JavaScript">
function ajustaAbas(index) {
	numAbas= 3;

	if (index == 1)
		document.getElementById("aba1").style.borderLeftColor= "";
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

function valida() {
/*	with(document.form) {
		if(dtretorno.value=='') { alert('Preencha a data de retorno efetivo!'); dtretorno.focus(); return false; }

		if (!Validar_Campo_Data(dtretorno,false)) {
			alert('Preencha corretamente o campo "data de retorno efetivo"!'); dtretorno.focus(); return false;
		}
	}*/
	if (!confirm("Confirma o fechamento da movimentação ?")) {
		return false;
	}
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
<body onLoad='ajustaAbas(<? echo $aba; ?>); /*document.form.dtretorno.focus();*/'>
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
		echo "<br>";

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

		if ($_REQUEST['submit'] <> '') {
			if($movid <> '') {
				$sql= "SELECT MIN(data_retorno) as min_retorno, MAX(data_retorno) as max_retorno from obra_movimentacao where movimentacao = '$movid'";
				$db->query($sql);
				$retorno_ult_obra= $db->dados();
				if ($retorno_ult_obra['min_retorno'] == 0) {
					echo "<script>alert('Não foi possível fechar a movimentação!\\n\\nExiste(m) obra(s) sem data de retorno efetivo.');</script>";
					echo "<script>location.href='movimento_registrar.php?movid=$movid'</script>";
					exit();
				}
				else {
					$retorno_ult_obra= $retorno_ult_obra['max_retorno'];
				}
				//
				//
				$sql= "UPDATE movimentacao set data_retorno='$retorno_ult_obra' where movimentacao = '$movid'";
				$db->query($sql);

				if ($rtipo=='EI' || $rtipo=='EE') {
					$db2=new conexao();
					$db2->conecta();
					$sql="SELECT a.exposicao,b.obra FROM movimentacao_exposicao as a  INNER JOIN  obra_movimentacao as b on (a.movimentacao=b.movimentacao) where a.movimentacao=$movid";
					$db->query($sql);
					while ($obras=$db->dados()) {
						$sql2= "INSERT into obra_exposicao(obra,exposicao) values('$obras[obra]','$obras[exposicao]')";
						$db2->query($sql2);
					}
					$sql= "SELECT distinct a.exposicao, c.autor FROM movimentacao_exposicao AS a
							INNER JOIN obra_movimentacao AS b ON ( a.movimentacao = b.movimentacao )
							INNER JOIN autor_obra AS c ON ( b.obra = c.obra )
							WHERE a.movimentacao = $movid";
					$db->query($sql);
					while ($autores=$db->dados()) {
						$sql2= "INSERT into autor_exposicao(autor,exposicao) values('$autores[autor]','$autores[exposicao]')";
						$db2->query($sql2);
					}
				}

				echo "<script>alert('Registro de retorno concluído');</script>";
				echo "<script>location.href='movreg_retorno.php'</script>";
			}
		}
	  ?>
    </div></th>
  </tr>
<form name="form" method="post" onSubmit='return valida();'>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100" height="20" align="center" valign="bottom" id="aba1" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto" id="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Movimenta&ccedil;&atilde;o</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba2" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto" id="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Obras</span></a></div></td>
      <td width="100" align="center" valign="bottom" id="aba3" style="display: <? if($numAbas == 2) { echo "none"; } ?>;  border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto" id="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Exposições</span></a></div></td>
	  <td width="<? if($numAbas == 2) { echo "340"; } else { echo "240"; } ?>" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
    </tr>
      <td colspan="4" align="left" class="texto" style="background-color: #f2f2f2; border: 0px solid #34689A; border-top: none;">
         <table height="320" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td valign="top">
			<!-- ABA 1 : Movimentação -->
                <div id="quadro1" class="divi1" style="display: none; width:540px; overflow: auto;">
                  <table width="95%" border="0" cellpadding="4" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td class="texto_bold"><br>Saída prevista: <? echo $dtsaida; ?></td>
                      <td align="right" class="texto_bold"><br>Retorno provável: <? echo $dtretorno; ?></td>
						<input type="hidden" name="rTipo" value="<? echo $rtipo; ?>">
                    </tr>
					<!--<tr>
					  <td class="texto_bold" colspan="2">Retorno da última obra: <input name="dtretorno" readonly type="text" class="combo_cadastro" id="dtretorno" size="12" maxlength="10">
							<input type="text" name="vazio" value="" style="display:none;">
					  </td>
					</tr>-->
					<? if ($rtipo == 'LE') { ?>
					<tr>
					  <td class="texto_bold" colspan="2">Local: <? echo $local_ext; ?></td>
					</tr>
					<tr>
					  <td class="texto_bold" colspan="2">Finalidade: <? echo $finalidade; ?></td>
					</tr>
					<? } elseif ($rtipo=='LI' || $rtipo=='EI') { ?>
						<? if ($rtipo=='LI' && $local_legado<>'') { ?>
							<tr>
							  <td class="texto_bold" colspan="2">Local: <? echo $local_legado; ?></td>
							</tr>
						<? } else { ?>
					<tr>
					  <td class="texto_bold" colspan="2">Local de origem: 
		                  <? 
							$sql= "SELECT nome from local where local = '$local_origem'";
							$db->query($sql);
							$local= $db->dados();
							echo $local['nome'];
							?>
					  </td>
					</tr>
					<tr>
					  <td class="texto_bold" colspan="2">Local de destino: 
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
					  <td class="texto_bold" colspan="2">Finalidade: <? echo $finalidade; ?></td>
					</tr>
					<? }} ?>
					<tr>
					  <td class="texto_bold" colspan="2">Tipo: <? if($rtipo=='EI' || $rtipo=='LI') { echo "<font style='color:;'>Interna</font>"; } else { echo "<font style='color:;'>Externa</font>"; } ?></td>
					</tr>
					<? if ($rtipo=='EI' || $rtipo=='EE') { ?>
					<tr>
					  <td class="texto_bold" colspan="2" style="color: navy;"><label style="border-bottom: 1px solid black;">ATENÇÃO</label>: Ao clicar em "Fechar movimentação", serão gerados os registros de <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;participações para obras e autores desta movimentação.</td>
					</tr>
					<? } ?>
		            <tr>
		              <td align="center" colspan="2" class="texto_bold"><br><input name="submit" type="submit" class="botao" value="Fechar Movimentação"></td>
        		    </tr>
					<tr>
						<td colspan="2" class="texto_bold"><? echo "<a href=\"movreg_retorno.php\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"?></td>
					</tr>
                  </table>
            	</div>
                <!-- ABA 2 : Obras -->
              <div id="quadro2" class="divi1" style="display: none; width:540px; overflow: auto;">
                <table width="100%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
					<? echo "<iframe name='abas' src='obra_lista_retorno.php?movid=$movid' width='540' height='330' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>"; ?>
                </table>
  		      </div>                
			  <!-- ABA 3 : Exposições -->
			  <div id="quadro3" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="100%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
					<? echo "<iframe name='abas' src='exposicao_lista_retorno.php?movid=$movid' width='540' height='330' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>"; ?>
                </table>
              </div></td>
          </tr>
        </table>
  </table>
</form>
</body>