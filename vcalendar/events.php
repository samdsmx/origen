<?php
//Include Common Files @1-BF44B150
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "events.php");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-8EACA429
include_once(RelativePath . "/header.php");
//End Include Page implementation

//Include Page implementation @4-D3FCB384
include_once(RelativePath . "/vertical_menu.php");
//End Include Page implementation

class clsRecordevents_rec { //events_rec Class @5-048CC98A

//Variables @5-F607D3A5

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

//Class_Initialize Event @5-E32486BA
    function clsRecordevents_rec($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record events_rec/Error";
        $this->DataSource = new clsevents_recDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "events_rec";
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->category_id = & new clsControl(ccsListBox, "category_id", $CCSLocales->GetText("cal_category"), ccsInteger, "", CCGetRequestParam("category_id", $Method), $this);
            $this->category_id->DSType = dsTable;
            list($this->category_id->BoundColumn, $this->category_id->TextColumn, $this->category_id->DBFormat) = array("category_id", "category_name", "");
            $this->category_id->DataSource = new clsDBcalendar();
            $this->category_id->ds = & $this->category_id->DataSource;
            $this->category_id->DataSource->SQL = "SELECT category_id, category_name  " .
"FROM categories_langs {SQL_Where} {SQL_OrderBy}";
            $this->category_id->DataSource->Parameters["seslocale"] = CCGetSession("locale");
            $this->category_id->DataSource->wp = new clsSQLParameters();
            $this->category_id->DataSource->wp->AddParameter("1", "seslocale", ccsText, "", "", $this->category_id->DataSource->Parameters["seslocale"], "", false);
            $this->category_id->DataSource->wp->Criterion[1] = $this->category_id->DataSource->wp->Operation(opEqual, "language_id", $this->category_id->DataSource->wp->GetDBValue("1"), $this->category_id->DataSource->ToSQL($this->category_id->DataSource->wp->GetDBValue("1"), ccsText),false);
            $this->category_id->DataSource->Where = 
                 $this->category_id->DataSource->wp->Criterion[1];
            $this->event_title = & new clsControl(ccsTextBox, "event_title", $CCSLocales->GetText("event_title"), ccsText, "", CCGetRequestParam("event_title", $Method), $this);
            $this->event_title->Required = true;
            $this->event_desc = & new clsControl(ccsTextArea, "event_desc", $CCSLocales->GetText("event_desc"), ccsMemo, "", CCGetRequestParam("event_desc", $Method), $this);
            $this->event_time_hrs = & new clsControl(ccsListBox, "event_time_hrs", "event_time_hrs", ccsText, "", CCGetRequestParam("event_time_hrs", $Method), $this);
            $this->event_time_hrs->DSType = dsListOfValues;
            $this->event_time_hrs->Values = array(array("00", "00"), array("01", "01"), array("02", "02"), array("03", "03"), array("04", "04"), array("05", "05"), array("06", "06"), array("07", "07"), array("08", "08"), array("09", "09"), array("10", "10"), array("11", "11"), array("12", "12"), array("13", "13"), array("14", "14"), array("15", "15"), array("16", "16"), array("17", "17"), array("18", "18"), array("19", "19"), array("20", "20"), array("21", "21"), array("22", "22"), array("23", "23"));
            $this->event_time_mns = & new clsControl(ccsListBox, "event_time_mns", "event_time_mns", ccsText, "", CCGetRequestParam("event_time_mns", $Method), $this);
            $this->event_time_mns->DSType = dsListOfValues;
            $this->event_time_mns->Values = array(array("00", "00"), array("05", "05"), array("10", "10"), array("15", "15"), array("20", "20"), array("25", "25"), array("30", "30"), array("35", "35"), array("40", "40"), array("45", "45"), array("50", "50"), array("55", "55"));
            $this->time_hrs_end = & new clsControl(ccsListBox, "time_hrs_end", "time_hrs_end", ccsText, "", CCGetRequestParam("time_hrs_end", $Method), $this);
            $this->time_hrs_end->DSType = dsListOfValues;
            $this->time_hrs_end->Values = array(array("00", "00"), array("01", "01"), array("02", "02"), array("03", "03"), array("04", "04"), array("05", "05"), array("06", "06"), array("07", "07"), array("08", "08"), array("09", "09"), array("10", "10"), array("11", "11"), array("12", "12"), array("13", "13"), array("14", "14"), array("15", "15"), array("16", "16"), array("17", "17"), array("18", "18"), array("19", "19"), array("20", "20"), array("21", "21"), array("22", "22"), array("23", "23"));
            $this->time_mns_end = & new clsControl(ccsListBox, "time_mns_end", "time_mns_end", ccsText, "", CCGetRequestParam("time_mns_end", $Method), $this);
            $this->time_mns_end->DSType = dsListOfValues;
            $this->time_mns_end->Values = array(array("00", "00"), array("05", "05"), array("10", "10"), array("15", "15"), array("20", "20"), array("25", "25"), array("30", "30"), array("35", "35"), array("40", "40"), array("45", "45"), array("50", "50"), array("55", "55"));
            $this->allday = & new clsControl(ccsCheckBox, "allday", "allday", ccsInteger, "", CCGetRequestParam("allday", $Method), $this);
            $this->allday->CheckedValue = $this->allday->GetParsedValue(1);
            $this->allday->UncheckedValue = $this->allday->GetParsedValue(0);
            $this->event_date = & new clsControl(ccsTextBox, "event_date", $CCSLocales->GetText("event_date"), ccsDate, array("mm", "/", "dd", "/", "yyyy"), CCGetRequestParam("event_date", $Method), $this);
            $this->event_date->Required = true;
            $this->DatePicker_event_date = & new clsDatePicker("DatePicker_event_date", "events_rec", "event_date", $this);
            $this->RepeatEvent = & new clsControl(ccsCheckBox, "RepeatEvent", "RepeatEvent", ccsInteger, "", CCGetRequestParam("RepeatEvent", $Method), $this);
            $this->RepeatEvent->CheckedValue = $this->RepeatEvent->GetParsedValue(1);
            $this->RepeatEvent->UncheckedValue = $this->RepeatEvent->GetParsedValue(0);
            $this->RepeatNum = & new clsControl(ccsTextBox, "RepeatNum", $CCSLocales->GetText("Every"), ccsText, "", CCGetRequestParam("RepeatNum", $Method), $this);
            $this->RepeatType = & new clsControl(ccsListBox, "RepeatType", "RepeatType", ccsText, "", CCGetRequestParam("RepeatType", $Method), $this);
            $this->RepeatType->DSType = dsListOfValues;
            $this->RepeatType->Values = array(array("0", "Day"), array("8", "Week"), array("30", "Month"), array("1", "Sunday"), array("2", "Monday"), array("3", "Tuesday"), array("4", "Wednesday"), array("5", "Thursday"), array("6", "Friday"), array("7", "Saturday"));
            $this->event_todate = & new clsControl(ccsTextBox, "event_todate", $CCSLocales->GetText("End_By"), ccsDate, array("mm", "/", "dd", "/", "yyyy"), CCGetRequestParam("event_todate", $Method), $this);
            $this->DatePicker_event_todate = & new clsDatePicker("DatePicker_event_todate", "events_rec", "event_todate", $this);
            $this->event_is_public = & new clsControl(ccsCheckBox, "event_is_public", $CCSLocales->GetText("event_is_public"), ccsInteger, "", CCGetRequestParam("event_is_public", $Method), $this);
            $this->event_is_public->CheckedValue = $this->event_is_public->GetParsedValue(1);
            $this->event_is_public->UncheckedValue = $this->event_is_public->GetParsedValue(0);
            $this->user_id = & new clsControl(ccsHidden, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method), $this);
            $this->event_time = & new clsControl(ccsHidden, "event_time", "event_time", ccsDate, array("HH", ":", "nn"), CCGetRequestParam("event_time", $Method), $this);
            $this->event_time_end = & new clsControl(ccsHidden, "event_time_end", "event_time_end", ccsDate, array("HH", ":", "nn"), CCGetRequestParam("event_time_end", $Method), $this);
            $this->PanelLocation = & new clsPanel("PanelLocation", $this);
            $this->LabelLocation = & new clsControl(ccsLabel, "LabelLocation", "LabelLocation", ccsText, "", CCGetRequestParam("LabelLocation", $Method), $this);
            $this->event_location = & new clsControl(ccsTextArea, "event_location", "event_location", ccsText, "", CCGetRequestParam("event_location", $Method), $this);
            $this->PanelCost = & new clsPanel("PanelCost", $this);
            $this->LabelCost = & new clsControl(ccsLabel, "LabelCost", "LabelCost", ccsText, "", CCGetRequestParam("LabelCost", $Method), $this);
            $this->event_cost = & new clsControl(ccsTextBox, "event_cost", "event_cost", ccsText, "", CCGetRequestParam("event_cost", $Method), $this);
            $this->PanelURL = & new clsPanel("PanelURL", $this);
            $this->LabelURL = & new clsControl(ccsLabel, "LabelURL", "LabelURL", ccsText, "", CCGetRequestParam("LabelURL", $Method), $this);
            $this->event_URL = & new clsControl(ccsTextBox, "event_URL", "event_URL", ccsText, "", CCGetRequestParam("event_URL", $Method), $this);
            $this->PanelTextBox1 = & new clsPanel("PanelTextBox1", $this);
            $this->LabelTextBox1 = & new clsControl(ccsLabel, "LabelTextBox1", "LabelTextBox1", ccsText, "", CCGetRequestParam("LabelTextBox1", $Method), $this);
            $this->TextBox1 = & new clsControl(ccsTextBox, "TextBox1", "TextBox1", ccsText, "", CCGetRequestParam("TextBox1", $Method), $this);
            $this->PanelTextBox2 = & new clsPanel("PanelTextBox2", $this);
            $this->LabelTextBox2 = & new clsControl(ccsLabel, "LabelTextBox2", "LabelTextBox2", ccsText, "", CCGetRequestParam("LabelTextBox2", $Method), $this);
            $this->TextBox2 = & new clsControl(ccsTextBox, "TextBox2", "TextBox2", ccsText, "", CCGetRequestParam("TextBox2", $Method), $this);
            $this->PanelTextBox3 = & new clsPanel("PanelTextBox3", $this);
            $this->LabelTextBox3 = & new clsControl(ccsLabel, "LabelTextBox3", "LabelTextBox3", ccsText, "", CCGetRequestParam("LabelTextBox3", $Method), $this);
            $this->TextBox3 = & new clsControl(ccsTextBox, "TextBox3", "TextBox3", ccsText, "", CCGetRequestParam("TextBox3", $Method), $this);
            $this->PanelTextArea1 = & new clsPanel("PanelTextArea1", $this);
            $this->LabelTextArea1 = & new clsControl(ccsLabel, "LabelTextArea1", "LabelTextArea1", ccsText, "", CCGetRequestParam("LabelTextArea1", $Method), $this);
            $this->TextArea1 = & new clsControl(ccsTextArea, "TextArea1", "TextArea1", ccsText, "", CCGetRequestParam("TextArea1", $Method), $this);
            $this->PanelTextArea2 = & new clsPanel("PanelTextArea2", $this);
            $this->LabelTextArea2 = & new clsControl(ccsLabel, "LabelTextArea2", "LabelTextArea2", ccsText, "", CCGetRequestParam("LabelTextArea2", $Method), $this);
            $this->TextArea2 = & new clsControl(ccsTextArea, "TextArea2", "TextArea2", ccsText, "", CCGetRequestParam("TextArea2", $Method), $this);
            $this->PanelTextArea3 = & new clsPanel("PanelTextArea3", $this);
            $this->LabelTextArea3 = & new clsControl(ccsLabel, "LabelTextArea3", "LabelTextArea3", ccsText, "", CCGetRequestParam("LabelTextArea3", $Method), $this);
            $this->TextArea3 = & new clsControl(ccsTextArea, "TextArea3", "TextArea3", ccsText, "", CCGetRequestParam("TextArea3", $Method), $this);
            $this->PanelCheckBox1 = & new clsPanel("PanelCheckBox1", $this);
            $this->LabelCheckBox1 = & new clsControl(ccsLabel, "LabelCheckBox1", "LabelCheckBox1", ccsText, "", CCGetRequestParam("LabelCheckBox1", $Method), $this);
            $this->CheckBox1 = & new clsControl(ccsCheckBox, "CheckBox1", "CheckBox1", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox1", $Method), $this);
            $this->CheckBox1->CheckedValue = true;
            $this->CheckBox1->UncheckedValue = false;
            $this->PanelCheckBox2 = & new clsPanel("PanelCheckBox2", $this);
            $this->LabelCheckBox2 = & new clsControl(ccsLabel, "LabelCheckBox2", "LabelCheckBox2", ccsText, "", CCGetRequestParam("LabelCheckBox2", $Method), $this);
            $this->CheckBox2 = & new clsControl(ccsCheckBox, "CheckBox2", "CheckBox2", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox2", $Method), $this);
            $this->CheckBox2->CheckedValue = true;
            $this->CheckBox2->UncheckedValue = false;
            $this->PanelCheckBox3 = & new clsPanel("PanelCheckBox3", $this);
            $this->LabelCheckBox3 = & new clsControl(ccsLabel, "LabelCheckBox3", "LabelCheckBox3", ccsText, "", CCGetRequestParam("LabelCheckBox3", $Method), $this);
            $this->CheckBox3 = & new clsControl(ccsCheckBox, "CheckBox3", "CheckBox3", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox3", $Method), $this);
            $this->CheckBox3->CheckedValue = true;
            $this->CheckBox3->UncheckedValue = false;
            $this->PanelRecurrentSubmit = & new clsPanel("PanelRecurrentSubmit", $this);
            $this->RecurrentApply = & new clsControl(ccsCheckBox, "RecurrentApply", "RecurrentApply", ccsInteger, "", CCGetRequestParam("RecurrentApply", $Method), $this);
            $this->RecurrentApply->CheckedValue = $this->RecurrentApply->GetParsedValue(1);
            $this->RecurrentApply->UncheckedValue = $this->RecurrentApply->GetParsedValue(0);
            $this->event_parent_id = & new clsControl(ccsHidden, "event_parent_id", "event_parent_id", ccsText, "", CCGetRequestParam("event_parent_id", $Method), $this);
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = & new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = & new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = & new clsButton("Button_Cancel", $Method, $this);
            $this->PanelLocation->AddComponent("LabelLocation", $this->LabelLocation);
            $this->PanelLocation->AddComponent("event_location", $this->event_location);
            $this->PanelCost->AddComponent("LabelCost", $this->LabelCost);
            $this->PanelCost->AddComponent("event_cost", $this->event_cost);
            $this->PanelURL->AddComponent("LabelURL", $this->LabelURL);
            $this->PanelURL->AddComponent("event_URL", $this->event_URL);
            $this->PanelTextBox1->AddComponent("LabelTextBox1", $this->LabelTextBox1);
            $this->PanelTextBox1->AddComponent("TextBox1", $this->TextBox1);
            $this->PanelTextBox2->AddComponent("LabelTextBox2", $this->LabelTextBox2);
            $this->PanelTextBox2->AddComponent("TextBox2", $this->TextBox2);
            $this->PanelTextBox3->AddComponent("LabelTextBox3", $this->LabelTextBox3);
            $this->PanelTextBox3->AddComponent("TextBox3", $this->TextBox3);
            $this->PanelTextArea1->AddComponent("LabelTextArea1", $this->LabelTextArea1);
            $this->PanelTextArea1->AddComponent("TextArea1", $this->TextArea1);
            $this->PanelTextArea2->AddComponent("LabelTextArea2", $this->LabelTextArea2);
            $this->PanelTextArea2->AddComponent("TextArea2", $this->TextArea2);
            $this->PanelTextArea3->AddComponent("LabelTextArea3", $this->LabelTextArea3);
            $this->PanelTextArea3->AddComponent("TextArea3", $this->TextArea3);
            $this->PanelCheckBox1->AddComponent("LabelCheckBox1", $this->LabelCheckBox1);
            $this->PanelCheckBox1->AddComponent("CheckBox1", $this->CheckBox1);
            $this->PanelCheckBox2->AddComponent("LabelCheckBox2", $this->LabelCheckBox2);
            $this->PanelCheckBox2->AddComponent("CheckBox2", $this->CheckBox2);
            $this->PanelCheckBox3->AddComponent("LabelCheckBox3", $this->LabelCheckBox3);
            $this->PanelCheckBox3->AddComponent("CheckBox3", $this->CheckBox3);
            $this->PanelRecurrentSubmit->AddComponent("RecurrentApply", $this->RecurrentApply);
            $this->PanelRecurrentSubmit->AddComponent("event_parent_id", $this->event_parent_id);
            if(!$this->FormSubmitted) {
                if(!is_array($this->RepeatNum->Value) && !strlen($this->RepeatNum->Value) && $this->RepeatNum->Value !== false)
                    $this->RepeatNum->SetText(1);
                if(!is_array($this->event_is_public->Value) && !strlen($this->event_is_public->Value) && $this->event_is_public->Value !== false)
                    $this->event_is_public->SetValue(true);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @5-E9DB0D77
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlevent_id"] = CCGetFromGet("event_id", "");
    }
//End Initialize Method

//Validate Method @5-6CC06FA9
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->category_id->Validate() && $Validation);
        $Validation = ($this->event_title->Validate() && $Validation);
        $Validation = ($this->event_desc->Validate() && $Validation);
        $Validation = ($this->event_time_hrs->Validate() && $Validation);
        $Validation = ($this->event_time_mns->Validate() && $Validation);
        $Validation = ($this->time_hrs_end->Validate() && $Validation);
        $Validation = ($this->time_mns_end->Validate() && $Validation);
        $Validation = ($this->allday->Validate() && $Validation);
        $Validation = ($this->event_date->Validate() && $Validation);
        $Validation = ($this->RepeatEvent->Validate() && $Validation);
        $Validation = ($this->RepeatNum->Validate() && $Validation);
        $Validation = ($this->RepeatType->Validate() && $Validation);
        $Validation = ($this->event_todate->Validate() && $Validation);
        $Validation = ($this->event_is_public->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $Validation = ($this->event_time->Validate() && $Validation);
        $Validation = ($this->event_time_end->Validate() && $Validation);
        $Validation = ($this->event_location->Validate() && $Validation);
        $Validation = ($this->event_cost->Validate() && $Validation);
        $Validation = ($this->event_URL->Validate() && $Validation);
        $Validation = ($this->TextBox1->Validate() && $Validation);
        $Validation = ($this->TextBox2->Validate() && $Validation);
        $Validation = ($this->TextBox3->Validate() && $Validation);
        $Validation = ($this->TextArea1->Validate() && $Validation);
        $Validation = ($this->TextArea2->Validate() && $Validation);
        $Validation = ($this->TextArea3->Validate() && $Validation);
        $Validation = ($this->CheckBox1->Validate() && $Validation);
        $Validation = ($this->CheckBox2->Validate() && $Validation);
        $Validation = ($this->CheckBox3->Validate() && $Validation);
        $Validation = ($this->RecurrentApply->Validate() && $Validation);
        $Validation = ($this->event_parent_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->category_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_title->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_desc->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_time_hrs->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_time_mns->Errors->Count() == 0);
        $Validation =  $Validation && ($this->time_hrs_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->time_mns_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->allday->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RepeatEvent->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RepeatNum->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RepeatType->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_todate->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_is_public->Errors->Count() == 0);
        $Validation =  $Validation && ($this->user_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_time->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_time_end->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_location->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_cost->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_URL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextBox2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextBox3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextArea1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextArea2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextArea3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->RecurrentApply->Errors->Count() == 0);
        $Validation =  $Validation && ($this->event_parent_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @5-CC05A7D0
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->category_id->Errors->Count());
        $errors = ($errors || $this->event_title->Errors->Count());
        $errors = ($errors || $this->event_desc->Errors->Count());
        $errors = ($errors || $this->event_time_hrs->Errors->Count());
        $errors = ($errors || $this->event_time_mns->Errors->Count());
        $errors = ($errors || $this->time_hrs_end->Errors->Count());
        $errors = ($errors || $this->time_mns_end->Errors->Count());
        $errors = ($errors || $this->allday->Errors->Count());
        $errors = ($errors || $this->event_date->Errors->Count());
        $errors = ($errors || $this->DatePicker_event_date->Errors->Count());
        $errors = ($errors || $this->RepeatEvent->Errors->Count());
        $errors = ($errors || $this->RepeatNum->Errors->Count());
        $errors = ($errors || $this->RepeatType->Errors->Count());
        $errors = ($errors || $this->event_todate->Errors->Count());
        $errors = ($errors || $this->DatePicker_event_todate->Errors->Count());
        $errors = ($errors || $this->event_is_public->Errors->Count());
        $errors = ($errors || $this->user_id->Errors->Count());
        $errors = ($errors || $this->event_time->Errors->Count());
        $errors = ($errors || $this->event_time_end->Errors->Count());
        $errors = ($errors || $this->LabelLocation->Errors->Count());
        $errors = ($errors || $this->event_location->Errors->Count());
        $errors = ($errors || $this->LabelCost->Errors->Count());
        $errors = ($errors || $this->event_cost->Errors->Count());
        $errors = ($errors || $this->LabelURL->Errors->Count());
        $errors = ($errors || $this->event_URL->Errors->Count());
        $errors = ($errors || $this->LabelTextBox1->Errors->Count());
        $errors = ($errors || $this->TextBox1->Errors->Count());
        $errors = ($errors || $this->LabelTextBox2->Errors->Count());
        $errors = ($errors || $this->TextBox2->Errors->Count());
        $errors = ($errors || $this->LabelTextBox3->Errors->Count());
        $errors = ($errors || $this->TextBox3->Errors->Count());
        $errors = ($errors || $this->LabelTextArea1->Errors->Count());
        $errors = ($errors || $this->TextArea1->Errors->Count());
        $errors = ($errors || $this->LabelTextArea2->Errors->Count());
        $errors = ($errors || $this->TextArea2->Errors->Count());
        $errors = ($errors || $this->LabelTextArea3->Errors->Count());
        $errors = ($errors || $this->TextArea3->Errors->Count());
        $errors = ($errors || $this->LabelCheckBox1->Errors->Count());
        $errors = ($errors || $this->CheckBox1->Errors->Count());
        $errors = ($errors || $this->LabelCheckBox2->Errors->Count());
        $errors = ($errors || $this->CheckBox2->Errors->Count());
        $errors = ($errors || $this->LabelCheckBox3->Errors->Count());
        $errors = ($errors || $this->CheckBox3->Errors->Count());
        $errors = ($errors || $this->RecurrentApply->Errors->Count());
        $errors = ($errors || $this->event_parent_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @5-AF47A9F6
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "index.php";
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @5-3B19DAE5
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->category_id->SetValue($this->category_id->GetValue());
        $this->DataSource->event_title->SetValue($this->event_title->GetValue());
        $this->DataSource->event_desc->SetValue($this->event_desc->GetValue());
        $this->DataSource->event_time_hrs->SetValue($this->event_time_hrs->GetValue());
        $this->DataSource->event_time_mns->SetValue($this->event_time_mns->GetValue());
        $this->DataSource->time_hrs_end->SetValue($this->time_hrs_end->GetValue());
        $this->DataSource->time_mns_end->SetValue($this->time_mns_end->GetValue());
        $this->DataSource->allday->SetValue($this->allday->GetValue());
        $this->DataSource->event_date->SetValue($this->event_date->GetValue());
        $this->DataSource->RepeatEvent->SetValue($this->RepeatEvent->GetValue());
        $this->DataSource->RepeatNum->SetValue($this->RepeatNum->GetValue());
        $this->DataSource->RepeatType->SetValue($this->RepeatType->GetValue());
        $this->DataSource->event_todate->SetValue($this->event_todate->GetValue());
        $this->DataSource->event_is_public->SetValue($this->event_is_public->GetValue());
        $this->DataSource->user_id->SetValue($this->user_id->GetValue());
        $this->DataSource->event_time->SetValue($this->event_time->GetValue());
        $this->DataSource->event_time_end->SetValue($this->event_time_end->GetValue());
        $this->DataSource->LabelLocation->SetValue($this->LabelLocation->GetValue());
        $this->DataSource->event_location->SetValue($this->event_location->GetValue());
        $this->DataSource->LabelCost->SetValue($this->LabelCost->GetValue());
        $this->DataSource->event_cost->SetValue($this->event_cost->GetValue());
        $this->DataSource->LabelURL->SetValue($this->LabelURL->GetValue());
        $this->DataSource->event_URL->SetValue($this->event_URL->GetValue());
        $this->DataSource->LabelTextBox1->SetValue($this->LabelTextBox1->GetValue());
        $this->DataSource->TextBox1->SetValue($this->TextBox1->GetValue());
        $this->DataSource->LabelTextBox2->SetValue($this->LabelTextBox2->GetValue());
        $this->DataSource->TextBox2->SetValue($this->TextBox2->GetValue());
        $this->DataSource->LabelTextBox3->SetValue($this->LabelTextBox3->GetValue());
        $this->DataSource->TextBox3->SetValue($this->TextBox3->GetValue());
        $this->DataSource->LabelTextArea1->SetValue($this->LabelTextArea1->GetValue());
        $this->DataSource->TextArea1->SetValue($this->TextArea1->GetValue());
        $this->DataSource->LabelTextArea2->SetValue($this->LabelTextArea2->GetValue());
        $this->DataSource->TextArea2->SetValue($this->TextArea2->GetValue());
        $this->DataSource->LabelTextArea3->SetValue($this->LabelTextArea3->GetValue());
        $this->DataSource->TextArea3->SetValue($this->TextArea3->GetValue());
        $this->DataSource->LabelCheckBox1->SetValue($this->LabelCheckBox1->GetValue());
        $this->DataSource->CheckBox1->SetValue($this->CheckBox1->GetValue());
        $this->DataSource->LabelCheckBox2->SetValue($this->LabelCheckBox2->GetValue());
        $this->DataSource->CheckBox2->SetValue($this->CheckBox2->GetValue());
        $this->DataSource->LabelCheckBox3->SetValue($this->LabelCheckBox3->GetValue());
        $this->DataSource->CheckBox3->SetValue($this->CheckBox3->GetValue());
        $this->DataSource->RecurrentApply->SetValue($this->RecurrentApply->GetValue());
        $this->DataSource->event_parent_id->SetValue($this->event_parent_id->GetValue());
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @5-575E4B6B
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->category_id->SetValue($this->category_id->GetValue());
        $this->DataSource->event_title->SetValue($this->event_title->GetValue());
        $this->DataSource->event_desc->SetValue($this->event_desc->GetValue());
        $this->DataSource->event_time_hrs->SetValue($this->event_time_hrs->GetValue());
        $this->DataSource->event_time_mns->SetValue($this->event_time_mns->GetValue());
        $this->DataSource->time_hrs_end->SetValue($this->time_hrs_end->GetValue());
        $this->DataSource->time_mns_end->SetValue($this->time_mns_end->GetValue());
        $this->DataSource->allday->SetValue($this->allday->GetValue());
        $this->DataSource->event_date->SetValue($this->event_date->GetValue());
        $this->DataSource->RepeatEvent->SetValue($this->RepeatEvent->GetValue());
        $this->DataSource->RepeatNum->SetValue($this->RepeatNum->GetValue());
        $this->DataSource->RepeatType->SetValue($this->RepeatType->GetValue());
        $this->DataSource->event_todate->SetValue($this->event_todate->GetValue());
        $this->DataSource->event_is_public->SetValue($this->event_is_public->GetValue());
        $this->DataSource->user_id->SetValue($this->user_id->GetValue());
        $this->DataSource->event_time->SetValue($this->event_time->GetValue());
        $this->DataSource->event_time_end->SetValue($this->event_time_end->GetValue());
        $this->DataSource->LabelLocation->SetValue($this->LabelLocation->GetValue());
        $this->DataSource->event_location->SetValue($this->event_location->GetValue());
        $this->DataSource->LabelCost->SetValue($this->LabelCost->GetValue());
        $this->DataSource->event_cost->SetValue($this->event_cost->GetValue());
        $this->DataSource->LabelURL->SetValue($this->LabelURL->GetValue());
        $this->DataSource->event_URL->SetValue($this->event_URL->GetValue());
        $this->DataSource->LabelTextBox1->SetValue($this->LabelTextBox1->GetValue());
        $this->DataSource->TextBox1->SetValue($this->TextBox1->GetValue());
        $this->DataSource->LabelTextBox2->SetValue($this->LabelTextBox2->GetValue());
        $this->DataSource->TextBox2->SetValue($this->TextBox2->GetValue());
        $this->DataSource->LabelTextBox3->SetValue($this->LabelTextBox3->GetValue());
        $this->DataSource->TextBox3->SetValue($this->TextBox3->GetValue());
        $this->DataSource->LabelTextArea1->SetValue($this->LabelTextArea1->GetValue());
        $this->DataSource->TextArea1->SetValue($this->TextArea1->GetValue());
        $this->DataSource->LabelTextArea2->SetValue($this->LabelTextArea2->GetValue());
        $this->DataSource->TextArea2->SetValue($this->TextArea2->GetValue());
        $this->DataSource->LabelTextArea3->SetValue($this->LabelTextArea3->GetValue());
        $this->DataSource->TextArea3->SetValue($this->TextArea3->GetValue());
        $this->DataSource->LabelCheckBox1->SetValue($this->LabelCheckBox1->GetValue());
        $this->DataSource->CheckBox1->SetValue($this->CheckBox1->GetValue());
        $this->DataSource->LabelCheckBox2->SetValue($this->LabelCheckBox2->GetValue());
        $this->DataSource->CheckBox2->SetValue($this->CheckBox2->GetValue());
        $this->DataSource->LabelCheckBox3->SetValue($this->LabelCheckBox3->GetValue());
        $this->DataSource->CheckBox3->SetValue($this->CheckBox3->GetValue());
        $this->DataSource->RecurrentApply->SetValue($this->RecurrentApply->GetValue());
        $this->DataSource->event_parent_id->SetValue($this->event_parent_id->GetValue());
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @5-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @5-A21BE5BB
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->category_id->Prepare();
        $this->event_time_hrs->Prepare();
        $this->event_time_mns->Prepare();
        $this->time_hrs_end->Prepare();
        $this->time_mns_end->Prepare();
        $this->RepeatType->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->category_id->SetValue($this->DataSource->category_id->GetValue());
                    $this->event_title->SetValue($this->DataSource->event_title->GetValue());
                    $this->event_desc->SetValue($this->DataSource->event_desc->GetValue());
                    $this->event_date->SetValue($this->DataSource->event_date->GetValue());
                    $this->event_is_public->SetValue($this->DataSource->event_is_public->GetValue());
                    $this->user_id->SetValue($this->DataSource->user_id->GetValue());
                    $this->event_time->SetValue($this->DataSource->event_time->GetValue());
                    $this->event_time_end->SetValue($this->DataSource->event_time_end->GetValue());
                    $this->event_location->SetValue($this->DataSource->event_location->GetValue());
                    $this->event_cost->SetValue($this->DataSource->event_cost->GetValue());
                    $this->event_URL->SetValue($this->DataSource->event_URL->GetValue());
                    $this->TextBox1->SetValue($this->DataSource->TextBox1->GetValue());
                    $this->TextBox2->SetValue($this->DataSource->TextBox2->GetValue());
                    $this->TextBox3->SetValue($this->DataSource->TextBox3->GetValue());
                    $this->TextArea1->SetValue($this->DataSource->TextArea1->GetValue());
                    $this->TextArea2->SetValue($this->DataSource->TextArea2->GetValue());
                    $this->TextArea3->SetValue($this->DataSource->TextArea3->GetValue());
                    $this->CheckBox1->SetValue($this->DataSource->CheckBox1->GetValue());
                    $this->CheckBox2->SetValue($this->DataSource->CheckBox2->GetValue());
                    $this->CheckBox3->SetValue($this->DataSource->CheckBox3->GetValue());
                    $this->event_parent_id->SetValue($this->DataSource->event_parent_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->category_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_title->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_desc->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_time_hrs->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_time_mns->Errors->ToString());
            $Error = ComposeStrings($Error, $this->time_hrs_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->time_mns_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->allday->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_event_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RepeatEvent->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RepeatNum->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RepeatType->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_todate->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_event_todate->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_is_public->Errors->ToString());
            $Error = ComposeStrings($Error, $this->user_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_time->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_time_end->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelLocation->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_location->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelCost->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_cost->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelURL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_URL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelTextBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelTextBox2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextBox2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelTextBox3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextBox3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelTextArea1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextArea1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelTextArea2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextArea2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelTextArea3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextArea3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelCheckBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelCheckBox2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->LabelCheckBox3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->RecurrentApply->Errors->ToString());
            $Error = ComposeStrings($Error, $this->event_parent_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->category_id->Show();
        $this->event_title->Show();
        $this->event_desc->Show();
        $this->event_time_hrs->Show();
        $this->event_time_mns->Show();
        $this->time_hrs_end->Show();
        $this->time_mns_end->Show();
        $this->allday->Show();
        $this->event_date->Show();
        $this->DatePicker_event_date->Show();
        $this->RepeatEvent->Show();
        $this->RepeatNum->Show();
        $this->RepeatType->Show();
        $this->event_todate->Show();
        $this->DatePicker_event_todate->Show();
        $this->event_is_public->Show();
        $this->user_id->Show();
        $this->event_time->Show();
        $this->event_time_end->Show();
        $this->PanelLocation->Show();
        $this->PanelCost->Show();
        $this->PanelURL->Show();
        $this->PanelTextBox1->Show();
        $this->PanelTextBox2->Show();
        $this->PanelTextBox3->Show();
        $this->PanelTextArea1->Show();
        $this->PanelTextArea2->Show();
        $this->PanelTextArea3->Show();
        $this->PanelCheckBox1->Show();
        $this->PanelCheckBox2->Show();
        $this->PanelCheckBox3->Show();
        $this->PanelRecurrentSubmit->Show();
        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End events_rec Class @5-FCB6E20C

class clsevents_recDataSource extends clsDBcalendar {  //events_recDataSource Class @5-5FCBDF1C

//DataSource Variables @5-E1B738E9
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;


    // Datasource fields
    var $category_id;
    var $event_title;
    var $event_desc;
    var $event_time_hrs;
    var $event_time_mns;
    var $time_hrs_end;
    var $time_mns_end;
    var $allday;
    var $event_date;
    var $RepeatEvent;
    var $RepeatNum;
    var $RepeatType;
    var $event_todate;
    var $event_is_public;
    var $user_id;
    var $event_time;
    var $event_time_end;
    var $LabelLocation;
    var $event_location;
    var $LabelCost;
    var $event_cost;
    var $LabelURL;
    var $event_URL;
    var $LabelTextBox1;
    var $TextBox1;
    var $LabelTextBox2;
    var $TextBox2;
    var $LabelTextBox3;
    var $TextBox3;
    var $LabelTextArea1;
    var $TextArea1;
    var $LabelTextArea2;
    var $TextArea2;
    var $LabelTextArea3;
    var $TextArea3;
    var $LabelCheckBox1;
    var $CheckBox1;
    var $LabelCheckBox2;
    var $CheckBox2;
    var $LabelCheckBox3;
    var $CheckBox3;
    var $RecurrentApply;
    var $event_parent_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-1A097984
    function clsevents_recDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record events_rec/Error";
        $this->Initialize();
        $this->category_id = new clsField("category_id", ccsInteger, "");
        $this->event_title = new clsField("event_title", ccsText, "");
        $this->event_desc = new clsField("event_desc", ccsMemo, "");
        $this->event_time_hrs = new clsField("event_time_hrs", ccsText, "");
        $this->event_time_mns = new clsField("event_time_mns", ccsText, "");
        $this->time_hrs_end = new clsField("time_hrs_end", ccsText, "");
        $this->time_mns_end = new clsField("time_mns_end", ccsText, "");
        $this->allday = new clsField("allday", ccsInteger, "");
        $this->event_date = new clsField("event_date", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        $this->RepeatEvent = new clsField("RepeatEvent", ccsInteger, "");
        $this->RepeatNum = new clsField("RepeatNum", ccsText, "");
        $this->RepeatType = new clsField("RepeatType", ccsText, "");
        $this->event_todate = new clsField("event_todate", ccsDate, array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"));
        $this->event_is_public = new clsField("event_is_public", ccsInteger, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->event_time = new clsField("event_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        $this->event_time_end = new clsField("event_time_end", ccsDate, array("HH", ":", "nn", ":", "ss"));
        $this->LabelLocation = new clsField("LabelLocation", ccsText, "");
        $this->event_location = new clsField("event_location", ccsText, "");
        $this->LabelCost = new clsField("LabelCost", ccsText, "");
        $this->event_cost = new clsField("event_cost", ccsText, "");
        $this->LabelURL = new clsField("LabelURL", ccsText, "");
        $this->event_URL = new clsField("event_URL", ccsText, "");
        $this->LabelTextBox1 = new clsField("LabelTextBox1", ccsText, "");
        $this->TextBox1 = new clsField("TextBox1", ccsText, "");
        $this->LabelTextBox2 = new clsField("LabelTextBox2", ccsText, "");
        $this->TextBox2 = new clsField("TextBox2", ccsText, "");
        $this->LabelTextBox3 = new clsField("LabelTextBox3", ccsText, "");
        $this->TextBox3 = new clsField("TextBox3", ccsText, "");
        $this->LabelTextArea1 = new clsField("LabelTextArea1", ccsText, "");
        $this->TextArea1 = new clsField("TextArea1", ccsText, "");
        $this->LabelTextArea2 = new clsField("LabelTextArea2", ccsText, "");
        $this->TextArea2 = new clsField("TextArea2", ccsText, "");
        $this->LabelTextArea3 = new clsField("LabelTextArea3", ccsText, "");
        $this->TextArea3 = new clsField("TextArea3", ccsText, "");
        $this->LabelCheckBox1 = new clsField("LabelCheckBox1", ccsText, "");
        $this->CheckBox1 = new clsField("CheckBox1", ccsBoolean, array(1, 0, ""));
        $this->LabelCheckBox2 = new clsField("LabelCheckBox2", ccsText, "");
        $this->CheckBox2 = new clsField("CheckBox2", ccsBoolean, array(1, 0, ""));
        $this->LabelCheckBox3 = new clsField("LabelCheckBox3", ccsText, "");
        $this->CheckBox3 = new clsField("CheckBox3", ccsBoolean, array(1, 0, ""));
        $this->RecurrentApply = new clsField("RecurrentApply", ccsInteger, "");
        $this->event_parent_id = new clsField("event_parent_id", ccsText, "");

    }
//End DataSourceClass_Initialize Event

//Prepare Method @5-FD6E473D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlevent_id", ccsInteger, "", "", $this->Parameters["urlevent_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "event_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @5-10D58CCA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *  " .
        "FROM events {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-7EB055FF
    function SetValues()
    {
        $this->category_id->SetDBValue(trim($this->f("category_id")));
        $this->event_title->SetDBValue($this->f("event_title"));
        $this->event_desc->SetDBValue($this->f("event_desc"));
        $this->event_date->SetDBValue(trim($this->f("event_date")));
        $this->event_is_public->SetDBValue(trim($this->f("event_is_public")));
        $this->user_id->SetDBValue(trim($this->f("user_id")));
        $this->event_time->SetDBValue(trim($this->f("event_time")));
        $this->event_time_end->SetDBValue(trim($this->f("event_time_end")));
        $this->event_location->SetDBValue($this->f("event_location"));
        $this->event_cost->SetDBValue($this->f("event_cost"));
        $this->event_URL->SetDBValue($this->f("event_url"));
        $this->TextBox1->SetDBValue($this->f("custom_TextBox1"));
        $this->TextBox2->SetDBValue($this->f("custom_TextBox2"));
        $this->TextBox3->SetDBValue($this->f("custom_TextBox3"));
        $this->TextArea1->SetDBValue($this->f("custom_TextArea1"));
        $this->TextArea2->SetDBValue($this->f("custom_TextArea2"));
        $this->TextArea3->SetDBValue($this->f("custom_TextArea3"));
        $this->CheckBox1->SetDBValue(trim($this->f("custom_CheckBox1")));
        $this->CheckBox2->SetDBValue(trim($this->f("custom_CheckBox2")));
        $this->CheckBox3->SetDBValue(trim($this->f("custom_CheckBox3")));
        $this->event_parent_id->SetDBValue($this->f("event_parent_id"));
    }
//End SetValues Method

//Insert Method @5-B5010C2D
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->SQL = "INSERT INTO events ("
             . "category_id, "
             . "event_title, "
             . "event_desc, "
             . "event_date, "
             . "event_is_public, "
             . "user_id, "
             . "event_time, "
             . "event_time_end, "
             . "event_location, "
             . "event_cost, "
             . "event_url, "
             . "custom_TextBox1, "
             . "custom_TextBox2, "
             . "custom_TextBox3, "
             . "custom_TextArea1, "
             . "custom_TextArea2, "
             . "custom_TextArea3, "
             . "custom_CheckBox1, "
             . "custom_CheckBox2, "
             . "custom_CheckBox3, "
             . "event_parent_id"
             . ") VALUES ("
             . $this->ToSQL($this->category_id->GetDBValue(), $this->category_id->DataType) . ", "
             . $this->ToSQL($this->event_title->GetDBValue(), $this->event_title->DataType) . ", "
             . $this->ToSQL($this->event_desc->GetDBValue(), $this->event_desc->DataType) . ", "
             . $this->ToSQL($this->event_date->GetDBValue(), $this->event_date->DataType) . ", "
             . $this->ToSQL($this->event_is_public->GetDBValue(), $this->event_is_public->DataType) . ", "
             . $this->ToSQL($this->user_id->GetDBValue(), $this->user_id->DataType) . ", "
             . $this->ToSQL($this->event_time->GetDBValue(), $this->event_time->DataType) . ", "
             . $this->ToSQL($this->event_time_end->GetDBValue(), $this->event_time_end->DataType) . ", "
             . $this->ToSQL($this->event_location->GetDBValue(), $this->event_location->DataType) . ", "
             . $this->ToSQL($this->event_cost->GetDBValue(), $this->event_cost->DataType) . ", "
             . $this->ToSQL($this->event_URL->GetDBValue(), $this->event_URL->DataType) . ", "
             . $this->ToSQL($this->TextBox1->GetDBValue(), $this->TextBox1->DataType) . ", "
             . $this->ToSQL($this->TextBox2->GetDBValue(), $this->TextBox2->DataType) . ", "
             . $this->ToSQL($this->TextBox3->GetDBValue(), $this->TextBox3->DataType) . ", "
             . $this->ToSQL($this->TextArea1->GetDBValue(), $this->TextArea1->DataType) . ", "
             . $this->ToSQL($this->TextArea2->GetDBValue(), $this->TextArea2->DataType) . ", "
             . $this->ToSQL($this->TextArea3->GetDBValue(), $this->TextArea3->DataType) . ", "
             . $this->ToSQL($this->CheckBox1->GetDBValue(), $this->CheckBox1->DataType) . ", "
             . $this->ToSQL($this->CheckBox2->GetDBValue(), $this->CheckBox2->DataType) . ", "
             . $this->ToSQL($this->CheckBox3->GetDBValue(), $this->CheckBox3->DataType) . ", "
             . $this->ToSQL($this->event_parent_id->GetDBValue(), $this->event_parent_id->DataType)
             . ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @5-529292C5
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->SQL = "UPDATE events SET "
             . "category_id=" . $this->ToSQL($this->category_id->GetDBValue(), $this->category_id->DataType) . ", "
             . "event_title=" . $this->ToSQL($this->event_title->GetDBValue(), $this->event_title->DataType) . ", "
             . "event_desc=" . $this->ToSQL($this->event_desc->GetDBValue(), $this->event_desc->DataType) . ", "
             . "event_date=" . $this->ToSQL($this->event_date->GetDBValue(), $this->event_date->DataType) . ", "
             . "event_is_public=" . $this->ToSQL($this->event_is_public->GetDBValue(), $this->event_is_public->DataType) . ", "
             . "user_id=" . $this->ToSQL($this->user_id->GetDBValue(), $this->user_id->DataType) . ", "
             . "event_time=" . $this->ToSQL($this->event_time->GetDBValue(), $this->event_time->DataType) . ", "
             . "event_time_end=" . $this->ToSQL($this->event_time_end->GetDBValue(), $this->event_time_end->DataType) . ", "
             . "event_location=" . $this->ToSQL($this->event_location->GetDBValue(), $this->event_location->DataType) . ", "
             . "event_cost=" . $this->ToSQL($this->event_cost->GetDBValue(), $this->event_cost->DataType) . ", "
             . "event_url=" . $this->ToSQL($this->event_URL->GetDBValue(), $this->event_URL->DataType) . ", "
             . "custom_TextBox1=" . $this->ToSQL($this->TextBox1->GetDBValue(), $this->TextBox1->DataType) . ", "
             . "custom_TextBox2=" . $this->ToSQL($this->TextBox2->GetDBValue(), $this->TextBox2->DataType) . ", "
             . "custom_TextBox3=" . $this->ToSQL($this->TextBox3->GetDBValue(), $this->TextBox3->DataType) . ", "
             . "custom_TextArea1=" . $this->ToSQL($this->TextArea1->GetDBValue(), $this->TextArea1->DataType) . ", "
             . "custom_TextArea2=" . $this->ToSQL($this->TextArea2->GetDBValue(), $this->TextArea2->DataType) . ", "
             . "custom_TextArea3=" . $this->ToSQL($this->TextArea3->GetDBValue(), $this->TextArea3->DataType) . ", "
             . "custom_CheckBox1=" . $this->ToSQL($this->CheckBox1->GetDBValue(), $this->CheckBox1->DataType) . ", "
             . "custom_CheckBox2=" . $this->ToSQL($this->CheckBox2->GetDBValue(), $this->CheckBox2->DataType) . ", "
             . "custom_CheckBox3=" . $this->ToSQL($this->CheckBox3->GetDBValue(), $this->CheckBox3->DataType) . ", "
             . "event_parent_id=" . $this->ToSQL($this->event_parent_id->GetDBValue(), $this->event_parent_id->DataType);
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @5-4A7849B6
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM events";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End events_recDataSource Class @5-FCB6E20C

//Include Page implementation @3-EBA5EA16
include_once(RelativePath . "/footer.php");
//End Include Page implementation

//Initialize Page @1-B9A1924C
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
$TemplateFileName = "events.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$PathToRoot = "./";
//End Initialize Page

//Include events file @1-B9C6B0FB
include("./events_events.php");
//End Include events file

//Initialize Objects @1-19CDD8B0
$DBcalendar = new clsDBcalendar();
$MainPage->Connections["calendar"] = & $DBcalendar;

// Controls
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$vertical_menu = & new clsvertical_menu("", "vertical_menu", $MainPage);
$vertical_menu->Initialize();
$events_rec = & new clsRecordevents_rec("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$MainPage->header = & $header;
$MainPage->vertical_menu = & $vertical_menu;
$MainPage->events_rec = & $events_rec;
$MainPage->footer = & $footer;
$events_rec->Initialize();

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

//Execute Components @1-231767AF
$header->Operations();
$vertical_menu->Operations();
$events_rec->Operation();
$footer->Operations();
//End Execute Components

//Go to destination page @1-BBB7FCAE
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcalendar->close();
    header("Location: " . $Redirect);
    $header->Class_Terminate();
    unset($header);
    $vertical_menu->Class_Terminate();
    unset($vertical_menu);
    unset($events_rec);
    $footer->Class_Terminate();
    unset($footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-3A84DFED
$vertical_menu->Show();
$events_rec->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
$main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-670D438E
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcalendar->close();
$header->Class_Terminate();
unset($header);
$vertical_menu->Class_Terminate();
unset($vertical_menu);
unset($events_rec);
$footer->Class_Terminate();
unset($footer);
unset($Tpl);
//End Unload Page


?>
