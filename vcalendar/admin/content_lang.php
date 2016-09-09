<?php
//Include Common Files @1-6DCA6173
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "content_lang.php");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
//End Include Common Files

class clsEditableGridcontents_lang { //contents_lang Class @29-9AD81BE4

//Variables @29-3F76484F

    // Public variables
    var $ComponentType = "EditableGrid";
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $ErrorBlock;
    var $FormSubmitted;
    var $FormParameters;
    var $FormState;
    var $FormEnctype;
    var $CachedColumns;
    var $TotalRows;
    var $UpdatedRows;
    var $EmptyRows;
    var $Visible;
    var $EditableGridset;
    var $RowsErrors;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    var $InsertAllowed = false;
    var $UpdateAllowed = false;
    var $DeleteAllowed = false;
    var $ReadAllowed   = false;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;
    var $ControlsErrors;

    // Class variables
    var $Sorter_language_id;
//End Variables

//Class_Initialize Event @29-174AD662
    function clsEditableGridcontents_lang($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid contents_lang/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "contents_lang";
        $this->CachedColumns["content_lang_id"][0] = "content_lang_id";
        $this->DataSource = new clscontents_langDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: EditableGrid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->EmptyRows = 0;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if(!$this->Visible) return;

        $CCSForm = CCGetFromGet("ccsForm", "");
        $this->FormEnctype = "application/x-www-form-urlencoded";
        $this->FormSubmitted = ($CCSForm == $this->ComponentName);
        if($this->FormSubmitted) {
            $this->FormState = CCGetFromPost("FormState", "");
            $this->SetFormState($this->FormState);
        } else {
            $this->FormState = "";
        }
        $Method = $this->FormSubmitted ? ccsPost : ccsGet;

        $this->SorterName = CCGetParam("contents_langOrder", "");
        $this->SorterDirection = CCGetParam("contents_langDir", "");

        $this->Sorter_language_id = & new clsSorter($this->ComponentName, "Sorter_language_id", $FileName, $this);
        $this->languageLabel = & new clsControl(ccsLabel, "languageLabel", $CCSLocales->GetText("language_id"), ccsText, "", "", $this);
        $this->language_id = & new clsControl(ccsHidden, "language_id", "language_id", ccsText, "", "", $this);
        $this->content_desc = & new clsControl(ccsTextBox, "content_desc", $CCSLocales->GetText("email_template_desc"), ccsText, "", "", $this);
        $this->content_value = & new clsControl(ccsTextArea, "content_value", $CCSLocales->GetText("email_template_body"), ccsMemo, "", "", $this);
        $this->Button_Submit = & new clsButton("Button_Submit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @29-C7C73A5B
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["urlcontent_id"] = CCGetFromGet("content_id", "");
    }
//End Initialize Method

//GetFormParameters Method @29-88F68EE2
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["language_id"][$RowNumber] = CCGetFromPost("language_id_" . $RowNumber);
            $this->FormParameters["content_desc"][$RowNumber] = CCGetFromPost("content_desc_" . $RowNumber);
            $this->FormParameters["content_value"][$RowNumber] = CCGetFromPost("content_value_" . $RowNumber);
        }
    }
//End GetFormParameters Method

