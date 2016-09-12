<?
function carrega()
{
include("classe_padrao.php");
$db= new conexao();
$db->conecta();
$sql="DELETE from menu_item WHERE menu_item='1'";
$db->query($sql);
$li=$db->affected();
if($li==1)
{
 $sql2="DELETE from menu_item where posicao='1'";
 $db->query($sql2);
}
else
{
echo "babou";
}}
/*
 $sqlx="SELECT t1.* from  menu_item as t1,usuario as t2
 INNER join usuario_menu_item as t3 WHERE (t2.usuario=t3.usuario)AND (t1.menu_item=t3.item) and t2.usuario='2'
  order by t1.posicao,t1.ordenacao ";
//$sql="SELECT item,nome,chamada,posicao from menu_item ORDER BY posicao,ordenacao ASC";
$db->query($sqlx);
 
  while ($row=$db->dados()) 
  { 

    $item = "m" . $row['menu_item'];
    $pos=$row['posicao'];
	if($pos != "NULL")
	{
	  $pos = "m" . $pos;
	  echo"<script>oCMenu.makeMenu('$item','$pos','$row[menu_nome]','$row[chamada]')</script>";
    }
	else
	{
	  echo"<script>oCMenu.makeMenu('$item','','$row[menu_nome]','$row[chamada]')</script>";
	}
 
  }}}*/
  
carrega();
?>
