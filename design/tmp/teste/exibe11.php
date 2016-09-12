<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
.style5 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>

<body>
<br>
<form name="form1" method="post" action="file://///192.168.0.135/htdocs/donato/processa.php">
  <p><?
 $acao=$_REQUEST['op'];
if($acao=='insert')
{
}
elseif($acao='update');
{
}
elseif($acao='del');
{
}
// $tipo=$linha['item'];
  ?>&nbsp;</p>
  <table width="300" border="0">
    <tr>
      <td><table width="300" border="0">
          <tr>
            <td height="21" colspan="2" class="style5"><div align="left"><strong>Incluir /Alterar menus de exibi&ccedil;&atilde;o</strong></div></td>
          </tr>
          <tr>
            <td colspan="2" class="style5">&nbsp;</td>
          </tr>
          <tr>
            <td width="77" class="style5">Item: </td>
            <td width="413" class="style5"><input name="item" type="text" class="style5" id="item" value="<? echo $x ?>" size="5">
            </td>
          </tr>
        </table>
          <table width="300" border="0">
            <tr>
              <td width="59" class="style5">Nome:</td>
              <td width="231"><input name="nome" type="text" class="style5" id="nome" value="<? echo $y ?>"></td>
            </tr>
          </table>
          <table width="300" border="0">
            <tr>
              <td width="60" class="style5">Chamada:</td>
              <td width="230"><input name="chamada" type="text" class="style5" id="chamada" value="<? echo $w ?>"></td>
            </tr>
          </table>
          <table width="300" border="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name="Submit" type="submit" class="style5" value="OK"></td>
            </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
