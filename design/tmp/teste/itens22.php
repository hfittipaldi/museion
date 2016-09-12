
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
<div align="center">
  <table width="542" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
    <tr align="center" class="style5">
	   <td bgcolor="#DDDDDD">Excluir</td>
	   <td bgcolor="#DDDDDD">Alterar</td>
      <td bgcolor="#DDDDDD"> Item </td>
      <td bgcolor="#DDDDDD">Nome</td>
      <td bgcolor="#DDDDDD">Chamada</td>
      <td bgcolor="#DDDDDD">Ordenacao</td>
    </tr>
<?php
require("classe_padrao.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();

$sql="SELECT a.* from menu_item as a ";
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
		<td width="88" class="marrom10b"><? echo "<a href=\"menu_apagar1.php?menu_item=".($b)."\" onClick='return confirm(".'"Confirma Exclusao do Registro ?"'.")'>Excluir</a>" ?></td>
		<td width="88" class="marrom10b"><? echo "<a href=\"javascript:abre_pagina(".desformatar($x).")\">Alterar</a>" ?></td>
		<td width="88" class="marrom10b"><? echo $x ?></td>
      <td width="114" align="left" class="marrom11"><? echo $y ?></td>
      <td width="128" align="left" class="marrom11"><? echo $w ?></td>
      <td width="105" align="center" class="marrom11"><? echo $a ?>&nbsp;</td>
  </tr>
  <? } }?>
  </table>
  <form name="form1" method="post" action="itens1.php">
    <table width="700" border="0">
      <tr>
        <td width="133"><span class="style5">Item:
          <input name="item" type="text" id="item" size="5"> 
        </span></td>
        <td width="255"><span class="style5">Nome:
            <input name="nome" type="text" id="nome">
        </span></td>
        <td width="298"><span class="style5">Chamada:
          <input name="chamada" type="text" id="chamada">
        </span></td>
      </tr>
      <tr class="style5">
        <td>Ordenacao:
        <input name="ordenacao" type="text" id="ordenacao" size="5"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <table width="700" border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="submit" name="Submit" value="Enviar"></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
</body>
</html>
