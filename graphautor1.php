<?php
include ("graficos/jpgraph.php");
include ("graficos/jpgraph_pie.php");
include ("graficos/jpgraph_pie3d.php");

$graph = new PieGraph(700,380,"auto");
$graph->SetShadow();
$data=array($_REQUEST[p1]-$_REQUEST[p2],$_REQUEST[p2]); 
$nome=array('Outros Autores',$_REQUEST[p3]);
$graph->title->Set("Gráfico das obras por autor");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot3D($data);
$p1->ExplodeSlice(1);
$p1->SetCenter(0.35,0.5); 
$p1->SetLegends($nome);
$p1->SetTheme("water");

//$p1->SetTheme("earth");
//$p1->SetTheme("sand"); 
//$p1->SetTheme("pastel");

$graph->Add($p1);
$graph->Stroke();

?>