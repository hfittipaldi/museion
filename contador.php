 <html>
<head>
<title>Acessos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="design/home.css" rel="stylesheet" type="text/css">
<link href="design/scroll_interno.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="500" border="0" align="left" cellpadding="0" cellspacing="1" >
  <tr> 
    <td valign="bottom">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="texto">

        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>
        <tr> 
          <td height="10" colspan="3" class="texto_bold"> 
            <div align="center"><br>Acessos ao Donato <br></div></td>
        </tr>
        <tr> 
          <td height="10" colspan="3"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>
        <tr> 
          <td height="10" colspan="3"><img src="imgs/transp.gif" width="10" height="10">
	<div align="center">
	<?
	$fp = fopen("contador.dat","r");
	$numero = fgets($fp,255);
              $numero = number_format($numero,0,'.','.');
	echo"$numero acessos desde 1º de fevereiro de 2008";
	fclose($fp);
	?></div><br></td>
        </tr>
        <tr> 
          <td height="10" colspan="3" style="border-bottom:1px solid #96ADBE;"><img src="imgs/transp.gif" width="10" height="10"></td>
        </tr>

      </table></td>
  </tr>
</table>

</body>
</html>
