<?php
class clsRecordvertical_menuVerticalMenu { //VerticalMenu Class @127-A8E84FAB

//Variables @127-F607D3A5

    // Public variables
    var $ComponentType = "Record";
    var $ComponentName;
    var $Parent;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormEnctype;
    var $Visible;
    var $Recordset;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode      = false;
    var $ds;
    var $DataSource;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @127-C98323F1
    function clsRecordvertical_menuVerticalMenu($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record VerticalMenu/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "VerticalMenu";
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->year = & new clsControl(ccsLink, "year", "year", ccsText, "", CCGetRequestParam("year", $Method), $this);
            $this->year->Page = $this->RelativePath . "year.php";
            $this->month = & new clsControl(ccsLink, "month", "month", ccsText, "", CCGetRequestParam("month", $Method), $this);
            $this->month->Page = $this->RelativePath . "index.php";
            $this->week = & new clsControl(ccsLink, "week", "week", ccsText, "", CCGetRequestParam("week", $Method), $this);
            $this->week->Page = $this->RelativePath . "week.php";
            $this->day = & new clsControl(ccsLink, "day", "day", ccsText, "", CCGetRequestParam("day", $Method), $this);
            $this->day->Page = $this->RelativePath . "day.php";
            $this->search = & new clsControl(ccsLink, "search", "search", ccsText, "", CCGetRequestParam("search", $Method), $this);
            $this->search->Page = $this->RelativePath . "search.php";
            $this->LoginPanel = & new clsPanel("LoginPanel", $this);
            $this->Link1 = & new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method), $this);
            $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->Link1->Page = $this->RelativePath . "registration.php";
            $this->login = & new clsControl(ccsLink, "login", "login", ccsText, "", CCGetRequestParam("login", $Method), $this);
            $this->login->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->login->Page = $this->RelativePath . "login.php";
            $this->user_logout = & new clsPanel("user_logout", $this);
            $this->add_event = & new clsControl(ccsLink, "add_event", "add_event", ccsText, "", CCGetRequestParam("add_event", $Method), $this);
            $this->add_event->Page = $this->RelativePath . "events.php";
            $this->profile = & new clsControl(ccsLink, "profile", "profile", ccsText, "", CCGetRequestParam("profile", $Method), $this);
            $this->profile->Page = $this->RelativePath . "profile.php";
            $this->administration_link = & new clsControl(ccsLink, "administration_link", "administration_link", ccsText, "", CCGetRequestParam("administration_link", $Method), $this);
            $this->administration_link->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
            $this->administration_link->Page = $this->RelativePath . "admin/index.php";
            $this->logout = & new clsControl(ccsLink, "logout", "logout", ccsText, "", CCGetRequestParam("logout", $Method), $this);
            $this->logout->Page = $this->RelativePath . "index.php";
            $this->user_login = & new clsControl(ccsLabel, "user_login", "user_login", ccsText, "", CCGetRequestParam("user_login", $Method), $this);
            $this->style = & new clsControl(ccsListBox, "style", "style", ccsText, "", CCGetRequestParam("style", $Method), $this);
            $this->style->DSType = dsListOfValues;
            $this->style->Values = array(array("Basic", "Basic"), array("Blueprint", "Blueprint"), array("CoffeeBreak", "CoffeeBreak"), array("Compact", "Compact"), array("GreenApple", "GreenApple"), array("Innovation", "Innovation"), array("Pine", "Pine"), array("SandBeach", "SandBeach"), array("School", "School"));
            $this->locale = & new clsControl(ccsListBox, "locale", "locale", ccsText, "", CCGetRequestParam("locale", $Method), $this);
            $this->locale->DSType = dsListOfValues;
            $this->locale->Values = array(array("en", $CCSLocales->GetText("cal_english")), array("ru", $CCSLocales->GetText("cal_russian")));
            $this->categories = & new clsControl(ccsListBox, "categories", "categories", ccsText, "", CCGetRequestParam("categories", $Method), $this);
            $this->categories->DSType = dsTable;
            list($this->categories->BoundColumn, $this->categories->TextColumn, $this->categories->DBFormat) = array("category_id", "category_name", "");
            $this->categories->DataSource = new clsDBcalendar();
            $this->categories->ds = & $this->categories->DataSource;
            $this->categories->DataSource->SQL = "SELECT category_name, category_id  " .
