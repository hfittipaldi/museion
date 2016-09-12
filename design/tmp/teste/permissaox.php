<?
require("classe_padrao.php");
$db=new conexao();
$db->conecta();
 $a=$_REQUEST['val'];

/* $compl_sql="";

for($i=0;$i<count($a);$i++)
{
$compl_sql.="$a[$i]";

if($i<count($a)-1)

  $compl_sql .= "," ;

}
$sql="SELECT item from usuario_menu_item where item not in ($compl_sql)";
//echo $sql;
$db->query($sql);
$li=$db->contalinhas();
if($li>0)
{
 echo "<script>alert(Erro)</script>";
} 
else
{*/
 $i=0; 
while($i<count($a))
{
////////////Caso SIM/SIM E SIM/NAO
$sql="SELECT item from usuario_menu_item where item='$a[$i]' and usuario='2'";

$db->query($sql);
$r=$db->contalinhas();
if($r==1) 
{
 $sql="UPDATE  usuario_menu_item set item='$a[$i]' where item='$a[$i]'";
  echo"$sql<br>";
  }
else
{  
  $sql="INSERT INTO usuario_menu_item(usuario,item) values('2','$a[$i]')";
   //$db->query($sql);
   echo "$sql<br>"; 
    }
$i++;

}
$compl_sql="";

for($i=0;$i<count($a);$i++)
{
$compl_sql.="$a[$i]";

if($i<count($a)-1)

  $compl_sql .= "," ;

}

$sql="DELETE FROM usuario_menu_item where item not in ($compl_sql)";
echo "$sql<br>";

?>
