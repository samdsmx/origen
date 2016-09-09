<?php
//Include Common Files @1-7CD130AF
define("RelativePath", "..");
define("PathToCurrentPage", "/admin/");
define("FileName", "config.php");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-47CFCC1A
include_once(RelativePath . "/admin/header.php");
//End Include Page implementation

class clsEditableGridconfig { //config Class @3-A1E2ACF6

//Variables @3-4ED993C8

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
//End Variables

//Class_Initialize Event @3-86C5ED83
    function clsEditableGridconfig($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "EditableGrid config/Error";
        $this->ControlsErrors = array();
        $this->ComponentName = "config";
        $this->CachedColumns["config_trans_id"][0] = "config_trans_id";
        $this->CachedColumns["config_lang_id"][0] = "config_lang_id";
        $this->CachedColumns["config_id"][0] = "config_id";
        $this->DataSource = new clsconfigDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
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

        $this->config_category = & new clsControl(ccsLabel, "config_category", "config_category", ccsText, "", "", $this);
        $this->config_desc = & new clsControl(ccsLabel, "config_desc", $CCSLocales->GetText("config_desc"), ccsText, "", "", $this);
        $this->config_desc->HTML = true;
        $this->Check_value = & new clsControl(ccsCheckBox, "Check_value", "Check_value", ccsInteger, "", "", $this);
        $this->Check_value->CheckedValue = $this->Check_value->GetParsedValue(1);
        $this->Check_value->UncheckedValue = $this->Check_value->GetParsedValue(0);
        $this->Box_value = & new clsControl(ccsTextBox, "Box_value", "Box_value", ccsText, "", "", $this);
        $this->Area_value = & new clsControl(ccsTextArea, "Area_value", $CCSLocales->GetText("config_value"), ccsMemo, "", "", $this);
        $this->ListBox_value = & new clsControl(ccsListBox, "ListBox_value", "ListBox_value", ccsText, "", "", $this);
        $this->ListBox_value->DSType = dsListOfValues;
        $this->ListBox_value->Values = array(array("0", "0"));
        $this->value_type = & new clsControl(ccsHidden, "value_type", $CCSLocales->GetText("config_type"), ccsText, "", "", $this);
        $this->ListBox_Values = & new clsControl(ccsHidden, "ListBox_Values", "ListBox_Values", ccsText, "", "", $this);
        $this->ButtonSubmit = & new clsButton("ButtonSubmit", $Method, $this);
    }
//End Class_Initialize Event

//Initialize Method @3-60E2C5BD
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);

        $this->DataSource->Parameters["seslocale"] = CCGetSession("locale");
    }
//End Initialize Method

//GetFormParameters Method @3-BCEEE6A3
    function GetFormParameters()
    {
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->FormParameters["Check_value"][$RowNumber] = CCGetFromPost("Check_value_" . $RowNumber);
            $this->FormParameters["Box_value"][$RowNumber] = CCGetFromPost("Box_value_" . $RowNumber);
            $this->FormParameters["Area_value"][$RowNumber] = CCGetFromPost("Area_value_" . $RowNumber);
            $this->FormParameters["ListBox_value"][$RowNumber] = CCGetFromPost("ListBox_value_" . $RowNumber);
            $this->FormParameters["value_type"][$RowNumber] = CCGetFromPost("value_type_" . $RowNumber);
            $this->FormParameters["ListBox_Values"][$RowNumber] = CCGetFromPost("ListBox_Values_" . $RowNumber);
        }
    }
//End GetFormParameters Method

//Validate Method @3-450CEE2A
    function Validate()
    {
        $Validation = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);

        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->DataSource->CachedColumns["config_trans_id"] = $this->CachedColumns["config_trans_id"][$RowNumber];
            $this->DataSource->CachedColumns["config_lang_id"] = $this->CachedColumns["config_lang_id"][$RowNumber];
            $this->DataSource->CachedColumns["config_id"] = $this->CachedColumns["config_id"][$RowNumber];
            $this->DataSource->CurrentRow = $RowNumber;
            $this->Check_value->SetText($this->FormParameters["Check_value"][$RowNumber], $RowNumber);
            $this->Box_value->SetText($this->FormParameters["Box_value"][$RowNumber], $RowNumber);
            $this->Area_value->SetText($this->FormParameters["Area_value"][$RowNumber], $RowNumber);
            $this->ListBox_value->SetText($this->FormParameters["ListBox_value"][$RowNumber], $RowNumber);
            $this->value_type->SetText($this->FormParameters["value_type"][$RowNumber], $RowNumber);
            $this->ListBox_Values->SetText($this->FormParameters["ListBox_Values"][$RowNumber], $RowNumber);
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

