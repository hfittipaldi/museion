<?
require('classe_padrao.php');
$db= new conexao();
$db-> conecta();
$valor='7';
$sql="SELECT distinct(posicao) from menu_item where posicao='$valor'";
  $db->query($sql);
  $linha=$db->contalinhas($db);
  
  if($linha==1)
  {
     echo"babou<br>";
	 echo"$li[0]";
	 
  }
   else
   {
     echo"Tá ok";
	 echo"$sql";
	}
 
?>