<html>
<head>
<title>Fundo:</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function fecha_pop()
{
 setTimeout('window.close()',60000);
 return true;
}
function cancela()
{
 document.form1.cancelar.submit=window.close();
 return true;
}
function seleciona()
{
	if (document.getElementById('selfundo').value != '') {
		opener.window.document.getElementById('fundo').value= document.getElementById('selfundo').value;
	}
	window.close();
}
</script>
<style type="text/css">
<!--
body {
	background-color: #ccccff;
}
-->
</style></head>

<body onLoad="fecha_pop()">
<table width="259"  border="0" align="center" cellpadding="0" cellspacing="8" bgcolor="ccccff">
  <tr>
    <td width="243" valign="top"><form name="form1" method="post">
      <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="2" bgcolor="#CCCCFF">
        <tr class="texto">
          <td colspan="4" align="center" class="texto">
			<select size="10" name="selfundo" id="selfundo" class="combo_cadastro">
				<option value="textura aparente">textura aparente</option>
				<option value="textura não aparente">textura n&atilde;o aparente</option>
			</select>
		  </td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"></td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">&nbsp;</td>
          <td align="center" class="texto">&nbsp;</td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="4" align="center" class="texto"><br>&nbsp;</td>
        </tr>
        <tr class="texto">
          <td colspan="2" align="center" class="texto">
            <div align="center">
              <input name="cancelar" type="submit" class="botao" id="cancelar" value="Cancelar" onClick="cancela()">
            </div></td>
          <td align="center" class="texto">
              <div align="center">
                <input name="submit" type="submit" class="botao" value="Confirmar" onClick="seleciona()">
              </div></td>
          <td align="center" class="texto">&nbsp;</td>
        </tr>
        <tr class="texto">
          <td width="42%"></td>
          <td width="9%"></td>
          <td width="48%"></td>
          <td width="1%"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
        </tr>
      </table>
    </form>
    <p></p></td>
  </tr>
</table>
</body>
</html>