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
$obra=$_GET[obra];
$parte=substr($_GET[parte],2,99999);
$sql="select obra from obra where num_registro='$obra'";
$db->query($sql);
$row=$db->dados();
$obra=$row[0];
$sql="SELECT num_registro FROM moldura
    WHERE parte='$parte' and obra='$obra'";
$db->query($sql);
$row=$db->dados();
echo "<script>document.getElementById(\"txtMoldura\").value='".$row[0]."'</script>";
?>
