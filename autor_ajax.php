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
echo "<select name='vinculo_autor' id='vinculo_autor' class='combo_cadastro short_combo'>";
$sql="SELECT autor,nomeetiqueta as nome from autor order by nome";

$db->query($sql);
while($row=$db->dados())
{
 $sel="";
 if ($row['autor'] == $_GET['ID'])
	$sel="selected";
 echo "<option value='$row[autor]' $sel>$row[nome]</option>";
}
echo "</select>";
?>