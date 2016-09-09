<?php
//BindEvents Method @1-B4BEEEC5
function BindEvents()
{
    global $event_reminds;
    $event_reminds->CCSEvents["BeforeShow"] = "event_reminds_BeforeShow";
}
//End BindEvents Method

//event_reminds_BeforeShow @5-47CB95CF
function event_reminds_BeforeShow(& $sender)
{
    $event_reminds_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $event_reminds; //Compatibility
//End event_reminds_BeforeShow

//Custom Code @31-5D1537ED
// -------------------------
	if ($Container->ds->PageCount() < 2)
		$Container->Navigator->Visible = false;
// -------------------------
//End Custom Code

//Close event_reminds_BeforeShow @5-C633AD93
    return $event_reminds_BeforeShow;
}
//End Close event_reminds_BeforeShow
?>
