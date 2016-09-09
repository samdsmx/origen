<?php
//Include Common Files @1-D1E4C7E1
define("RelativePath", "..");
define("PathToCurrentPage", "/install/");
define("FileName", "install.php");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordsql_environment { //sql_environment Class @2-CE2C11EE

//Variables @2-F607D3A5

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

//Class_Initialize Event @2-0FAD1383
    function clsRecordsql_environment($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record sql_environment/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "sql_environment";
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->sql_host = & new clsControl(ccsTextBox, "sql_host", $CCSLocales->GetText("sql_host"), ccsText, "", CCGetRequestParam("sql_host", $Method), $this);
            $this->sql_host->Required = true;
            $this->sql_db_name = & new clsControl(ccsTextBox, "sql_db_name", $CCSLocales->GetText("sql_database_name"), ccsText, "", CCGetRequestParam("sql_db_name", $Method), $this);
            $this->sql_db_name->Required = true;
            $this->CreateDB = & new clsControl(ccsCheckBox, "CreateDB", "CreateDB", ccsInteger, "", CCGetRequestParam("CreateDB", $Method), $this);
            $this->CreateDB->CheckedValue = $this->CreateDB->GetParsedValue(1);
            $this->CreateDB->UncheckedValue = $this->CreateDB->GetParsedValue(0);
            $this->sql_username = & new clsControl(ccsTextBox, "sql_username", $CCSLocales->GetText("sql_username"), ccsText, "", CCGetRequestParam("sql_username", $Method), $this);
            $this->sql_username->Required = true;
            $this->sql_password = & new clsControl(ccsTextBox, "sql_password", $CCSLocales->GetText("sql_password"), ccsText, "", CCGetRequestParam("sql_password", $Method), $this);
            $this->root_username = & new clsControl(ccsTextBox, "root_username", $CCSLocales->GetText("db_admin_name"), ccsText, "", CCGetRequestParam("root_username", $Method), $this);
            $this->root_password = & new clsControl(ccsTextBox, "root_password", $CCSLocales->GetText("db_admin_password"), ccsText, "", CCGetRequestParam("root_password", $Method), $this);
            $this->user_login = & new clsControl(ccsTextBox, "user_login", $CCSLocales->GetText("CCS_Login"), ccsText, "", CCGetRequestParam("user_login", $Method), $this);
            $this->user_login->Required = true;
            $this->user_password = & new clsControl(ccsTextBox, "user_password", $CCSLocales->GetText("CCS_Password"), ccsText, "", CCGetRequestParam("user_password", $Method), $this);
            $this->user_password->Required = true;
            $this->user_password_rep = & new clsControl(ccsTextBox, "user_password_rep", $CCSLocales->GetText("user_confirm_password"), ccsText, "", CCGetRequestParam("user_password_rep", $Method), $this);
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @2-4D7C6DB2
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->sql_host->Validate() && $Validation);
        $Validation = ($this->sql_db_name->Validate() && $Validation);
        $Validation = ($this->CreateDB->Validate() && $Validation);
        $Validation = ($this->sql_username->Validate() && $Validation);
        $Validation = ($this->sql_password->Validate() && $Validation);
        $Validation = ($this->root_username->Validate() && $Validation);
        $Validation = ($this->root_password->Validate() && $Validation);
        $Validation = ($this->user_login->Validate() && $Validation);
        $Validation = ($this->user_password->Validate() && $Validation);
        $Validation = ($this->user_password_rep->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->sql_host->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sql_db_name->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CreateDB->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sql_username->Errors->Count() == 0);
        $Validation =  $Validation && ($this->sql_password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->root_username->Errors->Count() == 0);
        $Validation =  $Validation && ($this->root_password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_login->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_password->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_password_rep->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @2-03178DB3
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->sql_host->Errors->Count());
        $errors = ($errors || $this->sql_db_name->Errors->Count());
        $errors = ($errors || $this->CreateDB->Errors->Count());
        $errors = ($errors || $this->sql_username->Errors->Count());
        $errors = ($errors || $this->sql_password->Errors->Count());
        $errors = ($errors || $this->root_username->Errors->Count());
        $errors = ($errors || $this->root_password->Errors->Count());
        $errors = ($errors || $this->user_login->Errors->Count());
        $errors = ($errors || $this->user_password->Errors->Count());
        $errors = ($errors || $this->user_password_rep->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @2-7E5EE990
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
            $this->PressedButton = "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            }
        }
        $Redirect = "install.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @2-F7885A20
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->sql_host->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sql_db_name->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CreateDB->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sql_username->Errors->ToString());
            $Error = ComposeStrings($Error, $this->sql_password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->root_username->Errors->ToString());
            $Error = ComposeStrings($Error, $this->root_password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_login->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_password->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_password_rep->Errors->ToString());
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

        $this->sql_host->Show();
        $this->sql_db_name->Show();
        $this->CreateDB->Show();
        $this->sql_username->Show();
        $this->sql_password->Show();
        $this->root_username->Show();
        $this->root_password->Show();
        $this->user_login->Show();
        $this->user_password->Show();
        $this->user_password_rep->Show();
        $this->Button_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End sql_environment Class @2-FCB6E20C