"FROM categories_langs {SQL_Where} {SQL_OrderBy}";
            $this->categories->DataSource->Order = "category_name";
            $this->categories->DataSource->Parameters["seslocale"] = CCGetSession("locale");
            $this->categories->DataSource->wp = new clsSQLParameters();
            $this->categories->DataSource->wp->AddParameter("1", "seslocale", ccsText, "", "", $this->categories->DataSource->Parameters["seslocale"], "", false);
            $this->categories->DataSource->wp->Criterion[1] = $this->categories->DataSource->wp->Operation(opEqual, "language_id", $this->categories->DataSource->wp->GetDBValue("1"), $this->categories->DataSource->ToSQL($this->categories->DataSource->wp->GetDBValue("1"), ccsText),false);
            $this->categories->DataSource->Where = 
                 $this->categories->DataSource->wp->Criterion[1];
            $this->categories->DataSource->Order = "category_name";
            $this->Button_Apply = & new clsButton("Button_Apply", $Method, $this);
            $this->LoginPanel->AddComponent("Link1", $this->Link1);
            $this->LoginPanel->AddComponent("login", $this->login);
            $this->user_logout->AddComponent("add_event", $this->add_event);
            $this->user_logout->AddComponent("profile", $this->profile);
            $this->user_logout->AddComponent("administration_link", $this->administration_link);
            $this->user_logout->AddComponent("logout", $this->logout);
            $this->user_logout->AddComponent("user_login", $this->user_login);
            if(!is_array($this->user_login->Value) && !strlen($this->user_login->Value) && $this->user_login->Value !== false)
                $this->user_login->SetText(CCGetUserLogin());
        }
    }
//End Class_Initialize Event

