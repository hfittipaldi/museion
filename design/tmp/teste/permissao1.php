<?
require("classe_padrao.php");
$db=new conexao();
$db->conecta();
$a=$_REQUEST['val'];
//////////////////////////////////////////////////////////////
/////////CASO1- Botao nao checado e presente na tabela
//$sql="SELECT t1.menu_item FROM menu_item AS t1
//INNER JOIN usuario_menu_item AS t2 WHERE (t1.menu_item = t2.item) AND t2.usuario = 2";
$sql="SELECT t1.menu_item from menu_item as t1";
$db->query($sql);

while($li=$db->dados())
{

$sql=array($li[0]);

for($i=0;$i<count($a);$i++)

   $b[]=$a[$i];
   
 $k=array_diff($sql,$b);
foreach($k as $t)
{
echo "$t<br>";
 //$res=array($t);}}
}}
////////////////////////////////////////////////////////////////////////
///CASO 2 S/S  e S/N
$sql="SELECT posicao from menu_item where posicao='$a'";
$db->query($sql);
$r=$db->contalinhas();
 if($r==1)
 {
  	for($i=0;$i<=count($a);$i++)
	{
	  $sql="UPDATE usuario_menu_item set item='$a[$i]' where item='$a[$i]'";
	  echo "$sql<br>";
	  $db->query($sql);
     }
   }
  else
  {
     $sql="INSERT INTO usuario_menu_item(usuario,item) values('2','$a[$i]')";
	  echo "$sql<br>";
	  $db->query($sql);
  }


?>

