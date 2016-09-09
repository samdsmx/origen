<?
	include ("../graficos/jpgraph.php");
	include ("../graficos/jpgraph_bar.php");

	$l1datay = array();
	$l1datay = split(",",$datagx);
	$l2datay = array();
	$l2datay = split(",",$datagx2);
	$datas=array();
	$datas=split(",",$datax);

		// Create the graph. 
		$graph = new Graph(600,400,"auto");	
		$graph->SetScale("textlin");
		$graph->SetMargin(90,40,20,160);
		$graph->SetShadow();

		$graph->SetBackgroundGradient('white','white');
		$graph->xaxis->SetTickLabels($datas);
		
		if(count($l1datay)>0){
			$l1plot=new BarPlot($l1datay);
			$l1plot->SetFillColor("blue");
			$l1plot->SetWeight(1);
			}
		
		$graph->Add($l1plot);
			
		$graph->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
		$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,6);
		$graph->xaxis->SetLabelAngle(45);
		
		$graph->Stroke();
?>