//Initialize Page @1-B47C22B6
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "install.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$PathToRoot = "../";
//End Initialize Page

//Include events file @1-8C86356C
include("./install_events.php");
//End Include events file

//Initialize Objects @1-6C662863

// Controls
$Panel1 = & new clsPanel("Panel1", $MainPage);
$MySQLCheck = & new clsControl(ccsLabel, "MySQLCheck", "MySQLCheck", ccsText, "", CCGetRequestParam("MySQLCheck", ccsGet), $MainPage);
$MySQLCheck->HTML = true;
$WriteCheck = & new clsControl(ccsLabel, "WriteCheck", "WriteCheck", ccsText, "", CCGetRequestParam("WriteCheck", ccsGet), $MainPage);
$WriteCheck->HTML = true;
$InstallLink = & new clsControl(ccsLink, "InstallLink", "InstallLink", ccsText, "", CCGetRequestParam("InstallLink", ccsGet), $MainPage);
$InstallLink->Page = "install.php";
$Panel2 = & new clsPanel("Panel2", $MainPage);
$sql_environment = & new clsRecordsql_environment("", $MainPage);
$Panel3 = & new clsPanel("Panel3", $MainPage);
$Link2 = & new clsControl(ccsLink, "Link2", "Link2", ccsText, "", CCGetRequestParam("Link2", ccsGet), $MainPage);
$Link2->Page = "../index.php";
$MainPage->Panel1 = & $Panel1;
$MainPage->MySQLCheck = & $MySQLCheck;
$MainPage->WriteCheck = & $WriteCheck;
$MainPage->InstallLink = & $InstallLink;
$MainPage->Panel2 = & $Panel2;
$MainPage->sql_environment = & $sql_environment;
$MainPage->Panel3 = & $Panel3;
$MainPage->Link2 = & $Link2;
$Panel1->AddComponent("MySQLCheck", $MySQLCheck);
$Panel1->AddComponent("WriteCheck", $WriteCheck);
$Panel1->AddComponent("InstallLink", $InstallLink);
$Panel2->AddComponent("sql_environment", $sql_environment);
$Panel3->AddComponent("Link2", $Link2);

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

$Charset = $Charset ? $Charset : "utf-8";
if ($Charset)
    header("Content-Type: text/html; charset=" . $Charset);
//End Initialize Objects

//Initialize HTML Template @1-885748E0
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "UTF-8", "replace");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
//End Initialize HTML Template

//Execute Components @1-F8DC281A
$sql_environment->Operation();
//End Execute Components

//Go to destination page @1-21CEAA46
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    unset($sql_environment);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-E7F94600
$Panel1->Show();
$Panel2->Show();
$Panel3->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
$main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E22495EE
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
unset($sql_environment);
unset($Tpl);
//End Unload Page


?>
