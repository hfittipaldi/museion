 <?
//Processando bloco insert/update
require("classe_padrao.php");
include("funcoes_inc.php");
  $item=desformatar($_REQUEST['item']);
  $posicao=corta_valor($item);
  $ordem=substr($item,-1);
function ver_item($valor)
{
global $item;
$valor=$item{0};
if($valor==0)
{ 
      echo"<script>alert('Erro.Zero nao permitido')</script>";
 	  echo"<script>window.history.go(-1)</script>";
 }
 else
 {
   return $valor;
  }
} 
function testa_sql($item)
{
//Funcao para evitar inserir registros duplicados na base
 global $posicao;
 global $ordem;

  $db=new conexao();
  $db->conecta();
  $sql="SELECT item from menu_item as a where a.item='$item'";
  $db->query($sql);
  $conta=$db->contalinhas();
  if($conta>0)
  {
   echo"<script>alert('Item:".formata($item)." ja se encontra cadastrado!Selecione outro.')</script>";
   echo"<script>window.history.go(-1)</script>";
  }
  else
  {
   return $item;  
  }
}
 if($_REQUEST['Submit']=='Enviar')
 { 
   ver_item($item);
   testa_sql($item);
   $sql="INSERT INTO menu_item values('','$item','$_REQUEST[nome]','$_REQUEST[chamada]','$posicao','$ordem')";
   //$db->query($sql);
   echo"<script>alert('Inclusao do item:".formata($item)." realizada com sucesso! ')</script>";
   echo"<script>location.href='itens2.php?op=insert'</script>";

}
elseif($_REQUEST['Submit']=='Atualizar')
{
 $sql="UPDATE menu_item set item='$item',nome='$_REQUEST[nome]',
chamada='$_REQUEST[chamada]',posicao='$posicao',ordenacao='$ordem' where item='$_REQUEST[item]'";
//$db->query($sql);
//echo $sql;

echo"<script>alert('Alteracao do item:".formata($item)." realizada com sucesso!')</script>";
echo"<script>location.href='itens2.php?item=".$_REQUEST[item]{0}."'</script>";
}
 ?>