//ValidateRow Method @3-3B322AEB
    function ValidateRow($RowNumber)
    {
        global $CCSLocales;
        $this->Check_value->Validate();
        $this->Box_value->Validate();
        $this->Area_value->Validate();
        $this->ListBox_value->Validate();
        $this->value_type->Validate();
        $this->ListBox_Values->Validate();
        $this->RowErrors = new clsErrors();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidateRow", $this);
        $errors = "";
        $errors = ComposeStrings($errors, $this->Check_value->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Box_value->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Area_value->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ListBox_value->Errors->ToString());
        $errors = ComposeStrings($errors, $this->value_type->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ListBox_Values->Errors->ToString());
        $this->Check_value->Errors->Clear();
        $this->Box_value->Errors->Clear();
        $this->Area_value->Errors->Clear();
        $this->ListBox_value->Errors->Clear();
        $this->value_type->Errors->Clear();
        $this->ListBox_Values->Errors->Clear();
        $errors = ComposeStrings($errors, $this->RowErrors->ToString());
        $this->RowsErrors[$RowNumber] = $errors;
        return $errors != "" ? 0 : 1;
    }
//End ValidateRow Method

//CheckInsert Method @3-291688B7
    function CheckInsert($RowNumber)
    {
        $filed = false;
        $filed = ($filed || strlen($this->FormParameters["Check_value"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["Box_value"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["Area_value"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["ListBox_value"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["value_type"][$RowNumber]));
        $filed = ($filed || strlen($this->FormParameters["ListBox_Values"][$RowNumber]));
        return $filed;
    }
//End CheckInsert Method

//CheckErrors Method @3-F5A3B433
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @3-EB80C2A6
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
        $this->PressedButton = "ButtonSubmit";
        if($this->ButtonSubmit->Pressed) {
            $this->PressedButton = "ButtonSubmit";
        }

        $Redirect = "index.php";
        if($this->PressedButton == "ButtonSubmit") {
            if(!CCGetEvent($this->ButtonSubmit->CCSEvents, "OnClick", $this->ButtonSubmit) || !$this->UpdateGrid()) {
                $Redirect = "";
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateGrid Method @3-4168F1EA
    function UpdateGrid()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSubmit", $this);
        if(!$this->Validate()) return;
        $Validation = true;
        for($RowNumber = 1; $RowNumber <= $this->TotalRows; $RowNumber++)
        {
            $this->DataSource->CachedColumns["config_trans_id"] = $this->CachedColumns["config_trans_id"][$RowNumber];
            $this->DataSource->CachedColumns["config_lang_id"] = $this->CachedColumns["config_lang_id"][$RowNumber];
            $this->DataSource->CachedColumns["config_id"] = $this->CachedColumns["config_id"][$RowNumber];
            $this->DataSource->CurrentRow = $RowNumber;
            $this->Check_value->SetText($this->FormParameters["Check_value"][$RowNumber], $RowNumber);
            $this->Box_value->SetText($this->FormParameters["Box_value"][$RowNumber], $RowNumber);
            $this->Area_value->SetText($this->FormParameters["Area_value"][$RowNumber], $RowNumber);
            $this->ListBox_value->SetText($this->FormParameters["ListBox_value"][$RowNumber], $RowNumber);
            $this->value_type->SetText($this->FormParameters["value_type"][$RowNumber], $RowNumber);
            $this->ListBox_Values->SetText($this->FormParameters["ListBox_Values"][$RowNumber], $RowNumber);
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

//UpdateRow Method @3-B68AE326
    function UpdateRow($RowNumber)
    {
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->Area_value->SetValue($this->Area_value->GetValue());
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

//FormScript Method @3-59800DB5
    function FormScript($TotalRows)
    {
        $script = "";
        return $script;
    }
//End FormScript Method

//SetFormState Method @3-EA659810
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
            for($i = 2; $i < sizeof($pieces); $i = $i + 3)  {
                $piece = $pieces[$i + 0];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["config_trans_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 1];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["config_lang_id"][$RowNumber] = $piece;
                $piece = $pieces[$i + 2];
                $piece = str_replace("\\" . ord("\\"), "\\", $piece);
                $piece = str_replace("\\" . ord(";"), ";", $piece);
                $this->CachedColumns["config_id"][$RowNumber] = $piece;
                $RowNumber++;
            }

            if(!$RowNumber) { $RowNumber = 1; }
            for($i = 1; $i <= $this->EmptyRows; $i++) {
                $this->CachedColumns["config_trans_id"][$RowNumber] = "";
                $this->CachedColumns["config_lang_id"][$RowNumber] = "";
                $this->CachedColumns["config_id"][$RowNumber] = "";
                $RowNumber++;
            }
        }
    }
//End SetFormState Method

//GetFormState Method @3-B1612DBF
    function GetFormState($NonEmptyRows)
    {
        if(!$this->FormSubmitted) {
            $this->FormState  = $NonEmptyRows . ";";
            $this->FormState .= $this->InsertAllowed ? $this->EmptyRows : "0";
            if($NonEmptyRows) {
                for($i = 0; $i <= $NonEmptyRows; $i++) {
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["config_trans_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["config_lang_id"][$i]));
                    $this->FormState .= ";" . str_replace(";", "\\;", str_replace("\\", "\\\\", $this->CachedColumns["config_id"][$i]));
                }
            }
        }
        return $this->FormState;
    }
//End GetFormState Method

//Show Method @3-DC77CBEC
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible) { return; }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->ListBox_value->Prepare();

        $this->DataSource->open();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) { return; }

        $this->ButtonSubmit->Visible = $this->ButtonSubmit->Visible && ($this->InsertAllowed || $this->UpdateAllowed || $this->DeleteAllowed);
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
                    $this->CachedColumns["config_trans_id"][$RowNumber] = $this->DataSource->CachedColumns["config_trans_id"];
                    $this->CachedColumns["config_lang_id"][$RowNumber] = $this->DataSource->CachedColumns["config_lang_id"];
                    $this->CachedColumns["config_id"][$RowNumber] = $this->DataSource->CachedColumns["config_id"];
                    $this->Check_value->SetText("");
                    $this->Box_value->SetText("");
                    $this->ListBox_value->SetText("");
                    $this->config_category->SetValue($this->DataSource->config_category->GetValue());
                    $this->config_desc->SetValue($this->DataSource->config_desc->GetValue());
                    $this->Area_value->SetValue($this->DataSource->Area_value->GetValue());
                    $this->value_type->SetValue($this->DataSource->value_type->GetValue());
                    $this->ListBox_Values->SetValue($this->DataSource->ListBox_Values->GetValue());
                } elseif ($this->FormSubmitted && $is_next_record) {
                    $this->config_category->SetText("");
                    $this->config_desc->SetText("");
                    $this->config_category->SetValue($this->DataSource->config_category->GetValue());
                    $this->config_desc->SetValue($this->DataSource->config_desc->GetValue());
                    $this->Check_value->SetText($this->FormParameters["Check_value"][$RowNumber], $RowNumber);
                    $this->Box_value->SetText($this->FormParameters["Box_value"][$RowNumber], $RowNumber);
                    $this->Area_value->SetText($this->FormParameters["Area_value"][$RowNumber], $RowNumber);
                    $this->ListBox_value->SetText($this->FormParameters["ListBox_value"][$RowNumber], $RowNumber);
                    $this->value_type->SetText($this->FormParameters["value_type"][$RowNumber], $RowNumber);
                    $this->ListBox_Values->SetText($this->FormParameters["ListBox_Values"][$RowNumber], $RowNumber);
                } elseif (!$this->FormSubmitted) {
                    $this->CachedColumns["config_trans_id"][$RowNumber] = "";
                    $this->CachedColumns["config_lang_id"][$RowNumber] = "";
                    $this->CachedColumns["config_id"][$RowNumber] = "";
                    $this->config_category->SetText("");
                    $this->config_desc->SetText("");
                    $this->Check_value->SetText("");
                    $this->Box_value->SetText("");
                    $this->Area_value->SetText("");
                    $this->ListBox_value->SetText("");
                    $this->value_type->SetText("");
                    $this->ListBox_Values->SetText("");
                } else {
                    $this->config_category->SetText("");
                    $this->config_desc->SetText("");
                    $this->Check_value->SetText($this->FormParameters["Check_value"][$RowNumber], $RowNumber);
                    $this->Box_value->SetText($this->FormParameters["Box_value"][$RowNumber], $RowNumber);
                    $this->Area_value->SetText($this->FormParameters["Area_value"][$RowNumber], $RowNumber);
                    $this->ListBox_value->SetText($this->FormParameters["ListBox_value"][$RowNumber], $RowNumber);
                    $this->value_type->SetText($this->FormParameters["value_type"][$RowNumber], $RowNumber);
                    $this->ListBox_Values->SetText($this->FormParameters["ListBox_Values"][$RowNumber], $RowNumber);
                }
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->config_category->Show($RowNumber);
                $this->config_desc->Show($RowNumber);
                $this->Check_value->Show($RowNumber);
                $this->Box_value->Show($RowNumber);
                $this->Area_value->Show($RowNumber);
                $this->ListBox_value->Show($RowNumber);
                $this->value_type->Show($RowNumber);
                $this->ListBox_Values->Show($RowNumber);
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
                        if (($this->DataSource->CachedColumns["config_trans_id"] == $this->CachedColumns["config_trans_id"][$RowNumber]) && ($this->DataSource->CachedColumns["config_lang_id"] == $this->CachedColumns["config_lang_id"][$RowNumber]) && ($this->DataSource->CachedColumns["config_id"] == $this->CachedColumns["config_id"][$RowNumber])) {
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
        $this->ButtonSubmit->Show();

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

} //End config Class @3-FCB6E20C

class clsconfigDataSource extends clsDBcalendar {  //configDataSource Class @3-1253FAA8

//DataSource Variables @3-C826C2B4
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
    var $config_category;
    var $config_desc;
    var $Check_value;
    var $Box_value;
    var $Area_value;
    var $ListBox_value;
    var $value_type;
    var $ListBox_Values;
    var $CurrentRow;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-DB6D6485
    function clsconfigDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "EditableGrid config/Error";
        $this->Initialize();
        $this->config_category = new clsField("config_category", ccsText, "");
        $this->config_desc = new clsField("config_desc", ccsText, "");
        $this->Check_value = new clsField("Check_value", ccsInteger, "");
        $this->Box_value = new clsField("Box_value", ccsText, "");
        $this->Area_value = new clsField("Area_value", ccsMemo, "");
        $this->ListBox_value = new clsField("ListBox_value", ccsText, "");
        $this->value_type = new clsField("value_type", ccsText, "");
        $this->ListBox_Values = new clsField("ListBox_Values", ccsText, "");

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-6F1E21BB
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "config_category, config.config_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @3-08F88DDC
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "seslocale", ccsText, "", "", $this->Parameters["seslocale"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "config_langs.language_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-01C6BE38
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) " .
        "FROM config_langs INNER JOIN config ON " .
        "config_langs.config_id = config.config_id";
        $this->SQL = "SELECT config.config_id AS config_id, config.config_value, config_type, config_langs.config_desc AS config_langs_config_desc, config_category, " .
        "config.config_listbox AS config_config_listbox, config_langs.config_listbox AS config_langs_config_listbox  " .
        "FROM config_langs INNER JOIN config ON " .
        "config_langs.config_id = config.config_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-942B6056
    function SetValues()
    {
        $this->CachedColumns["config_trans_id"] = $this->f("config_trans_id");
        $this->CachedColumns["config_lang_id"] = $this->f("config_lang_id");
        $this->CachedColumns["config_id"] = $this->f("config_id");
        $this->config_category->SetDBValue($this->f("config_category"));
        $this->config_desc->SetDBValue($this->f("config_langs_config_desc"));
        $this->Area_value->SetDBValue($this->f("config_value"));
        $this->value_type->SetDBValue($this->f("config_type"));
        $this->ListBox_Values->SetDBValue($this->f("config_langs_config_listbox"));
    }
//End SetValues Method

//Update Method @3-77789BE5
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["config_value"] = new clsSQLParameter("ctrlArea_value", ccsMemo, "", "", $this->Area_value->GetValue(), "", false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "dsconfig_id", ccsInteger, "", "", $this->CachedColumns["config_id"], "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!strlen($this->cp["config_value"]->GetText()) and !is_bool($this->cp["config_value"]->GetValue())) 
            $this->cp["config_value"]->SetValue($this->Area_value->GetValue());
        $wp->Criterion[1] = $wp->Operation(opEqual, "config_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->SQL = "UPDATE config SET "
             . "config_value=" . $this->ToSQL($this->cp["config_value"]->GetDBValue(), $this->cp["config_value"]->DataType);
        $this->SQL = CCBuildSQL($this->SQL, $Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End configDataSource Class @3-FCB6E20C

//Initialize Page @1-C92E400C
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
$TemplateFileName = "config.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$PathToRoot = "../";
//End Initialize Page

//Authenticate User @1-5D1F805C
CCSecurityRedirect("", "../login.php");
//End Authenticate User

//Include events file @1-CA5031E2
include("./config_events.php");
//End Include events file

//Initialize Objects @1-F729CF35
$DBcalendar = new clsDBcalendar();
$MainPage->Connections["calendar"] = & $DBcalendar;

// Controls
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$config = & new clsEditableGridconfig("", $MainPage);
$MainPage->header = & $header;
$MainPage->config = & $config;
$config->Initialize();

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

//Execute Components @1-C4F348F2
$header->Operations();
$config->Operation();
//End Execute Components

//Go to destination page @1-4AE05AE2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcalendar->close();
    header("Location: " . $Redirect);
    $header->Class_Terminate();
    unset($header);
    unset($config);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-39F29D0E
$header->Show();
$config->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
$main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-651E5C5C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcalendar->close();
$header->Class_Terminate();
unset($header);
unset($config);
unset($Tpl);
//End Unload Page


?>
