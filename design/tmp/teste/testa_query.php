<?
include("classe_padrao.php");
$db=new conexao();
$db->conecta();
$sql="DELETE from menu_item WHERE menu_item='50'";
//$sql="INSERT INTO menu_item(menu_item,menu_nome) values('50','guigui')";
$db->query($sql);

?>
