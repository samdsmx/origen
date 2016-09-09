<?php
//BindEvents Method @1-B9A72695
function BindEvents()
{
    global $users;
    $users->CCSEvents["OnValidate"] = "users_OnValidate";
    $users->CCSEvents["BeforeInsert"] = "users_BeforeInsert";
    $users->CCSEvents["AfterInsert"] = "users_AfterInsert";
}
//End BindEvents Method

//users_OnValidate @5-2CD43F71
function users_OnValidate(& $sender)
{
    $users_OnValidate = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_OnValidate

//Custom Code @20-D37AD2A6
// -------------------------
global $CCSLocales;

	if ($Component->user_password->GetValue() != $Component->ConfirmPassword->GetValue()) {
		$Component->Errors->addError($CCSLocales->GetText("cal_error_difpass"));
	}

	if ($Component->user_login->GetValue() && !preg_match("/^[a-zA-Z0-9_\-]{3,16}$/", $Component->user_login->GetValue()))
		$Component->Errors->addError($CCSLocales->GetText("cal_error_login"));
	if ($Component->user_password->GetValue() && !preg_match("/^[a-zA-Z0-9]{3,16}$/", $Component->user_password->GetValue()))
		$Component->Errors->addError($CCSLocales->GetText("cal_error_pass"));
// -------------------------
//End Custom Code

//Close users_OnValidate @5-6FF40A5B
    return $users_OnValidate;
}
//End Close users_OnValidate

//users_BeforeInsert @5-8891C1C3
function users_BeforeInsert(& $sender)
{
    $users_BeforeInsert = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_BeforeInsert

//Custom Code @21-D37AD2A6
// -------------------------
global $calendar_config;

	switch ($calendar_config["registration_type"]) {
		case 1: $Component->user_is_approved->SetValue(1);
				$Component->user_level->SetValue(10);
				break;
		case 4: srand();
				$Component->user_access_code->SetValue(rand(1111,9999) . rand(1111,9999));
		case 8: $Component->user_is_approved->SetValue(0);
				$Component->user_level->SetValue(1);
	}
// -------------------------
//End Custom Code

//Close users_BeforeInsert @5-43897968
    return $users_BeforeInsert;
}
//End Close users_BeforeInsert

//users_AfterInsert @5-CDABC8DE
function users_AfterInsert(& $sender)
{
    $users_AfterInsert = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $users; //Compatibility
//End users_AfterInsert

//Custom Code @22-D37AD2A6
// -------------------------
global $calendar_config;

	$parameters["{user_name}"] = $Component->user_first_name->GetValue();
	$parameters["{user_login}"] = $Component->user_login->GetValue();
	$parameters["{user_email}"] = $Component->user_email->GetValue();
	$parameters["{date_time}"] = CCFormatDate($Component->user_date_add->GetValue(), array("GeneralDate"));
	$parameters["{activate_url}"] = ServerURL . "confirm.php?name=" . $Component->user_login->GetValue() . "&acc=" . $Component->user_access_code->GetValue();
	$parameters["{subject}"] = "[VCalendar] Confirm your registration.";

	CCSetSession("content_param", $parameters);

	switch ($calendar_config["registration_type"]) {
		case 1: CCSetSession("content_type", "registration_message"); break;
		case 4:	CCSetSession("content_type", "registration_need_confirm");
				$sent = SendEmailMessage("confirm_registration", $Component->user_email->GetValue(), $parameters); break;
		case 8: CCSetSession("content_type", "registration_need_approve"); break;
	}
// -------------------------
//End Custom Code

//Close users_AfterInsert @5-11208659
    return $users_AfterInsert;
}
//End Close users_AfterInsert

?>
