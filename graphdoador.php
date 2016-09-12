<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<title>Gr&aacute;fico das obras por cole&ccedil;&atilde;o</title>
</head>
<body style="background-color: #CCCCCC;" onLoad="document.getElementById('fecha').style.display='';">
<br>
<div align="center"><table width="50%"  border="0">
  <tr>
    <td><img src='graphdoador1.php?p1=<? echo $_REQUEST[p1] ?>&p2=<? echo $_REQUEST[p2] ?>&p3=<? echo $_REQUEST[p3] ?>'></td>
  </tr>
  <tr id="fecha" style="display:none;">
    <td align="left">&nbsp;
	<img src="imgs/icons/ic_remover.gif">&nbsp;<a href="javascript:;" class="texto_bold" onClick="window.close();">Fechar</a></td>
  </tr>
</table>
</div>
</body>
</html>
