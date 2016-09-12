<? include_once("seguranca.php");?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
<script>
function abre_grafico()
{
    document.getElementById('wait').style.display='none';
  	win=window.open('graphcolmuseu.php','PAG','left='+((window.screen.width/2)-390)+',top='+((window.screen.height/2)-300)+',scrollbars=yes, height=600,width=800,status=yes,toolbar=no,menubar=no,location=no,resizable=yes', screenX=0, screenY=0);
 if(parseInt(navigator.appVersion)>=4){
   win.window.focus();
 }
}
</script>
<script type="text/javascript">
 limite=5;
limite=limite * 10;
function temporizador(){
  setTimeout('abre_grafico()',limite);
}

</script>
</head>

<body>      
<table width="542" border="0" align="left" cellpadding="0" cellspacing="8">
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
</div></th>
  </tr>
  <tr>
    <td valign="top"><form name="form1" method="post" id="wait">
<table width="100%"  border="0" cellpadding="0" cellspacing="4" bgcolor="">
         <tr>
           <td colspan="3" class="texto_bold"></td>
          </tr>
         <tr>
           <td colspan="3" class="texto_bold">
<script>temporizador();</script></td>
          </tr>

         <tr>
           <td width="8%" rowspan="2" align="center"><img src="imgs/icons/clock.gif"></td>
           <td colspan="2" class="texto_bold"> </td>
         </tr>
         <tr>
           <td colspan="2"><span class="texto">Aguarde. Carregando o gráfico... </span></td>
         </tr>
          <tr>
            <td colspan="2" class="texto_bold">&nbsp;</td>
            <td width="12%" class="texto_bold">&nbsp;</td>
          </tr>
          <tr>
          <td colspan="3"></td>
          </tr>
      </table>
      <br>

    </form>
	</td>
  </tr>
</table>
</body>
</html>
