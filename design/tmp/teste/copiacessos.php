<?
include("classe_padrao.php");
$db=new conexao();
$db->conecta();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="copia11.php">
   <p><span class="style1">Copiar acessos:</span><br>
  </p>
   <table width="443" border="0" class="style1">
     <tr>
       <td width="162">De:         
	   <?php
$sql="SELECT a.nome,a.usuario from usuario as a ";
$db->query($sql);
$combo='';
$i = $db->contalinhas();
  if ($i > 0)
   {
     while ($linha = $db-> dados())
      {
                $x= $linha["nome"];
                $y= $linha["usuario"];
       $combo = $combo . "<option value='$y'>$x</option>";
       // $combo = $combo . "<option value='$y'>$y</option>";
      }
echo "<select size=\"1\" name=\"campo1\"> $combo </select>";
      }
?>&nbsp;</td>
       <td width="271">Para:
	   <?php
$sql="SELECT a.nome,a.usuario from usuario as a ";
$db->query($sql);
$combo='';
$i = $db->contalinhas();
  if ($i > 0)
   {
     while ($linha = $db-> dados())
      {
                $x= $linha["nome"];
                $y= $linha["usuario"];
       $combo = $combo . "<option value='$y'>$x</option>";
       // $combo = $combo . "<option value='$y'>$y</option>";
      }
echo "<select size=\"1\" name=\"campo2\"> $combo </select>";
      }
?>
	  </td>
     </tr>
   </table>
   <table width="300" border="0" class="style1">
     <tr>
       <td width="139">&nbsp;</td>
       <td width="151">&nbsp;</td>
     </tr>
   </table>
   <table width="300" border="0">
     <tr>
       <td><input type="submit" name="Submit" value="Copiar!"></td>
       <td>&nbsp;</td>
     </tr>
   </table>
   <p><br>
   </p>
</form>
</body>
</html>
