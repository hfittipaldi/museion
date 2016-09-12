<?
function carrega()
{
include("classe_padrao.php");
$db= new conexao();
$db->conecta();
 $sql="SELECT t1.* from  menu_item2 as t1 order by t1.ordem ";
//$sql="SELECT item,nome,chamada,posicao from menu_item ORDER BY posicao,ordenacao ASC";
$db->query($sql);
 
  while ($row=$db->dados()) 
  { 
    $chave=$row['item'];
	// $n=$chave{0}.$chave{1}.$chave{2};
	 // $nchave=strlen($chave);
	  //$n2=substr($chave,0,-1);
	  echo "$chave<br>";
	  
	  
   }
	/*
    $item = "m" . $row['item'];
    $c=count($item);
	if($c>1)
	{
	  $item = "m" . $item;
	  echo"<script>oCMenu.makeMenu('$item','$pos','$row[menu_nome]','$row[chamada]')</script>";
    }
	else
	{
	  echo"<script>oCMenu.makeMenu('$item','','$row[menu_nome]','$row[chamada]')</script>";
	}
 
  }*/
 }
carrega();
?>