<?
include("classe_padrao.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();

$item=desformatar($_REQUEST['item']);
$posicao=corta_valor($item);
$ordem=substr($item,0,-1);
$sql="INSERT INTO menu_item values('','$item','$_REQUEST[nome]',
'$_REQUEST[chamada]','$posicao','$ordem')";
echo $sql;
//$db->query($sql);
/*
echo"<script>alert('Inclusao realizada com sucesso!')</script>";
echo"<script>location.href='itens2.php'</script>";*/
?>
