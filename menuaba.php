
<style type="text/css">
<!--
.abas {
/*	border-bottom: 1px solid #FFFFFF;	*/
}
.abas a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #34689A;
	text-decoration: none;
/*	background-color: #DFDFDF;
	background-image: url(imgs/esquerdoazul.gif);
	background-repeat: no-repeat;
	background-position: left top;
	padding-left: 10px;*/
}
/*.abas a span {
	background-image: url(imgs/direitoazul.gif);
	background-repeat: no-repeat;
	background-position: right top;
	padding-right: 10px;
}*/
/*.abas a:hover {
	color: #000000;
	text-decoration: underline;
	background-color: #FFCC00;
	background-image: url(imgs/esquerdoazul_hover.gif);
	background-repeat: no-repeat;
	background-position: left top;
	padding-left: 10px;
}*/
/*.abas a:hover span {
	background-image: url(imgs/direitoazul_hover.gif);
	background-repeat: no-repeat;
	background-position: right top;
	padding-right: 10px;
}*/

.divi {
	scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
-->
</style>

<script language="JavaScript">
niveis= new Array();

function obterNivel(object,str) {
	str= str.split(".");
	i=0;
	if (str[0] != '') {
		while(str[i] != undefined)
			i++;
	}
	//limpa a lista
	for (k=0;k<object.options.length;k++) {
		object.options[k]= null;
	}
	//preenche a lista
	addOption(object,niveis[i],i,0);
	addOption(object,niveis[ultimo],ultimo,1);
}

function addOption(selectObject,optionText,optionValue,optionRank) {
	var optionObject= new Option(optionText,optionValue);
	if (optionRank == undefined)
		optionRank= selectObject.options.length;
alert(selectObject);
	selectObject.options[optionRank]= optionObject;
}

function textCounter(field,maxlimit,divid) {
	navegador= navigator.appName;
	if (navegador != 'Netscape') {
		if (field.value.length>maxlimit) field.value=field.value.substring(0,maxlimit);
		else document.getElementById(divid).innerText=maxlimit-field.value.length;
	}
}

function ajustaAbas(index) {
	document.getElementById("link1").style.color= "#34689A";
	document.getElementById("link2").style.color= "#34689A";
	document.getElementById("link3").style.color= "#34689A";
	document.getElementById("link4").style.color= "#34689A";
	document.getElementById("link5").style.color= "#34689A";
	document.getElementById("link6").style.color= "#34689A";
	document.getElementById("link7").style.color= "#34689A";
	document.getElementById("link"+index).style.color= "blue";

	document.getElementById("aba1").style.borderBottomColor= "#34689A";
	document.getElementById("aba2").style.borderBottomColor= "#34689A";
	document.getElementById("aba3").style.borderBottomColor= "#34689A";
	document.getElementById("aba4").style.borderBottomColor= "#34689A";
	document.getElementById("aba5").style.borderBottomColor= "#34689A";
	document.getElementById("aba6").style.borderBottomColor= "#34689A";
	document.getElementById("aba7").style.borderBottomColor= "#34689A";
	document.getElementById("aba"+index).style.borderBottomColor= "#FFFFFF";

	document.getElementById("aba1").style.verticalAlign= "bottom";
	document.getElementById("aba2").style.verticalAlign= "bottom";
	document.getElementById("aba3").style.verticalAlign= "bottom";
	document.getElementById("aba4").style.verticalAlign= "bottom";
	document.getElementById("aba5").style.verticalAlign= "bottom";
	document.getElementById("aba6").style.verticalAlign= "bottom";
	document.getElementById("aba7").style.verticalAlign= "bottom";
	document.getElementById("aba"+index).style.verticalAlign= "middle";

	document.getElementById("aba1").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba2").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba3").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba4").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba5").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba6").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba7").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba"+index).style.backgroundColor= "#FFFFFF";

	document.getElementById("quadro1").style.display= "none";
	document.getElementById("quadro2").style.display= "none";
	document.getElementById("quadro3").style.display= "none";
	document.getElementById("quadro4").style.display= "none";
	document.getElementById("quadro5").style.display= "none";
	document.getElementById("quadro6").style.display= "none";
	document.getElementById("quadro7").style.display= "none";
	document.getElementById("quadro"+index).style.display= "";

	if (index==4 || index==5) {
		document.frm_Ficha.salvar.disabled= true;
	} else {
		document.frm_Ficha.salvar.disabled= false;
	}
}
</script>

