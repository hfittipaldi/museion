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
    {
      $cp_sql .= "," ;
    }
 }
$sql="SELECT item from usuario_menu_item where item not in($cp_sql)";
echo "$sql<br>";
$db->query($sql);
while($row=$db->dados())
		{
		 echo "$row[0]<br>";
		 
    $sql2="SELECT distinct(posicao) from menu_item where posicao='$row[0]'";
    echo "$sql2<br>";
}
    $db->query($sql2);
    $total=$db->contalinhas();
	echo $total;
    if($total<>NULL)
    {
     
	 echo"<script>location.href='permissao.php'</script>";
    }
    elseif($total==NULL)
    {
	echo "Pode continuar";
	}
	/*
     $sql="DELETE from usuario_menu_item where usuario='2'";
	echo "$sql<br><br>";
	//$db->query($sql);
	for($i=0;$i<=count($a);$i++)
	{
	  $sqlu="INSERT INTO usuario_menu_item(usuario,item) values('2','$a[$i]')";
	  echo "$sqlu<br>";
	  //$db->query($sql);
    }
	}
	*/
	
?>
