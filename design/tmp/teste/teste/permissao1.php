<?
require("classe_padrao.php");
$db=new conexao();
$db->conecta();
$a=$_REQUEST['val'];

$sql="SELECT t1.menu_item FROM menu_item AS t1
INNER JOIN usuario_menu_item AS t2 WHERE (t1.menu_item = t2.item) AND t2.usuario = 2";
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
 } }
/*
foreach($a as $valor)
{

    $sql="SELECT distinct(posicao) from menu_item where posicao='$valor'";
	$db->query($sql);
	$linhas=$db->contalinhas();
	//echo "$sql<br>";
		if($linhas==1)
	{
	 $sql="UPDATE usuario_menu_item set item='$valor' where item='$valor'";
	 $db->query($sql);
	 echo"$sql<br>";
	 }
	else
	 { 
    // $sql="DELETE from usuario_menu_item where usuario='2'";
	//$db->query($sql);
	$sql="INSERT INTO usuario_menu_item(usuario,item) values('2','$valor')";
	$db->query($sql);
    echo "$sql<br>";
	
	}
}             */
?>