<?php
	$aba= 1;
	if (!empty($_GET['aba']))
		$aba= $_GET['aba'];
	if ($aba > 7)
		$aba= 7;

	$opcao= $_REQUEST['op'];

	////Faz a preparação da página quando for modificar autor ou assunto:
	$alterando= false;
	if ($_REQUEST['salvar']=='' && $opcao<>'') {
		if ($opcao=='insAutor') {
			$aba=4;
		}
		elseif ($opcao=='insAssunto') {
			$aba=5;
		}

		elseif ($opcao=='upd') {
			if ($_REQUEST['aut']<>'') {
				$aba=4;
				$alterando= true;
				$compid= 'autor_alter';
			}
			elseif ($_REQUEST['ass']<>'') {
				$aba=5;
				$alterando= true;
				$compid= 'assunto_alter';
			}		
		}

		elseif ($opcao=='altAutor') {
			$aba=4;
		}
		elseif ($opcao=='altAssunto') {
			$aba=5;
		}

		elseif ($opcao=='del') {
			if ($_REQUEST['aut']<>'') {
				$aba=4;
			}
			elseif ($_REQUEST['ass']<>'') {
				$aba=5;
			}
		}
	}
?>

<body onLoad='ajustaAbas(<? echo $aba ?>); <? if ($alterando) { echo "document.getElementById(\"".$compid."\").focus(); /*document.getElementById(\"".$compid."\").select();*/"; } ?>'>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="4" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
	<td height="20" width="108" id="aba1" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Identificação</span></a></div></td>
	<td width="97" id="aba2" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Contexto</span></a></div></td>
	<td width="98" id="aba3" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="abas"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Conteúdo</span></a></div></td>
	<td width="92" id="aba4" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="abas"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Autoria</span></a></div></td>
	<td width="97" id="aba5" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(5);"><div class="abas"><a href="javascript:;" id="link5" onClick="ajustaAbas(5);" onMouseDown="this.click();"><span>Assuntos</span></a></div></td>
	<td width="91" id="aba6" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(6);"><div class="abas"><a href="javascript:;" id="link6" onClick="ajustaAbas(6);" onMouseDown="this.click();"><span>Fontes</span></a></div></td>
	<td width="100" id="aba7" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(7);"><div class="abas"><a href="javascript:;" id="link7" onClick="ajustaAbas(7);" onMouseDown="this.click();"><span>Condições</span></a></div></td>
	<td width="113" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9" align="left" class="texto" style="border: 2px solid #34689A; border-top: none; border-left-width: 1px;">
		<table height="365" border="0" cellpadding="0" cellspacing="0">
			<tr><td>
<!-- ABA 1 : Identificação -->
<div id="quadro1" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="6" cellspacing="1">
	<?php if ($IdFichaTecnica <> '') { ?>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="1" cellspacing="1">
					<tr>
						<td width="130">Fundo :</td>
						<td style="font-size: 11px;">GF - Gilberto Ferrez</td>
					</tr>
					<tr>
						<td>Seção :</td>
						<td style="font-size: 11px;">GF.1 - Homem de História, Arte e Cultura</td>
					</tr>
					<tr>
						<td>Subseção :</td>
						<td style="font-size: 11px;">GF.1.0 - Diversos</td>
					</tr>
					<tr>
						<td>Série :</td>
						<td style="font-size: 11px;">GF.1.0.1 - Correspondência</td>
					</tr>
					<tr>
						<td>Subsérie :</td>
						<td style="font-size: 11px;">GF.1.0.1.1 - Notas de trabalho</td>
					</tr>
					<tr>
						<td>Dossiê :</td>
						<td style="font-size: 11px;">GF.1.0.1.1.1 - Fotografias e obras de arte e arquitetônicas</td>
					</tr>
				</table>
			</td>
		</tr>
	<? } else { ?>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	<?php } ?>
		<tr>
			<td>Referência: </td>
			<td><input type="text" name="referencia" size="44" readonly> <input type="button" value="Selecionar..." onClick="window.open('pop_referencia.php','referencia','left='+((window.screen.width/2)-250)+',top='+((window.screen.height/2)-210)+',width=500,height=420, scrollbars=yes, resizable=no');"></td>
		</tr>
		<tr>
			<td>Nível de descrição: </td>
			<td>
				<?php 
					$sql="SELECT * from nivel_descricao order by nivel_descricao asc";
					$db->query($sql);
					//Preenche o array javascript 'niveis' e guarda o valor do ultimo nível
					echo "<script>";
					while($niv=$db->dados()) {
						echo "niveis[".$niv['nivel_descricao']."]= '".$niv['nome']."'; ";
						echo "ultimo= ".$niv['nivel_descricao']."; ";
					}
					echo "</script>";
				?>
				<select class="select" name="nivel_desc" id="nivel_desc" ></select> &nbsp;
				<script>
					addOption(document.frm_Ficha.nivel_desc,niveis[ultimo],ultimo);
					document.getElementById('nivel_desc').selectedIndex=-1;
				</script>
			</td>
		</tr>
		<tr>
			<td>Nº catálogo: </td>
			<td><input type="text" name="catalogo" size="44" maxlength="20"></td>
		</tr>
		<tr>
			<td>Data descritiva: </td>
			<td><input type="text" name="data_desc" size="24" maxlength="50">&nbsp;&nbsp;&nbsp;&nbsp;
				De: <input type="text" name="de" size="10" maxlength="10">&nbsp;
				Até: <input type="text" name="ate" size="10" maxlength="10"></td>
		</tr>
		<tr>
			<td><br>Incluída por: </td>
			<td><br><input readonly type="text" name="usu_inclusao" size="34" maxlength="40" style="background-color: #fdfdfd;">&nbsp;&nbsp;&nbsp;
			em: <input type="text" name="inclusao_em" size="19" maxlength="19" readonly style="background-color: #fdfdfd;"></td>
		</tr>
		<tr>
			<td>Atualizada por: </td>
			<td><input type="text" name="usu_alteracao" size="34" maxlength="40" readonly style="background-color: #fdfdfd;">&nbsp;&nbsp;&nbsp;
			em: <input type="text" name="alteracao_em" size="19" maxlength="19" readonly style="background-color: #fdfdfd;"></td>
		</tr>
	</table>
