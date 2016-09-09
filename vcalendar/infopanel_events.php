<?php
// //Events @1-F81417CB

//infopanel_InfoCalendar_GoWeekHeader_BeforeShow @56-AF0BB295
function infopanel_InfoCalendar_GoWeekHeader_BeforeShow(& $sender)
{
    $infopanel_InfoCalendar_GoWeekHeader_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_InfoCalendar_GoWeekHeader_BeforeShow

//Custom Code @58-2A29BDB7
// -------------------------
global $calendar_config;

	if ($calendar_config["info_week_icon"] == 1)
		$Component->Visible = True;		
	else
		$Component->Visible = False;
// -------------------------
//End Custom Code

//Close infopanel_InfoCalendar_GoWeekHeader_BeforeShow @56-0C0A02C0
    return $infopanel_InfoCalendar_GoWeekHeader_BeforeShow;
}
//End Close infopanel_InfoCalendar_GoWeekHeader_BeforeShow

//infopanel_InfoCalendar_category_image_BeforeShow @35-17DD4C3E
function infopanel_InfoCalendar_category_image_BeforeShow(& $sender)
{
    $infopanel_InfoCalendar_category_image_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_InfoCalendar_category_image_BeforeShow

//Custom Code @36-2A29BDB7
// -------------------------
	if (strlen($Component->GetValue()))
		$Component->Visible = True;
	else
		$Component->Visible = False;
// -------------------------
//End Custom Code

//Close infopanel_InfoCalendar_category_image_BeforeShow @35-F82C392C
    return $infopanel_InfoCalendar_category_image_BeforeShow;
}
//End Close infopanel_InfoCalendar_category_image_BeforeShow

//infopanel_InfoCalendar_EventTime_BeforeShow @153-51C65885
function infopanel_InfoCalendar_EventTime_BeforeShow(& $sender)
{
    $infopanel_InfoCalendar_EventTime_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_InfoCalendar_EventTime_BeforeShow

//Custom Code @25-2A29BDB7
// -------------------------
	if (strlen($Component->GetText()))
		$Component->Visible = True;
	else
		$Component->Visible = False;
// -------------------------
//End Custom Code

//Close infopanel_InfoCalendar_EventTime_BeforeShow @153-993812FC
    return $infopanel_InfoCalendar_EventTime_BeforeShow;
}
//End Close infopanel_InfoCalendar_EventTime_BeforeShow

//infopanel_InfoCalendar_GoWeek_BeforeShow @27-74F35FB9
function infopanel_InfoCalendar_GoWeek_BeforeShow(& $sender)
{
    $infopanel_InfoCalendar_GoWeek_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_InfoCalendar_GoWeek_BeforeShow

//Custom Code @57-2A29BDB7
// -------------------------
global $calendar_config;

	if ($calendar_config["info_week_icon"] == 1)
		$Component->Visible = True;		
	else
		$Component->Visible = False;
// -------------------------
//End Custom Code

//Close infopanel_InfoCalendar_GoWeek_BeforeShow @27-85BC864A
    return $infopanel_InfoCalendar_GoWeek_BeforeShow;
}
//End Close infopanel_InfoCalendar_GoWeek_BeforeShow

//infopanel_InfoCalendar_BeforeShowDay @108-BD8C482D
function infopanel_InfoCalendar_BeforeShowDay(& $sender)
{
    $infopanel_InfoCalendar_BeforeShowDay = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_InfoCalendar_BeforeShowDay

//Custom Code @114-2A29BDB7
// -------------------------
global $divID;
global $Tpl;
	
	$CurrentDay = $Container->CurrentProcessingDate;
	$CurrentDayStr = sprintf("%4d%02d%02d", $CurrentDay[ccsYear], $CurrentDay[ccsMonth], $CurrentDay[ccsDay]);

	if (IsSet($Container->Events[$CurrentDayStr])) {
		$divID++;
		$Container->div_begin->SetValue("<div style=\"position: absolute; visibility: hidden; padding: 6px; border: 1px solid black; text-align: left; background: #ffffff\" name=\"float\" id=\"div".$divID."\">");
		$Container->div_end->SetValue("</div>");
		$LinkStyle = "style=\"font-weight: bold\" onmouseover=\"javascript:show('".$divID."')\" onmouseout=\"javascript:hide('".$divID."')\"";
	} else {
		$Container->div_begin->SetValue("");
		$Container->div_end->SetValue("");
		$LinkStyle = "";
	}

	if (FileName == "day.php" || FileName == "week.php") {
		$SelectDay = CCParseDate(CCGetFromGet("day",CCFormatDate(CCGetDateArray(), array("yyyy","-","mm","-","dd"))), array("yyyy","-","mm","-","dd"));
		if (FileName == "week.php") {
			$FirstWeekDay = $Container->FirstWeekDay;
			$SelectDay = CCDateAdd($SelectDay, ((-6-CCDayOfWeek($SelectDay)+$FirstWeekDay)%7)."days");
			$LastDay = CCDateAdd($SelectDay, "6days");
		} else 
			$LastDay = $SelectDay;

		if (CCCompareValues($CurrentDay, $SelectDay, ccsDate) >= 0 && CCCompareValues($CurrentDay, $LastDay, ccsDate) <= 0) {
			$Component->CurrentStyle = "class=\"CalendarSelectedDay\"";
			if (!strlen($LinkStyle))
				$LinkStyle = "style=\"font-weight: normal\"";
		}
	}

	$Tpl->setvar("LinkStyle", $LinkStyle);
// -------------------------
//End Custom Code

//Close infopanel_InfoCalendar_BeforeShowDay @108-9C7BA354
    return $infopanel_InfoCalendar_BeforeShowDay;
}
//End Close infopanel_InfoCalendar_BeforeShowDay

