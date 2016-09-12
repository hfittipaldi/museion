<?php
include ("graficos/jpgraph.php");
include ("graficos/jpgraph_pie.php");
include ("graficos/jpgraph_pie3d.php");
 $nome = $_REQUEST[p3];

 if (strlen($nome)>24) {
	$nome = substr($nome,0,22)."...";
 }

$graph = new PieGraph(700,380,"auto");
$graph->SetShadow();
$data=array(($_REQUEST[p1]-$_REQUEST[p2]),$_REQUEST[p2]); 
$nome=array('Demais Doadores',$nome);
$graph->title->Set("Gráfico das obras por Doador");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data);
$p1->ExplodeSlice(1);
$p1->SetCenter(0.35,0.5); 
$p1->SetLegends($nome);
$p1->SetTheme("sand"); 
$graph->Add($p1);
$graph->Stroke();

?>