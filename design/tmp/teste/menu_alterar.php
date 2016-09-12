<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alterando Itens de Menu</title>
<style type="text/css">
<!--
.style5 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<?php
require("classe_padrao.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();

$sql="SELECT a.* from menu_item as a  where a.item='$_REQUEST[item]'";
$db->query($sql);
$i=$db->contalinhas();
  if ($i > 0)
   {
     while ($linha = $db->dados())
      {
                $x=formata($linha['item']);
                $y=$linha['nome'];
				$w=$linha['chamada'];
				//$z=formata($linha['posicao']);
				$a=$linha['ordenacao']
	
?> 
<body>
<div align="center">
  <form name="form1" method="post" action="menu_alterar1.php">
    <div align="left">
      <table width="300" border="0" class="style5">
        <tr>
          <td width="71"><div align="right">Item:</div></td>
          <td width="219">          <input name="item" type="text" id="item" value="<? echo $x ?>" size="3">        </td>
        </tr>
          </table>
      <table width="350" border="0" class="style5">
        <tr>
          <td width="70"><div align="right">Nome: </div></td>
          <td width="270">          <input name="nome" type="text" id="nome" value="<? echo $y ?>" size="35">        </td>
        </tr>
          </table>
      <table width="350" border="0" class="style5">
        <tr>
          <td width="69"><div align="right">Chamada:</div></td>
          <td width="271">          <input name="chamada" type="text" id="chamada" value="<? echo $w ?>" size="35">        </td>
        </tr>
          </table>
      <table width="300" border="0">
        <tr class="style5">
          <td width="66">Ordenacao:</td>
          <td width="224"><input name="ordenacao" type="text" id="ordenacao" value="<? echo $a ?>" size="3"></td>
        </tr>
          </table>
      <table width="300" border="0">
        <tr>
          <td>&nbsp;</td>
          <td><input name="menu_item" type="hidden" id="menu_item" value="<? echo $linha[menu_item] ?>"></td>
        </tr>
        <tr>
          <td width="70">&nbsp;</td>
          <td width="220"><input type="submit" name="Submit" value="Alterar"></td>
        </tr>
          </table>
    </div>
    <p align="left">&nbsp;</p>
  </form>
  <? }}?>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</body>
</html>