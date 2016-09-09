<?php
        
//File Description @0-C2543A8E
//======================================================
//
//  This file contains the following classes:
//      class clsSQLParameters
//      class clsSQLParameter
//      class clsControl
//      class clsField
//      class clsButton
//      class clsPanel
//      class clsFileUpload
//      class clsDatePicker
//      class clsErrors
//      class clsSection
//      class clsLocaleInfo
//      class clsLocale
//      class clsLocales
//
//======================================================
//End File Description

//Constant List @0-7AB35E8C

// ------- Controls ---------------
define("ccsLabel",           1);
define("ccsLink",            2);
define("ccsTextBox",         3);
define("ccsTextArea",        4);
define("ccsListBox",         5);
define("ccsRadioButton",     6);
define("ccsButton",          7);
define("ccsCheckBox",        8);
define("ccsImage",           9);
define("ccsImageLink",       10);
define("ccsHidden",          11);
define("ccsCheckBoxList",    12);
define("ccsDatePicker",      13);
define("ccsReportLabel",     14);
define("ccsReportPageBreak", 15);

$ControlTypes = array(
  "", "Label","Link","TextBox","TextArea","ListBox","RadioButton",
  "Button","CheckBox","Image","ImageLink","Hidden","CheckBoxList",
  "ccsDatePicker", "ccsReportLabel","ccsReportPageBreak"
);


// ------- Operators --------------
define("opEqual",              1);
define("opNotEqual",           2);
define("opLessThan",           3);
define("opLessThanOrEqual",    4);
define("opGreaterThan",        5);
define("opGreaterThanOrEqual", 6);
define("opBeginsWith",         7);
define("opNotBeginsWith",      8);
define("opEndsWith",           9);
define("opNotEndsWith",        10);
define("opContains",           11);
define("opNotContains",        12);
define("opIsNull",             13);
define("opNotNull",            14);

// ------- Datasource types -------
define("dsTable",        1);
define("dsSQL",          2);
define("dsProcedure",    3);
define("dsListOfValues", 4);
define("dsEmpty",        5);

// ------- CheckBox states --------
define("ccsChecked", true);
define("ccsUnchecked", false);


//End Constant List

//CCCheckValue @0-962BACE6
function CCCheckValue($Value, $DataType)
{
  $result = false;
  if($DataType == ccsInteger)
    $result = is_int($Value); 
  else if($DataType == ccsFloat)
    $result = is_float($Value);
  else if($DataType == ccsDate)
    $result = (is_array($Value) || is_int($Value));
  else if($DataType == ccsBoolean)
    $result = is_bool($Value); 
  return $result;
}
//End CCCheckValue

//clsSQLParameters Class @0-E07CF993

class clsSQLParameters
{
  
  var $Connection;
  var $Criterion;
  var $AssembledWhere;
  var $Errors;
  var $DataSource;
  var $AllParametersSet;
  var $ErrorBlock;

  var $Parameters1;

  function clsSQLParameters($ErrorBlock = "")
  {
    $this->ErrorBlock = $ErrorBlock;
  }

  function SetParameters($Name, $NewParameter)
  {
    $this->Parameters[$Name] = $NewParameter;
  }

  function AddParameter($ParameterID, $ParameterSource, $DataType, $Format, $DBFormat, $InitValue, $DefaultValue, $UseIsNull = false)
  {
    $this->Parameters[$ParameterID] = new clsSQLParameter($ParameterSource, $DataType, $Format, $DBFormat, $InitValue, $DefaultValue, $UseIsNull, $this->ErrorBlock);
  }

  function AllParamsSet()
  {
    $blnResult = true;

    if(isset($this->Parameters) && is_array($this->Parameters))
    {
      reset($this->Parameters);
      while ($blnResult && list ($key, $Parameter) = each ($this->Parameters)) 
      {
        if($Parameter->GetValue() === "" && $Parameter->GetValue() !== false && $Parameter->UseIsNull === false)
          $blnResult = false;
      }
    }
     return $blnResult;
  }

  function GetDBValue($ParameterID)
  {
    return $this->Parameters[$ParameterID]->GetDBValue();
  }

  function opAND($Brackets, $strLeft, $strRight)
  {
    $strResult = "";
    if (strlen($strLeft))
    {
      if (strlen($strRight)) 
      {
        $strResult = $strLeft . " AND " . $strRight;
        if ($Brackets) 
          $strResult = " (" . $strResult . ") ";
      }
      else
      {
        $strResult = $strLeft;
      }
    }
    else
    {
      if (strlen($strRight)) 
        $strResult = $strRight;
    }
    return $strResult;
  }

  function opOR($Brackets, $strLeft, $strRight)
  {
    $strResult = "";
    if (strlen($strLeft))
    {
      if (strlen($strRight))
      {
        $strResult = $strLeft . " OR " . $strRight;
        if ($Brackets) 
          $strResult = " (" . $strResult . ") ";
      }
      else
      {
        $strResult = $strLeft;
      }
    }
    else
    {
      if (strlen($strRight))
        $strResult = $strRight;
    }
    return $strResult;
  }

  function Operation($Operation, $FieldName, $DBValue, $SQLText, $UseIsNull = false)
  {
    $Result = "";

    if(strlen($DBValue) || $DBValue === false)
    {
      $SQLValue = $SQLText;
      if(CCSubStr($SQLValue, 0, 1) == "'")
        $SQLValue = CCSubStr($SQLValue, 1, CCStrLen($SQLValue) - 2);

      switch ($Operation)
      {
        case opEqual:
          $Result = $FieldName . " = " . $SQLText;
          break;
        case opNotEqual:
          $Result = $FieldName . " <> " . $SQLText;
          break;
        case opLessThan:
          $Result = $FieldName . " < " . $SQLText;
          break;
        case opLessThanOrEqual:
          $Result = $FieldName . " <= " . $SQLText;
          break;
        case opGreaterThan:
          $Result = $FieldName . " > " . $SQLText;
          break;
        case opGreaterThanOrEqual:
          $Result = $FieldName . " >= " . $SQLText;
          break;                                
        case opBeginsWith:
          $Result = $FieldName . " like '" . $SQLValue . "%'";
          break;
        case opNotBeginsWith:
          $Result = $FieldName . " not like '" . $SQLValue . "%'";
          break;
        case opEndsWith:
          $Result = $FieldName . " like '%" . $SQLValue . "'";
          break;
        case opNotEndsWith:
          $Result = $FieldName . " not like '%" . $SQLValue . "'";
          break;
        case opContains:
          $Result = $FieldName . " like '%" . $SQLValue . "%'";
          break;
        case opNotContains:
          $Result = $FieldName . " not like '%" . $SQLValue . "%'";
          break;
        case opIsNull:
          $Result = $FieldName . " IS NULL";
          break;
        case opNotNull:
          $Result = $FieldName . " IS NOT NULL";
          break;
      }
    } 
    else if ($UseIsNull) 
    {
      switch ($Operation)
      {
        case opEqual:
        case opLessThan:
        case opLessThanOrEqual:
        case opGreaterThan:
        case opGreaterThanOrEqual:
        case opBeginsWith:
        case opEndsWith:
        case opContains:
        case opIsNull:
          $Result = $FieldName . " IS NULL";
          break;
        case opNotEqual:
        case opNotEndsWith:
        case opNotBeginsWith:
        case opNotContains:
        case opNotNull:
          $Result = $FieldName . " IS NOT NULL";
          break;
      }

    }

    return $Result;
  }
}
//End clsSQLParameters Class