//Validate Method @127-DC579C28
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->style->Validate() && $Validation);
        $Validation = ($this->locale->Validate() && $Validation);
        $Validation = ($this->categories->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->style->Errors->Count() == 0);
        $Validation =  $Validation && ($this->locale->Errors->Count() == 0);
        $Validation =  $Validation && ($this->categories->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @127-FBCC7020
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->year->Errors->Count());
        $errors = ($errors || $this->month->Errors->Count());
        $errors = ($errors || $this->week->Errors->Count());
        $errors = ($errors || $this->day->Errors->Count());
        $errors = ($errors || $this->search->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->login->Errors->Count());
        $errors = ($errors || $this->add_event->Errors->Count());
        $errors = ($errors || $this->profile->Errors->Count());
        $errors = ($errors || $this->administration_link->Errors->Count());
        $errors = ($errors || $this->logout->Errors->Count());
        $errors = ($errors || $this->user_login->Errors->Count());
        $errors = ($errors || $this->style->Errors->Count());
        $errors = ($errors || $this->locale->Errors->Count());
        $errors = ($errors || $this->categories->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @127-7EEB6976
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_Apply";
            if($this->Button_Apply->Pressed) {
                $this->PressedButton = "Button_Apply";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Apply") {
                if(!CCGetEvent($this->Button_Apply->CCSEvents, "OnClick", $this->Button_Apply)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @127-889A0581
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->style->Prepare();
        $this->locale->Prepare();
        $this->categories->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }
        $this->logout->Parameters = "";
        $this->logout->Parameters = CCAddParam($this->logout->Parameters, "Logout", 1);

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->year->Errors->ToString());
            $Error = ComposeStrings($Error, $this->month->Errors->ToString());
            $Error = ComposeStrings($Error, $this->week->Errors->ToString());
            $Error = ComposeStrings($Error, $this->day->Errors->ToString());
            $Error = ComposeStrings($Error, $this->search->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->add_event->Errors->ToString());
            $Error = ComposeStrings($Error, $this->profile->Errors->ToString());
            $Error = ComposeStrings($Error, $this->administration_link->Errors->ToString());
            $Error = ComposeStrings($Error, $this->logout->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->style->Errors->ToString());
            $Error = ComposeStrings($Error, $this->locale->Errors->ToString());
            $Error = ComposeStrings($Error, $this->categories->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->year->Show();
        $this->month->Show();
        $this->week->Show();
        $this->day->Show();
        $this->search->Show();
        $this->LoginPanel->Show();
        $this->user_logout->Show();
        $this->style->Show();
        $this->locale->Show();
        $this->categories->Show();
        $this->Button_Apply->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End VerticalMenu Class @127-FCB6E20C

class clsvertical_menu { //vertical_menu class @1-446EF9B7

//Variables @1-5DD9E934
    var $ComponentType = "IncludablePage";
    var $Connections = array();
    var $FileName = "";
    var $Redirect = "";
    var $Tpl = "";
    var $TemplateFileName = "";
    var $BlockToParse = "";
    var $ComponentName = "";

    // Events;
    var $CCSEvents = "";
    var $CCSEventResult = "";
    var $RelativePath;
    var $Visible;
    var $Parent;
//End Variables

//Class_Initialize Event @1-5AF04248
    function clsvertical_menu($RelativePath, $ComponentName, & $Parent)
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = $ComponentName;
        $this->RelativePath = $RelativePath;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->FileName = "vertical_menu.php";
        $this->Redirect = "";
        $this->TemplateFileName = "vertical_menu.html";
        $this->BlockToParse = "main";
        $this->TemplateEncoding = "UTF-8";
    }
//End Class_Initialize Event

//Class_Terminate Event @1-167C54FA
    function Class_Terminate()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload", $this);
        unset($this->VerticalMenu);
    }
//End Class_Terminate Event

//BindEvents Method @1-AE167BC9
    function BindEvents()
    {
        $this->VerticalMenu->CCSEvents["BeforeShow"] = "vertical_menu_VerticalMenu_BeforeShow";
        $this->VerticalMenu->CCSEvents["OnValidate"] = "vertical_menu_VerticalMenu_OnValidate";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize", $this);
    }
//End BindEvents Method

//Operations Method @1-F5318ADB
    function Operations()
    {
        global $Redirect;
        if(!$this->Visible)
            return "";
        $this->VerticalMenu->Operation();
    }
//End Operations Method

//Initialize Method @1-999F83EB
    function Initialize()
    {
        global $FileName;
        global $CCSLocales;
        if(!$this->Visible)
            return "";
        $this->DBcalendar = new clsDBcalendar();
        $this->Connections["calendar"] = & $this->DBcalendar;

        // Create Components
        $this->VerticalMenu = & new clsRecordvertical_menuVerticalMenu($this->RelativePath, $this);
        $this->BindEvents();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
    }
//End Initialize Method

//Show Method @1-C2E09F8A
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        $block_path = $Tpl->block_path;
        $Tpl->LoadTemplate("/" . $this->TemplateFileName, $this->ComponentName, $this->TemplateEncoding, "remove");
        $Tpl->block_path = $Tpl->block_path . "/" . $this->ComponentName;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $block_path;
            $Tpl->SetVar($this->ComponentName, "");
            return "";
        }
        $this->VerticalMenu->Show();
        $Tpl->Parse();
        $Tpl->block_path = $block_path;
        $Tpl->SetVar($this->ComponentName, $Tpl->GetVar($this->ComponentName));
    }
//End Show Method

} //End vertical_menu Class @1-FCB6E20C

//Include Event File @1-51FAC64A
include(RelativePath . "/vertical_menu_events.php");
//End Include Event File


?>
