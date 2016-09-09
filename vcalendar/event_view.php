<?php
//Include Common Files @1-99D479BE
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "event_view.php");
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

class clsGrideventGrid { //eventGrid class @5-FA43114E

//Variables @5-C23F2C5F

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    // Grid Controls
    var $StaticControls;
    var $RowControls;
//End Variables

//Class_Initialize Event @5-EE09CAD0
    function clsGrideventGrid($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "eventGrid";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid eventGrid";
        $this->DataSource = new clseventGridDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 1;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->event_date = & new clsControl(ccsLabel, "event_date", "event_date", ccsDate, array("LongDate"), CCGetRequestParam("event_date", ccsGet), $this);
        $this->event_time = & new clsControl(ccsLabel, "event_time", "event_time", ccsDate, array("HH", ":", "nn"), CCGetRequestParam("event_time", ccsGet), $this);
        $this->event_time_end = & new clsControl(ccsLabel, "event_time_end", "event_time_end", ccsDate, array("HH", ":", "nn"), CCGetRequestParam("event_time_end", ccsGet), $this);
        $this->category_id = & new clsControl(ccsLabel, "category_id", "category_id", ccsText, "", CCGetRequestParam("category_id", ccsGet), $this);
        $this->user_id = & new clsControl(ccsLabel, "user_id", "user_id", ccsText, "", CCGetRequestParam("user_id", ccsGet), $this);
        $this->event_desc = & new clsControl(ccsLabel, "event_desc", "event_desc", ccsMemo, "", CCGetRequestParam("event_desc", ccsGet), $this);
        $this->event_desc->HTML = true;
        $this->PanelLocation = & new clsPanel("PanelLocation", $this);
        $this->LabelLocation = & new clsControl(ccsLabel, "LabelLocation", "LabelLocation", ccsText, "", CCGetRequestParam("LabelLocation", ccsGet), $this);
        $this->event_Location = & new clsControl(ccsLabel, "event_Location", "event_Location", ccsText, "", CCGetRequestParam("event_Location", ccsGet), $this);
        $this->event_Location->HTML = true;
        $this->PanelCost = & new clsPanel("PanelCost", $this);
        $this->LabelCost = & new clsControl(ccsLabel, "LabelCost", "LabelCost", ccsText, "", CCGetRequestParam("LabelCost", ccsGet), $this);
        $this->event_Cost = & new clsControl(ccsLabel, "event_Cost", "event_Cost", ccsText, "", CCGetRequestParam("event_Cost", ccsGet), $this);
        $this->PanelURL = & new clsPanel("PanelURL", $this);
        $this->LabelURL = & new clsControl(ccsLabel, "LabelURL", "LabelURL", ccsText, "", CCGetRequestParam("LabelURL", ccsGet), $this);
        $this->event_URL = & new clsControl(ccsLink, "event_URL", "event_URL", ccsText, "", CCGetRequestParam("event_URL", ccsGet), $this);
        $this->PanelTextBox1 = & new clsPanel("PanelTextBox1", $this);
        $this->LabelTextBox1 = & new clsControl(ccsLabel, "LabelTextBox1", "LabelTextBox1", ccsText, "", CCGetRequestParam("LabelTextBox1", ccsGet), $this);
        $this->LabelTextBox1->HTML = true;
        $this->event_TextBox1 = & new clsControl(ccsLabel, "event_TextBox1", "event_TextBox1", ccsText, "", CCGetRequestParam("event_TextBox1", ccsGet), $this);
        $this->PanelTextBox2 = & new clsPanel("PanelTextBox2", $this);
        $this->LabelTextBox2 = & new clsControl(ccsLabel, "LabelTextBox2", "LabelTextBox2", ccsText, "", CCGetRequestParam("LabelTextBox2", ccsGet), $this);
        $this->LabelTextBox2->HTML = true;
        $this->event_TextBox2 = & new clsControl(ccsLabel, "event_TextBox2", "event_TextBox2", ccsText, "", CCGetRequestParam("event_TextBox2", ccsGet), $this);
        $this->event_TextBox2->HTML = true;
        $this->PanelTextBox3 = & new clsPanel("PanelTextBox3", $this);
        $this->LabelTextBox3 = & new clsControl(ccsLabel, "LabelTextBox3", "LabelTextBox3", ccsText, "", CCGetRequestParam("LabelTextBox3", ccsGet), $this);
        $this->LabelTextBox3->HTML = true;
        $this->event_TextBox3 = & new clsControl(ccsLabel, "event_TextBox3", "event_TextBox3", ccsText, "", CCGetRequestParam("event_TextBox3", ccsGet), $this);
        $this->event_TextBox3->HTML = true;
        $this->PanelTextArea1 = & new clsPanel("PanelTextArea1", $this);
        $this->LabelTextArea1 = & new clsControl(ccsLabel, "LabelTextArea1", "LabelTextArea1", ccsText, "", CCGetRequestParam("LabelTextArea1", ccsGet), $this);
        $this->event_TextArea1 = & new clsControl(ccsLabel, "event_TextArea1", "event_TextArea1", ccsText, "", CCGetRequestParam("event_TextArea1", ccsGet), $this);
        $this->event_TextArea1->HTML = true;
        $this->PanelTextArea2 = & new clsPanel("PanelTextArea2", $this);
        $this->LabelTextArea2 = & new clsControl(ccsLabel, "LabelTextArea2", "LabelTextArea2", ccsText, "", CCGetRequestParam("LabelTextArea2", ccsGet), $this);
        $this->LabelTextArea2->HTML = true;
        $this->event_TextArea2 = & new clsControl(ccsLabel, "event_TextArea2", "event_TextArea2", ccsText, "", CCGetRequestParam("event_TextArea2", ccsGet), $this);
        $this->event_TextArea2->HTML = true;
        $this->PanelTextArea3 = & new clsPanel("PanelTextArea3", $this);
        $this->LabelTextArea3 = & new clsControl(ccsLabel, "LabelTextArea3", "LabelTextArea3", ccsText, "", CCGetRequestParam("LabelTextArea3", ccsGet), $this);
        $this->LabelTextArea3->HTML = true;
        $this->event_TextArea3 = & new clsControl(ccsLabel, "event_TextArea3", "event_TextArea3", ccsText, "", CCGetRequestParam("event_TextArea3", ccsGet), $this);
        $this->event_TextArea3->HTML = true;
        $this->PanelCheckBox1 = & new clsPanel("PanelCheckBox1", $this);
        $this->LabelCheckBox1 = & new clsControl(ccsLabel, "LabelCheckBox1", "LabelCheckBox1", ccsText, "", CCGetRequestParam("LabelCheckBox1", ccsGet), $this);
        $this->event_CheckBox1 = & new clsControl(ccsLabel, "event_CheckBox1", "event_CheckBox1", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("event_CheckBox1", ccsGet), $this);
        $this->PanelCheckBox2 = & new clsPanel("PanelCheckBox2", $this);
        $this->LabelCheckBox2 = & new clsControl(ccsLabel, "LabelCheckBox2", "LabelCheckBox2", ccsText, "", CCGetRequestParam("LabelCheckBox2", ccsGet), $this);
        $this->event_CheckBox2 = & new clsControl(ccsLabel, "event_CheckBox2", "event_CheckBox2", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("event_CheckBox2", ccsGet), $this);
        $this->PanelCheckBox3 = & new clsPanel("PanelCheckBox3", $this);
        $this->LabelCheckBox3 = & new clsControl(ccsLabel, "LabelCheckBox3", "LabelCheckBox3", ccsText, "", CCGetRequestParam("LabelCheckBox3", ccsGet), $this);
        $this->event_CheckBox3 = & new clsControl(ccsLabel, "event_CheckBox3", "event_CheckBox3", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("event_CheckBox3", ccsGet), $this);
        $this->event_title = & new clsControl(ccsLabel, "event_title", "event_title", ccsText, "", CCGetRequestParam("event_title", ccsGet), $this);
        $this->edit = & new clsPanel("edit", $this);
        $this->edit_event = & new clsControl(ccsLink, "edit_event", "edit_event", ccsText, "", CCGetRequestParam("edit_event", ccsGet), $this);
        $this->edit_event->Parameters = CCAddParam($this->edit_event->Parameters, "event_id", CCGetFromGet("event_id", ""));
        $this->edit_event->Page = "events.php";
        $this->PanelLocation->AddComponent("LabelLocation", $this->LabelLocation);
        $this->PanelLocation->AddComponent("event_Location", $this->event_Location);
        $this->PanelCost->AddComponent("LabelCost", $this->LabelCost);
        $this->PanelCost->AddComponent("event_Cost", $this->event_Cost);
        $this->PanelURL->AddComponent("LabelURL", $this->LabelURL);
        $this->PanelURL->AddComponent("event_URL", $this->event_URL);
        $this->PanelTextBox1->AddComponent("LabelTextBox1", $this->LabelTextBox1);
        $this->PanelTextBox1->AddComponent("event_TextBox1", $this->event_TextBox1);
        $this->PanelTextBox2->AddComponent("LabelTextBox2", $this->LabelTextBox2);
        $this->PanelTextBox2->AddComponent("event_TextBox2", $this->event_TextBox2);
        $this->PanelTextBox3->AddComponent("LabelTextBox3", $this->LabelTextBox3);
        $this->PanelTextBox3->AddComponent("event_TextBox3", $this->event_TextBox3);
        $this->PanelTextArea1->AddComponent("LabelTextArea1", $this->LabelTextArea1);
        $this->PanelTextArea1->AddComponent("event_TextArea1", $this->event_TextArea1);
        $this->PanelTextArea2->AddComponent("LabelTextArea2", $this->LabelTextArea2);
        $this->PanelTextArea2->AddComponent("event_TextArea2", $this->event_TextArea2);
        $this->PanelTextArea3->AddComponent("LabelTextArea3", $this->LabelTextArea3);
        $this->PanelTextArea3->AddComponent("event_TextArea3", $this->event_TextArea3);
        $this->PanelCheckBox1->AddComponent("LabelCheckBox1", $this->LabelCheckBox1);
        $this->PanelCheckBox1->AddComponent("event_CheckBox1", $this->event_CheckBox1);
        $this->PanelCheckBox2->AddComponent("LabelCheckBox2", $this->LabelCheckBox2);
        $this->PanelCheckBox2->AddComponent("event_CheckBox2", $this->event_CheckBox2);
        $this->PanelCheckBox3->AddComponent("LabelCheckBox3", $this->LabelCheckBox3);
        $this->PanelCheckBox3->AddComponent("event_CheckBox3", $this->event_CheckBox3);
        $this->edit->AddComponent("edit_event", $this->edit_event);
    }
//End Class_Initialize Event

//Initialize Method @5-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @5-6391640B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->DataSource->Parameters["urlevent_id"] = CCGetFromGet("event_id", "");
        $this->DataSource->Parameters["seslocale"] = CCGetSession("locale");
        $this->DataSource->Parameters["urlevents_category_id"] = CCGetFromGet("events_category_id", "");

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if(($ShownRecords < $this->PageSize) && $this->DataSource->next_record())
        {
            do {
                $this->DataSource->SetValues();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->event_date->SetValue($this->DataSource->event_date->GetValue());
                $this->event_time->SetValue($this->DataSource->event_time->GetValue());
                $this->event_time_end->SetValue($this->DataSource->event_time_end->GetValue());
                $this->category_id->SetValue($this->DataSource->category_id->GetValue());
                $this->user_id->SetValue($this->DataSource->user_id->GetValue());
                $this->event_desc->SetValue($this->DataSource->event_desc->GetValue());
                $this->event_Location->SetValue($this->DataSource->event_Location->GetValue());
                $this->event_Cost->SetValue($this->DataSource->event_Cost->GetValue());
                $this->event_URL->SetValue($this->DataSource->event_URL->GetValue());
                $this->event_URL->Page = $this->DataSource->f("event_url");
                $this->event_TextBox1->SetValue($this->DataSource->event_TextBox1->GetValue());
                $this->event_TextBox2->SetValue($this->DataSource->event_TextBox2->GetValue());
                $this->event_TextBox3->SetValue($this->DataSource->event_TextBox3->GetValue());
                $this->event_TextArea1->SetValue($this->DataSource->event_TextArea1->GetValue());
                $this->event_TextArea2->SetValue($this->DataSource->event_TextArea2->GetValue());
                $this->event_TextArea3->SetValue($this->DataSource->event_TextArea3->GetValue());
                $this->event_CheckBox1->SetValue($this->DataSource->event_CheckBox1->GetValue());
                $this->event_CheckBox2->SetValue($this->DataSource->event_CheckBox2->GetValue());
                $this->event_CheckBox3->SetValue($this->DataSource->event_CheckBox3->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->event_date->Show();
                $this->event_time->Show();
                $this->event_time_end->Show();
                $this->category_id->Show();
                $this->user_id->Show();
                $this->event_desc->Show();
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
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
            } while (($ShownRecords < $this->PageSize) && $this->DataSource->next_record());
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->event_title->SetValue($this->DataSource->event_title->GetValue());
        $this->event_title->Show();
        $this->edit->Show();
        $this->edit_event->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @5-71EE8BC5
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->event_date->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_time->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_time_end->Errors->ToString());
        $errors = ComposeStrings($errors, $this->category_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->user_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_desc->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelLocation->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_Location->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelCost->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_Cost->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelURL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_URL->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelTextBox1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_TextBox1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelTextBox2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_TextBox2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelTextBox3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_TextBox3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelTextArea1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_TextArea1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelTextArea2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_TextArea2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelTextArea3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_TextArea3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelCheckBox1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_CheckBox1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelCheckBox2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_CheckBox2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->LabelCheckBox3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->event_CheckBox3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End eventGrid Class @5-FCB6E20C

class clseventGridDataSource extends clsDBcalendar {  //eventGridDataSource Class @5-3C6984DC

//DataSource Variables @5-F263C099
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $event_title;
    var $event_date;
    var $event_time;
    var $event_time_end;
    var $category_id;
    var $user_id;
    var $event_desc;
    var $event_Location;
    var $event_Cost;
    var $event_URL;
    var $event_TextBox1;
    var $event_TextBox2;
    var $event_TextBox3;
    var $event_TextArea1;
    var $event_TextArea2;
    var $event_TextArea3;
    var $event_CheckBox1;
    var $event_CheckBox2;
    var $event_CheckBox3;
//End DataSource Variables

//DataSourceClass_Initialize Event @5-9021CE3F
    function clseventGridDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid eventGrid";
        $this->Initialize();
        $this->event_title = new clsField("event_title", ccsText, "");
        $this->event_date = new clsField("event_date", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        $this->event_time = new clsField("event_time", ccsDate, array("HH", ":", "nn", ":", "ss"));
        $this->event_time_end = new clsField("event_time_end", ccsDate, array("HH", ":", "nn", ":", "ss"));
        $this->category_id = new clsField("category_id", ccsText, "");
        $this->user_id = new clsField("user_id", ccsText, "");
        $this->event_desc = new clsField("event_desc", ccsMemo, "");
        $this->event_Location = new clsField("event_Location", ccsText, "");
        $this->event_Cost = new clsField("event_Cost", ccsText, "");
        $this->event_URL = new clsField("event_URL", ccsText, "");
        $this->event_TextBox1 = new clsField("event_TextBox1", ccsText, "");
        $this->event_TextBox2 = new clsField("event_TextBox2", ccsText, "");
        $this->event_TextBox3 = new clsField("event_TextBox3", ccsText, "");
        $this->event_TextArea1 = new clsField("event_TextArea1", ccsText, "");
        $this->event_TextArea2 = new clsField("event_TextArea2", ccsText, "");
        $this->event_TextArea3 = new clsField("event_TextArea3", ccsText, "");
        $this->event_CheckBox1 = new clsField("event_CheckBox1", ccsBoolean, array(1, 0, ""));
        $this->event_CheckBox2 = new clsField("event_CheckBox2", ccsBoolean, array(1, 0, ""));
        $this->event_CheckBox3 = new clsField("event_CheckBox3", ccsBoolean, array(1, 0, ""));

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @5-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @5-E3F340D5
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlevent_id", ccsInteger, "", "", $this->Parameters["urlevent_id"], "", true);
        $this->wp->AddParameter("2", "seslocale", ccsText, "", "", $this->Parameters["seslocale"], "", false);
        $this->wp->AddParameter("3", "urlevents_category_id", ccsInteger, "", "", $this->Parameters["urlevents_category_id"], "", true);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "events.event_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "categories_langs.language_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opIsNull, "events.category_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),true);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], $this->wp->opOR(
             true, 
             $this->wp->Criterion[2], 
             $this->wp->Criterion[3]));
    }
//End Prepare Method

//Open Method @5-A2915269
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) " .
        "FROM (events LEFT JOIN users ON " .
        "events.user_id = users.user_id) LEFT JOIN categories_langs ON " .
        "events.category_id = categories_langs.category_id";
        $this->SQL = "SELECT events.*, user_login, user_last_name, user_first_name, category_name  " .
        "FROM (events LEFT JOIN users ON " .
        "events.user_id = users.user_id) LEFT JOIN categories_langs ON " .
        "events.category_id = categories_langs.category_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @5-D780A013
    function SetValues()
    {
        $this->event_title->SetDBValue($this->f("event_title"));
        $this->event_date->SetDBValue(trim($this->f("event_date")));
        $this->event_time->SetDBValue(trim($this->f("event_time")));
        $this->event_time_end->SetDBValue(trim($this->f("event_time_end")));
        $this->category_id->SetDBValue($this->f("category_name"));
        $this->user_id->SetDBValue($this->f("user_login"));
        $this->event_desc->SetDBValue($this->f("event_desc"));
        $this->event_Location->SetDBValue($this->f("event_location"));
        $this->event_Cost->SetDBValue($this->f("event_cost"));
        $this->event_URL->SetDBValue($this->f("event_url"));
        $this->event_TextBox1->SetDBValue($this->f("custom_TextBox1"));
        $this->event_TextBox2->SetDBValue($this->f("custom_TextBox2"));
        $this->event_TextBox3->SetDBValue($this->f("custom_TextBox3"));
        $this->event_TextArea1->SetDBValue($this->f("custom_TextArea1"));
        $this->event_TextArea2->SetDBValue($this->f("custom_TextArea2"));
        $this->event_TextArea3->SetDBValue($this->f("custom_TextArea3"));
        $this->event_CheckBox1->SetDBValue(trim($this->f("custom_CheckBox1")));
        $this->event_CheckBox2->SetDBValue(trim($this->f("custom_CheckBox2")));
        $this->event_CheckBox3->SetDBValue(trim($this->f("custom_CheckBox3")));
    }
//End SetValues Method

} //End eventGridDataSource Class @5-FCB6E20C