</div>
<!-- ABA 2 : Contexto -->
<div id="quadro2" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="6" cellspacing="3">
		<tr>
			<td>Produtor: </td>
			<td><input type="text" name="produtor" size="65" maxlength="250" readonly style="background-color: #fdfdfd;"></td>
		</tr>
		<tr>
			<td valign="top">Biografia: </td>
			<td><textarea name="biografia" cols="67" rows="9" readonly style="background-color: #fdfdfd;"></textarea></td>
		</tr>
		<tr>
			<td valign="top">Histórico <br>arquivístico: </td>
			<td><textarea name="historico" cols="67" rows="8" readonly style="background-color: #fdfdfd;"></textarea></td>
		</tr>
		<tr>
			<td>Procedência: </td>
			<td><input type="text" name="procedencia" size="65" maxlength="250" readonly style="background-color: #fdfdfd;"></td>
		</tr>
	</table>
</div>
<!-- ABA 3 : Conteúdo -->
<div id="quadro3" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="6" cellspacing="2">
		<tr>
			<td>Entrada principal: </td>
			<td><input type="text" name="entrada" size="65" maxlength="120"></td>
		</tr>
		<tr>
			<td valign="top">Descrição de conteúdo: <br><br><em><div style="color: #666666;" id=counterfieldi align="right"></div></em></td>
			<td><textarea name="ambito" cols="67" rows="14" onKeyDown="textCounter(this,4000,'counterfieldi');" onKeyUp="textCounter(this,4000,'counterfieldi');"></textarea></td>
		</tr>
		<tr>
			<td>Data: </td>
			<td><input type="text" name="dt_conteudo" size="65" maxlength="100"></td>
		</tr>
		<tr>
			<td>Local: </td>
			<td><input type="text" name="local_conteudo" size="65" maxlength="200"></td>
		</tr>
		<tr>
			<td>Dimensão suporte: </td>
			<td><input type="text" name="suporte" size="65" maxlength="100"></td>
		</tr>
		<tr>
			<td valign="top">Anexo: <br><br><em><div style="color: #666666;" id=counterfieldii align="right"></div></em></td>
			<td><textarea name="anexo" cols="67" rows="13" onKeyDown="textCounter(this,4000,'counterfieldii');" onKeyUp="textCounter(this,4000,'counterfieldii');"></textarea></td>
		</tr>
		<tr>
			<td valign="top">Notas: <br><br><em><div style="color: #666666;" id=counterfieldiii align="right"></div></em></td>
			<td><textarea name="notas" cols="67" rows="8" onKeyDown="textCounter(this,2000,'counterfieldiii');" onKeyUp="textCounter(this,2000,'counterfieldiii');"></textarea></td>
		</tr>
		<tr>
			<td>Idiomas: </td>
			<td><input type="text" name="idioma" size="65" maxlength="250"></td>
		</tr>
	</table>
