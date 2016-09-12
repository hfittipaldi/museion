<table width="542" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
    <tr align="center" class="style5">
      <td bgcolor="#DDDDDD">Menu Item </td>
      <td bgcolor="#DDDDDD">Menu_nome</td>
      <td bgcolor="#DDDDDD">Chamada</td>
      <td bgcolor="#DDDDDD">Posicao</td>
      <td bgcolor="#DDDDDD">Ordenacao</td>
    </tr>
<?php
require("classe_padrao.php");
$db=new conexao();
$db->conecta();
$sql="SELECT a.menu_item,a.menu_nome,chamada,posicao,ordenacao from menu_item as a ";
$db->query($sql);
$i=$db->contalinhas();
  if ($i > 0)
   {
     while ($linha = $db->dados())
      {
                $x=$linha['menu_item'];
                $y=$linha['menu_nome'];
				$w=$linha['chamada'];
				$z=$linha['posicao'];
				$a=$linha['ordenacao']
	

?> 
  <tr class="style5">
    <td width="88" class="marrom10b"><? echo $x ?></td>
      <td width="114" align="center" class="marrom11"><? echo $y ?></td>
      <td width="128" align="center" class="marrom11"><? echo $w ?></td>
      <td width="75" align="center" class="marrom11"><? echo $z ?>&nbsp;</td>
      <td width="105" align="center" class="marrom11"><? echo $a ?>&nbsp;</td>
  </tr>
  <? } }?>
  </table>
