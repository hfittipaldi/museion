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
	with(document.form) {
		if(dtsaida.value=='') { alert('Preencha a data de saída!'); dtsaida.focus(); return false; }
		if(dtretorno.value=='') { alert('Preencha a data de retorno provavel!'); dtretorno.focus(); return false; }

		if (!Validar_Campo_Data(dtsaida,false)) {
			alert('Preencha corretamente o campo "data de saída"!'); dtsaida.focus(); return false;
		}
		if (!Validar_Campo_Data(dtretorno,false)) {
			alert('Preencha corretamente o campo "data de retorno provavel"!'); dtretorno.focus(); return false;
		}
	}
}
</script>

<?php $aba=1; ?>

<link href="css/home.css" rel="stylesheet" type="text/css">
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
		echo "<br>";

		$movid= $_REQUEST['movid'];

		if ($movid <> '') {
			if ($_REQUEST['op'] == 'del') {
				$sql= "SELECT count(*) as total from movimentacao where movimentacao = '$movid' AND data_retorno <> 0";
				$db->query($sql);
				$tot=$db->dados();
				if ($tot[0] == 1) {
					echo "<script>alert('Exclusão abortada!!!');</script>";
					echo "<script>location.href='movpre_altera.php?movid=".$movid."'</script>";
				}
				else {
					$sql= "DELETE from movimentacao where movimentacao = '$movid'";
					$db->query($sql);
					$sql= "DELETE from obra_movimentacao where movimentacao = '$movid'";
					$db->query($sql);
					$sql= "DELETE from movimentacao_exposicao where movimentacao = '$movid'";
					$db->query($sql);
					echo "<script>alert('Exclusão realizada com sucesso');</script>";
					echo "<script>location.href='movpre_altera.php?movid=".$movid."'</script>";
				}
			}

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
				$local_legado= $row['local_int_legado'];
				$local_origem= $row['local_origem'];
				$local_destino= $row['local_destino'];
			}
		}
		else
			$rtipo= $_REQUEST['rTipo'];

		// EI -> Exposição Interna | EE -> Exposição Externa | LI -> Local Interno | LE -> Local Externo \\
		if ($rtipo=='EI' || $rtipo=='EE')
			$numAbas= 3;
		else
			$numAbas= 2;

		if($_REQUEST['submit'] <> '') {

			$dtsaida= explode("/", $_REQUEST['dtsaida']);
			$dia=$dtsaida[0]; $mes=$dtsaida[1]; $ano=$dtsaida[2];
			$dtsaida= $ano."-".$mes."-".$dia;
			$dtretorno= explode("/", $_REQUEST['dtretorno']);
			$dia=$dtretorno[0]; $mes=$dtretorno[1]; $ano=$dtretorno[2];
			$dtretorno= $ano."-".$mes."-".$dia;
			if($movid <> '') {
				$sql= "UPDATE movimentacao set data_saida='$dtsaida', retorno_provavel='$dtretorno', local_externo='$_POST[local_ext]', finalidade='$_POST[finalidade]', 
					local_origem='$_POST[local_origem]', local_destino='$_POST[local_destino]' where movimentacao = '$movid'";

				$db->query($sql);
				echo "<script>location.href='movimentacao.php?movid=".$movid."'</script>";
			} else {
				$sql= "INSERT into movimentacao(tipo_mov,data_saida,retorno_provavel,local_externo,finalidade,local_origem,local_destino) 
					values('$rtipo','$dtsaida','$dtretorno','$_POST[local_ext]','$_POST[finalidade]','$_POST[local_origem]','$_POST[local_destino]')";

				$db->query($sql);
					echo "<script>alert('Inclusão realizada com sucesso');</script>";
				echo "<script>location.href='movimentacao.php?movid=".$db->lastid()."'</script>";

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
         <table height="340" border="0" cellpadding="0" cellspacing="0">
		  <tr>
            <td valign="top">
			<!-- ABA 1 : Movimentação -->
                <div id="quadro1" class="divi1" style="display: none; width:540px; overflow: auto;">
                  <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#f2f2f2">
                    <tr>
                      <td class="texto_bold"><br>Saída prevista: <input name="dtsaida" type="text" class="combo_cadastro" id="dtsaida" value="<? echo $dtsaida ?>" size="12" maxlength="10"></td>
                      <td align="right" class="texto_bold"><br>Retorno provável: <input name="dtretorno" type="text" class="combo_cadastro" id="dtretorno" value="<? echo $dtretorno ?>" size="12" maxlength="10"></td>
						<input type="hidden" name="rTipo" value="<? echo $rtipo; ?>">
                    </tr></select>   
					<? if ($rtipo == 'EE') { ?>
						<input type="hidden" name="local_origem" value="0"><input type="hidden" name="local_destino" value="0">
					<? } elseif ($rtipo == 'LE') { ?> 
					<tr>
					  <td class="texto_bold" colspan="2">Local:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="combo_cadastro" type="text" name="local_ext" maxlength="255" size="50" value="<? echo htmlentities($local_ext, ENT_QUOTES); ?>"></td>
					</tr>
					<tr> 
					  <td class="texto_bold" colspan="2">Finalidade:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="combo_cadastro" type="text" name="finalidade" maxlength="255" size="50" value="<? echo htmlentities($finalidade, ENT_QUOTES); ?>">
							<input type="hidden" name="local_origem" value="0"><input type="hidden" name="local_destino" value="0">
					  </td>

					</tr>
					<? } elseif ($rtipo=='LI' || $rtipo=='EI') { ?>

						<? if ($rtipo=='LI' && $local_legado<>'') { ?>
							<tr>

							  <td class="texto_bold" colspan="2">Local:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="combo_cadastro" type="text" name="local_legado" readonly size="50" value="<? echo htmlentities($local_legado, ENT_QUOTES); ?>">
								<br><sup style="color:#444444;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Este campo não pode ser alterado.</sup>
								<input type="hidden" name="local_origem" value="0"><input type="hidden" name="local_destino" value="0">
							  </td>
							</tr>
						<? } else { ?>

					<tr>
					  <td class="texto_bold" colspan="2">Local de origem:&nbsp;
						<select name="local_origem" class="combo_cadastro" id="local_origem" >
		                                                           < <? 
							  $sql="SELECT * from local order by local";
							  $db->query($sql);
							  echo "<option value='0' ></option>";
							  while($loc=$db->dados())
							  {	   ?>
			                      <option value="<? echo $loc[0];?>"<? if($local_origem==$loc[0]) echo "Selected" ?>><? echo $loc[1]; ?></option>
		                      <? } ?>
			            </select>
	       </td>
					</tr>
					<tr>
					  <td class="texto_bold" colspan="2">Local de destino: 
						<select name="local_destino" class="combo_cadastro" id="local_destino" >
		                                                     <? 
							  $sql="SELECT * from local order by local";
                                

							  $db->query($sql);
							  echo "<option value='0' ></option>";
							  while($loc=$db->dados())
							  {	   ?>
			                      <option value="<? echo $loc[0];?>"<? if($local_destino==$loc[0]) echo "Selected" ?>><? echo $loc[1]; ?></option>
		                      <? } ?>
			            
					  </td>
					</tr>
					<? } ?>
					<? if ($rtipo == 'LI') { ?>
					<tr>
					  <td class="texto_bold" colspan="2">Finalidade:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input class="combo_cadastro" type="text" name="finalidade" maxlength="255" size="50" value="<? echo htmlentities($finalidade, ENT_QUOTES); ?>"></td>
					</tr>
					<? }} ?>
					<tr>
					  <td class="texto_bold" colspan="2">Tipo: <? if($rtipo=='EI' || $rtipo=='LI') { echo "<font style='color:;'>Interna</font>"; } else { echo "<font style='color:;'>Externa</font>"; } ?></td>
					</tr>
		            <tr>
		              <td align="center" colspan="2" class="texto_bold"><br><input name="submit" type="submit" class="botao" value="Gravar"> &nbsp;
				<? if ($movid <> '') { ?><input type="button" class="botao" name="laudo_vis" value="Laudo de Vistoria" onClick="window.open('imprime_laudo.php?id=<? echo $movid; ?>&pTipo=<? echo $rtipo; ?>&local=<? echo htmlentities($local_ext, ENT_QUOTES); ?>&fim=<? echo htmlentities($finalidadeENT_QUOTES); ?>','','left='+((window.screen.width/2)-370)+',top='+((window.screen.height/2)-300)+',height=560, width=740,menubar=yes,toolbar=yes,resizable=yes,scrollbars=yes');"><? } ?>

					  </td>
        		    </tr>
					<tr>
						<td colspan="2" class="texto_bold"><? 
							if ($movid == 0) {
								echo "<a href=\"movimentacao1.php?registro=$_REQUEST[registro]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>";
							} else {
								echo "<a href=\"movimentacao1.php?registro=$_REQUEST[registro]\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar'>"; }?>
						</td>
					</tr>
                  </table>
            	</div>
                <!-- ABA 2 : Obras -->
              <div id="quadro2" class="divi1" style="display: none; width:540px; overflow: auto;">
                  <table width="100%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
					<? if ($movid <> '') {
						echo "<iframe name='abas' src='obra_lista.php?movid=$movid' width='540' height='330' frameborder='0' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";
					} else { ?>
	                    <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;"><br><br><br><br><br><br><br><br>É necessário salvar a movimentação <br>para poder incluir uma obra. </td>
        	            </tr>
					<? } ?>
                </table>
  		      </div>                
			  <!-- ABA 3 : Exposições -->
			  <div id="quadro3" class="divi1" style="display: none; width:540px; overflow: auto;">
			    <table width="100%" border="0" cellpadding="6" cellspacing="3" class="texto_bold">
                              

					<? if ($movid <> '') {
						echo "<iframe name='abas' src='exposicao_movimentacao.php?movid=$movid' width='540' height='330' frameborder='0' align='center' scrolling='auto' ALLOWTRANSPARENCY='true'></iframe>";

					} else { ?>
	                    <tr>
    	                  <td align="center" class="texto_bold" style="color:#333333;"><br><br><br><br><br><br><br><br>É necessário salvar a movimentação <br>para poder incluir uma exposição. </td>
        	            </tr>
					<? } ?>
                </table>
              </div>
			</td>
          </tr>
        </table>
  </table>
</form>
</body>
