<?
include("classe_padrao.php");
$db=new conexao();
$db->conecta();

$de=$_REQUEST['campo1'];
$para=$_REQUEST['campo2'];
if($de==$para)
{
  echo"Erro!Nao se pode copiar acessos identicos";
}
else
{
  $sql="DELETE from usuario_menu_item where usuario='$para'";
  echo "$sql<br>";
  $db->query($sql);
  
  $sql= "SELECT t1.item FROM usuario_menu_item AS t1 where t1.usuario = '$de'";
  echo "$sql<br>";
  $db->query($sql);
while($row=$db->dados())
{
  echo "$row<br>";
  }
 }
 /*
while($row=$db->dados())
 {

  for($i=0;$i<count($row);$i++)
  {
   $sql="INSERT INTO usuario_menu_item(usuario,item) values('$para','$row[$i]')";
   $db->query($sql);
   echo"$sql<br>";
   }
}*/

?>