</div>
<!-- ABA 4 : Autoria -->
<div id="quadro4" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="5" cellspacing="2">
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="1">
					<tr>
						<td width="75">Autor: </td>
						<td nowrap><input type="text" name="autor_novo" size="62" maxlength="200" tabindex="2">&nbsp;&nbsp;</td>
						<?php if ($IdFichaTecnica <> '') { ?>
							<td colspan="2"><input type="button" name="incluirAutor" value="Incluir" tabindex="4" onClick="document.frm_Ficha.op.value = 'insAutor'; document.frm_Ficha.submit();"></td>
						<? } else {
							echo "<td colspan='2'><input type='button' name='incluirAutor' value='Incluir' disabled></td>";
						   } ?>
					</tr>
					<tr>
						<td>Ordem: </td>
						<td colspan="3"><input type="text" name="autor_ordem" size="12" tabindex="3" maxlength="6">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4"><br>Índice de autor: </td>
					</tr>
					<?php if ($IdFichaTecnica == '') { ?>
					<tr>
						<td colspan="4" align="center" style="color: navy;"><br><br>Para incluir um autor a ficha deve estar salva.</td>
					</tr>
					<? } ?>
					<?php 
						$sql="SELECT * from ficha_tecnica_autor where ficha_tecnica = '$IdFichaTecnica' order by sequencia asc";
						$db->query($sql);
						while($autor=$db->dados()) {
						?>
						<tr>
							<td width="98%" colspan="2" valign="bottom" style="border-bottom: 1px solid #DFDFDF; font-size: 11px;">
								<? if ($_REQUEST['aut']==$autor['sequencia'] && $opcao=='upd') {
										echo "<div align='right'><img src='imgs/ic_novo.gif' width='18' border='0'>
											<input type='text' name='autor_alter' id='autor_alter' value='".$autor['nome']."' size='62' maxlength='200'>&nbsp;&nbsp;</div>";
								   } else {
										echo "&nbsp;".$autor['sequencia'].". ".$autor['nome'];
								   }	?>
							</td>
							<td align="center" style="border: 1px solid #96ADEB;">
								<? if ($_REQUEST['aut']==$autor['sequencia'] && $opcao=='upd') {
										echo "<input type='button' name='alterarAutor' value='OK' onClick='document.frm_Ficha.op.value = \"altAutor\"; document.frm_Ficha.submit();'>";
										echo "<input type='hidden' name='aut' value='".$_REQUEST['aut']."'>";
								   } else {
										echo "<a href='ficha_tecnica.php?op=upd&IdF=".$IdFichaTecnica."&aut=".$autor['sequencia']."'>
											<img src='imgs/ic_alterar.gif' width='20' border='0' alt='Alterar'>";
								   } ?></td>
							<td align="center" style="border: 1px solid #EBAD96;">
									<? echo "<a href='ficha_tecnica.php?op=del&IdF=".$IdFichaTecnica."&aut=".$autor['sequencia']."'
										onClick='return confirm(".'"Confirma EXCLUSÃO do registro?"'.")'>
										<img src='imgs/ic_excluir.gif' width='20' border='0' alt='Excluir'>";
									?></td>
						</tr>
					<? } ?>
				</table>
			</td>
		</tr>
	</table>
