
<style type="text/css">
<!--
.abas a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
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
-->
</style>

<script language="JavaScript">
function ajustaAbas(index) {
	document.getElementById("link1").style.color= "#34689A";
	document.getElementById("link2").style.color= "#34689A";
	document.getElementById("link3").style.color= "#34689A";
	document.getElementById("link4").style.color= "#34689A";
	document.getElementById("link"+index).style.color= "blue";

	document.getElementById("aba1").style.borderBottomColor= "#34689A";
	document.getElementById("aba2").style.borderBottomColor= "#34689A";
	document.getElementById("aba3").style.borderBottomColor= "#34689A";
	document.getElementById("aba4").style.borderBottomColor= "#34689A";
	document.getElementById("aba"+index).style.borderBottomColor= "#FFFFFF";

	document.getElementById("aba1").style.verticalAlign= "bottom";
	document.getElementById("aba2").style.verticalAlign= "bottom";
	document.getElementById("aba3").style.verticalAlign= "bottom";
	document.getElementById("aba4").style.verticalAlign= "bottom";
	document.getElementById("aba"+index).style.verticalAlign= "middle";

	document.getElementById("aba1").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba2").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba3").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba4").style.backgroundColor= "#DFDFDF";
	document.getElementById("aba"+index).style.backgroundColor= "#FFFFFF";

	document.getElementById("quadro1").style.display= "none";
	document.getElementById("quadro2").style.display= "none";
	document.getElementById("quadro3").style.display= "none";
	document.getElementById("quadro4").style.display= "none";
	document.getElementById("quadro"+index).style.display= "";
}
</script>

<?php $aba=1; ?>

<body onLoad='ajustaAbas(<? echo $aba ?>);'>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="1" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
	<td height="20" width="100" id="aba1" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="abas"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Identificação</span></a></div></td>
	<td width="100" id="aba2" valign="bottom" align="center" bgcolor="#DFDFDF" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="abas"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Contexto</span></a></div></td>
	<td width="370" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left" class="texto" style="border: 2px solid #34689A; border-top: none; border-left-width: 1px;">
		<table height="365" border="0" cellpadding="0" cellspacing="0">
			<tr><td>

<!-- ABA 1 : Identificação -->
<div id="quadro1" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
  <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#cccccc">
    <tr>
      <td width="26%" class="texto_bold">Nome catalogo :</td>
      <td colspan="2"><input name="nomecatalogo" type="text" class="combo_cadastro" id="nomecatalogo" size="44" maxlength="20"></td>
    </tr>
    <tr class="texto_bold">
      <td>Nascimento:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Cidade:</div></td>
      <td width="52%"><input name="referencia" type="text" class="combo_cadastro" size="44" readonly>
      </td>
      <td width="22%">Estado:
          <select name="select" class="combo_cadastro">
        </select></td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Pa&iacute;s:</div></td>
      <td colspan="2"><input name="catalogo" type="text" class="combo_cadastro" size="44" maxlength="20"></td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Sexo:</div></td>
      <td colspan="2"><select name="select" class="combo_cadastro">
        </select>
&nbsp;&nbsp;&nbsp;&nbsp; Naturalizado? SIM
      <input name="radiobutton" type="radio" value="radiobutton">
      NAO&nbsp;
      <input name="radiobutton" type="radio" value="radiobutton">
      </td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Naturalizado em: </div></td>
      <td colspan="2"><input name="textfield" type="text" class="combo_cadastro" size="44" maxlength="20"></td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Dt. Nascimento:</div></td>
      <td colspan="2"><input name="textfield" type="text" class="combo_cadastro" size="2">
&nbsp;
      <input name="textfield" type="text" class="combo_cadastro" size="2">
&nbsp;
      <input name="textfield" type="text" class="combo_cadastro" size="4">
      -&nbsp;
      <input name="textfield" type="text" class="combo_cadastro" size="4">
&nbsp;(
      <input name="textfield" type="text" class="combo_cadastro" size="4">
      ) </td>
    </tr>
    <tr class="texto_bold">
      <td>Estados de atua&ccedil;&atilde;o:</td>
      <td colspan="2"><input name="textfield" type="text" class="combo_cadastro" size="44" maxlength="20"></td>
    </tr>
    <tr class="texto_bold">
      <td>Pa&iacute;ses de atua&ccedil;&atilde;o:</td>
      <td colspan="2"><input name="textfield" type="text" class="combo_cadastro" size="44" maxlength="20"></td>
    </tr>
    <tr class="texto_bold">
      <td>Falecimento:</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Cidade:</div></td>
      <td><input name="textfield" type="text" class="combo_cadastro" size="44" maxlength="20"></td>
      <td>Estado:
          <select name="select" class="combo_cadastro">
        </select></td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Pa&iacute;s:</div></td>
      <td colspan="2"><div align="left">
          <input name="textfield" type="text" class="combo_cadastro" size="44" maxlength="20">
      </div></td>
    </tr>
    <tr class="texto_bold">
      <td><div align="right">Dt.Falecimento:</div></td>
      <td colspan="2"><input name="textfield" type="text" class="combo_cadastro" size="2">
&nbsp;
      <input name="textfield" type="text" class="combo_cadastro" size="2">
&nbsp;
      <input name="textfield" type="text" class="combo_cadastro" size="4">
      -&nbsp;
      <input name="textfield" type="text" class="combo_cadastro" size="4">
&nbsp;(
      <input name="textfield" type="text" class="combo_cadastro" size="4">
      ) </td>
    </tr>
  </table>
</div>
<!-- ABA 2 : Contexto -->
<div id="quadro2" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
<table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#cccccc" class="texto_bold">
    <tr>
      <td width="17%" valign="top">Biografia: </td>
      <td width="83%"><textarea name="biografia" cols="67" rows="9" readonly class="combo_cadastro" style="background-color: #fdfdfd;"></textarea></td>
    </tr>
  </table>
</div>
<!-- ABA 2 : Contexto -->
<div id="quadro3" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
<table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#cccccc" class="texto_bold">
    <tr>
      <td width="17%" valign="top">Biografia: </td>
      <td width="83%"><textarea name="biografia" cols="67" rows="9" readonly class="combo_cadastro" style="background-color: #fdfdfd;"></textarea></td>
    </tr>
  </table>
</div>
<!-- ABA 2 : Contexto -->
<div id="quadro4" class="divi" style="display: none; width:569px; height:351px; overflow: auto;">
<table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#cccccc" class="texto_bold">
        <tr>
          <td valign="top">Imagem:
              <input name="file" type="file" class="combo_cadastro">
&nbsp; </td>
          <td>&nbsp;</td>
        </tr>
      </table>
</div>
</td></tr>
</table>
</td>
  </tr>
</table>
</body>