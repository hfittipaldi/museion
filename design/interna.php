<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Museu Nacional de Belas Artes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<public:component>
<public:attach event="onpropertychange" onevent="propertyChanged()" />
<script>

var supported = /MSIE (5\.5)|[6789]/.test(navigator.userAgent) && navigator.platform == "Win32";
var realSrc;
var blankSrc = "blank.gif";

if (supported) fixImage();

function propertyChanged() {
   if (!supported) return;

   var pName = event.propertyName;
   if (pName != "src") return;
   // if not set to blank
   if ( ! new RegExp(blankSrc).test(src))
      fixImage();
};

function fixImage() {
   // get src
   var src = element.src;

   // check for real change
   if (src == realSrc) {
      element.src = blankSrc;
      return;
   }

   if ( ! new RegExp(blankSrc).test(src)) {
      // backup old src
      realSrc = src;
   }

   // test for png
   if ( /\.png$/.test( realSrc.toLowerCase() ) ) {
      // set blank image
      element.src = blankSrc;
      // set filter
      element.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" +
                                     src + "',sizingMethod='scale')";
   }
   else {
      // remove filter
      element.runtimeStyle.filter = "";
   }
}

</script>
</public:component>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<link href="museu.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="750" height="560" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td height="48" colspan="2"><div id="obra" style="position:absolute; width:164px; height:137px; z-index:1; left: 0; top: 0; visibility: visible;">
      <?php require_once('imgtopo.php'); ?>
</div>
      <?php require_once('topo.php'); ?></td>
  </tr>
  <tr>
    <td width="151" height="15" valign="top" bgcolor="#DFDFDF"><img src="imgs/transp.gif" width="10" height="10"></td>
    <td width="702" rowspan="3" valign="top"><table width="100%"  border="0" cellspacing="20" cellpadding="1">
      <tr>
        <td height="19"><table width="80%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="titulo">Consultas</td>
          </tr>
          <tr>
            <td bgcolor="#000000"><img src="imgs/transp.gif" width="1" height="2"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="0E4F8D"><table width="100%"  border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
          <tr bgcolor="#0E4F8D">
            <th width="14%" bgcolor="#0E4F8D" scope="col"><div align="left" class="texto_branco">Registro</div></th>
            <th width="68%" bgcolor="#0E4F8D" scope="col"><div align="left" class="texto_branco">Autor e Obra </div></th>
            <th width="18%" bgcolor="#0E4F8D" class="texto_branco" scope="col">Consultas</th>
          </tr>
          <tr bgcolor="#D8ECFA">
            <td bgcolor="#D8ECFA"><div align="center" class="texto_bold">60</div></td>
            <td bgcolor="#D8ECFA" class="texto">Texto</td>
            <td bgcolor="#D8ECFA"><div align="center" class="texto_bold">200</div></td>
          </tr>
          <tr>
            <td bgcolor="#CAE2F2"><div align="center"></div></td>
            <td bgcolor="#CAE2F2">&nbsp;</td>
            <td bgcolor="#CAE2F2"><div align="center"></div></td>
          </tr>
          <tr bgcolor="#D8ECFA">
            <td bgcolor="#D8ECFA"><div align="center"></div></td>
            <td bgcolor="#D8ECFA">&nbsp;</td>
            <td><div align="center"></div></td>
          </tr>
          <tr bgcolor="#CAE2F2">
            <td bgcolor="#CAE2F2"><div align="center"></div></td>
            <td bgcolor="#CAE2F2">&nbsp;</td>
            <td><div align="center"></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top" class="texto_bold"><div align="center">Total de consultas realizadas nos 10 registros desde 00/00/0000: <span class="texto_bold_azul">0000 </span></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="423" bgcolor="#34689A">&nbsp;</td>
  </tr>
  <tr>
    <td height="70" valign="top" bgcolor="#34689A"><div align="center"><img src="imgs/vitae_interno.gif" width="53" height="67" vspace="5"></div></td>
  </tr>
</table>
</body>
</html>
