<?
require("classe_padrao.php");
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
  $sql="SELECT item from usuario_menu_item where item not in ($cp_sql)";
  echo "$sql<br><br>";
  $db->query($sql);
  $li=$db->contalinhas();
  echo "$li<br>";

if($li==true)
{
 echo "<script>alert('Erro')</script>";
 //exit();
} 
else
{
echo" pode continuar<br>";
 $j=0; 
while($j<count($a))
{
////////////Caso SIM/SIM E SIM/NAO
$sql="SELECT item from usuario_menu_item where item='$a[$j]' and usuario='2'";
echo "$sql<br><br>";

$db->query($sql);
$r=$db->contalinhas();
if($r==true) 
{
 $sql="UPDATE  usuario_menu_item set item='$a[$j]' where item='$a[$j]'";
  echo"$sql<br><br>";
  }
else
{  
  $sql="INSERT INTO usuario_menu_item(usuario,item) values('2','$a[$i]')";
   //$db->query($sql);
   echo "$sql<br>"; 
 }
$j++;
  }
 }
$compl_sql="";

for($i=0;$i<count($a);$i++)
{
$compl_sql.="$a[$i]";

if($i<count($a)-1)

  $compl_sql .= "," ;

}

$sql="DELETE FROM usuario_menu_item where item not in ($compl_sql)";
echo "$sql<br><br>";

?>

