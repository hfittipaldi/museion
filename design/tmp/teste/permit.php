
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
    {
      $cp_sql .= "," ;
    }
 }
$sql="SELECT item from usuario_menu_item where item not in($cp_sql)";
$db->query($sql);
while($row=$db->dados())

    $dados=$row[0];		
    $sql2="SELECT posicao from menu_item where posicao='$dados'";
    echo "$sql2<br>";
    $db->query($sql2);
    $conta=$db->contalinhas();
    if($conta==true)
    {
     echo "Favor corrigir o menu";
    }
    else
    {
    $sql3="DELETE from usuario_menu_item where item='$dados'";
   echo "$sql3<br>";
    }
/*
 for($i=0;$i<count($a);$i++)
 {  
    $sql3="SELECT posicao from menu_item where posicao='$a[$i]'";
	$db->query($sql3);
	$row=$db->contalinhas();
	if($row==true)
	{
	  $sql4="UPDATE item from usuario_menu_item where item='$a[$i]' and usuario='2'";
	  $db->query($sql4);
	}
	else
	{
	  $sql5="INSERT INTO from usuario_menu_item(usuario,item)values('2','$a[$i]')";
	  $db->query($sql5);
	}
}	  */ 
?>

