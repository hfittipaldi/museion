<?
//Header para evitar cache
header("Content-type: text/html; charset=iso-8859-1");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

echo"<link href='css/home.css' rel='stylesheet' type='text/css'>";
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
echo "<select name=\"item\" id='item' size=5 multiple class=combo_menu onChange='direciona()'>";
$sql="SELECT controle,item from manual A,area_manual B
         where A.area=B.area AND B.area='$_GET[ID]' order by controle asc";

$db->query($sql);
while($row=$db->dados())
{
 echo "<option value=\"$row[0]\" >$row[0] - $row[1]</option>";
 $controle=$row[0];
 $item=$row[1];
}
echo "</select>";
//echo $sql;
//exit;
echo"<input name='controle' type='hidden' id='controle' value='$controle' >";
echo"<input name='item' type='hidden' id='item' value='$item' >";
?>