//clsSQLParameter Class @0-DED5245E
class clsSQLParameter
{
  var $Errors;
  var $DataType;
  var $Format;
  var $DBFormat;
  var $Link;
  var $Caption;
  var $ErrorBlock;
  var $UseIsNull;

  var $Value;
  var $DBValue;
  var $Text;
  

  function clsSQLParameter($ParameterSource, $DataType, $Format, $DBFormat, $InitValue, $DefaultValue, $UseIsNull = false, $ErrorBlock = "")
  {
    $this->Errors = new clsErrors();
    $this->ErrorBlock = $ErrorBlock;
    $this->UseIsNull = $UseIsNull;

    $this->Caption = $ParameterSource;
    $this->DataType = $DataType;
    $this->Format = $Format;
    $this->DBFormat = $DBFormat;
    if(is_array($InitValue) && $DataType != ccsDate)
      $this->SetText(join(",", $InitValue));
    else if(is_array($InitValue) || strlen($InitValue))
      $this->SetText($InitValue);
    else
      $this->SetText($DefaultValue);
  }

  function GetParsedValue($ParsingValue, $Format)
  {
    global $Tpl;
    global $CCSLocales;
    $varResult = "";

    if (strlen($ParsingValue))
    {
      switch ($this->DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($ParsingValue, $Format)) {
            $varResult = CCParseDate($ParsingValue, $Format);
            if(!$varResult || !CCValidateDate($varResult))
            {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if(!$DateValidation) {
            if (is_array($Format)) {
              $FormatString = join("", $Format);
            } else {
              $FormatString = $Format;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($ParsingValue, $Format))
            $varResult = CCParseBoolean($ParsingValue, $Format);
          else
          {
            if (is_array($Format)) {
              $FormatString = CCGetBooleanFormat($Format);;
            } else {
              $FormatString = $Format;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));
          }
          break;
        case ccsInteger:
          if (CCValidateNumber($ParsingValue, $Format))
            $varResult = CCParseInteger($ParsingValue, $Format);
          else
          {
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          }
          break;
        case ccsFloat:
          if (CCValidateNumber($ParsingValue, $Format) )
            $varResult = CCParseFloat($ParsingValue, $Format);
          else 
          {
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          }
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($ParsingValue);
          break;
      }
      if($this->Errors->Count() > 0)
      {
        if(strlen($this->ErrorBlock))
          $Tpl->replaceblock($this->ErrorBlock, $this->Errors->ToString());
        else
          echo $this->Errors->ToString();
      }
    }

    return $varResult;
  }

  function GetFormattedValue($Format)
  {
    $strResult = "";
    switch($this->DataType)
    {
      case ccsDate:
        $strResult = CCFormatDate($this->Value, $Format);
        break;
      case ccsBoolean:
        $strResult = CCFormatBoolean($this->Value, $Format);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $strResult = CCFormatNumber($this->Value, $Format, $this->DataType);
        break;
      case ccsText:
      case ccsMemo:
        $strResult = strval($this->Value);
        break;
    }
    return $strResult;
  }

  function SetValue($Value)
  {
    $this->Value = $Value;
    $this->Text = $this->GetFormattedValue($this->Format);
    $this->DBValue = $this->GetFormattedValue($this->DBFormat);
  }

  function SetText($Text)
  {
    if(CCCheckValue($Text, $this->DataType)) {
      $this->SetValue($Text);
    } else {
      $this->Text = $Text;
      $this->Value = $this->GetParsedValue($this->Text, $this->Format);
      $this->DBValue = $this->GetFormattedValue($this->DBFormat);
    }
  }

  function SetDBValue($DBValue)
  {
    $this->DBValue = $DBValue;
    $this->Value = $this->GetParsedValue($this->DBValue, $this->DBFormat);
    $this->Text = $this->GetFormattedValue($this->Format);
  }

  function GetValue()
  {
    return $this->Value;
  }

  function GetText()
  {
    return $this->Text;
  }

  function GetDBValue()
  {
    return $this->DBValue;
  }

}

//End clsSQLParameter Class

//clsControl Class @0-E8774A2A
class clsControl
{
  var $ComponentType = "Control";
  var $Errors;
  var $DataType;
  var $DSType;
  var $Format;
  var $DBFormat;
  var $Caption;
  var $ControlType;
  var $ControlTypeName;
  var $Name;
  var $BlockName;
  var $HTML;
  var $Required;
  var $CheckedValue;
  var $UncheckedValue;
  var $State;
  var $BoundColumn;
  var $TextColumn;
  var $Multiple;
  var $Visible;

  var $Page;
  var $Parameters;

  var $CountValue;
  var $SumValue;
  var $ValueRelative;
  var $CountValueRelative;
  var $SumValueRelative;
  var $TotalFunction;
  var $IsPercent = false;
  var $IsEmptySource = false;

  var $isInternal = false;
  var $initialValue;
  var $prevItem = false;

  var $prevValue;
  var $prevCountValue;
  var $prevSumValue;
  var $prevValueRelative;
  var $prevCountValueRelative;
  var $prevSumValueRelative;


  var $Value;
  var $Text;
  var $EmptyText;
  var $Values;

  var $CCSEvents;
  var $CCSEventResult;

  var $Parent;


  function clsControl($ControlType, $Name, $Caption, $DataType, $Format, $InitValue = "", & $Parent)
  {
    global $ControlTypes;

    $this->Value = "";
    $this->Text = "";
    $this->Page = "";
    $this->Parameters = "";
    $this->CCSEvents = "";
    $this->Values = "";
    $this->BoundColumn = "";
    $this->TextColumn = "";
    $this->Visible = true;

    $this->Required = false;
    $this->HTML = false;
    $this->Multiple = false;

    $this->Errors = new clsErrors();

    $this->Name = $Name;
    $this->BlockName = $ControlTypes[$ControlType] . " " . $Name;
    $this->ControlType = $ControlType;
    $this->DataType = $DataType;
    $this->DSType = dsEmpty;
    $this->Format = $Format;
    $this->Caption = $Caption;
    if(is_array($InitValue))
      $this->Value = $InitValue;
    else if(strlen($InitValue))
      $this->SetText($InitValue);
    $this->Parent = & $Parent;
    $this->ComponentType = $ControlTypes[$ControlType];
  }

  function Validate()
  {
    global $CCSLocales;
    $validation = true;
    if($this->Required && $this->Value === "" && $this->Errors->Count() == 0)
    {
      $FieldName = strlen($this->Caption) ? $this->Caption : $this->Name;
      $this->Errors->addError($CCSLocales->GetText('CCS_RequiredField', $this->Caption));
    }
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    return ($this->Errors->Count() == 0);
  }

  function GetParsedValue($ParsingValue)
  {
    global $CCSLocales;
    $varResult = "";
    if($this->Multiple && is_array($ParsingValue)) {
      $ParsingValue = $ParsingValue[0];
    }
    if(CCCheckValue($ParsingValue, $this->DataType))
      $varResult = $ParsingValue;
    else if(strlen($ParsingValue))
    {
      switch ($this->DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($ParsingValue, $this->Format)) {
            $varResult = CCParseDate($ParsingValue, $this->Format);
            if(!$varResult || !CCValidateDate($varResult))
            {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if(!$DateValidation && $this->Errors->Count() == 0)
          {
            if (is_array($this->Format)) {
              $FormatString = join("", $this->Format);
            } else {
              $FormatString = $this->Format;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($ParsingValue, $this->Format))
            $varResult = CCParseBoolean($ParsingValue, $this->Format);
          else if($this->Errors->Count() == 0) {
            if (is_array($this->Format)) {
              $FormatString = CCGetBooleanFormat($this->Format);
            } else {
              $FormatString = $this->Format;
            }
              $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));          }
          break;
        case ccsInteger:
          if (CCValidateNumber($ParsingValue, $this->Format))
            $varResult = CCParseInteger($ParsingValue, $this->Format);
          else if($this->Errors->Count() == 0)
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          break;
        case ccsFloat:
          if (CCValidateNumber($ParsingValue, $this->Format))
            $varResult = CCParseFloat($ParsingValue, $this->Format);
          else if($this->Errors->Count() == 0)
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($ParsingValue);
          break;
      }
    }

    return $varResult;
  }