//Validate Method @29-E93CEA18
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->DataSource->CachedColumns["content_lang_id"] = $this->CachedColumns["content_lang_id"][$RowNumber];
            $this->DataSource->CurrentRow = $RowNumber;
            $this->language_id->SetText($this->FormParameters["language_id"][$RowNumber], $RowNumber);
            $this->content_desc->SetText($this->FormParameters["content_desc"][$RowNumber], $RowNumber);
            $this->content_value->SetText($this->FormParameters["content_value"][$RowNumber], $RowNumber);
            if ($this->UpdatedRows >= $RowNumber) {
                $Validation = ($this->ValidateRow($RowNumber) && $Validation);
            }
            else if($this->CheckInsert($RowNumber))
            {
                $Validation = ($this->ValidateRow($RowNumber) && $Validation);
            }
        }
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//ValidateRow Method @29-6328184A
    function ValidateRow($RowNumber)
    {
        global $CCSLocales;
        $this->language_id->Validate();
        $this->content_desc->Validate();
        $this->content_value->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->language_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->content_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->content_value->Errors->ToString());
        $this->language_id->Errors->Clear();
        $this->content_desc->Errors->Clear();
        $this->content_value->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @29-BB84097A
    function CheckInsert($RowNumber)
    {
        $filed = false;
        $filed = ($filed || strlen($this->FormParameters["language_id"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["content_desc"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["content_value"][$RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @29-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @29-5B665942
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted)
            return;

        $this->GetFormParameters();
        $this->PressedButton = "Button_Submit";
        if($this->Button_Submit->Pressed) {
            $this->PressedButton = "Button_Submit";
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "content_id"));
        if($this->PressedButton == "Button_Submit") {
            if(!CCGetEvent($this->Button_Submit->CCSEvents, "OnClick", $this->Button_Submit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @29-8CCF168F
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->DataSource->CachedColumns["content_lang_id"] = $this->CachedColumns["content_lang_id"][$RowNumber];
            $this->DataSource->CurrentRow = $RowNumber;
            $this->language_id->SetText($this->FormParameters["language_id"][$RowNumber], $RowNumber);
            $this->content_desc->SetText($this->FormParameters["content_desc"][$RowNumber], $RowNumber);
            $this->content_value->SetText($this->FormParameters["content_value"][$RowNumber], $RowNumber);
            if ($this->UpdatedRows >= $RowNumber) {
                if($this->UpdateAllowed) { $Validation = ($this->UpdateRow($RowNumber) && $Validation); }
            }
            else if($this->CheckInsert($RowNumber) && $this->InsertAllowed)
            {
                $Validation = ($Validation && $this->InsertRow($RowNumber));
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterSubmit", $this);
        if ($this->Errors->Count() == 0 && $Validation){
            $this->DataSource->close();
            return true;
        }
        return false;
    }
//End UpdateGrid Method

//UpdateRow Method @29-C87CFE63
    function UpdateRow($RowNumber)
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->languageLabel->SetValue($this->languageLabel->GetValue());
        $this->DataSource->language_id->SetValue($this->language_id->GetValue());
        $this->DataSource->content_desc->SetValue($this->content_desc->GetValue());
        $this->DataSource->content_value->SetValue($this->content_value->GetValue());
        $this->DataSource->Update();
        $errors = "";
        if($this->DataSource->Errors->Count() > 0) {
            $errors = $this->DataSource->Errors->ToString();
            $this->RowsErrors[$RowNumber] = $errors;
            $this->DataSource->Errors->Clear();
        }
        return (($this->Errors->Count() == 0) && !strlen($errors));
    }
//End UpdateRow Method

//FormScript Method @29-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @29-1AB509A0
    function SetFormState($FormState)
    {
        if(strlen($FormState)) {
            $FormState = str_replace("\\\\", "\\" . ord("\\"), $FormState);
            $FormState = str_replace("\\;", "\\" . ord(";"), $FormState);
            $pieces = explode(";", $FormState);
            $this->UpdatedRows = $pieces[0];
            $this->EmptyRows   = $pieces[1];
            $this->TotalRows = $this->UpdatedRows + $this->EmptyRows;
            $RowNumber = 0;
            for($i = 2; $i < sizeof($pieces); $i = $i + 1)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["content_lang_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["content_lang_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @29-4A8EA868
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["content_lang_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @29-CE4D18E0
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->open();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->Button_Submit->Visible = $this->Button_Submit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
        $ParentPath = $Tpl->block_path;
        $EditableGridPath = $ParentPath . "/EditableGrid " . $this->ComponentName;
        $EditableGridRowPath = $ParentPath . "/EditableGrid " . $this->ComponentName . "/Row";
        $Tpl->block_path = $EditableGridRowPath;
        $RowNumber = 0;
        $NonEmptyRows = 0;
        $EmptyRowsLeft = $this->EmptyRows;
        $is_next_record = ($this->ReadAllowed && $this->DataSource->next_record());
        if ($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed)) {
            do {
                $RowNumber++;
                if($is_next_record) {
                    $NonEmptyRows++;
                    $this->DataSource->SetValues();
                }
                if (!($this->FormSubmitted) && $is_next_record) {
                    $this->CachedColumns["content_lang_id"][$RowNumber] = $this->DataSource->CachedColumns["content_lang_id"];
                    $this->languageLabel->SetValue($this->DataSource->languageLabel->GetValue());
                    $this->language_id->SetValue($this->DataSource->language_id->GetValue());
                    $this->content_desc->SetValue($this->DataSource->content_desc->GetValue());
                    $this->content_value->SetValue($this->DataSource->content_value->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->languageLabel->SetText("");
                    $this->languageLabel->SetValue($this->DataSource->languageLabel->GetValue());
                    $this->language_id->SetText($this->FormParameters["language_id"][$RowNumber], $RowNumber);
                    $this->content_desc->SetText($this->FormParameters["content_desc"][$RowNumber], $RowNumber);
                    $this->content_value->SetText($this->FormParameters["content_value"][$RowNumber], $RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["content_lang_id"][$RowNumber] = "";
                    $this->languageLabel->SetText("");
                    $this->language_id->SetText("");
                    $this->content_desc->SetText("");
                    $this->content_value->SetText("");
                } else {
                    $this->languageLabel->SetText("");
                    $this->language_id->SetText($this->FormParameters["language_id"][$RowNumber], $RowNumber);
                    $this->content_desc->SetText($this->FormParameters["content_desc"][$RowNumber], $RowNumber);
                    $this->content_value->SetText($this->FormParameters["content_value"][$RowNumber], $RowNumber);
                }
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->languageLabel->Show($RowNumber);
                $this->language_id->Show($RowNumber);
                $this->content_desc->Show($RowNumber);
                $this->content_value->Show($RowNumber);
                if (isset($this->RowsErrors[$RowNumber]) && ($this->RowsErrors[$RowNumber] != "")) {
                    $Tpl->setblockvar("RowError", "");
                    $Tpl->setvar("Error", $this->RowsErrors[$RowNumber]);
                    $Tpl->parse("RowError", false);
                } else {
                    $Tpl->setblockvar("RowError", "");
                }
                $Tpl->setvar("FormScript", $this->FormScript($RowNumber));
                $Tpl->parse();
                if ($is_next_record) {
                    if ($this->FormSubmitted) {
                        $is_next_record = $RowNumber < $this->UpdatedRows;
                        if (($this->DataSource->CachedColumns["content_lang_id"] == $this->CachedColumns["content_lang_id"][$RowNumber])) {
                            if ($this->ReadAllowed) $this->DataSource->next_record();
                        }
                    }else{
                        $is_next_record = ($RowNumber < $this->PageSize) &&  $this->ReadAllowed && $this->DataSource->next_record();
                    }
                } else { 
                    $EmptyRowsLeft--;
                }
            } while($is_next_record || ($EmptyRowsLeft && $this->InsertAllowed));
        } else {
            $Tpl->block_path = $EditableGridPath;
            $Tpl->parse("NoRecords", false);
        }

        $Tpl->block_path = $EditableGridPath;
        $this->Sorter_language_id->Show();
        $this->Button_Submit->Show();

        if($this->CheckErrors()) {
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $Tpl->SetVar("HTMLFormProperties", "method=\"POST\" action=\"" . $this->HTMLFormAction . "\" name=\"" . $this->ComponentName . "\"");
        $Tpl->SetVar("FormState", CCToHTML($this->GetFormState($NonEmptyRows)));
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End contents_lang Class @29-FCB6E20C

class clscontents_langDataSource extends clsDBcalendar {  //contents_langDataSource Class @29-F01CB214

//DataSource Variables @29-A6DCEA61
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $UpdateParameters;
    var $CountSQL;
    var $wp;
    var $AllParametersSet;

    var $CachedColumns;

    // Datasource fields
    var $languageLabel;
    var $language_id;
    var $content_desc;
    var $content_value;
    var $CurrentRow;
//End DataSource Variables

//DataSourceClass_Initialize Event @29-40A368F2
    function clscontents_langDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid contents_lang/Error";
        $this->Initialize();
        $this->languageLabel = new clsField("languageLabel", ccsText, "");
        $this->language_id = new clsField("language_id", ccsText, "");
        $this->content_desc = new clsField("content_desc", ccsText, "");
        $this->content_value = new clsField("content_value", ccsMemo, "");

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @29-B38A5A97
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_language_id" => array("language_id", "")));
    }
//End SetOrder Method

//Prepare Method @29-0060948C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcontent_id", ccsInteger, "", "", $this->Parameters["urlcontent_id"], "", true);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "content_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @29-1F879E15
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) " .
        "FROM contents_langs";
        $this->SQL = "SELECT *  " .
        "FROM contents_langs {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @29-DEA9FF97
    function SetValues()
    {
        $this->CachedColumns["content_lang_id"] = $this->f("content_lang_id");
        $this->languageLabel->SetDBValue($this->f("language_id"));
        $this->language_id->SetDBValue($this->f("language_id"));
        $this->content_desc->SetDBValue($this->f("content_desc"));
        $this->content_value->SetDBValue($this->f("content_value"));
    }
//End SetValues Method

//Update Method @29-09BE1AC7
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $SelectWhere = $this->Where;
        $this->Where = "content_lang_id=" . $this->ToSQL($this->CachedColumns["content_lang_id"], ccsInteger);
        $this->SQL = "UPDATE contents_langs SET "
             . "language_id=" . $this->ToSQL($this->language_id->GetDBValue(), $this->language_id->DataType) . ", "
             . "content_desc=" . $this->ToSQL($this->content_desc->GetDBValue(), $this->content_desc->DataType) . ", "
             . "content_value=" . $this->ToSQL($this->content_value->GetDBValue(), $this->content_value->DataType);
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
        $this->Where = $SelectWhere;
    }
//End Update Method

} //End contents_langDataSource Class @29-FCB6E20C

//Initialize Page @1-478435DC
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
$TemplateFileName = "content_lang.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$PathToRoot = "../";
//End Initialize Page

//Authenticate User @1-132EF5B6
CCSecurityRedirect("100", "");
//End Authenticate User

//Include events file @1-BFF0A558
include("./content_lang_events.php");
//End Include events file

//Initialize Objects @1-C3496D79
$DBcalendar = new clsDBcalendar();
$MainPage->Connections["calendar"] = & $DBcalendar;

// Controls
$JavaScriptLabel = & new clsControl(ccsLabel, "JavaScriptLabel", "JavaScriptLabel", ccsText, "", CCGetRequestParam("JavaScriptLabel", ccsGet), $MainPage);
$JavaScriptLabel->HTML = true;
$contents_lang = & new clsEditableGridcontents_lang("", $MainPage);
$close = & new clsControl(ccsLabel, "close", "close", ccsText, "", CCGetRequestParam("close", ccsGet), $MainPage);
$close->HTML = true;
$MainPage->JavaScriptLabel = & $JavaScriptLabel;
$MainPage->contents_lang = & $contents_lang;
$MainPage->close = & $close;
$contents_lang->Initialize();

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

//Execute Components @1-3EA9A4A4
$contents_lang->Operation();
//End Execute Components

//Go to destination page @1-B201907A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcalendar->close();
    header("Location: " . $Redirect);
    unset($contents_lang);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-FD41CAA1
$contents_lang->Show();
$JavaScriptLabel->Show();
$close->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
$main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9EE2C6DC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcalendar->close();
unset($contents_lang);
unset($Tpl);
//End Unload Page


?>
