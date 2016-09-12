<?
require("classe_padrao.php");
set_time_limit(0);
$db=new conexao();
$db->conecta();
 $a=$_REQUEST['val'];
 
 $cp_sql="";

for($i=0;$i<count($a);$i++)
{
$cp_sql.="$a[$i]";

if($i<count($a)-1)

  $cp_sql .= "," ;

}
$sql="DELETE FROM usuario_menu_item where item not in ($cp_sql)";
echo "$sql<br><br>";
 $i=0;
 while($i<count($a))
 {
    $sql3="SELECT posicao from menu_item where posicao='$a[$i]'";
	$db->query($sql3);
	$row=$db->contalinhas();
	if($row==true)
	{
	  $sql4="UPDATE item from usuario_menu_item where item='$a[$i]' and usuario='2'";
	  echo "$sql4<br>";
	  //$db->query($sql4);
	}
	else
	{
	  $sql5="INSERT INTO from usuario_menu_item(usuario,item)values('2','$a[$i]')";
	  echo "$sql5<br>";
	  //$db->query($sql5);
	}
$i++;
}	  
?>
