<?
include("classe_padrao.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();

$item=desformatar($_REQUEST['item']);
$posicao=corta_valor($item);

$sql="UPDATE menu_item set item='$item',nome='$_REQUEST[nome]',
chamada='$_REQUEST[chamada]',posicao='$posicao',ordenacao='$_REQUEST[ordenacao]' where menu_item='$_REQUEST[menu_item]'";
//echo $sql;
$db->query($sql);

echo"<script>alert('Alteracao efetuada com sucesso!')</script>";
echo"<script>window.opener.location.reload()</script>";
echo"<script>window.close()</script>";

?>