//infopanel_InfoCalendar_ds_BeforeBuildSelect @108-C6F0614B
function infopanel_InfoCalendar_ds_BeforeBuildSelect(& $sender)
{
    $infopanel_InfoCalendar_ds_BeforeBuildSelect = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_InfoCalendar_ds_BeforeBuildSelect

//Custom Code @115-187067D8
// -------------------------
	$Container->ds->Where .= AddReadFilter($Container->ds->Where);
// -------------------------
//End Custom Code

//Close infopanel_InfoCalendar_ds_BeforeBuildSelect @108-F38D2D2A
    return $infopanel_InfoCalendar_ds_BeforeBuildSelect;
}
//End Close infopanel_InfoCalendar_ds_BeforeBuildSelect

//infopanel_AfterInitialize @1-27C05026
function infopanel_AfterInitialize(& $sender)
{
    $infopanel_AfterInitialize = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $infopanel; //Compatibility
//End infopanel_AfterInitialize

//Custom Code @20-187067D8
// -------------------------
global $calendar_config;

	switch ($calendar_config["info_calendar"]) {
		case "None" : $Container->InfoCalendar->Visible = False; break;
		case "Selected":
			switch (FileName) {
				case "index.php" :
					if ($calendar_config["info_in_views"] == 2) {
						if (strlen(CCGetFromGet("cal_monthDate"))) {
							$QueryString = CCGetQueryString("QueryString", "");
							if (!strlen(CCGetFromGet("InfoCalendarDate")) || strpos($QueryString, "cal_monthDate") > strpos($QueryString, "InfoCalendarDate"))
								$Container->InfoCalendar->CurrentDate = CCParseDate(CCGetFromGet("cal_monthDate"), array("yyyy","-","mm"));
						} else
							if (strlen(CCGetFromGet("cal_monthMonth")) || strlen(CCGetFromGet("cal_monthYear"))) {
								$QueryString = CCGetQueryString("QueryString", "");
								if (!strlen(CCGetFromGet("InfoCalendarDate")) || strpos($QueryString, "cal_monthYear") > strpos($QueryString, "InfoCalendarDate") || strpos($QueryString, "cal_monthMonth") > strpos($QueryString, "InfoCalendarDate")) {
									$Container->InfoCalendar->CurrentDate[ccsMonth] = CCGetFromGet("cal_monthMonth");
									$Container->InfoCalendar->CurrentDate[ccsYear] = CCGetFromGet("cal_monthYear");
								}
							}
					} else
						$Container->InfoCalendar->Visible = False;
					break;

				case "day.php" : case "week.php" :
					if (strlen(CCGetFromGet("day")) && !strlen(CCGetFromGet("InfoCalendarDate")))
							$Container->InfoCalendar->CurrentDate = CCParseDate(CCGetFromGet("day"), array("yyyy","-","mm","-","dd"));
					break;

				default : $Container->InfoCalendar->Visible = False;
			}
			if ($calendar_config["info_navigator"] != 0)
				$Container->InfoCalendar->InfoNavigator->Visible = True;
			else
				$Container->InfoCalendar->InfoNavigator->Visible = False;
			break;
		default:
			switch (FileName) {
				case "index.php" :
					if ($calendar_config["info_in_views"] != 2)
						$Container->InfoCalendar->Visible = False;
					break;

				case "day.php" : case "week.php" : break;

				default : $Container->InfoCalendar->Visible = False;
			}
			$Container->InfoCalendar->InfoNavigator->Visible = False;
	}
// -------------------------
//End Custom Code

//Close infopanel_AfterInitialize @1-5C19CAA4
    return $infopanel_AfterInitialize;
}
//End Close infopanel_AfterInitialize

?>