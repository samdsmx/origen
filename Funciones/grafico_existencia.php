<?
include ( "../graficos/jpgraph.php");
include ("../graficos/jpgraph_pie.php");
include ("../graficos/jpgraph_pie3d.php");
$data = array();
$data = split(",",$datagx);
$Legend=array();
$Legend=split(",",$datax);

$graph = new PieGraph(500,300,"auto");
$graph->SetShadow();

$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($data);
$p1->SetSize(0.3);
$p1->SetCenter(0.4,0.5);
$p1 ->SetGuideLines ();
$p1->SetLegends($Legend);

$graph->Add($p1);
$graph->Stroke();
?>