  function GetFormattedValue()
  {
    $strResult = "";
    switch($this->DataType)
    {
      case ccsDate:
        $strResult = CCFormatDate($this->Value, $this->Format);
        break;
      case ccsBoolean:
        $strResult = CCFormatBoolean($this->Value, $this->Format);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $strResult = CCFormatNumber($this->Value, $this->Format, $this->DataType);
        break;
      case ccsText:
      case ccsMemo:
        $strResult = strval($this->Value);
        break;
    }
    return $strResult;
  }

  function Prepare()
  {
    if($this->DSType == dsTable || $this->DSType == dsSQL || $this->DSType == dsProcedure)
    {
      if(!isset($this->DataSource->CCSEvents)) $this->DataSource->CCSEvents = "";
      if(!strlen($this->BoundColumn)) $this->BoundColumn = 0;
      if(!strlen($this->TextColumn)) $this->TextColumn = 1;
      $this->EventResult = CCGetEvent($this->DataSource->CCSEvents, "BeforeBuildSelect", $this);
      $this->EventResult = CCGetEvent($this->DataSource->CCSEvents, "BeforeExecuteSelect", $this);
      $FieldName = strlen($this->Caption) ? $this->Caption : $this->Name;
      list($this->Values, $this->Errors) = CCGetListValues($this->DataSource, $this->DataSource->SQL, $this->DataSource->Where, $this->DataSource->Order, $this->BoundColumn, $this->TextColumn, $this->DBFormat, $this->DataType, $this->Errors, $FieldName);
      $this->DataSource->close();
      $this->EventResult = CCGetEvent($this->DataSource->CCSEvents, "AfterExecuteSelect", $this);
    }
  }

  function Show($RowNumber = "")
  {
    global $Tpl;
    $this->EventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);

    $ControlName = ($RowNumber === "") ? $this->Name : $this->Name . "_" . $RowNumber;
    if($this->Multiple) $ControlName = $ControlName . "[]";

    if(!$this->Visible) {
      $Tpl->SetVar($this->Name . "_Name", $ControlName);
      $Tpl->SetVar($this->Name, "");
      if($Tpl->BlockExists($this->BlockName))
        $Tpl->setblockvar($this->BlockName, "");
      return;
    }

    $Tpl->SetVar($this->Name . "_Name", $ControlName);
    switch($this->ControlType)
    {
      case ccsLabel:
        $value=$this->GetText();
        if (!$this->HTML) {
          $value = CCToHTML($value);
          $value = str_replace("\n", "<BR>", $value);
        }
        $Tpl->SetVar($this->Name, $value);
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsReportLabel:
        $value=$this->GetText();
        if (strlen($this->EmptyText) && !strlen($value))
          $value = $this->EmptyText;
        if (!$this->HTML) {
          $value = CCToHTML($value);
          $value = str_replace("\n", "<BR>", $value);
        }
        $Tpl->SetVar($this->Name, $value);
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsTextBox:
      case ccsTextArea:
      case ccsImage:
      case ccsHidden:
        $Tpl->SetVar($this->Name, CCToHTML($this->GetText()));
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsLink:
        if ($this->HTML)
          $Tpl->SetVar($this->Name, $this->GetText());
        else {
          $value = CCToHTML($this->GetText());
          $value = str_replace("\n", "<BR>", $value);
          $Tpl->SetVar($this->Name, $value);
        }
        $Tpl->SetVar($this->Name . "_Src", $this->GetLink());
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsImageLink:
        $Tpl->SetVar($this->Name . "_Src", CCToHTML($this->GetText()));
        $Tpl->SetVar($this->Name, $this->GetLink());
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsCheckBox:
        if($this->Value)
          $Tpl->SetVar($this->Name, "CHECKED");
        else
          $Tpl->SetVar($this->Name, "");
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsRadioButton:
        $BlockToParse = "RadioButton " . $this->Name;
        $Tpl->SetBlockVar($BlockToParse, "");
        if(is_array($this->Values))
        {
          for($i = 0; $i < sizeof($this->Values); $i++)
          {
            $Value = $this->Values[$i][0];
            $Text = $this->HTML ? $this->Values[$i][1] : CCToHTML($this->Values[$i][1]);
            $Selected = (CCCompareValues($Value,$this->Value, $this->DataType, $this->Format) == 0) ? " CHECKED" : "";
            $TextValue = CCToHTML(CCFormatValue($Value, $this->Format, $this->DataType, $this->Format));
            $Tpl->SetVar("Value", $TextValue);
            $Tpl->SetVar("Check", $Selected);
            $Tpl->SetVar("Description", $Text);
            $Tpl->Parse($BlockToParse, true);
          }
        }
        break;
      case ccsCheckBoxList:
        $BlockToParse = "CheckBoxList " . $this->Name;
        $Tpl->SetBlockVar($BlockToParse, "");
        if(is_array($this->Values))
        {
          for($i = 0; $i < sizeof($this->Values); $i++)
          {
            $Value = $this->Values[$i][0];
            $TextValue = CCToHTML(CCFormatValue($Value, $this->Format, $this->DataType));
            $Text = $this->HTML ? $this->Values[$i][1] : CCToHTML($this->Values[$i][1]);
	    if ($this->Multiple && is_array($this->Value)) {
              $Selected = "";
              foreach ($this->Value as $Val) {
                if (CCCompareValues($Value,$Val, $this->DataType, $this->Format) == 0) {
                  $Selected = " CHECKED";
                  break;  
                }
              }
	    } else {
              $Selected = (CCCompareValues($Value,$this->Value, $this->DataType, $this->Format) == 0) ? " CHECKED" : "";
            }
            $Tpl->SetVar("Value", $TextValue);
            $Tpl->SetVar("Check", $Selected);
            $Tpl->SetVar("Description", $Text);
            $Tpl->Parse($BlockToParse, true);
          }
        }
        break;
      case ccsListBox:
        $Options = "";
        if(is_array($this->Values))
        {
          for($i = 0; $i < sizeof($this->Values); $i++)
          {
            $Value = $this->Values[$i][0];
            $TextValue = CCToHTML(CCFormatValue($Value, $this->Format, $this->DataType));
            $Text = CCToHTML($this->Values[$i][1]);
	    if ($this->Multiple && is_array($this->Value)) {
              $Selected = "";
              foreach ($this->Value as $Val) {
                if (CCCompareValues($Value,$Val, $this->DataType, $this->Format) == 0) {
                  $Selected = " SELECTED";
                  break;  
                }
              }
	    } else {
              $Selected = (CCCompareValues($Value,$this->Value, $this->DataType, $this->Format) == 0) ? " SELECTED" : "";
            }
            $Options .= "<OPTION VALUE=\"" . $TextValue . "\"" . $Selected . ">" . $Text . "</OPTION>\n";
          }
        }
        $Tpl->SetVar($this->Name . "_Options", $Options);
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsPageBreak:
          $Tpl->SetVar($this->Name, $this->Text);

    }
  }

