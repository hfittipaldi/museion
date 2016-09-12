<?
//Header para evitar cache
header("Content-type: text/html; charset=iso-8859-1");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
$db=new conexao();
$db->conecta();
$parte=substr($_GET[ID],2,999);
$sql="SELECT num_registro FROM moldura
    WHERE parte='$parte'";
$db->query($sql);
$row=$db->dados();
echo "<input type=text name='txtMolduraGhost' id='txtMolduraGhost' value='".$row[0]."'>";
?>