class clsGridactive_reminders { //active_reminders class @147-B3ED150D

//Variables @147-C23F2C5F

    // Public variables
    var $ComponentType = "Grid";
    var $ComponentName;
    var $Visible;
    var $Errors;
    var $ErrorBlock;
    var $ds;
    var $DataSource;
    var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $RelativePath = "";

    // Grid Controls
    var $StaticControls;
    var $RowControls;
//End Variables

//Class_Initialize Event @147-3C03428E
    function clsGridactive_reminders($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "active_reminders";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid active_reminders";
        $this->DataSource = new clsactive_remindersDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->Detail = & new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet), $this);
        $this->Detail->Page = "event_view.php";
        $this->remind_date = & new clsControl(ccsLabel, "remind_date", "remind_date", ccsDate, array("mm", "/", "dd", "/", "yyyy"), CCGetRequestParam("remind_date", ccsGet), $this);
        $this->remind_time = & new clsControl(ccsLabel, "remind_time", "remind_time", ccsDate, array("HH", ":", "nn"), CCGetRequestParam("remind_time", ccsGet), $this);
    }
//End Class_Initialize Event

//Initialize Method @147-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @147-AC03AFFD
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->DataSource->Parameters["sesUserID"] = CCGetSession("UserID");
        $this->DataSource->Parameters["urlevent_id"] = CCGetFromGet("event_id", "");

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if(($ShownRecords < $this->PageSize) && $this->DataSource->next_record())
        {
            do {
                $this->DataSource->SetValues();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->Detail->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "remind_id", $this->DataSource->f("remind_id"));
                $this->remind_date->SetValue($this->DataSource->remind_date->GetValue());
                $this->remind_time->SetValue($this->DataSource->remind_time->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Detail->Show();
                $this->remind_date->Show();
                $this->remind_time->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
            } while (($ShownRecords < $this->PageSize) && $this->DataSource->next_record());
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @147-C4C39644
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->Detail->Errors->ToString());
        $errors = ComposeStrings($errors, $this->remind_date->Errors->ToString());
        $errors = ComposeStrings($errors, $this->remind_time->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End active_reminders Class @147-FCB6E20C

class clsactive_remindersDataSource extends clsDBcalendar {  //active_remindersDataSource Class @147-4784BBDD

//DataSource Variables @147-1D6A6B90
    var $Parent = "";
    var $CCSEvents = "";
    var $CCSEventResult;
    var $ErrorBlock;
    var $CmdExecution;

    var $CountSQL;
    var $wp;


    // Datasource fields
    var $remind_date;
    var $remind_time;
//End DataSource Variables

//DataSourceClass_Initialize Event @147-5356CE70
    function clsactive_remindersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid active_reminders";
        $this->Initialize();
        $this->remind_date = new clsField("remind_date", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        $this->remind_time = new clsField("remind_time", ccsDate, array("HH", ":", "nn", ":", "ss"));

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @147-BD2C22E8
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "remind_date, remind_time";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @147-1DDB69F9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "", true);
        $this->wp->AddParameter("2", "urlevent_id", ccsInteger, "", "", $this->Parameters["urlevent_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),true);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "event_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @147-E5716FB0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) " .
        "FROM event_remind";
        $this->SQL = "SELECT remind_id, remind_date, remind_time  " .
        "FROM event_remind {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @147-5044D683
    function SetValues()
    {
        $this->remind_date->SetDBValue(trim($this->f("remind_date")));
        $this->remind_time->SetDBValue(trim($this->f("remind_time")));
    }
//End SetValues Method

} //End active_remindersDataSource Class @147-FCB6E20C

class clsRecordevent_reminder { //event_reminder Class @159-E7D626E6

//Variables @159-F607D3A5

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

//Class_Initialize Event @159-8C6D6F56
    function clsRecordevent_reminder($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record event_reminder/Error";
        $this->DataSource = new clsevent_reminderDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "event_reminder";
            $CCSForm = split(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->remind_date = & new clsControl(ccsTextBox, "remind_date", $CCSLocales->GetText("remind_date"), ccsDate, array("mm", "/", "dd", "/", "yyyy"), CCGetRequestParam("remind_date", $Method), $this);
            $this->remind_date->Required = true;
            $this->DatePicker_remind_date = & new clsDatePicker("DatePicker_remind_date", "event_reminder", "remind_date", $this);
            $this->remind_time_hrs = & new clsControl(ccsListBox, "remind_time_hrs", "remind_time_hrs", ccsText, "", CCGetRequestParam("remind_time_hrs", $Method), $this);
            $this->remind_time_hrs->DSType = dsListOfValues;
            $this->remind_time_hrs->Values = array(array("00", "00"), array("01", "01"), array("02", "02"), array("03", "03"), array("04", "04"), array("05", "05"), array("06", "06"), array("07", "07"), array("08", "08"), array("09", "09"), array("10", "10"), array("11", "11"), array("12", "12"), array("13", "13"), array("14", "14"), array("15", "15"), array("16", "16"), array("17", "17"), array("18", "18"), array("19", "19"), array("20", "20"), array("21", "21"), array("22", "22"), array("23", "23"));
            $this->remind_time_mns = & new clsControl(ccsListBox, "remind_time_mns", "remind_time_mns", ccsText, "", CCGetRequestParam("remind_time_mns", $Method), $this);
            $this->remind_time_mns->DSType = dsListOfValues;
            $this->remind_time_mns->Values = array(array("00", "00"), array("05", "05"), array("10", "10"), array("15", "15"), array("20", "20"), array("25", "25"), array("30", "30"), array("35", "35"), array("40", "40"), array("45", "45"), array("50", "50"), array("55", "55"));
            $this->Button_Insert = & new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = & new clsButton("Button_Update", $Method, $this);
            $this->Button_Delete = & new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = & new clsButton("Button_Cancel", $Method, $this);
            $this->remind_time = & new clsControl(ccsHidden, "remind_time", $CCSLocales->GetText("remind_time"), ccsDate, array("HH", ":", "nn"), CCGetRequestParam("remind_time", $Method), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @159-DAA9A860
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlremind_id"] = CCGetFromGet("remind_id", "");
    }
//End Initialize Method

//Validate Method @159-F807774A
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->remind_date->Validate() && $Validation);
        $Validation = ($this->remind_time_hrs->Validate() && $Validation);
        $Validation = ($this->remind_time_mns->Validate() && $Validation);
        $Validation = ($this->remind_time->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->remind_date->Errors->Count() == 0);
        $Validation =  $Validation && ($this->remind_time_hrs->Errors->Count() == 0);
        $Validation =  $Validation && ($this->remind_time_mns->Errors->Count() == 0);
        $Validation =  $Validation && ($this->remind_time->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @159-8BA407B4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->remind_date->Errors->Count());
        $errors = ($errors || $this->DatePicker_remind_date->Errors->Count());
        $errors = ($errors || $this->remind_time_hrs->Errors->Count());
        $errors = ($errors || $this->remind_time_mns->Errors->Count());
        $errors = ($errors || $this->remind_time->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @159-908F5B78
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
        $Redirect = "event_view.php" . "?" . CCGetQueryString("QueryString", array("ccsForm", "remind_id"));
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

//InsertRow Method @159-EC9FC33E
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->remind_date->SetValue($this->remind_date->GetValue());
        $this->DataSource->remind_time->SetValue($this->remind_time->GetValue());
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @159-04D70F92
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->remind_date->SetValue($this->remind_date->GetValue());
        $this->DataSource->remind_time->SetValue($this->remind_time->GetValue());
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @159-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @159-4C94929E
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->remind_time_hrs->Prepare();
        $this->remind_time_mns->Prepare();

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
                    $this->remind_date->SetValue($this->DataSource->remind_date->GetValue());
                    $this->remind_time->SetValue($this->DataSource->remind_time->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->remind_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DatePicker_remind_date->Errors->ToString());
            $Error = ComposeStrings($Error, $this->remind_time_hrs->Errors->ToString());
            $Error = ComposeStrings($Error, $this->remind_time_mns->Errors->ToString());
            $Error = ComposeStrings($Error, $this->remind_time->Errors->ToString());
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

        $this->remind_date->Show();
        $this->DatePicker_remind_date->Show();
        $this->remind_time_hrs->Show();
        $this->remind_time_mns->Show();
        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->remind_time->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End event_reminder Class @159-FCB6E20C

class clsevent_reminderDataSource extends clsDBcalendar {  //event_reminderDataSource Class @159-3060E6A5

//DataSource Variables @159-8564E65A
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
    var $remind_date;
    var $remind_time_hrs;
    var $remind_time_mns;
    var $remind_time;
//End DataSource Variables

//DataSourceClass_Initialize Event @159-CCBF5936
    function clsevent_reminderDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record event_reminder/Error";
        $this->Initialize();
        $this->remind_date = new clsField("remind_date", ccsDate, array("yyyy", "-", "mm", "-", "dd"));
        $this->remind_time_hrs = new clsField("remind_time_hrs", ccsText, "");
        $this->remind_time_mns = new clsField("remind_time_mns", ccsText, "");
        $this->remind_time = new clsField("remind_time", ccsDate, array("HH", ":", "nn", ":", "ss"));

    }
//End DataSourceClass_Initialize Event

//Prepare Method @159-B42421DA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlremind_id", ccsInteger, "", "", $this->Parameters["urlremind_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "remind_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @159-0E57F05B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT *  " .
        "FROM event_remind {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @159-5044D683
    function SetValues()
    {
        $this->remind_date->SetDBValue(trim($this->f("remind_date")));
        $this->remind_time->SetDBValue(trim($this->f("remind_time")));
    }
//End SetValues Method

//Insert Method @159-F4730C24
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["remind_date"] = new clsSQLParameter("ctrlremind_date", ccsDate, array("mm", "/", "dd", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd"), $this->remind_date->GetValue(), "", false, $this->ErrorBlock);
        $this->cp["remind_time"] = new clsSQLParameter("ctrlremind_time", ccsDate, array("HH", ":", "nn"), array("HH", ":", "nn", ":", "ss"), $this->remind_time->GetValue(), "", false, $this->ErrorBlock);
        $this->cp["event_id"] = new clsSQLParameter("urlevent_id", ccsInteger, "", "", CCGetFromGet("event_id", ""), "", false, $this->ErrorBlock);
        $this->cp["user_id"] = new clsSQLParameter("expr175", ccsInteger, "", "", CCGetUserID(), "", false, $this->ErrorBlock);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        if (!strlen($this->cp["remind_date"]->GetText()) and !is_bool($this->cp["remind_date"]->GetValue())) 
            $this->cp["remind_date"]->SetValue($this->remind_date->GetValue());
        if (!strlen($this->cp["remind_time"]->GetText()) and !is_bool($this->cp["remind_time"]->GetValue())) 
            $this->cp["remind_time"]->SetValue($this->remind_time->GetValue());
        if (!strlen($this->cp["event_id"]->GetText()) and !is_bool($this->cp["event_id"]->GetValue())) 
            $this->cp["event_id"]->SetText(CCGetFromGet("event_id", ""));
        if (!strlen($this->cp["user_id"]->GetText()) and !is_bool($this->cp["user_id"]->GetValue())) 
            $this->cp["user_id"]->SetValue(CCGetUserID());
        $this->SQL = "INSERT INTO event_remind ("
             . "remind_date, "
             . "remind_time, "
             . "event_id, "
             . "user_id"
             . ") VALUES ("
             . $this->ToSQL($this->cp["remind_date"]->GetDBValue(), $this->cp["remind_date"]->DataType) . ", "
             . $this->ToSQL($this->cp["remind_time"]->GetDBValue(), $this->cp["remind_time"]->DataType) . ", "
             . $this->ToSQL($this->cp["event_id"]->GetDBValue(), $this->cp["event_id"]->DataType) . ", "
             . $this->ToSQL($this->cp["user_id"]->GetDBValue(), $this->cp["user_id"]->DataType)
             . ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @159-B46E91FF
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->cp["remind_date"] = new clsSQLParameter("ctrlremind_date", ccsDate, array("mm", "/", "dd", "/", "yyyy"), array("yyyy", "-", "mm", "-", "dd"), $this->remind_date->GetValue(), "", false, $this->ErrorBlock);
        $this->cp["remind_time"] = new clsSQLParameter("ctrlremind_time", ccsDate, array(" ", "HH", ":", "nn"), array("HH", ":", "nn", ":", "ss"), $this->remind_time->GetValue(), "", false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urlremind_id", ccsInteger, "", "", CCGetFromGet("remind_id", ""), "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!strlen($this->cp["remind_date"]->GetText()) and !is_bool($this->cp["remind_date"]->GetValue())) 
            $this->cp["remind_date"]->SetValue($this->remind_date->GetValue());
        if (!strlen($this->cp["remind_time"]->GetText()) and !is_bool($this->cp["remind_time"]->GetValue())) 
            $this->cp["remind_time"]->SetValue($this->remind_time->GetValue());
        $wp->Criterion[1] = $wp->Operation(opEqual, "remind_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->SQL = "UPDATE event_remind SET "
             . "remind_date=" . $this->ToSQL($this->cp["remind_date"]->GetDBValue(), $this->cp["remind_date"]->DataType) . ", "
             . "remind_time=" . $this->ToSQL($this->cp["remind_time"]->GetDBValue(), $this->cp["remind_time"]->DataType);
        $this->SQL = CCBuildSQL($this->SQL, $Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

//Delete Method @159-7CB7372E
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM event_remind";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End event_reminderDataSource Class @159-FCB6E20C

//Include Page implementation @3-EBA5EA16
include_once(RelativePath . "/footer.php");
//End Include Page implementation

//Initialize Page @1-80A48E1C
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
$TemplateFileName = "event_view.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$PathToRoot = "./";
//End Initialize Page

//Include events file @1-B6CC3771
include("./event_view_events.php");
//End Include events file

//Initialize Objects @1-B2916D64
$DBcalendar = new clsDBcalendar();
$MainPage->Connections["calendar"] = & $DBcalendar;

// Controls
$header = & new clsheader("", "header", $MainPage);
$header->Initialize();
$vertical_menu = & new clsvertical_menu("", "vertical_menu", $MainPage);
$vertical_menu->Initialize();
$eventGrid = & new clsGrideventGrid("", $MainPage);
$hideReminders = & new clsPanel("hideReminders", $MainPage);
$active_reminders = & new clsGridactive_reminders("", $MainPage);
$event_reminder = & new clsRecordevent_reminder("", $MainPage);
$footer = & new clsfooter("", "footer", $MainPage);
$footer->Initialize();
$MainPage->header = & $header;
$MainPage->vertical_menu = & $vertical_menu;
$MainPage->eventGrid = & $eventGrid;
$MainPage->hideReminders = & $hideReminders;
$MainPage->active_reminders = & $active_reminders;
$MainPage->event_reminder = & $event_reminder;
$MainPage->footer = & $footer;
$hideReminders->AddComponent("active_reminders", $active_reminders);
$hideReminders->AddComponent("event_reminder", $event_reminder);
$eventGrid->Initialize();
$active_reminders->Initialize();
$event_reminder->Initialize();

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

//Execute Components @1-5253DC91
$header->Operations();
$vertical_menu->Operations();
$event_reminder->Operation();
$footer->Operations();
//End Execute Components

//Go to destination page @1-54F6C059
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBcalendar->close();
    header("Location: " . $Redirect);
    $header->Class_Terminate();
    unset($header);
    $vertical_menu->Class_Terminate();
    unset($vertical_menu);
    unset($eventGrid);
    unset($active_reminders);
    unset($event_reminder);
    $footer->Class_Terminate();
    unset($footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1CD04F97
$header->Show();
$vertical_menu->Show();
$eventGrid->Show();
$footer->Show();
$hideReminders->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
$main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-50CDD507
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBcalendar->close();
$header->Class_Terminate();
unset($header);
$vertical_menu->Class_Terminate();
unset($vertical_menu);
unset($eventGrid);
unset($active_reminders);
unset($event_reminder);
$footer->Class_Terminate();
unset($footer);
unset($Tpl);
//End Unload Page


?>
