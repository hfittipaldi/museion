<? include_once("seguranca.php") ?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function seta_foco()
{
    form1.sigla.focus();
	return;}
function valida()
{
 with(document.form1){
    if(sigla.value==''){
	  alert('Preencha com a sigla do Pais');
	  sigla.focus();
	  return false;}
  if(nome.value==''){
    alert('Preencha com o nome do Pais');
	nome.focus();
   return false;  }
}}

</script>  
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
	document.getElementById("aba3").style.borderBottomColor= "#34689A";
	document.getElementById("aba4").style.borderBottomColor= "#34689A";
	document.getElementById("aba"+index).style.backgroundColor= "#FFFFFF";

	document.getElementById("quadro1").style.display= "none";
	document.getElementById("quadro2").style.display= "none";
	document.getElementById("quadro3").style.display= "none";
	document.getElementById("quadro4").style.display= "none";
	document.getElementById("quadro"+index).style.display= "";
}
</script>
<style type="text/css">
<!--
.divi {scrollbar-arrow-color:#34689A;
	scrollbar-3dlight-color:#96ADBE;
	scrollbar-track-color:#DFDFDF;
	scrollbar-darkshadow-color:#34689A;
	scrollbar-face-color:#F3F3F3;
	scrollbar-highlight-color:#FFFFFF;
	scrollbar-shadow-color:#96ADBE;
}
-->
</style>
</head>

<body onload='seta_foco()'>      
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <!--	<td width="0" style="border-bottom: 1px solid #34689A;">&nbsp;</td> -->
    <td height="20" width="120" id="aba1" valign="bottom" align="center" bgcolor="#96ADBE" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(1);"><div class="texto"><a href="javascript:;" id="link1" onClick="ajustaAbas(1);" onMouseDown="this.click();"><span>Identifica&ccedil;&atilde;o</span></a></div></td>
    <td width="108" id="aba2" valign="bottom" align="center" bgcolor="#96ADBE" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(2);"><div class="texto"><a href="javascript:;" id="link2" onClick="ajustaAbas(2);" onMouseDown="this.click();"><span>Biografia</span></a></div></td>
    <td width="108" id="aba3" valign="bottom" align="center" bgcolor="#96ADBE" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(3);"><div class="texto"><a href="javascript:;" id="link3" onClick="ajustaAbas(3);" onMouseDown="this.click();"><span>Bibliografia</span></a></div></td>
    <td width="108" id="aba4" valign="bottom" align="center" bgcolor="#96ADBE" style="border: 1px solid #34689A; cursor:hand; cursor:pointer;" onMouseDown="ajustaAbas(4);"><div class="texto"><a href="javascript:;" id="link4" onClick="ajustaAbas(4);" onMouseDown="this.click();"><span>Imagem</span></a></div></td>
    <td width="118" style="border-bottom: 1px solid #34689A;">&nbsp;</td>
  </tr>
  <tr>
    <td height="61" colspan="5" align="left" class="texto" style="border: 2px solid #34689A; border-top: none; border-left-width: 1px;"><div id="quadro1" class="divi" style="display: ; width:569px; height:351px; overflow: auto;">
        <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#CCCCFF">
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
        <br>
      </div>
        <div id="quadro2" class="divi" style="display: ; width:569px; height:250px; overflow: auto;">
          <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="#ccccff" class="texto_bold">
            <tr>
              <td width="17%" valign="top">Biografia: </td>
              <td width="83%"><textarea name="biografia" cols="67" rows="9" readonly class="combo_cadastro" style="background-color: #fdfdfd;"></textarea></td>
            </tr>
          </table>
          <br>
        </div>
        <div id="quadro3" class="divi" style="display: ; width:569px; height:250px; overflow: auto;">
          <table width="95%" border="0" cellpadding="6" cellspacing="3" bgcolor="ccccff" class="texto_bold">
            <tr>
              <td valign="top">Bibliografia: </td>
              <td><textarea name="bibliografia" cols="67" rows="9" readonly class="combo_cadastro" style="background-color: #fdfdfd;"></textarea></td>
            </tr>
          </table>
          <br>
        </div>
        <div id="quadro4" class="divi" style="display: ; width:569px; height:250px; overflow: auto;">
          <table width="95%" height="146" border="0" cellpadding="6" cellspacing="3" bgcolor="#ccccff" class="texto_bold">
            <tr>
              <td valign="top"><br>
                  <br>
              Imagem:
              <input name="file" type="file" class="combo_cadastro">
&nbsp; </td>
              <td>&nbsp;</td>
            </tr>
          </table>
      </div></td>
  </tr>
</table>
</body>
</html>
