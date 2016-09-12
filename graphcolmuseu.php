<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<title>Gr&aacute;fico Cole&ccedil;&otilde;es no Museu</title>
<script>
function abre_imagem(){
 document.getElementById('wait').style.display='none';
 document.getElementById('grafico').style.display='';
 } 
</script>
</head>
<body style="background-color:ffffff;" onLoad="abre_imagem()">
<br>
<div id='wait'>
<table width="47%"  border="0" cellpadding="0" cellspacing="4" bgcolor="">
  <tr>
    <td colspan="3" class="texto_bold"></td>
  </tr>
  <tr>
    <td colspan="3" class="texto_bold"></td>
  </tr>
  <tr>
    <td width="8%" rowspan="2" align="center"><img src="imgs/icons/clock.gif"></td>
    <td colspan="2" class="texto_bold" align="left">&nbsp;Carregando... </td>
  </tr>
  <tr>
    <td colspan="2" align="left"><span class="texto">&nbsp;Carregando o gráfico....</span></td>
  </tr>
  <tr>
    <td colspan="2" class="texto_bold"></td>
    <td width="12%" class="texto_bold"></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
</table>
</div>
<div id='grafico' style="display:none;">
 <table width="47%"  border="0"> 
    <tr>
      <td><img src="graph_colmuseu1.php"></img></td>
    </tr>
    <tr>
      <td align="left">&nbsp;
      <img src="imgs/icons/ic_remover.gif">&nbsp;<a href="javascript:;"  class="texto_bold" onClick="window.close();">Fechar</a></td>
    </tr>
  </table> 
</div>
</body>
</html>
