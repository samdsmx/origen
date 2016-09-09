<?php
//BindEvents Method @1-096E3C73
function BindEvents()
{
    global $Login;
    $Login->Button_DoLogin->CCSEvents["OnClick"] = "Login_Button_DoLogin_OnClick";
}
//End BindEvents Method

//Login_Button_DoLogin_OnClick @6-9DE63FBA
function Login_Button_DoLogin_OnClick(& $sender)
{
    $Login_Button_DoLogin_OnClick = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $Login; //Compatibility
//End Login_Button_DoLogin_OnClick

//Custom Code @13-ADD652EE
// -------------------------
global $Login;
global $CCSLocales;

    $db = new clsDBcalendar();

  //	$SQL = "SELECT user_is_approved FROM users WHERE user_login=" . $db->ToSQL($Login->login->Value, ccsText);
	$SQL = "SELECT user_is_approved FROM users WHERE user_login=user";  	
	$db->query($SQL);
	if ($db->next_record() && !$db->f("user_is_approved")) {
        $Login->Errors->addError($CCSLocales->GetText("CCS_LoginInactive"));
        $Login->password->SetValue("");
        $Login_Button_DoLogin_OnClick = false;
		return;
    }

// -------------------------
//End Custom Code

//Login @14-AF70F5F5
    global $CCSLocales;
    global $Login;
    if(!CCLoginUser($Container->login->GetValue(), $Container->password->GetValue()))
    {
        $Container->Errors->addError($CCSLocales->GetText("CCS_LoginError"));
        $Container->password->SetValue("");
        $Login_Button_DoLogin_OnClick = false;
    }
    else
    {
        global $Redirect;
        $Redirect = CCGetParam("ret_link", $Redirect);
        $Login_Button_DoLogin_OnClick = true;
    }
//End Login

//Close Login_Button_DoLogin_OnClick @6-0EB5DCFE
    return $Login_Button_DoLogin_OnClick;
}
//End Close Login_Button_DoLogin_OnClick


?>
