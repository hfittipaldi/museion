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
<script>
	function abre_pagina(ident) {
		window.open('menu_alterar.php?item='+ident,'','width=500, height=400, scrollbars=yes');
	}
</script>
</head>

<body>
<?
require("classe_padrao.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();
$sql="SELECT a.* from menu_item as a where length(a.item)=1";
$db->query($sql);
while($row=$db->dados())
{
 echo " <a href=\"item_novo.php?item=$row[item]\">";
	if ($row['nome'] == isset($nome))
   echo "<span class=\"style5\"><b>$row[nome] -($row[item])</b></span></a> |";
	else
		echo "<span class=\"style5\">$row[nome]-($row[item])</span></a> |";
} 
 
?>
 <table width="542" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
    <tr align="center" class="style5">
	   <td bgcolor="#DDDDDD">Excluir</td>
	   <td bgcolor="#DDDDDD">Alterar</td>
      <td bgcolor="#DDDDDD"> Item </td>
      <td bgcolor="#DDDDDD">Nome</td>
      <td bgcolor="#DDDDDD">Chamada</td>
      <td bgcolor="#DDDDDD">Ordenacao</td>
    </tr>
<?
if(isset($item)<>'')
{
echo"<br>";
$sql="SELECT a.* from menu_item as a where item like'$item%'";
////////////
$db->query($sql);
$i=$db->contalinhas();
  if ($i > 0)
   {
     while ($linha = $db->dados())
      {
                
				$x=formata($linha['item']);
				$y=$linha['nome'];
				$w=$linha['chamada'];
				$a=$linha['ordenacao'];
	            $b=$linha['menu_item'];   
				

?> 
  <tr class="style5">
		<td width="88" class="marrom10b"><? echo "<a href=\"menu_apagar11.php?menu_item=".($b)."\" onClick='return confirm(".'"Confirma Exclusao do Registro ?"'.")'>Excluir</a>" ?></td>
		<td width="88" class="marrom10b"><? echo "<a href=\"javascript:abre_pagina(".desformatar($x).")\">Alterar</a>" ?></td>
		<td width="88" class="marrom10b"><? echo $x ?></td>
      <td width="114" align="left" class="marrom11"><? echo $y ?></td>
      <td width="128" align="left" class="marrom11"><? echo $w ?></td>
      <td width="105" align="center" class="marrom11"><? echo $a ?>&nbsp;</td>
  </tr>
  <? } }}?>
</table>

  <form name="form1" method="post" action="itens1.php">
    <table width="300" border="0">
      <tr>
        <td width="77"><span class="style5">Item:
            
        </span></td>
        <td width="413"><span class="style5">
          <input name="item" type="text" id="item" size="5" class="style5">
        </span></td>
      </tr>
    </table>
    <table width="300" border="0">
      <tr>
        <td width="59" class="style5">Nome:</td>
        <td width="231"><input name="nome" type="text" id="nome" class="style5"></td>
      </tr>
    </table>
    <table width="300" border="0">
      <tr>
        <td width="87" class="style5">Chamada:</td>
        <td width="403"><input name="chamada" type="text" class="style5" id="chamada"></td>
      </tr>
    </table>
    <table width="300" border="0">
      <tr>
        <td width="69" class="style5">Ordena&ccedil;&atilde;o:</td>
        <td width="421"><input name="ordenacao" type="text" class="style5" id="ordenacao" size="5"></td>
      </tr>
    </table>
    <table width="300" border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input name="Submit" type="submit" class="style5" value="Enviar"></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </form>
</body>
</html>
