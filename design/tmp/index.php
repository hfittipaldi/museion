<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Museu Nacional de Belas Artes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

body {
margin:0;
padding:0;
background:#ffffff;
text-align:center; /* hack para o IE */	
	}

</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<link href="home.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="tudo">
 <table width="750" height="549"  border="0" cellpadding="0" cellspacing="0" background="imgs/fundo.jpg">
  <tr>
    <td align="left" valign="bottom">	  
	<div id="fazul1"><a href="#"><img src="imgs/transp.gif" width="750" height="140" border="0" onClick="MM_showHideLayers('fazul1','','show','fazul2','','show','login','','show','donato','','show')"></a></div> 
	<div id="fazul2"></div>
	  <div id="login">
	    <FORM><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="51%" scope="col"><div align="right"><span class="login">NOME DO USU&Aacute;RIO: </span></div></th>
            <th width="17%" class="login" scope="col">
                <div align="left">
                   &nbsp;
                   <input name="nome" type="text" class="combo_login" id="nome" size="15">
                </div></th>
            <th width="5%" scope="col"><span class="login">SENHA:</span></th>
            <th width="5%" scope="col"><div align="left">
              <input name="senha" type="text" class="combo_login" id="senha" size="8">
            </div></th>
            <th width="11%" scope="col"><a href="#" class="login">ENTRAR</a></th>
            <th width="11%" scope="col"><a href="#" class="visitante">VISITANTE</a></th>
          </tr>
        </table></FORM>
	  </div>
      <div id="donato"><img src="imgs/donato.gif" width="160" height="75" hspace="10" vspace="8"></div>
        <div id="sombra">Museu Nacional de Belas Artes </div>
		<div id="museu">Museu Nacional de Belas Artes </div>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="19%" scope="col"><div align="left"><a href="#"><img src="imgs/vitae_branco.gif" name="vitae" width="45" height="71" hspace="14" vspace="15" border="0" id="vitae"></a></div></th>
            <th width="58%" valign="bottom" scope="col"><div align="right"><img src="imgs/mnba.gif" name="mnba" width="129" height="20" vspace="14" id="mnba"></div></th>
            <th width="23%" valign="bottom" scope="col"><div align="right"><img src="imgs/logos_gov.gif" name="gov" width="148" height="20" hspace="14" vspace="14" id="gov"></div></th>
          </tr>
        </table>
      </td>
  </tr>
</table>
</div>
</body>
</html>