  function SetValue($Value)
  {
    if($this->ControlType == ccsCheckBox)
      $this->Value = CCCompareValues($Value, $this->CheckedValue, $this->DataType) == 0 || (CCCompareValues($Value, $this->UncheckedValue, $this->DataType) != 0 && (is_array($Value) || strlen($Value))) ? true : false;
    else
      $this->Value = $Value;
    $this->Text = $this->GetFormattedValue();
    if (!$this->isInternal) 
      $this->initialValue = $this->Value;
  }

  function SetText($Text, $RowNumber = "")
  {
    $ControlName = ($RowNumber === "") ? $this->Name : $this->Name . "_" . $RowNumber;
    if(CCCheckValue($Text, $this->DataType)) {
      $this->SetValue($Text);
    } else {
      $this->Text = $Text;
      if($this->ControlType == ccsCheckBox) {
        $RequestParameter = CCGetParam($ControlName);
        if (strlen($Text) && strlen($RequestParameter) && $Text == $RequestParameter) {
          $this->Value = true;
        } else {
          $Value = $this->GetParsedValue($this->Text);
          $this->SetValue($Value);
        }

      } else {
        $this->Value = $this->GetParsedValue($this->Text);
        if (!$this->isInternal) 
          $this->initialValue = $this->Value;
      }
    }
  }

  function GetValue()
  {
    if($this->ControlType == ccsCheckBox)
      $value = ($this->Value) ? $this->CheckedValue : $this->UncheckedValue;
    else if($this->Multiple && is_array($this->Value))
      $value = $this->Value[0];
    else
      $value = $this->Value;

    return $value;
  }

  function GetText()
  {
    if(!strlen($this->Text))
      $this->Text = $this->GetFormattedValue();
    return $this->Text;
  }

  function GetLink()
  {
    if(CCSubStr($this->Page, 0, 2) == "./")
      return CCSubStr($this->Page, 2);
    if($this->Parameters == "")
      return $this->Page;
    else
      return $this->Page . "?" . $this->Parameters;
  }

  function SetLink($Link)
  {
    if(!strlen($Link))
    {
      $this->Page = "";
      $this->Parameters = "";
    }
    else
    {
      $LinkParts = explode("?", $Link);
      $this->Page = $LinkParts[0];
      $this->Parameters = (sizeof($LinkParts) == 2) ? $LinkParts[1] : "";
    }
  }

  function GetTotalValue($mode) 
  {
    if ($mode == "GetPrevValue") {
      if ($this->TotalFunction == "Count")
        $this->prevValue += 0;
      $this->Value = $this->prevValue;
      return $this->Value;      
    }
    if ($mode == "GetNextValue" && $this->TotalFunction) {
      if ($this->TotalFunction == "Count")
        $this->prevValue += 0;
      $this->Value = $this->prevValue;
      return $this->Value;      
    }

    $this->Value = $this->initialValue;

    $newVal = $this->prevValue;
    switch ($this->TotalFunction) {
      case "Sum":
        if (strval($this->Value) == "" && strval($this->prevValue) == "")
          break;
        $newVal = $this->Value + $this->prevValue;
        if ($this->IsPercent && (strval($this->Value) != "" || strval($this->prevValueRelative) != ""))
          $this->ValueRelative = $this->Value + $this->prevValueRelative;
        break;
      case "Count":
        $newVal = $this->prevValue + ($this->IsEmptySource || ($this->DataType == ccsBoolean && is_bool($this->Value)) || ($this->DataType == ccsDate  && CCValidateDate($this->Value)) || strval($this->Value) != "" ? 1 : 0);
        if ($this->IsPercent)
          $this->ValueRelative = $this->prevValueRelative + ($this->IsEmptySource || ($this->DataType == ccsBoolean && is_bool($this->Value)) || ($this->DataType == ccsDate  && CCValidateDate($this->Value)) || strval($this->Value) != "" ? 1 : 0);
        break;
      case "Min":
        if (strval($this->Value) == "") 
          break;
        $newVal = strval($this->prevValue) == "" ? $this->Value : min($this->Value,$this->prevValue);
        if ($this->IsPercent)
          $this->ValueRelative = strval($this->prevValueRelative) == "" ? $this->Value : min($this->Value,$this->prevValueRelative);
        break;
      case "Max":
        if (strval($this->Value) == "") 
          break;
        $newVal = strval($this->prevValue) == "" ? $this->Value : max($this->Value,$this->prevValue);
        if ($this->IsPercent)
          $this->ValueRelative = strval($this->prevValueRelative) == "" ? $this->Value : max($this->Value,$this->prevValueRelative);
        break;
      case "Avg":
        if (strval($this->Value) != "") { 
          $this->CountValue = $this->prevCountValue + 1;
          $this->SumValue = $this->prevSumValue + $this->Value;
        }
        if ($this->CountValue == 0) 
          $newVal = $this->prevValue;
        else
          $newVal = $this->SumValue / $this->CountValue;
        if ($this->IsPercent) { 
          if (strval($this->Value) !="") { 
            $this->CountValueRelative = $this->prevCountValueRelative + 1;
            $this->SumValueRelative = $this->prevSumValueRelative + $this->Value;
          }
          if ($this->CountValueRelative == 0)
            $this->ValueRelative = $this->prevValueRelative;
          else
            $this->ValueRelative = $this->SumValueRelative / $this->CountValueRelative;
        }
        break;
      default: 
        if ($mode == "" && $this->IsPercent && (strval($this->Value) != "" || strval($this->prevValueRelative) != "")) {
          $this->ValueRelative = $this->Value + $this->prevValueRelative;
        }
        $newVal = $this->Value;
    }
    $this->Value = $newVal;
    if ($mode == "GetNextValue") {
      return $this->Value;
    }
    $this->prevValueRelative = $this->ValueRelative;
    $this->prevValue = $newVal;
    $this->prevCountValue = $this->CountValue;
    $this->prevSumValue = $this->SumValue;
    $this->prevCountValueRelative = $this->CountValueRelative;
    $this->prevSumValueRelative = $this->SumValueRelative;
    return $this->Value;
  }

  function Reset() 
  {
    $this->Value = "";
    $this->CountValue = "";
    $this->SumValue = "";
    $this->prevValue = "";
    $this->prevCountValue = "";
    $this->prevSumValue = "";
  }

  function ResetRelativeValues() 
  {
    $this->ValueRelative = $this->initialValue;
    $this->prevValueRelative = "";
    $this->CountValueRelative = "";
    $this->SumValueRelative = "";
    $this->prevCountValueRelative = "";
    $this->prevSumValueRelative = "";
  }


}

//End clsControl Class

//clsField Class @0-85C01F37
class clsField
{
  var $DataType;
  var $DBFormat;
  var $Name;
  var $Errors;

  var $Value;
  var $DBValue;

  function clsField($Name, $DataType, $DBFormat)
  {
    $this->Value = "";
    $this->DBValue = "";

    $this->Name = $Name;
    $this->DataType = $DataType;
    $this->DBFormat = $DBFormat;

    $this->Errors = new clsErrors;
  }

