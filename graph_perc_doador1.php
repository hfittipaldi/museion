<? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
include ("graficos/jpgraph.php");
include ("graficos/jpgraph_pie.php");
include ("graficos/jpgraph_pie3d.php");

$db=new conexao();
$db->conecta();

$sql="SELECT count(*) as totgeral FROM obra where status='P' and doador<>''";
$db->query($sql);
$row=$db->dados();
$tot_geral=$row['totgeral'];

$total=0;

$sql="select o.doador as doador,count(o.obra) as total,f.nome as forma from obra o,forma_aquisicao f where o.status='P' and doador<>'' and o.forma_aquisicao=f.forma_aquisicao group by o.doador order by total desc limit 10";	  
$db->query($sql);
while($row=$db->dados())
{
 $data[]=$row['total'];
 $total=$total+$row['total'];
 $doador=$row['doador'];
 if (strlen($doador)<25) {
	$data_nome[]=$doador;
 } else {
	$data_nome[]=substr($doador,0,22)."...";
 }
}

$outros=$tot_geral-$total;
$data[]=$outros;
$data_nome[]="Outros";

$graph = new PieGraph(750,400,"auto");
$graph->SetShadow();

$graph->title->Set("Doadores do Acervo");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data); 
$p1->SetCenter(0.35,0.5); 
$p1->SetLegends($data_nome); 
  
$p1->SetTheme("earth"); 
  
$graph->Add($p1); 
$graph->Stroke(); 

?>
