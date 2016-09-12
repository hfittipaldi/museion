<?
echo"<form action='permissao1.php' method='post'>";
require("classe_padrao.php");
$db=new conexao();
$db->conecta();
$sql="SELECT t1.menu_nome,t1.menu_item FROM menu_item AS t1
INNER JOIN usuario_menu_item AS t2 WHERE (t1.menu_item = t2.item) AND t2.usuario = 2";
$db->query($sql);
/*echo "###################<br>";
echo"COM PERMISSOES!<br>";
echo "###################<br>";*/
while($linhas=$db->dados())
 {
  $val=$linhas[1];
 echo "<input type=\"checkbox\" name=\"val[]\" value=\"$val\" checked>";
 echo "<span class=preto12>$val</span><br> ";
 }
/*echo "###################<br>";
echo "SEM PERMISSOES<br>";
echo "###################<br>";*/

/*$sql="SELECT t1.menu_nome,t1.menu_item from menu_item as t1 where (
                                               not exists (
                                              select t2.item from usuario_menu_item as t2 where t1.menu_item=t2.item))";
$db->query($sql);
while($linhas=$db->dados())
{
   $val=$linhas[1];
      echo "<input type=\"checkbox\" name=\"val[]\" value=\"$val\" unchecked>";
      echo "<span class=preto12>$val</span><br>";
 }             */
echo"<br>";
echo"<input type='submit' name='submit' value='Salvar'>";
echo"</form>";
?>