  function GetParsedValue()
  {
    global $CCSLocales;
    $varResult = "";

    if (strlen($this->DBValue))
    {
      switch ($this->DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($this->DBValue, $this->DBFormat)) {
            $varResult = CCParseDate($this->DBValue, $this->DBFormat);
            if(!$varResult || !CCValidateDate($varResult)) {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if (!$DateValidation)
          {
            if (is_array($this->DBFormat)) {
              $FormatString = join("", $this->DBFormat);
            } else {
              $FormatString = $this->DBFormat;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($this->DBValue, $this->DBFormat)) {
            $varResult = CCParseBoolean($this->DBValue, $this->DBFormat);
          } else {
            if (is_array($this->DBFormat)) {
              $FormatString = CCGetBooleanFormat($this->DBFormat);
            } else {
              $FormatString = $this->DBFormat;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $FormatString)));
          }
          break;
        case ccsInteger:
          if (CCValidateNumber($this->DBValue, $this->DBFormat))
            $varResult = CCParseInteger($this->DBValue, $this->DBFormat);
          else 
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $this->DBFormat)));
          break;
        case ccsFloat:
          if (CCValidateNumber($this->DBValue, $this->DBFormat) )
            $varResult = CCParseFloat($this->DBValue, $this->DBFormat);
          else 
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $this->DBFormat)));
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($this->DBValue);
          break;
      }
    }

    return $varResult;
  }

  function GetFormattedValue()
  {
    $strResult = "";
    switch($this->DataType)
    {
      case ccsDate:
        $strResult = CCFormatDate($this->Value, $this->DBFormat);
        break;
      case ccsBoolean:
        $strResult = CCFormatBoolean($this->Value, $this->DBFormat);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $strResult = CCFormatNumber($this->Value, $this->DBFormat, $this->DataType);
        break;
      case ccsText:
      case ccsMemo:
        $strResult = strval($this->Value);
        break;
    }
    return $strResult;
  }

  function SetDBValue($DBValue)
  {
    $this->DBValue = $DBValue;
    $this->Value = $this->GetParsedValue();
  }

  function SetValue($Value)
  {
    $this->Value = $Value;
    $this->DBValue = $this->GetFormattedValue();
  }

  function GetValue()
  {
    return $this->Value;
  }

  function GetDBValue()
  {
    return $this->DBValue;
  }
}

//End clsField Class

//clsButton Class @0-7F6737AA
class clsButton
{
  var $ComponentType = "Button";
  var $Name;
  var $Visible;
  var $Pressed;

  var $CCSEvents = "";
  var $CCSEventResult;

  var $Parent;

  function clsButton($Name, $Method, & $Parent)
  {
    $this->Name    = $Name;
    $this->Visible = true;
    $this->Parent  = & $Parent;
    $this->Pressed = CCGetRequestParam($Name, $Method) != "" || CCGetRequestParam($Name . "_x", $Method) != "";
  }

  function Show($RowNumber = "")
  {
    global $Tpl;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if($this->Visible)
    {
      $ControlName = ($RowNumber === "") ? $this->Name : $this->Name . "_" . $RowNumber;
      $Tpl->SetVar("Button_Name", $ControlName);
      $Tpl->Parse("Button " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("Button " . $this->Name, "");
    }
  }

}

//End clsButton Class

//clsPanel Class @0-907E6F12
class clsPanel
{
  var $ComponentType = "Panel";
  var $Name;
  var $Visible;
  var $Components = array();
  var $ComponentsArray = array();

  var $CCSEvents = "";
  var $CCSEventResult;

  var $Parent;

  function clsPanel($Name, & $Parent)
  {
    $this->Name = $Name;
    $this->Visible = true;
    $this->Parent = & $Parent;
  }
  
  function AddComponent($Name, &$Component){
    $this->Components[$Name] = & $Component;
    $this->ComponentsArray[] = & $Component;
  }

  function Show($RowNumber = "")
  {
    global $Tpl;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if($this->Visible)
    {
      $ControlName = $this->Name;
      $ParentPath = $Tpl->block_path;
      $PanelPath = $ParentPath . "/Panel " . $ControlName;
      $Tpl->block_path =  $PanelPath;
      foreach($this->ComponentsArray as $num => $Component){
        if(strlen($RowNumber)) 
          $this->ComponentsArray[$num]->Show($RowNumber);
        else      
          $this->ComponentsArray[$num]->Show();
      }
      $Tpl->block_path = $ParentPath;
      $Tpl->Parse("Panel " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("Panel " . $this->Name, "");
    }
  }

}

//End clsPanel Class

//clsFileUpload Class @0-FA0733E9
class clsFileUpload
{
  var $ComponentType = "FileUpload";
  var $Name;
  var $Caption;
  var $Visible;
  var $Required;

  var $TemporaryFolder;
  var $FileFolder;
  var $AllowedMask; // @deprecated , use AllowedFileMasks property
  var $AllowedFileMasks;
  var $DisallowedFileMasks;
  var $FileSizeLimit;
  var $Value;
  var $Text;
  var $State;

  var $CCSEvents = "";
  var $CCSEventResult;

  var $Parent;

