<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
include ("graficos/jpgraph.php");
include ("graficos/jpgraph_pie.php");
include ("graficos/jpgraph_pie3d.php");


$db=new conexao();
$db->conecta();
$sql="SELECT c.nome, count( * ) T 
FROM colecao c, obra o
WHERE c.colecao = o.colecao
GROUP BY c.colecao";
$db->query($sql);
while($row=$db->dados())
{
 $data[]=$row['T'];
 $data_nome[]=$row['nome'];
}
$graph = new PieGraph(750,1000,"auto");
$graph->SetShadow();

$graph->title->Set("Gráfico das Coleções/Classes na instituição");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data); 
$p1->SetCenter(0.35,0.5); 
$p1->SetLegends($data_nome); 
  
$p1->SetTheme("earth"); 
  
$graph->Add($p1); 
$graph->Stroke(); 

?>
