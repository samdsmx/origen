<?php
//BindEvents Method @1-7649B971
function BindEvents()
{
    global $eventGrid;
    global $active_reminders;
    global $event_reminder;
    global $CCSEvents;
    $eventGrid->edit->CCSEvents["BeforeShow"] = "eventGrid_edit_BeforeShow";
    $eventGrid->CCSEvents["BeforeShowRow"] = "eventGrid_BeforeShowRow";
    $active_reminders->CCSEvents["BeforeShow"] = "active_reminders_BeforeShow";
    $event_reminder->CCSEvents["BeforeInsert"] = "event_reminder_BeforeInsert";
    $event_reminder->CCSEvents["BeforeUpdate"] = "event_reminder_BeforeUpdate";
    $event_reminder->CCSEvents["BeforeShow"] = "event_reminder_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//eventGrid_edit_BeforeShow @42-427CC52F
function eventGrid_edit_BeforeShow(& $sender)
{
    $eventGrid_edit_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $eventGrid; //Compatibility
//End eventGrid_edit_BeforeShow

//Custom Code @43-2A29BDB7
// -------------------------
	if (!EditAllowed(CCGetFromGet("event_id","")))
		$eventGrid->edit->Visible = false;
	else
		$eventGrid->edit_event->Parameters = CCAddParam($eventGrid->edit_event->Parameters,"ret_link",FileName."?".CCGetQueryString("QueryString", array("ccsForm")));
// -------------------------
//End Custom Code

//Close eventGrid_edit_BeforeShow @42-6D314EBE
    return $eventGrid_edit_BeforeShow;
}
//End Close eventGrid_edit_BeforeShow

//eventGrid_BeforeShowRow @5-BCE2C937
function eventGrid_BeforeShowRow(& $sender)
{
    $eventGrid_BeforeShowRow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $eventGrid; //Compatibility
//End eventGrid_BeforeShowRow

//Custom Code @39-2A29BDB7
// -------------------------
	global $calendar_config;

	if (strlen($Component->event_time_end->GetText()))
		$Component->event_time_end->Visible = True;
	else
		$Component->event_time_end->Visible = False;

	if (strlen($Component->event_time->GetText()))
		$Component->event_time->Visible = True;
	else
		$Component->event_time->Visible = False;		

	if (strlen($Component->category_id->GetValue()))
		$Component->category_id->Visible = True;
	else
		$Component->category_id->Visible = False;

	processCustomFields($Component, 1);
// -------------------------
//End Custom Code

//Close eventGrid_BeforeShowRow @5-0014368C
    return $eventGrid_BeforeShowRow;
}
//End Close eventGrid_BeforeShowRow

//active_reminders_BeforeShow @147-1F9EC9C5
function active_reminders_BeforeShow(& $sender)
{
    $active_reminders_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $active_reminders; //Compatibility
//End active_reminders_BeforeShow

//Custom Code @152-2A29BDB7
// -------------------------

	if (!$Container->DataSource->RecordsCount)
		$Container->Visible = false;

// -------------------------
//End Custom Code

//Close active_reminders_BeforeShow @147-AA0EAD6D
    return $active_reminders_BeforeShow;
}
//End Close active_reminders_BeforeShow

//event_reminder_BeforeInsert @159-A5C72471
function event_reminder_BeforeInsert(& $sender)
{
    $event_reminder_BeforeInsert = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $event_reminder; //Compatibility
//End event_reminder_BeforeInsert

//Custom Code @168-2A29BDB7
// -------------------------

	$event_start[ccsHour] = $Container->remind_time_hrs->GetValue();
	$event_start[ccsMinute] = $Container->remind_time_mns->GetValue();
	$event_start[ccsSecond] = 0;
	$Container->remind_time->SetValue($event_start);

// -------------------------
//End Custom Code

//Close event_reminder_BeforeInsert @159-5164C03C
    return $event_reminder_BeforeInsert;
}
//End Close event_reminder_BeforeInsert

//event_reminder_BeforeUpdate @159-8795499F
function event_reminder_BeforeUpdate(& $sender)
{
    $event_reminder_BeforeUpdate = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $event_reminder; //Compatibility
//End event_reminder_BeforeUpdate

//Custom Code @169-2A29BDB7
// -------------------------

	$event_start[ccsHour] = $Container->remind_time_hrs->GetValue();
	$event_start[ccsMinute] = $Container->remind_time_mns->GetValue();
	$event_start[ccsSecond] = 0;
	$Container->remind_time->SetValue($event_start);

// -------------------------
//End Custom Code

//Close event_reminder_BeforeUpdate @159-9E4D01B3
    return $event_reminder_BeforeUpdate;
}
//End Close event_reminder_BeforeUpdate

//event_reminder_BeforeShow @159-8C330287
function event_reminder_BeforeShow(& $sender)
{
    $event_reminder_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $event_reminder; //Compatibility
//End event_reminder_BeforeShow

//Custom Code @170-2A29BDB7
// -------------------------
	if (!$Container->FormSubmitted) {
		$reminderTime = $Container->remind_time->GetValue();
		if (!is_array($reminderTime)) {
			$reminderTime[ccsHour]   = "0";
			$reminderTime[ccsMinute] = "0";
		}
		$Container->remind_time_hrs->SetValue(substr("0".$reminderTime[ccsHour],-2));
		$Container->remind_time_mns->SetValue(substr("0".$reminderTime[ccsMinute],-2));
	}
// -------------------------
//End Custom Code

//Close event_reminder_BeforeShow @159-05D42C2C
    return $event_reminder_BeforeShow;
}
//End Close event_reminder_BeforeShow

//Page_AfterInitialize @1-ED9E1B21
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $event_view; //Compatibility
//End Page_AfterInitialize

//Custom Code @179-2A29BDB7
// -------------------------
global $hideReminders;
global $Redirect;

	if (!ReadAllowed(CCGetFromGet("event_id")))
		$Redirect = "index.php";
	else
//		if (!CCGetUserID())
			$hideReminders->Visible = false;
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

?>