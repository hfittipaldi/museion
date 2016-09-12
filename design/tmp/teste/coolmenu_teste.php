<?
function carrega()
{
include("classe_padrao.php");
$db= new conexao();
$db->conecta();
 //$sql="SELECT t1.* from  menu_item as t1,usuario as t2
 //INNER join usuario_menu_item as t3 WHERE (t2.usuario=t3.usuario)AND (t1.menu_item=t3.item) and t2.usuario='2'
  //order by t1.posicao,t1.ordenacao ";
$sql="SELECT item,nome,chamada,posicao,ordenacao from menu_item ORDER BY posicao,ordenacao ASC";
$db->query($sql);
 
  while ($row=$db->dados()) 
  { 

    $item = "m" . $row['item'];
    $pos=$row['posicao'];
	if($pos != "NULL")
	{
	  $pos = "m" . $pos;
	  echo"<script>oCMenu.makeMenu('$item','$pos','$row[nome]','$row[chamada]')</script>";
    }
	else
	{
	  echo"<script>oCMenu.makeMenu('$item','','$row[nome]','$row[chamada]')</script>";
	}
 
  }
 }
carrega();
?>