</div>
<!-- ABA 5 : Assuntos -->
<div id="quadro5" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="5" cellspacing="2">
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="1">
					<tr>
						<td width="75">Assunto: </td>
						<td nowrap><input type="text" name="assunto_novo" size="62" maxlength="200" tabindex="2">&nbsp;&nbsp;</td>
						<?php if ($IdFichaTecnica <> '') { ?>
							<td colspan="2"><input type="button" name="incluirAssunto" value="Incluir" tabindex="4" onClick="document.frm_Ficha.op.value = 'insAssunto'; document.frm_Ficha.submit();"></td>
						<? } else {
							echo "<td colspan='2'><input type='button' name='incluirAutor' value='Incluir' disabled></td>";
						   } ?>
					</tr>
					<tr>
						<td>Ordem: </td>
						<td colspan="3"><input type="text" name="assunto_ordem" size="12" maxlength="6" tabindex="3">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="4"><br>Índice de assunto: </td>
					</tr>
					<?php if ($IdFichaTecnica == '') { ?>
					<tr>
						<td colspan="4" align="center" style="color: navy;"><br><br>Para incluir um assunto a ficha deve estar salva.</td>
					</tr>
					<? } ?>
					<?php 
						$sql="SELECT * from ficha_tecnica_assunto where ficha_tecnica = '$IdFichaTecnica' order by sequencia asc";
						$db->query($sql);
						while($assunto=$db->dados()) {
						?>
						<tr>
							<td width="98%" colspan="2" valign="bottom" style="border-bottom: 1px solid #DFDFDF; font-size: 11px;">
								<? if ($_REQUEST['ass']==$assunto['sequencia'] && $opcao=='upd') {
										echo "<div align='right'><img src='imgs/ic_novo.gif' width='18' border='0'>
											<input type='text' name='assunto_alter' id='assunto_alter' value='".$assunto['nome']."' size='62' maxlength='200'>&nbsp;&nbsp;</div>";
								   } else {
										echo "&nbsp;".$assunto['sequencia'].". ".$assunto['nome'];
								   }	?>
							</td>
							<td align="center" style="border: 1px solid #96ADEB;">
								<? if ($_REQUEST['ass']==$assunto['sequencia'] && $opcao=='upd') {
										echo "<input type='button' name='alterarAssunto' value='OK' onClick='document.frm_Ficha.op.value = \"altAssunto\"; document.frm_Ficha.submit();'>";
										echo "<input type='hidden' name='ass' value='".$_REQUEST['ass']."'>";
								   } else {
										echo "<a href='ficha_tecnica.php?op=upd&IdF=".$IdFichaTecnica."&ass=".$assunto['sequencia']."'>
											<img src='imgs/ic_alterar.gif' width='20' border='0' alt='Alterar'>";
								   }	?></td>
							<td align="center" style="border: 1px solid #EBAD96;">
									<? echo "<a href='ficha_tecnica.php?op=del&IdF=".$IdFichaTecnica."&ass=".$assunto['sequencia']."'
										onClick='return confirm(".'"Confirma EXCLUSÃO do registro?"'.")'>
										<img src='imgs/ic_excluir.gif' width='20' border='0' alt='Excluir'>";
								?></td>
						</tr>
					<? } ?>
				</table>
			</td>
		</tr>
	</table>
</div>
<!-- ABA 6 : Fontes relacionadas -->
<div id="quadro6" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="6" cellspacing="2">
		<tr>
			<td valign="top">Unidades <br>de descrição <br>relacionadas: <br><br><em><div style="color: #666666;" id=counterfieldiv align="right"></div></em></td>
			<td><textarea name="fontes" cols="67" rows="24" onKeyDown="textCounter(this,2000,'counterfieldiv');" onKeyUp="textCounter(this,2000,'counterfieldiv');"></textarea></td>
		</tr>
	</table>
</div>
<!-- ABA 7 : Condições -->
<div id="quadro7" class="divi" style="display: none; width:570px; height:351px; overflow: auto;">
	<table width="95%" border="0" cellpadding="6" cellspacing="4">
		<tr>
			<td colspan="2">Estado de conservação: 
				<select class="select" name="estado" id="estado">
					<option value="BM">Bom</option>
					<option value="RE">Regular</option>
					<option value="RU">Ruim</option>
				</select>&nbsp;
				Obs: <input type="text" name="estado_obs" size="36" maxlength="120">
			</td>
		</tr>
		<script>
			document.getElementById('estado').selectedIndex=-1;
		</script>
		<tr>
			<td>Localização: </td>
			<td><input type="text" name="localiza" size="65" maxlength="250"></td>
		</tr>
		<tr>
			<td valign="top">Restrições <br>de acesso: <br><br><em><div style="color: #666666;" id=counterfieldv align="right"></div></em></td>
			<td><textarea name="acesso" cols="67" rows="8" onKeyDown="textCounter(this,500,'counterfieldv');" onKeyUp="textCounter(this,500,'counterfieldv');"></textarea></td>
		</tr>
		<tr>
			<td valign="top">Condições <br>de uso e reprodução: <br><br><em><div style="color: #666666;" id=counterfieldvi align="right"></div></em></td>
			<td><textarea name="reprod" cols="67" rows="8" onKeyDown="textCounter(this,500,'counterfieldvi');" onKeyUp="textCounter(this,500,'counterfieldvi');"></textarea></td>
		</tr>
	</table>
</div>
			</td></tr>
		</table>
	</td>
  </tr>
</table>
</body>