  function clsFileUpload($Name, $Caption, $TemporaryFolder, $FileFolder, $AllowedFileMasks, $DisallowedFileMasks, $FileSizeLimit, & $Parent)
  {
    global $CCSLocales;

    $this->Errors = new clsErrors;

    $this->Name            = $Name;
    $this->Visible         = true;
    $this->Caption         = $Caption;
    $this->Parent          = & $Parent;
    if(CCSubStr($TemporaryFolder, 0, 1) == "%") {
      $TemporaryFolder = CCSubStr($TemporaryFolder, 1);
      $TemporaryFolder = isset($_ENV[$TemporaryFolder]) ? $_ENV[$TemporaryFolder] : "";
    }
    $this->TemporaryFolder = $TemporaryFolder;
    if(CCSubStr($FileFolder, 0, 1) == "%") {
      $FileFolder = CCSubStr($FileFolder, 1);
      $FileFolder = isset($_ENV[$FileFolder]) ? $_ENV[$FileFolder] : "";
    }
    $this->FileFolder          = $FileFolder;
    $this->AllowedFileMasks    = $AllowedFileMasks;
    $this->AllowedMask         = & $this->AllowedFileMasks; 
    $this->DisallowedFileMasks = $DisallowedFileMasks;
    $this->FileSizeLimit       = $FileSizeLimit;
    $this->Value               = "";
    $this->Text                = "";
    $this->Required            = false;

    $FileName = "";
    $FieldName = $this->Caption;
    if( !is_dir($TemporaryFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_TempFolderNotFound', $this->Caption));
    } else if( !is_writable($TemporaryFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_TempInsufficientPermissions', $this->Caption));
    } else if( !is_dir($FileFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_FilesFolderNotFound', $this->Caption));
    } else if( !is_writable($FileFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_InsufficientPermissions', $this->Caption));
    } 

  }

  function Validate()
  {
    global $CCSLocales;
    $validation = true;
    if($this->Required && $this->Value === "" && $this->Errors->Count() == 0)
    {
      $FieldName = $this->Caption;
      $this->Errors->addError($CCSLocales->GetText('CCS_RequiredFieldUpload', $this->Caption));
    }
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    return ($this->Errors->Count() == 0);
  }


  function Upload($RowNumber = "")
  {
    global $CCSLocales;
    global $TemplateEncoding;
    global $FileEncoding;
    global $CCSLocales;
     

    $FieldName = $this->Caption;
    if(strlen($RowNumber)) {
      $ControlName = $this->Name . "_" . $RowNumber;
      $FileControl = $this->Name . "_File_" . $RowNumber;
      $DeleteControl = $this->Name . "_Delete_" . $RowNumber;
    } else {
      $ControlName = $this->Name;
      $FileControl = $this->Name . "_File";
      $DeleteControl = $this->Name . "_Delete";
    }

    $SessionName = CCGetParam($ControlName);
    $this->State = CCGetSession($SessionName);

    if (strlen(CCGetParam($DeleteControl))) { 
      // delete file from folder
      $ActualFileName = $this->State[0];
      if( file_exists($this->FileFolder . $ActualFileName) ) {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
        unlink($this->FileFolder . $ActualFileName);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
      } else if ( file_exists($this->TemporaryFolder . $ActualFileName) ) {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
        unlink($this->TemporaryFolder . $ActualFileName);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
      }
      $this->Value = ""; $this->Text = "";
      $this->State[0] = "";
    } else if (isset ($_FILES[$FileControl]) 
        && $_FILES[$FileControl]["tmp_name"] != "none" 
        && strlen ($_FILES[$FileControl]["tmp_name"])) {
      $this->Value = ""; $this->Text = "";
      $FileName = CCConvertEncoding(CCStrip($_FILES[$FileControl]["name"]), $CCSLocales->GetFormatInfo("Encoding"), $FileEncoding);
      $GoodFileMask = 1;
      $meta_characters = array("*" => ".+", "?" => ".", "\\" => "\\\\", "^" => "\\^", "\$" => "\\\$", "." => "\\.", "[" => "\\[", "]" => "\\]", "|" => "\\|", "(" => "\\(", ")" => "\\)", "{" => "\\{", "}" => "\\}", "+" => "\\+", "-" => "\\-");
      if ($this->AllowedFileMasks != "") {
        $GoodFileMask = 0;
        $FileMasks=explode(';', $this->AllowedFileMasks);
        foreach ($FileMasks as $FileMask) {
          $FileMask = preg_replace("/(\\*|\\?|\\\\|\\^|\\\$|\\.|\\[|\\]|\\||\\(|\\)|\\{|\\}|\\+|\\-)/ei", "\$meta_characters['\\1']", $FileMask);
          if (preg_match("/^$FileMask$/i", $FileName)) {
            $GoodFileMask = 1;
            break;
          }
        }
      }


      if ($GoodFileMask && $this->DisallowedFileMasks != "") {
        $FileMasks=explode(';', $this->DisallowedFileMasks);
        foreach ($FileMasks as $FileMask) {
          $FileMask = preg_replace("/(\\*|\\?|\\\\|\\^|\\\$|\\.|\\[|\\]|\\||\\(|\\)|\\{|\\}|\\+|\\-)/ei", "\$meta_characters['\\1']", $FileMask);
          if (preg_match("/^$FileMask$/i", $FileName)) {
            $GoodFileMask = 0;
            break;
          }
        }
      }
      if($_FILES[$FileControl]["size"] > $this->FileSizeLimit) {
      $this->Errors->addError($CCSLocales->GetText('CCS_LargeFile', $this->Caption));
      } else if (!$GoodFileMask) {
      $this->Errors->addError($CCSLocales->GetText('CCS_WrongType', $this->Caption));
      } else {
        // move uploaded file to temporary folder
        $file_exists = true;
        $index = 0;
        while($file_exists) {
          $ActualFileName = date("YmdHis") . $index . "." . $FileName;
          $file_exists = file_exists($ActualFileName);
          $index++;
        }
        if( move_uploaded_file($_FILES[$FileControl]["tmp_name"], $this->TemporaryFolder . $ActualFileName) ) {
          $this->Value = $ActualFileName;
          $this->Text = $ActualFileName;
          if(strlen($this->State[0])) {
            if(file_exists($this->TemporaryFolder . $this->State[0])) {
              $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
              unlink($this->TemporaryFolder . $this->State[0]);
              $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
              $this->State[0] = $ActualFileName;
            } else {
              if(!is_dir($this->TemporaryFolder . $this->State[1]) && file_exists($this->TemporaryFolder . $this->State[1])) {
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
                unlink($this->TemporaryFolder . $this->State[1]);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
              }
              $this->State[1] = $ActualFileName;
            }
          } else {
            $this->State[0] = $ActualFileName;
          }
        } else {
          $this->Errors->addError($CCSLocales->GetText('CCS_TempInsufficientPermissions', $this->Caption));
        }
      }
    } else {
      $this->SetValue(strlen($this->State[1]) ? $this->State[1] : $this->State[0]);
    }
  }

  function Move()
  {
    global $CCSLocales;
    if (strlen($this->Value) && !file_exists($this->FileFolder . $this->Value)) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeProcessFile", $this);
      $FileName = $this->GetFileName();
      $FieldName = $this->Caption;
      if (!file_exists($this->TemporaryFolder . $this->Value)) {
        $this->Errors->addError($CCSLocales->GetText('CCS_FileNotFound', array($this->TemporaryFolder . $this->Value, $this->Caption)));
      } else if (!@copy($this->TemporaryFolder . $this->Value, $this->FileFolder . $this->Value)) {
        $this->Errors->addError($CCSLocales->GetText('CCS_InsufficientPermissions', $this->Caption));
      } else if (strlen($this->State[1])) {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
        unlink($this->FileFolder . $this->State[0]);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
      }
      if($this->Errors->Count() == 0 && file_exists($this->TemporaryFolder . $this->Value)) {
        unlink($this->TemporaryFolder . $this->Value);
      }
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterProcessFile", $this);
    }
  }

  function Delete()
  {
    if( !is_dir($this->FileFolder . $this->State[0]) && file_exists($this->FileFolder . $this->State[0]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->FileFolder . $this->State[0]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    } else if ( !is_dir($this->TemporaryFolder . $this->State[0]) && file_exists($this->TemporaryFolder . $this->State[0]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->TemporaryFolder . $this->State[0]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    }
    if( !is_dir($this->FileFolder . $this->State[1]) && file_exists($this->FileFolder . $this->State[1]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->FileFolder . $this->State[1]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    } else if ( !is_dir($this->TemporaryFolder . $this->State[1]) && file_exists($this->TemporaryFolder . $this->State[1]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->TemporaryFolder . $this->State[1]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    }
  }

  function Show($RowNumber = "")
  {
    global $Tpl;
    if($this->Visible)
    {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);

      if(!$this->Visible) {
        $Tpl->setblockvar("FileUpload " . $this->Name, "");
        return;
      }

      if(strlen($RowNumber)) {
        $ControlName = $this->Name . "_" . $RowNumber;
        $FileControl = $this->Name . "_File_" . $RowNumber;
        $DeleteControl = $this->Name . "_Delete_" . $RowNumber;
      } else {
        $ControlName = $this->Name;
        $FileControl = $this->Name . "_File";
        $DeleteControl = $this->Name . "_Delete";
      }

      $SessionName = CCGetParam($ControlName);
      if(!strlen($SessionName)) {
        $random_value = mt_rand(100000,9999999) . mt_rand(100000,9999999);
        $SessionName = "FileUpload" . $random_value . date("dHis");
        $this->State = array($this->Value, "");
      } 

      CCSetSession($SessionName, $this->State);

      $Tpl->SetVar("State", $SessionName);
      $Tpl->SetVar("ControlName", $ControlName);
      $Tpl->SetVar("FileControl", $FileControl);
      $Tpl->SetVar("DeleteControl", $DeleteControl);
      if (strlen($this->Value) ) {
        $Tpl->SetVar("ActualFileName", $this->Value);
        $Tpl->SetVar("FileName", $this->GetFileName());
        $Tpl->SetVar("FileSize", $this->GetFileSize());
        $Tpl->parse("FileUpload " . $this->Name . "/Info", false);
        if($this->Required) {
          $Tpl->parse("FileUpload " . $this->Name . "/Upload", false);
          $Tpl->setblockvar("FileUpload " . $this->Name . "/DeleteControl", "");
        } else {
          $Tpl->setblockvar("FileUpload " . $this->Name . "/Upload", "");
          $Tpl->parse("FileUpload " . $this->Name . "/DeleteControl", false);
        }
      } else {
        $Tpl->parse("FileUpload " . $this->Name . "/Upload", false);
        $Tpl->setblockvar("FileUpload " . $this->Name . "/Info", "");
        $Tpl->setblockvar("FileUpload " . $this->Name . "/DeleteControl", "");
      }

      $Tpl->Parse("FileUpload " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("FileUpload " . $this->Name, "");
    }
  }

  function SetValue($Value) {
    global $CCSLocales;
    $this->Text = $Value;
    $this->Value = $Value;
    $this->State[0] = $Value;
    if(strlen($Value) 
      && !file_exists($this->TemporaryFolder . $Value) 
      && !file_exists($this->FileFolder . $Value)) {
        $FileName = $this->GetFileName();
        $FieldName = $this->Caption;
        $this->Errors->addError($CCSLocales->GetText('CCS_FileNotFound', $this->Caption));
    }
  }

  function SetText($Text) {
    $this->SetValue($Text);
  }

  function GetValue() {
    return $this->Value;
  }

  function GetText() {
    return $this->Text;
  }

  function GetFileName() {
    return CCGetOriginalFileName($this->Value);
  }

  function GetFileSize() {
    $filesize = 0;
    if( file_exists($this->FileFolder . $this->Value) ) {
      $filesize = filesize($this->FileFolder . $this->Value);
    } else if ( file_exists($this->TemporaryFolder . $this->Value) ) {
      $filesize = filesize($this->TemporaryFolder . $this->Value);
    }
    return $filesize;
  }

}

//End clsFileUpload Class

//clsDatePicker Class @0-139F9C1C
class clsDatePicker
{
  var $CmponentType = "DatePicker";
  var $Name;
  var $DateFormat;
  var $Style;
  var $FormName;
  var $ControlName;
  var $Visible;
  var $Errors;

  var $CCSEvents = "";
  var $CCSEventResult;

  var $Parent;

  function clsDatePicker($Name, $FormName, $ControlName, & $Parent)
  {
    $this->Name        = $Name;
    $this->FormName    = $FormName;
    $this->ControlName = $ControlName;
    $this->Parent      = & $Parent;
    $this->Visible     = true;

    $this->Errors = new clsErrors;
  }

  function Show($RowNumber = "")
  {
    global $Tpl;
    if($this->Visible)
    {
      $ControlName = ($RowNumber === "") ? $this->ControlName : $this->ControlName . "_" . $RowNumber;
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
      $Tpl->SetVar("Name",        $this->FormName . "_" . $this->Name);
      $Tpl->SetVar("FormName",    $this->FormName);
      $Tpl->SetVar("DateControl", $ControlName);

      $Tpl->Parse("DatePicker " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("DatePicker " . $this->Name, "");
    }
  }

}

//End clsDatePicker Class

//clsErrors Class @0-29B52C31
class clsErrors
{
  var $Errors;
  var $ErrorsCount;
  var $ErrorDelimiter;

  function clsErrors()
  {
    $this->Errors = array();
    $this->ErrorsCount = 0;
    $this->ErrorDelimiter = "<br>";
  }

  function addError($Description)
  {
    if (strlen($Description))
    {
      $this->Errors[$this->ErrorsCount] = $Description; 
      $this->ErrorsCount++;
    }
  }

  function AddErrors($Errors)
  {
    for($i = 0; $i < $Errors->Count(); $i++)
      $this->addError($Errors->Errors[$i]);
  }

  function Clear()
  {
    $this->Errors = array();
    $this->ErrorsCount = 0;
  }

  function Count()
  {
    return $this->ErrorsCount;
  }

  function ToString()
  {

    if(sizeof($this->Errors) > 0)
      return join($this->ErrorDelimiter, $this->Errors);
    else
      return "";
  }

}
//End clsErrors Class

//clsSection Class @0-3F424779
class clsSection
{
  var $ComponentType = "Section";
  var $Visible = true;
  var $Height = 0;
  var $CCSEvents = array();
  var $CCSEventResult;
  var $Parent;
  function clsSection(& $Parent) {
    $this->Parent = & $Parent;
  }

}
//End clsSection Class

//clsLocaleInfo @0-3560C5D0
class clsLocaleInfo {
  var $FormatInfo;
  var $Name;
  var $Language;
  var $Country;
  var $BooleanFormat;
  var $DecimalDigits;
  var $DecimalSeparator;
  var $GroupSeparator;
  var $MonthNames;
  var $MonthShortNames;
  var $WeekdayNames;
  var $WeekdayShortNames;
  var $WeekdayNarrowNames;
  var $ShortDate;
  var $LongDate;
  var $ShortTime;
  var $LongTime;
  var $GeneralDate;
  var $FirstWeekDay;
  var $OverrideNumberFormats;
  var $AMDesignator;
  var $PMDesignator;
  var $Encoding;
  var $PHPEncoding;
  var $PHPLocale;

  function clsLocaleInfo($name, $LocaleInfoArray) {
    $this->Name = $name;
    $this->Language = $LocaleInfoArray[0];
    $this->Country = $LocaleInfoArray[1];

    $this->BooleanFormat = $LocaleInfoArray[2];

    $this->DecimalDigits = $LocaleInfoArray[3];
    $this->DecimalSeparator = $LocaleInfoArray[4];
    $this->GroupSeparator = $LocaleInfoArray[5];

    $this->MonthNames = $LocaleInfoArray[6];
    $this->MonthShortNames = $LocaleInfoArray[7];

    $this->WeekdayNames = $LocaleInfoArray[8];
    $this->WeekdayShortNames = $LocaleInfoArray[9];
    $this->WeekdayNarrowNames = $LocaleInfoArray[10];

    $this->ShortDate = $LocaleInfoArray[11];
    $this->LongDate = $LocaleInfoArray[12];

    $this->ShortTime = $LocaleInfoArray[13];
    $this->LongTime = $LocaleInfoArray[14];
    $this->AMDesignator = $LocaleInfoArray[15];
    $this->PMDesignator = $LocaleInfoArray[16];

    $this->GeneralDate = array();
    foreach ($this->ShortDate as $val) {
     array_push($this->GeneralDate, $val);
    }
     array_push($this->GeneralDate, " ");
    foreach ($this->LongTime as $val) {
     array_push($this->GeneralDate, $val);
    }
    $this->FirstWeekDay = $LocaleInfoArray[17];
    $this->OverrideNumberFormats = $LocaleInfoArray[18];
    $this->PHPLocale = $LocaleInfoArray[19];
    $this->Encoding = $LocaleInfoArray[20];
    $this->PHPEncoding = $LocaleInfoArray[21];
  }

  function GetInfo($name) {
    return $this->$name;
  }
  
  function GetCCSFormatInfo() {
    if (!$this->FormatInfo)
      $this->FormatInfo = join("|" , Array($this->Name, $this->Language, $this->Country,  join(";", $this->BooleanFormat),
        $this->DecimalDigits, $this->DecimalSeparator, $this->GroupSeparator,
        join(";", $this->MonthNames) ,  join(";", $this->MonthShortNames),
        join(";", $this->WeekdayNames), join(";", $this->WeekdayShortNames),
        join("", $this->ShortDate), join("", $this->LongDate),
        join("", $this->ShortTime), join("", $this->LongTime),       
        $this->FirstWeekDay, $this->AMDesignator, $this->PMDesignator));
    return $this->FormatInfo;
  }
}

//End clsLocaleInfo

//clsLocale Class @0-3325E2A9
class clsLocale {
  var $Name;
  var $Dir;
  var $Ext = ".txt";
  var $ParentLocale;
  var $ParentLocaleName = "";
  var $IsLoaded = false;
  var $LocaleInfo;
  var $Messages;
  var $InternalEncoding = "UTF-8";

  function clsLocale($name, $LocaleInfoArray, $dir = "") {
    $this->Name = $name;
    $this->Dir = $dir;
    $this->Translations = array();
    $this->LocaleInfo = new clsLocaleInfo($name, $LocaleInfoArray);
    $arr = explode("-", $name, 2);
    if (count($arr) == 2)
      $this->ParentLocaleName = $arr[0];
  }

  function LoadTranslation($filename = "") {
    $this->Messages = array();
    if ($filename == "")
      $filename = $this->Name . $this->Ext;
    if (CCSubStr($filename, 0, 1) != "/" && CCSubStr($filename, 0, 1) != ".")
      $filename = $this->Dir . "/" . $filename;
    if ($FileContent = @file($filename)) {
      foreach($FileContent as $str) {
        if (preg_match("/^([^'].+?)=(.*)$/", $str, $matches)) { 
          $this->Messages[$matches[1]] = str_replace(chr(13), "", $matches[2]);
        }
      }
    }
    $this->IsLoaded = true;
  }

  function GetMessage($id) {
    global $CCSLocales;
    global $FileEncoding;
    if ($id == "CCS_LocaleID") return $this->Name;
    if ($id == "CCS_LanguageID") return $this->LocaleInfo->GetInfo("Language");
    if ($id == "CCS_FormatInfo") return $this->LocaleInfo->GetCCSFormatInfo();

    if (!$this->IsLoaded)
      $this->LoadTranslation();
    if (array_key_exists($id,  $this->Messages)) {
      return $FileEncoding != $this->InternalEncoding && $id != "CCS_FormatInfo" ? CCConvertEncoding($this->Messages[$id], $this->InternalEncoding, $FileEncoding) : $this->Messages[$id];
    } else if ($this->ParentLocale) {
      return $this->ParentLocale->GetMessage($id);
    } elseif ($this->ParentLocaleName && array_key_exists($this->ParentLocaleName, $CCSLocales->Locales)) {
      $this->ParentLocale = & $CCSLocales->Locales[$this->ParentLocaleName];
      return $this->ParentLocale->GetMessage($id);
    } elseif ($CCSLocales->DefaultLocale != $this->Name) {
      $DefaultLocale = $CCSLocales->Locales[$CCSLocales->DefaultLocale];
      return $DefaultLocale->GetMessage($id);  
    } else {
      return $id;
    }

  }
}

//End clsLocale Class

//clsLocales Class @0-1FF115AF
class clsLocales {
  var $Locale;
  var $DefaultLocale;
  var $Locales;
  var $Dir;

  function clsLocales($dir, $locale = "")  {
    $this->Dir = $dir;
    $this->Locale = $locale;
    $this->DefaultLocale = "";
    $this->Locales = array();
  }

  function Init() {
    $this->SetLocale(CCGetFromGet("locale"));
    $this->SetLocale(CCGetSession("locale"));
    $this->SetLocale(CCGetCookie("locale"));
    $this->SetLocale($this->DefaultLocale);
    CCSetSession("locale", $this->GetFormatInfo("Name"));
    CCSetSession("lang", $this->GetFormatInfo("Language"));
    CCSetCookie("locale", $this->GetFormatInfo("Name"), time() + 31536000);
  }

  function AddLocale($name, $LocaleInfoArray) {
    $lname = strtolower($name);
    if (array_key_exists($lname, $this->Locales))
      return;
    $this->Locales[$lname] = new clsLocale($name, $LocaleInfoArray, $this->Dir);
  }

  function GetText($id, $params = Null, $locale = "") {
    if ($locale == "")  
      $locale = $this->Locale;
    if ($locale == "")  
      $locale = $this->DefaultLocale;
    if (!array_key_exists($locale, $this->Locales))
      return "";
    $Result = $this->Locales[$locale]->GetMessage($id);
    if ($Result != "") {
      $Result = preg_replace("/\\\\n/", "\n", $Result);
      $Result = preg_replace("/\\\\/", "\\", $Result);
      if (is_array($params)) {
        for ($i = 0; $i < count($params); $i++)
          $Result = preg_replace("/\{$i\}/", $params[$i], $Result);
      } elseif (!is_null($params)) {
          $Result = preg_replace("/\{0}/", $params, $Result);
      }
    }
    return $Result;
  }

  function GetFormatInfo($name, $locale = "") {
    if ($locale == "")  
      $locale = $this->Locale;
    if ($locale == "")  
      $locale = $this->DefaultLocale;
    return $this->Locales[$locale]->LocaleInfo->GetInfo($name);
  }

  function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
  }

  function FindLocale($locale) {
    $locale = strtolower($locale);
    if (!$this->Locale && $locale) {
      $arr = explode("-", $locale, 2);        
      $lang = $arr[0];
      $country = isset($arr[1]) ? $arr[1] : "";
      $defaultCountry = array_key_exists($lang, $this->Locales) ? strtolower($this->Locales[$lang]->LocaleInfo->GetInfo("Country")) : "";
      if (!$country && $defaultCountry && array_key_exists($lang . "-" . $defaultCountry, $this->Locales)) 
        return $lang . "-" . $defaultCountry;
      elseif ($country && !array_key_exists($locale, $this->Locales) && array_key_exists($lang . "-" . $defaultCountry, $this->Locales)) 
        return $lang . "-" . $defaultCountry;
      elseif (array_key_exists($locale, $this->Locales))
        return $locale;
      elseif (array_key_exists($lang, $this->Locales))
        return $lang;
    }
    return false;
  }

  function SetLocale($locale) {
    if (!$this->Locale && $locale) {
      $this->Locale = $this->FindLocale($locale);
      if (!$this->Locale) 
        $this->Locale = $this->DefaultLocale;
    }
  }

  function  SetLocaleFromHttpHeader($Name = "HTTP_ACCEPT_LANGUAGE") {
    if ($this->Locale)
      return false;
    $Locales = array();
    $locale = "";
    $q = "";
    if (!isset($_SERVER[$Name])) return;
    $arr = explode(",", strtolower($_SERVER[$Name]));
    foreach ($arr as $L) {
      if(preg_match("/(.+);q=(\\d+(\\.\\d+)?)/", $L, $matches)) {
        $locale = $matches[1];
        $q = doubleval($matches[2]);
      } else {
        $locale = $L;
        $q = 1;
      }
      if (!array_key_exists(strval($q), $this->Locales))
        $Locales[strval($q)] = array();
      array_push($Locales[strval($q)], $locale);
    }
    uksort($Locales, array($this, "cmp"));

    foreach ($Locales as $q) {
      foreach ($q as $locale) {
        if ($result = $this->FindLocale($locale)) {
          $this->Locale = $result;
          return;
        }
      }
    }
  }

}


//End clsLocales Class

//clsMainPage Class @0-EAF29FA7
class clsMainPage
{
  var $ComponentType = "Page";
  var $Parent = false;
  var $Connections = array();


}
//End clsMainPage Class


?>
