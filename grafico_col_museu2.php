<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<title>Untitled Document</title>
<script>
function fecha_abre_div()
{
  document.getElementById('wait').style.display='none'; 
  document.getElementById('grafico').style.display='';
 }   
</script>
<script type="text/javascript">
limite=3;
limite=limite * 1000;  
function temporizador(){
    
    setTimeout('fecha_abre_div()',limite);
    }

</script>
</head>
<body onLoad="document.getElementById('grafico').style.display='none'">
<div id='wait'>
<script>temporizador();</script>
<table width="47%"  border="0" cellpadding="0" cellspacing="4" bgcolor="#CCCCFF">
  <tr>
    <td colspan="3" class="texto_bold"></td>
  </tr>
  <tr>
    <td colspan="3" class="texto_bold"></td>
  </tr>
  <tr>
    <td width="8%" rowspan="2" align="center"><img src="imgs/icons/clock.gif"></td>
    <td colspan="2" class="texto_bold">Carregando... </td>
  </tr>
  <tr>
    <td colspan="2"><span class="texto">Por favor aguarde at&eacute; que a p&aacute;gina
        seja carregada.</span></td>
  </tr>
  <tr>
    <td colspan="2" class="texto_bold"></td>
    <td width="12%" class="texto_bold"></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
</table></div>
<img id='grafico' src="graph_col_museu.php"></img>
</body>
</html>
