<?
	include ("../graficos/jpgraph.php");
	include ("../graficos/jpgraph_bar.php");
	
	$data1y = array();
	$data1y = split(",",$datagx);
	$datas=array();
	$datas=split(",",$datax);

	// Create the graph. These two calls are always required
	$graph = new Graph(600,400,"auto");	
	$graph->SetScale("textlin");
	
	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);
	
	$graph->SetMargin(90,40,20,160);
	$graph->xaxis->SetTickLabels($datas);
	$graph->xaxis->SetLabelAngle(45);
	
	// Create the bar plots
	if(count($data1y)>0){
		$b1plot = new BarPlot($data1y);
		$b1plot->SetFillColor("blue");
		$graph->Add($b1plot);
		$graph->Stroke();
	}
?>
