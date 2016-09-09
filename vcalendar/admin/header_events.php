<?php
// //Events @1-F81417CB

//header_HMenu_Button_Apply_OnClick @58-61545863
function header_HMenu_Button_Apply_OnClick(& $sender)
{
    $header_HMenu_Button_Apply_OnClick = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $header; //Compatibility
//End header_HMenu_Button_Apply_OnClick

//Custom Code @78-2A29BDB7
// -------------------------
	CCSetSession("locale", $Container->locale->GetValue());
	CCSetSession("style", $Container->style->GetValue());
	CCSetCookie("style", $Container->style->GetValue(), time() + 31536000);
// -------------------------
//End Custom Code

//Close header_HMenu_Button_Apply_OnClick @58-387763A4
    return $header_HMenu_Button_Apply_OnClick;
}
//End Close header_HMenu_Button_Apply_OnClick

//header_HMenu_BeforeShow @38-F8C312A9
function header_HMenu_BeforeShow(& $sender)
{
    $header_HMenu_BeforeShow = true;
    $Component = & $sender;
    $Container = CCGetParentContainer($sender);
    global $header; //Compatibility
//End header_HMenu_BeforeShow

//Custom Code @71-2A29BDB7
// -------------------------
global $CCProjectStyle;

	$Component->style->SetValue($CCProjectStyle);
	$Component->locale->SetValue(CCGetSession("locale"));
// -------------------------
//End Custom Code

//Close header_HMenu_BeforeShow @38-1930A679
    return $header_HMenu_BeforeShow;
}
//End Close header_HMenu_BeforeShow


?>
