<?
include("classe_padrao.php");
include("funcoes_inc.php");
$db=new conexao();
$db->conecta();
/*if(strlen($_REQUEST['item'])==1)
{
  $var=$_REQUEST[item];
}
else
{ 
  $var=corta_valor($_REQUEST[item]);
}*/
$sql="SELECT count(posicao) as total from menu_item where posicao='$_REQUEST[item]'";
$db->query($sql);
$total=$db->dados();
if($total[0] > 0)
{
  echo"<script>alert('Menu hierarquico.Apague os filhos primeiramente!')</script>";
  
  echo"<script>location.href='itens2.php?item=".$_REQUEST[item]{0}."'</script>";
}
else
{ 

 $sql="DELETE from menu_item where posicao='$_REQUEST[item]'";
 //$db->query($sql);
echo"<script>alert('Exclusao $_REQUEST[item] realizada com sucesso!')</script>";
echo"<script>location.href='itens2.php?item=".$_REQUEST[item]{0}."'</script>";
}
?>