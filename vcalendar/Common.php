﻿<?php

//Include Files @0-6CA7C540
include(RelativePath . "/Classes.php");
include(RelativePath . "/db_mysql.php");
//End Include Files

//Connection Settings @0-503442DF
$CCConnectionSettings = array (
    "calendar" => array(
        "Type" => "MySQL",
        "Database" => "vcalendar",
        "Host" => "localhost",
        "Port" => "",
        "User" => "X",
        "Password" => "X",
        "Encoding" => array("", "utf8"),
        "Persistent" => true,
        "DateFormat" => array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss"),
        "BooleanFormat" => array(1, 0, ""),
        "Uppercase" => false
    )
);
//End Connection Settings

//Initialize Common Variables @0-A2C819B5
$PHPVersion = explode(".",  phpversion());
if (($PHPVersion[0] < 4) || ($PHPVersion[0] == 4  && $PHPVersion[1] < 1)) {
    echo "Sorry. This program requires PHP 4.1 and above to run.<br>You may upgrade your php at <a href='http://www.php.net/downloads.php'>http://www.php.net/downloads.php</a>";
    exit;
}
@session_start();
header('Pragma: ');
header('Cache-control: ');
header('Expires: ');
define("TemplatePath", RelativePath);
define("ServerURL", ((isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == "on") ? "https://" : "http://" ). ($_SERVER["HTTP_HOST"] ? $_SERVER["HTTP_HOST"] : $_SERVER["SERVER_NAME"]) . ($_SERVER["SERVER_PORT"] != 80 ? ":" . $_SERVER["SERVER_PORT"] : "") . substr($_SERVER["PHP_SELF"], 0, strlen($_SERVER["PHP_SELF"]) - strlen(PathToCurrentPage . FileName)) . "/");
define("SecureURL", "");

$FileEncoding = "UTF-8";
$CCSLocales = new clsLocales(RelativePath);
$CCSLocales->AddLocale("en", Array("en", "US", array("Si", "No", ""), 2, ".", ",", array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"), array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"), array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"), array("Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"), array("D", "L", "M", "M", "J", "V", "S"), array("m", "/", "d", "/", "yyyy"), array("dddd", ", ", "mmmm", " ", "dd", ", ", "yyyy"), array("h", ":", "nn", " ", "tt"), array("h", ":", "nn", ":", "ss", " ", "tt"), "AM", "PM", 0, false, "", "utf-8", "UTF-8"));
$CCSLocales->AddLocale("ru", Array("ru", "RU", array("Да", "Нет", ""), 2, ",", " ", array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"), array("янв", "фев", "мар", "апр", "май", "июн", "июл", "авг", "сен", "окт", "ноя", "дек"), array("воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"), array("Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"), array("В", "П", "В", "С", "Ч", "П", "С"), array("mm", ".", "dd", ".", "yyyy"), array("d", " ", "mmmm", " ", "yyyy", " г."), array("H", ":", "nn"), array("H", ":", "nn", ":", "ss"), "", "", 1, false, "", "utf-8", "UTF-8"));
$CCSLocales->DefaultLocale = strtolower("en");
$CCSLocales->Init();
$Charset = $CCSLocales->GetFormatInfo("Encoding");

if ($PHPLocale = $CCSLocales->GetFormatInfo("PHPLocale"))
    setlocale(LC_ALL, $PHPLocale);
CCConvertDataArrays();
$CCProjectStyle = "Blueprint";
CCSelectProjectStyle();
//for compatibility
$ShortWeekdays = $CCSLocales->GetFormatInfo("WeekdayShortNames");
$Weekdays = $CCSLocales->GetFormatInfo("WeekdayNames");
$ShortMonths =  $CCSLocales->GetFormatInfo("MonthShortNames");
$Months = $CCSLocales->GetFormatInfo("MonthNames");

define("ccsInteger", 1);
define("ccsFloat", 2);
define("ccsSingle", ccsFloat); //alias
define("ccsText", 3);
define("ccsDate", 4);
define("ccsBoolean", 5);
define("ccsMemo", 6);

define("ccsGet", 1);
define("ccsPost", 2);

define("ccsTimestamp", 0);
define("ccsYear", 1);
define("ccsMonth", 2);
define("ccsDay", 3);
define("ccsHour", 4);
define("ccsMinute", 5);
define("ccsSecond", 6);
define("ccsMilliSecond", 7);
define("ccsAmPm", 8);
define("ccsShortMonth", 9);
define("ccsFullMonth", 10);
define("ccsWeek", 11);
define("ccsGMT", 12);
define("ccsAppropriateYear", 13);

$DefaultDateFormat = array("ShortDate");

$MainPage = new clsMainPage();
//End Initialize Common Variables

//calendar Connection Class @-2000467A
class clsDBcalendar extends DB_MySQL
{

    var $DateFormat;
    var $BooleanFormat;
    var $LastSQL;
    var $Errors;

    var $RecordsCount;
    var $RecordNumber;
    var $PageSize;
    var $AbsolutePage;

    var $SQL = "";
    var $Where = "";
    var $Order = "";

    var $Parameters;
    var $wp;

    function clsDBcalendar()
    {
        $this->Initialize();
    }

    function Initialize()
    {
        $this->AbsolutePage = 0;
        $this->PageSize = 0;
        global $CCConnectionSettings;
        $Configuration = $CCConnectionSettings["calendar"];
        $this->DB = $Configuration["Type"];
        $this->DBDatabase = $Configuration["Database"];
        $this->DBHost = $Configuration["Host"];
        $this->DBPort = $Configuration["Port"];
        $this->DBUser = $Configuration["User"];
        $this->DBPassword = $Configuration["Password"];
        $this->Encoding = $Configuration["Encoding"];
        $this->Persistent = $Configuration["Persistent"];
        $this->DateFormat = $Configuration["DateFormat"];
        $this->BooleanFormat = $Configuration["BooleanFormat"];
        $this->Uppercase = $Configuration["Uppercase"];
        $this->RecordsCount = 0;
        $this->RecordNumber = 0;
        $this->LastSQL = "";
        $this->Errors = New clsErrors();
    }

    function MoveToPage($Page)
    {
        global $CCSLocales;
        if($this->RecordNumber == 0 && $this->PageSize != 0 && $Page != 0 && $Page != 1)
            if( !$this->seek(($Page-1) * $this->PageSize)) {
                $this->Errors->addError($CCSLocales->GetText('CCS_CannotSeek'));
                $this->RecordNumber = $this->Row;
            } else {
                $this->RecordNumber = ($Page-1) * $this->PageSize;
            }
    }
    function PageCount()
    {
        return $this->PageSize && $this->RecordsCount != "CCS not counted" ? ceil($this->RecordsCount / $this->PageSize) : 1;
    }

    function ToSQL($Value, $ValueType)
    {
        if(($ValueType == ccsDate && is_array($Value)) || strlen($Value) || ($ValueType == ccsBoolean && is_bool($Value)))
        {
            if($ValueType == ccsInteger || $ValueType == ccsFloat)
            {
                return doubleval(str_replace(",", ".", $Value));
            }
            else if($ValueType == ccsDate)
            {
                if (is_array($Value)) {
                    $Value = CCFormatDate($Value, $this->DateFormat);
                }
                return "'" . addslashes($Value) . "'";
            }
            else if($ValueType == ccsBoolean)
            {
                if(is_bool($Value))
                    $Value = CCFormatBoolean($Value, $this->BooleanFormat);
                else if(is_numeric($Value))
                    $Value = intval($Value);
                else
                    $Value = "'" . addslashes($Value) . "'";
                return $Value;
            }
            else
            {
                return "'" . addslashes($Value) . "'";
            }
        }
        else
        {
            return "NULL";
        }
    }

    function SQLValue($Value, $ValueType)
    {
        if ($ValueType == ccsDate && is_array($Value)) {
            $Value = CCFormatDate($Value, $this->DateFormat);
        }
        if(!strlen($Value))
        {
            return "";
        }
        else
        {
            if($ValueType == ccsInteger || $ValueType == ccsFloat)
            {
                return doubleval(str_replace(",", ".", $Value));
            }
            else if($ValueType == ccsBoolean)
            {
                if(is_bool($Value))
                    $Value = CCFormatBoolean($Value, $this->BooleanFormat);
                else if(is_numeric($Value))
                    $Value = intval($Value);
                else
                    $Value = addslashes($Value);
                return $Value;
            }
            else
            {
                return addslashes($Value);
            }
        }
    }

    function query($SQL)
    {
        $this->LastSQL = $SQL;
        return parent::query($SQL);
    }

    function OptimizeSQL($SQL)
    {
        $PageSize = (int) $this->PageSize;
        if (!$PageSize) return $SQL;
        $Page = $this->AbsolutePage ? (int) $this->AbsolutePage : 1;
        if (strcmp($this->RecordsCount, "CCS not counted")) 
            $SQL .= " LIMIT " . (($Page - 1) * $PageSize) . "," .$PageSize;
        else
            $SQL .= " LIMIT " . (($Page - 1) * $PageSize) . "," . ($PageSize + 1);
        return $SQL;
    }

}
//End calendar Connection Class

//CCToHTML @0-93F44B0D
function CCToHTML($Value)
{
  return htmlspecialchars($Value);
}
//End CCToHTML

//CCToURL @0-88FAFE26
function CCToURL($Value)
{
  return urlencode($Value);
}
//End CCToURL

//CCGetEvent @0-7AE506F3
function CCGetEvent($events, $event_name, & $sender)
{
  $result = true;
  $function_name = (is_array($events) && isset($events[$event_name])) ? $events[$event_name] : "";
  if($function_name && function_exists($function_name))
    $result = call_user_func_array($function_name, array(& $sender));
  return $result;  
}
//End CCGetEvent

//CCGetParentContainer @0-0CD41DEB
function & CCGetParentContainer(& $object)
{
  $i = & $object;
  while ($i && !($i->ComponentType == "Page" || $i->ComponentType == "IncludablePage" || $i->ComponentType == "Directory" || $i->ComponentType == "Path" || $i->ComponentType == "EditableGrid" || $i->ComponentType == "Grid" || $i->ComponentType == "Record" || $i->ComponentType == "Report" || $i->ComponentType == "Calendar"))
    $i = & $i->Parent;
  return $i;
}
//End CCGetParentContainer

//CCGetParentPage @0-AD47469D
function & CCGetParentPage(& $object)
{
  $i = & $object;
  while ($i && !($i->ComponentType == "Page" || $i->ComponentType == "IncludablePage"))
    $i = & $i->Parent;
  return $i;
}
//End CCGetParentPage

//CCGetValueHTML @0-B8903145
function CCGetValueHTML(&$db, $fieldname)
{
  return CCToHTML($db->f($fieldname));
}
//End CCGetValueHTML

//CCGetValue @0-36EF6396
function CCGetValue(&$db, $fieldname)
{
  return $db->f($fieldname);
}
//End CCGetValue

//CCGetSession @0-1125A396
function CCGetSession($parameter_name)
{
    return isset($_SESSION[$parameter_name]) ? $_SESSION[$parameter_name] : "";
}
//End CCGetSession

//CCSetSession @0-7889A59E
function CCSetSession($param_name, $param_value)
{
    $_SESSION[$param_name] = $param_value;
}
//End CCSetSession

//CCGetCookie @0-6B04B9B5
function CCGetCookie($parameter_name)
{
    return isset($_COOKIE[$parameter_name]) ? $_COOKIE[$parameter_name] : "";
}
//End CCGetCookie

//CCSetCookie @0-0148E673
function CCSetCookie($parameter_name, $param_value, $expired = -1)
{
  if ($expired == -1)
    $expired = time() + 3600 * 24 * 366;
  elseif ($expired && $expired < time())
    $expired = time() + $expired;
  setcookie ($parameter_name, $param_value, $expired);  
}
//End CCSetCookie

//CCStrip @0-E1370054
function CCStrip($value)
{
  if(get_magic_quotes_gpc() != 0)
  {
    if(is_array($value))  
      foreach($value as $key=>$val)
        $value[$key] = stripslashes($val);
    else
      $value = stripslashes($value);
  }
  return $value;
}
//End CCStrip

//CCGetParam @0-3BB7E2D4
function CCGetParam($parameter_name, $default_value = "")
{
    $parameter_value = "";
    if(isset($_POST[$parameter_name]))
        $parameter_value = CCStrip($_POST[$parameter_name]);
    else if(isset($_GET[$parameter_name]))
        $parameter_value = CCStrip($_GET[$parameter_name]);
    else
        $parameter_value = $default_value;
    return $parameter_value;
}
//End CCGetParam

//CCGetParamStartsWith @0-4BE76C1A
function CCGetParamStartsWith($prefix)
{
    $parameter_name = "";
    foreach($_POST as $key => $value) {
        if(preg_match ("/^" . $prefix . "_\d+$/i", $key)) {
            $parameter_name = $key;
            break;
        }
    }
    if($parameter_name === "") {
        foreach($_GET as $key => $value) {
            if(preg_match ("/^" . $prefix . "_\d+$/i", $key)) {
                $parameter_name = $key;
                break;
            }
        }
    }
    return $parameter_name;
}
//End CCGetParamStartsWith

//CCGetFromPost @0-393586D2
function CCGetFromPost($parameter_name, $default_value = "")
{
    return isset($_POST[$parameter_name]) ? CCStrip($_POST[$parameter_name]) : $default_value;
}
//End CCGetFromPost

//CCGetFromGet @0-90CF1921
function CCGetFromGet($parameter_name, $default_value = "")
{
    return isset($_GET[$parameter_name]) ? CCStrip($_GET[$parameter_name]) : $default_value;
}
//End CCGetFromGet

//CCToSQL @0-422F5B92
function CCToSQL($Value, $ValueType)
{
  if(!strlen($Value))
  {
    return "NULL";
  }
  else
  {
    if($ValueType == ccsInteger || $ValueType == ccsFloat)
    {
      return doubleval(str_replace(",", ".", $Value));
    }
    else
    {
      return "'" . str_replace("'", "''", $Value) . "'";
    }
  }
}
//End CCToSQL

//CCDLookUp @0-AD41DC8E
function CCDLookUp($field_name, $table_name, $where_condition, &$db)
{
  $sql = "SELECT " . $field_name . ($table_name ? " FROM " . $table_name : "") . ($where_condition ? " WHERE " . $where_condition : "");
  return CCGetDBValue($sql, $db);
}
//End CCDLookUp

//CCGetDBValue @0-6DCF4DC4
function CCGetDBValue($sql, &$db)
{
  $db->query($sql);
  $dbvalue = $db->next_record() ? $db->f(0) : "";
  return $dbvalue;  
}
//End CCGetDBValue

//CCGetListValues @0-B431A4F4
function CCGetListValues(&$db, $sql, $where = "", $order_by = "", $bound_column = "", $text_column = "", $dbformat = "", $datatype = "", $errorclass = "", $fieldname = "")
{
    $errors = new clsErrors();
    $values = "";
    if(!strlen($bound_column))
        $bound_column = 0;
    if(!strlen($text_column))
        $text_column = 1;
    $db->query(CCBuildSQL($sql, $where, $order_by));
    if ($db->next_record())
    {
        do
        {
            $bound_column_value = $db->f($bound_column);
            if($bound_column_value === false) {$bound_column_value = "";}
            list($bound_column_value, $errors) = CCParseValue($bound_column_value, $dbformat, $datatype, $errors, $fieldname);
            $values[] = array($bound_column_value, $db->f($text_column));
        } while ($db->next_record());
    }
    if (is_string($errorclass)) {
        return $values;
    } else {
        $errorclass->AddErrors($errors);
        return array($values, $errorclass);
    }
}

//End CCGetListValues

//CCParseValue @0-1A0E2576
  function CCParseValue($ParsingValue, $Format, $DataType, $ErrorClass, $FieldName)
  {
    global $CCSLocales;
    $errors = new clsErrors();
    $varResult = "";
    if(CCCheckValue($ParsingValue, $DataType))
      $varResult = $ParsingValue;
    else if(strlen($ParsingValue))
    {
      switch ($DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($ParsingValue, $Format)) {
            $varResult = CCParseDate($ParsingValue, $Format);
            if(!CCValidateDate($varResult)) {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if(!$DateValidation && $ErrorClass->Count() == 0) {
            if (is_array($Format)) {
              $FormatString = join("", $Format);
            } else {
              $FormatString = $Format;
            }
            $errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($FieldName, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($ParsingValue, $Format)) {
            $varResult = CCParseBoolean($ParsingValue, $Format);
          } else if($ErrorClass->Count() == 0) {
            if (is_array($Format)) {
              $FormatString = CCGetBooleanFormat($Format);
            } else {
              $FormatString = $Format;
            }
            $errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($FieldName, $FormatString)));
          }
          break;
        case ccsInteger:
          if (CCValidateNumber($ParsingValue, $Format))
            $varResult = CCParseInteger($ParsingValue, $Format);
          else if($ErrorClass->Count() == 0)
            $errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($FieldName, $Format)));
          break;
        case ccsFloat:
          if (CCValidateNumber($ParsingValue, $Format))
            $varResult = CCParseFloat($ParsingValue, $Format);
          else if($ErrorClass->Count() == 0)
            $errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($FieldName, $Format)));
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($ParsingValue);
          break;
      }
    }
  if (is_string($ErrorClass)) {
    return $varResult;
  } else {
    $ErrorClass->AddErrors($errors);
    return array($varResult, $ErrorClass);
  }
}

//End CCParseValue

//CCFormatValue @0-53405652
  function CCFormatValue($Value, $Format, $DataType)
  {
    switch($DataType)
    {
      case ccsDate:
        $Value = CCFormatDate($Value, $Format);
        break;
      case ccsBoolean:
        $Value = CCFormatBoolean($Value, $Format);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $Value = CCFormatNumber($Value, $Format, $DataType);
        break;
      case ccsText:
      case ccsMemo:
        $Value = strval($Value);
        break;
    }
    return $Value;
  }

//End CCFormatValue

//CCBuildSQL @0-0D4CE748
function CCBuildSQL($sql, $where = "", $order_by = "")
{
if(strlen($where)) $where = " WHERE " . $where;
if(strlen($order_by)) $order_by = " ORDER BY " . $order_by;
if(stristr($sql,"{SQL_Where}") || stristr($sql,"{SQL_OrderBy}")){
    $sql = str_replace("{SQL_Where}", $where, $sql);
    $sql = str_replace("{SQL_OrderBy}", $order_by, $sql);
    return $sql;
}
        $sql .= $where . $order_by;
    return $sql;
}

//End CCBuildSQL

//CCGetRequestParam @0-3342AA47
function CCGetRequestParam($ParameterName, $Method)
{
    $ParameterValue = "";
    if($Method == ccsGet && isset($_GET[$ParameterName]))
        $ParameterValue = CCStrip($_GET[$ParameterName]);
    else if($Method == ccsPost && isset($_POST[$ParameterName]))
        $ParameterValue = CCStrip($_POST[$ParameterName]);
    return $ParameterValue;
}
//End CCGetRequestParam

//CCGetQueryString @0-CDA71B06
function CCGetQueryString($CollectionName, $RemoveParameters)
{
    $querystring = "";
    $postdata = "";
    if($CollectionName == "Form")
        $querystring = CCCollectionToString($_POST, $RemoveParameters);
    else if($CollectionName == "QueryString")
        $querystring = CCCollectionToString($_GET, $RemoveParameters);
    else if($CollectionName == "All")
    {
        $querystring = CCCollectionToString($_GET, $RemoveParameters);
        $postdata = CCCollectionToString($_POST, $RemoveParameters);
        if(strlen($postdata) > 0 && strlen($querystring) > 0)
            $querystring .= "&" . $postdata;
        else
            $querystring .= $postdata;
    }
    else
        die("1050: Common Functions. CCGetQueryString Function. " .
            "The CollectionName contains an illegal value.");
    return $querystring;
}
//End CCGetQueryString

//CCCollectionToString @0-082B6384
function CCCollectionToString($ParametersCollection, $RemoveParameters)
{
  $Result = ""; 
  if(is_array($ParametersCollection))
  {
    reset($ParametersCollection);
    foreach($ParametersCollection as $ItemName => $ItemValues)
    {
      $Remove = false;
      if(is_array($RemoveParameters))
      {
        foreach($RemoveParameters as $key => $val)
        {
          if($val == $ItemName)
          {
            $Remove = true;
            break;
          }
        }
      }
      if(!$Remove)
      {
        if(is_array($ItemValues))
          for($J = 0; $J < sizeof($ItemValues); $J++)
            $Result .= "&" . $ItemName . "[]=" . urlencode(CCStrip($ItemValues[$J]));
        else
           $Result .= "&" . $ItemName . "=" . urlencode(CCStrip($ItemValues));
      }
    }
  }

  if(strlen($Result) > 0)
    $Result = substr($Result, 1);
  return $Result;
}
//End CCCollectionToString

//CCMergeQueryStrings @0-6C3BA254
function CCMergeQueryStrings($LeftQueryString, $RightQueryString = "")
{
  $QueryString = $LeftQueryString; 
  if($QueryString === "")
    $QueryString = $RightQueryString;
  else if($RightQueryString !== "")
    $QueryString .= "&" . $RightQueryString;
  
  return $QueryString;
}
//End CCMergeQueryStrings

//CCAddParam @0-5C4653D9
function CCAddParam($querystring, $ParameterName, $ParameterValue)
{
    $querystring = $querystring ? "&" . $querystring : "";
    $querystring = preg_replace ("/&".$ParameterName."(\[\])?=[^&]*/", "", $querystring);
    if(is_array($ParameterValue)) {
        foreach($ParameterValue as $key => $val) {
            $querystring .= "&" . $ParameterName . "[]=" . urlencode($val);
        }
    } else {
    $querystring .= "&" . $ParameterName . "=" . urlencode($ParameterValue);
    }
    $querystring = substr($querystring, 1);
    return $querystring;
}
//End CCAddParam

//CCRemoveParam @0-2AB4820E
function CCRemoveParam($querystring, $ParameterName)
{
    $querystring = "&" . $querystring;
    $Result = preg_replace ("/&".$ParameterName."(\[\])?=[^&]*/", "", $querystring);
    if (substr($Result, 0, 1) == "&")
        $Result = substr($Result, 1);
    return $Result;
}
//End CCRemoveParam

//CCGetOrder @0-27B4AC18
function CCGetOrder($DefaultSorting, $SorterName, $SorterDirection, $MapArray)
{
  if(is_array($MapArray) && isset($MapArray[$SorterName]))
    if(strtoupper($SorterDirection) == "DESC")
      $OrderValue = ($MapArray[$SorterName][1] != "") ? $MapArray[$SorterName][1] : $MapArray[$SorterName][0] . " DESC";
    else
      $OrderValue = $MapArray[$SorterName][0];
  else
    $OrderValue = $DefaultSorting;

  return $OrderValue;
}
//End CCGetOrder

//CCGetDateArray @0-F86CA386
function CCGetDateArray($timestamp = "")
{
  $DateArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
  if(!strlen($timestamp) && !is_int($timestamp)) {
    $timestamp = time();
  }

  $DateArray[ccsTimestamp] = $timestamp;
  $DateArray[ccsYear] = date("Y", $timestamp);
  $DateArray[ccsMonth] = date("n", $timestamp);
  $DateArray[ccsDay] = date("j", $timestamp);
  $DateArray[ccsHour] = date("G", $timestamp);
  $DateArray[ccsMinute] = date("i", $timestamp);
  $DateArray[ccsSecond] = date("s", $timestamp);

  return $DateArray;
}
//End CCGetDateArray

//CCFormatDate @0-A1CC1872
function CCFormatDate($DateToFormat, $FormatMask)
{

  global $CCSLocales;

  if(!is_array($DateToFormat) && strlen($DateToFormat))
    $DateToFormat = CCGetDateArray($DateToFormat);

  if(is_array($FormatMask) && is_array($DateToFormat))
  {
    $WeekdayNames = $CCSLocales->GetFormatInfo("WeekdayNames");
    $WeekdayShortNames = $CCSLocales->GetFormatInfo("WeekdayShortNames");
    $WeekdayNarrowNames = $CCSLocales->GetFormatInfo("WeekdayNarrowNames");
    $MonthNames = $CCSLocales->GetFormatInfo("MonthNames");
    $MonthShortNames = $CCSLocales->GetFormatInfo("MonthShortNames");

    $FormattedDate = "";
    for($i = 0; $i < sizeof($FormatMask); $i++)
    {
      switch ($FormatMask[$i])
      {
        case "GeneralDate": 
          $FormattedDate .= CCFormatDate($DateToFormat, $CCSLocales->GetFormatInfo("GeneralDate"));
          break;
        case "LongDate": 
          $FormattedDate .= CCFormatDate($DateToFormat, $CCSLocales->GetFormatInfo("LongDate"));
          break;
        case "ShortDate": 
          $FormattedDate .= CCFormatDate($DateToFormat, $CCSLocales->GetFormatInfo("ShortDate"));
          break;
        case "LongTime":
          $FormattedDate .= CCFormatDate($DateToFormat, $CCSLocales->GetFormatInfo("LongTime"));
          break;
        case "ShortTime":
          $FormattedDate .= CCFormatDate($DateToFormat, $CCSLocales->GetFormatInfo("ShortTime"));
          break;
        case "d":
          $FormattedDate .= $DateToFormat[ccsDay];
          break;
        case "dd":
          $FormattedDate .= sprintf("%02d", $DateToFormat[ccsDay]);
          break;
        case "ddd": 
          $FormattedDate .= $WeekdayShortNames[CCDayOfWeek($DateToFormat) - 1];
          break;
        case "dddd": 
          $FormattedDate .= $WeekdayNames[CCDayOfWeek($DateToFormat) - 1];
          break;
        case "wi": 
          $FormattedDate .= $WeekdayNarrowNames[CCDayOfWeek($DateToFormat) - 1];
          break;
        case "w": 
          $FormattedDate .= CCDayOfWeek($DateToFormat);
          break;
        case "ww": 
          $FormattedDate .= ceil((7 + date("z", $DateToFormat[ccsTimestamp]) - date("w", $DateToFormat[ccsTimestamp])) / 7);
          break;
        case "m":
          $FormattedDate .= $DateToFormat[ccsMonth];
          break;
        case "mm":
          $FormattedDate .= sprintf("%02d", $DateToFormat[ccsMonth]);
          break;
        case "mmm": 
          $FormattedDate .= $MonthShortNames[$DateToFormat[ccsMonth] - 1];
          break;
        case "mmmm":
          $FormattedDate .= $MonthNames[$DateToFormat[ccsMonth] - 1];
          break;
        case "q":
          $FormattedDate .= ceil($DateToFormat[ccsMonth] / 3);
          break;
        case "y":
          $FormattedDate .= CCDayOfYear($DateToFormat);
          break;
        case "yy": 
          $FormattedDate .= substr($DateToFormat[ccsYear], 2);
          break;
        case "yyyy": 
          $FormattedDate .= sprintf("%04d", $DateToFormat[ccsYear]);
          break;
        case "h":
          $FormattedDate .= ($DateToFormat[ccsHour] % 12 == 0 ) ? 12 : $DateToFormat[ccsHour] % 12;
          break;
        case "hh":
          $FormattedDate .= sprintf("%02d", $DateToFormat[ccsHour] % 12 == 0 ? 12 : $DateToFormat[ccsHour] % 12);
          break;
        case "H":
          $FormattedDate .= $DateToFormat[ccsHour];
          break;
        case "HH":
          $FormattedDate .= sprintf("%02d", $DateToFormat[ccsHour]);
          break;
        case "n": 
          $FormattedDate .= $DateToFormat[ccsMinute];
          break;
        case "nn": 
          $FormattedDate .= sprintf("%02d", $DateToFormat[ccsMinute]);
          break;
        case "s":
          $FormattedDate .= $DateToFormat[ccsSecond];
          break;
        case "ss":
          $FormattedDate .= sprintf("%02d", $DateToFormat[ccsSecond]);
          break;
        case "S": 
          $FormattedDate .= $DateToFormat[ccsMilliSecond];
          break;
        case "AM/PM":
        case "A/P":
          $FormattedDate .=  $DateToFormat[ccsHour] < 12 ? "AM" : "PM";
          break;
        case "am/pm":
        case "a/p":
          $FormattedDate .=  $DateToFormat[ccsHour] < 12 ? "am" : "pm";
          break;
        case "tt":
          $FormattedDate .=  $DateToFormat[ccsHour] < 12 ? $CCSLocales->GetFormatInfo("AMDesignator") : $CCSLocales->GetFormatInfo("PMDesignator");
          break;
        case "GMT":
          $gmt = date("Z", $DateToFormat[ccsTimestamp]) / (60 * 60);
          if($gmt >= 0) $gmt = "+" . $gmt;
          $FormattedDate .= $gmt;
          break;
        default:
          $FormattedDate .= $FormatMask[$i];
          break;
      }
    }
  }
  else
  {
    $FormattedDate = "";
  }
  return $FormattedDate;
}
//End CCFormatDate

//CCValidateDate @0-815AEC07
function CCValidateDate($ValidatingDate)
{
  $IsValid = true;
  if(is_array($ValidatingDate) && 
    $ValidatingDate[ccsMonth] != 0 && 
    $ValidatingDate[ccsDay] != 0 && 
    $ValidatingDate[ccsYear] != 0) 
  {
    $IsValid = checkdate($ValidatingDate[ccsMonth], $ValidatingDate[ccsDay], $ValidatingDate[ccsYear]);
  }

  return $IsValid;
}
//End CCValidateDate

//CCValidateDateMask @0-6A1F5673
function CCValidateDateMask($ValidatingDate, $FormatMask)
{
  $IsValid = true;
  if(is_array($FormatMask) && strlen($ValidatingDate))
  {
    $RegExp = CCGetDateRegExp($FormatMask);
    $IsValid = preg_match($RegExp[0], $ValidatingDate, $matches);
  }

  return $IsValid;
}
//End CCValidateDateMask

//CCParseDate @0-0A24A0F2
function CCParseDate($ParsingDate, $FormatMask)
{
  global $CCSLocales;
  if(is_array($FormatMask) && strlen($ParsingDate))
  {
    $DateArray = array(0, "", "", "", "", "", "", "", "", "", "", "", "", "");
    $RegExp = CCGetDateRegExp($FormatMask);
    $IsValid = preg_match($RegExp[0], $ParsingDate, $matches);
    for($i = 1; $i < sizeof($matches); $i++)
      $DateArray[$RegExp[$i]] = $matches[$i];

    if(!strlen($DateArray[ccsMonth]) && (strlen($DateArray[ccsFullMonth]) || strlen($DateArray[ccsShortMonth])))
    {
      if(strlen($DateArray[ccsFullMonth]))
        $DateArray[ccsMonth] = CCGetIndex($CCSLocales->GetFormatInfo("MonthNames"), $DateArray[ccsFullMonth], true) + 1;
      else if(strlen($DateArray[ccsShortMonth]))
        $DateArray[ccsMonth] = CCGetIndex($CCSLocales->GetFormatInfo("MonthShortNames"), $DateArray[ccsShortMonth], true) + 1;
    } else {
      $DateArray[ccsMonth] = intval($DateArray[ccsMonth]);
    }

    if(intval($DateArray[ccsDay]) == 0) { 
      $DateArray[ccsDay] = 1; 
    } else {
      $DateArray[ccsDay] = intval($DateArray[ccsDay]); 
    }

    if($DateArray[ccsHour] < 12 && $DateArray[ccsAmPm] && (strtoupper(substr($DateArray[ccsAmPm], 0, 1)) == "P" || $DateArray[ccsAmPm] == $CCSLocales->GetFormatInfo("PMDesignator")))
      $DateArray[ccsHour] += 12;

    if($DateArray[ccsHour] == 12 && is_array($DateArray[ccsAmPm]) && (strtoupper(substr($DateArray[ccsAmPm], 0, 1)) == "A" || $DateArray[ccsAmPm] == $CCSLocales->GetFormatInfo("PMDesignator")))
      $DateArray[ccsHour] = 0;

    if(strlen($DateArray[ccsYear]) == 2)
      if($DateArray[ccsYear] < 70)
        $DateArray[ccsYear] = "20" . $DateArray[ccsYear];
      else
        $DateArray[ccsYear] = "19" . $DateArray[ccsYear];
      
    if($DateArray[ccsYear] < 1971 && $DateArray[ccsYear] > 0)
      $DateArray[ccsAppropriateYear] = $DateArray[ccsYear] + intval((2000 - $DateArray[ccsYear]) / 28) * 28;
    else if($DateArray[ccsYear] > 2030)
      $DateArray[ccsAppropriateYear] = $DateArray[ccsYear] - intval(($DateArray[ccsYear] - 2000) / 28) * 28;
    else      
      $DateArray[ccsAppropriateYear] = $DateArray[ccsYear];


    $DateArray[ccsHour] = intval($DateArray[ccsHour]);
    $DateArray[ccsMinute] = intval($DateArray[ccsMinute]);
    $DateArray[ccsSecond] = intval($DateArray[ccsSecond]);

    $DateArray[ccsTimestamp] = @mktime ($DateArray[ccsHour], $DateArray[ccsMinute], $DateArray[ccsSecond], $DateArray[ccsMonth], $DateArray[ccsDay], $DateArray[ccsAppropriateYear]);
    if(!CCValidateDate($DateArray)) $ParsingDate = "";
    else $ParsingDate = $DateArray;
    
  }

  return $ParsingDate;
}
//End CCParseDate

//CCGetDateRegExp @0-A1EFD83C
function CCGetDateRegExp($FormatMask)
{
  global $CCSLocales;
  $RegExp = false;
  if(is_array($FormatMask))
  {
    $masks = array(
      "d" => array("(\d{1,2})", ccsDay), 
      "dd" => array("(\d{2})", ccsDay), 
      "ddd" => array("(" . join("|", $CCSLocales->GetFormatInfo("WeekdayShortNames")) . ")", ccsWeek), 
      "dddd" => array("(" . join("|", $CCSLocales->GetFormatInfo("WeekdayNames")) . ")", ccsWeek), 
      "w" => array("\d"), "ww" => array("\d{1,2}"),
      "m" => array("(\d{1,2})", ccsMonth), "mm" => array("(\d{2})", ccsMonth), 
      "mmm" => array("(" . join("|", $CCSLocales->GetFormatInfo("MonthShortNames")) . ")", ccsShortMonth), 
      "mmmm" => array("(" . join("|", $CCSLocales->GetFormatInfo("MonthNames")) . ")", ccsFullMonth),
      "y" => array("\d{1,3}"), "yy" => array("(\d{2})", ccsYear), 
      "yyyy" => array("(\d{4})", ccsYear), "q" => array("\d"),
      "h" => array("(\d{1,2})", ccsHour), "hh" => array("(\d{2})", ccsHour), 
      "H" => array("(\d{1,2})", ccsHour), "HH" => array("(\d{2})", ccsHour),
      "n" => array("(\d{1,2})", ccsMinute), "nn" => array("(\d{2})", ccsMinute), 
      "s" => array("(\d{1,2})", ccsSecond), "ss" => array("(\d{2})", ccsSecond), 
      "AM/PM" => array("(AM|PM)", ccsAmPm), "am/pm" => array("(am|pm)", ccsAmPm), 
      "A/P" => array("(A|P)", ccsAmPm), "a/p" => array("(a|p)", ccsAmPm),
      "a/p" => array("(a|p)", ccsAmPm),
      "tt" => array("(" . $CCSLocales->GetFormatInfo("AMDesignator") . "|" . $CCSLocales->GetFormatInfo("PMDesignator") . ")", ccsAmPm), 
      "GMT" => array("([\+\-]\d{2})", ccsGMT), 
      "S" => array("(\d{1,6})", ccsMilliSecond)
    );
    $RegExp[0] = "";
    $RegExpIndex = 1;
    $is_date = false; $is_datetime = false;
    for($i = 0; $i < sizeof($FormatMask); $i++)
    {
      if ($FormatMask[$i] == "GeneralDate") 
      {
        $reg = CCGetDateRegExp($CCSLocales->GetFormatInfo("GeneralDate"));
        $RegExp[0] .= substr($reg[0], 2, strlen($reg[0]) - 5);
        $is_datetime = true;
        for ($j=1; $j < sizeof($reg); $j++) {
          $RegExp[$RegExpIndex++] = $reg[$j];
        }
      }
      else if ($FormatMask[$i] == "LongDate" || $FormatMask[$i] == "ShortDate") 
      {
        $reg = CCGetDateRegExp($CCSLocales->GetFormatInfo($FormatMask[$i]));
        $RegExp[0] .= substr($reg[0], 2, strlen($reg[0]) - 5);
        $is_date = true;
        for ($j=1; $j < sizeof($reg); $j++) {
          $RegExp[$RegExpIndex++] = $reg[$j];
        }
      }
      else if ($FormatMask[$i] == "LongTime" || $FormatMask[$i] == "ShortTime") 
      {
        $reg = CCGetDateRegExp($CCSLocales->GetFormatInfo($FormatMask[$i]));
        $RegExp[0] .= substr($reg[0], 2, strlen($reg[0]) - 5);
        for ($j=1; $j < sizeof($reg); $j++) {
          $RegExp[$RegExpIndex++] = $reg[$j];
        }
      }
      else if(isset($masks[$FormatMask[$i]]))
      {
        $MaskArray = $masks[$FormatMask[$i]];
        if($i == 0 && ($MaskArray[1] == ccsYear || $MaskArray[1] == ccsMonth 
          || $MaskArray[1] == ccsFullMonth || $MaskArray[1] == ccsWeek || $MaskArray[1] == ccsDay))
          $is_date = true;
        else if($is_date && !$is_datetime && $MaskArray[1] == ccsHour)
          $is_datetime = true;
        $RegExp[0] .= $MaskArray[0];
        if($is_datetime) $RegExp[0] .= "?";
        for($j = 1; $j < sizeof($MaskArray); $j++)
          $RegExp[$RegExpIndex++] = $MaskArray[$j];
      }
      else
      {
        if($is_date && !$is_datetime && $i < sizeof($FormatMask) && $masks[$FormatMask[$i + 1]][1] == ccsHour)
          $is_datetime = true;
        $RegExp[0] .= CCAddEscape($FormatMask[$i]);
        if($is_datetime) $RegExp[0] .= "?";
      }
    }
    $RegExp[0] = str_replace(" ", "\s*", $RegExp[0]);
    $RegExp[0] = "/^" . $RegExp[0] . "$/i";
  }

  return $RegExp;
}
//End CCGetDateRegExp

//CCAddEscape @0-06D50C27
function CCAddEscape($FormatMask)
{
  $meta_characters = array("\\", "^", "\$", ".", "[", "|", "(", ")", "?", "*", "+", "{", "-", "]", "/");
  for($i = 0; $i < sizeof($meta_characters); $i++)
    $FormatMask = str_replace($meta_characters[$i], "\\" . $meta_characters[$i], $FormatMask);
  return $FormatMask;
}
//End CCAddEscape

//CCGetIndex @0-8DB8E12C
function CCGetIndex($ArrayValues, $Value, $IgnoreCase = true)
{
  $index = false;
  for($i = 0; $i < sizeof($ArrayValues); $i++)
  {
    if(($IgnoreCase && strtoupper($ArrayValues[$i]) == strtoupper($Value)) || ($ArrayValues[$i] == $Value))
    {
      $index = $i;
      break;
    }
  }
  return $index;
}
//End CCGetIndex

//CCFormatNumber @0-4DC9D3EB
function CCFormatNumber($NumberToFormat, $FormatArray, $DataType = ccsFloat)
{
  global $CCSLocales;
  $Result = "";
  if(is_array($FormatArray) && strlen($NumberToFormat))
  {
    $IsExtendedFormat = $FormatArray[0];
    $IsNegative = ($NumberToFormat < 0);
    $NumberToFormat = abs($NumberToFormat);
    $NumberToFormat *= $FormatArray[7];
  
    if($IsExtendedFormat) // Extended format
    {
      $DecimalSeparator        = !is_null($FormatArray[2]) ? $FormatArray[2] : $CCSLocales->GetFormatInfo("DecimalSeparator");
      $PeriodSeparator         = !is_null($FormatArray[3]) ? $FormatArray[3] : $CCSLocales->GetFormatInfo("GroupSeparator");

      $ObligatoryBeforeDecimal = 0;
      $DigitsBeforeDecimal = 0;
      $BeforeDecimal = $FormatArray[5];
      $AfterDecimal = !is_null($FormatArray[6]) ? $FormatArray[6] : ($DataType != ccsInteger ? $CCSLocales->GetFormatInfo("DecimalDigits") : 0);
      if(is_array($BeforeDecimal)) {
        for($i = 0; $i < sizeof($BeforeDecimal); $i++) {
          if($BeforeDecimal[$i] == "0") {
            $ObligatoryBeforeDecimal++;
            $DigitsBeforeDecimal++;
          } else if($BeforeDecimal[$i] == "#") 
            $DigitsBeforeDecimal++;
        }
      }
      $ObligatoryAfterDecimal = 0;
      $DigitsAfterDecimal = 0;
      if(is_array($AfterDecimal)) {
        for($i = 0; $i < sizeof($AfterDecimal); $i++) {
          if($AfterDecimal[$i] == "0") {
            $ObligatoryAfterDecimal++;
            $DigitsAfterDecimal++;
          } else if($AfterDecimal[$i] == "#")
            $DigitsAfterDecimal++;
        }
      }
  
      $NumberToFormat = number_format($NumberToFormat, $DigitsAfterDecimal, ".", "");
      $NumberParts = explode(".", $NumberToFormat);

      $LeftPart = $NumberParts[0];
      if($LeftPart == "0") $LeftPart = "";
      $RightPart = isset($NumberParts[1]) ? $NumberParts[1] : "";
      $j = strlen($LeftPart);
    
      if(is_array($BeforeDecimal))
      {
        $RankNumber = 0;
        $i = sizeof($BeforeDecimal);
        while ($i > 0 || $j > 0)
        {
          if(($i > 0 && ($BeforeDecimal[$i - 1] == "#" || $BeforeDecimal[$i - 1] == "0")) || ($j > 0 && $i < 1)) {
            $RankNumber++;
            $CurrentSeparator = ($RankNumber % 3 == 1 && $RankNumber > 3 && $j > 0) ? $PeriodSeparator : "";
            if($ObligatoryBeforeDecimal > 0 && $j < 1)
              $Result = "0" . $CurrentSeparator . $Result;
            else if($j > 0)
              $Result = $LeftPart[$j - 1] . $CurrentSeparator . $Result;
            $j--;
            $ObligatoryBeforeDecimal--;
            $DigitsBeforeDecimal--;
            if($DigitsBeforeDecimal == 0 && $j > 0)
              for(;$j > 0; $j--)
              {
                $RankNumber++;
                $CurrentSeparator = ($RankNumber % 3 == 1 && $RankNumber > 3 && $j > 0) ? $PeriodSeparator : "";
                $Result = $LeftPart[$j - 1] . $CurrentSeparator . $Result;
              }
          }
          else if ($i > 0) {
            $BeforeDecimal[$i - 1] = str_replace("##", "#", $BeforeDecimal[$i - 1]);
            $BeforeDecimal[$i - 1] = str_replace("00", "0", $BeforeDecimal[$i - 1]);
            $Result = $BeforeDecimal[$i - 1] . $Result;
          }
          $i--;
        }
      }

      // Left part after decimal
      $RightResult = "";
      $IsRightNumber = false;
      if(is_array($AfterDecimal))
      {
        $IsZero = true;
        for($i = sizeof($AfterDecimal); $i > 0; $i--) {
          if($AfterDecimal[$i - 1] == "#" || $AfterDecimal[$i - 1] == "0") {
            if($DigitsAfterDecimal > $ObligatoryAfterDecimal) {
              if($RightPart[$DigitsAfterDecimal - 1] != "0") 
                $IsZero = false;
              if(!$IsZero)
              {
                $RightResult = $RightPart[$DigitsAfterDecimal - 1] . $RightResult;
                $IsRightNumber = true;
              }
            } else {
              $RightResult = $RightPart[$DigitsAfterDecimal - 1] . $RightResult;
              $IsRightNumber = true;
            }
            $DigitsAfterDecimal--;
          } else {
            $AfterDecimal[$i - 1] = str_replace("##", "#", $AfterDecimal[$i - 1]);
            $AfterDecimal[$i - 1] = str_replace("00", "0", $AfterDecimal[$i - 1]);
            $RightResult = $AfterDecimal[$i - 1] . $RightResult;
          }
        }
      }
    
      if($IsRightNumber)
        $Result .= $DecimalSeparator ;

      $Result .= $RightResult;

      if(!$FormatArray[4] && $IsNegative && $Result)
        $Result = "-" . $Result;
    }
    else // Simple format
    {
      $DecimalSeparator = !is_null($FormatArray[2]) ? $FormatArray[2] : $CCSLocales->GetFormatInfo("DecimalSeparator");
      $PeriodSeparator = !is_null($FormatArray[3]) ? $FormatArray[3] : $CCSLocales->GetFormatInfo("GroupSeparator");
      $AfterDecimal = !is_null($FormatArray[1]) ? $FormatArray[1] : ($DataType != ccsInteger ? $CCSLocales->GetFormatInfo("DecimalDigits") : 0);

      $Result = number_format($NumberToFormat, $AfterDecimal, '.', ',');
      $Result = str_replace(".", '---', $Result);
      $Result = str_replace(",", '+++', $Result);
      $Result = str_replace("---", $DecimalSeparator, $Result);
      $Result = str_replace("+++", $PeriodSeparator, $Result);
      $Result = $FormatArray[5] . $Result . $FormatArray[6];
      if(!$FormatArray[4] && $IsNegative)
        $Result = "-" . $Result;
     
    }

    if(!$FormatArray[8])
      $Result = CCToHTML($Result);

    if(strlen($FormatArray[9]))
      $Result = "<FONT COLOR=\"" . $FormatArray[9] . "\">" . $Result . "</FONT>";
  }
  elseif (strlen($NumberToFormat))
  { 
    if ($DataType != ccsInteger) {
      $DecimalSeparator        = $CCSLocales->GetFormatInfo("DecimalSeparator");
      $Result = str_replace(",", $DecimalSeparator, $NumberToFormat);
      $Result = str_replace(".", $DecimalSeparator, $Result);
    } else {
      $Result = $NumberToFormat;
    }
  }

  return $Result;
}
//End CCFormatNumber

//CCValidateNumber @0-D53857C4
function CCValidateNumber($NumberValue, $FormatArray)
{
  $is_valid = true;
  if(strlen($NumberValue))
  {
    $NumberValue = CCCleanNumber($NumberValue, $FormatArray);
    $is_valid = is_numeric($NumberValue);
  }
  return $is_valid;
}

//End CCValidateNumber

//CCParseNumber @0-733509F3
function CCParseNumber($NumberValue, $FormatArray, $DataType)
{
  $NumberValue = CCCleanNumber($NumberValue, $FormatArray);
  if(is_array($FormatArray) && strlen($NumberValue))
  {

    if($FormatArray[4]) // Contains parenthesis
      $NumberValue = - abs(doubleval($NumberValue));

    $NumberValue /= $FormatArray[7];
  }

  if(strlen($NumberValue))
  {
    if($DataType == ccsFloat)
      $NumberValue = doubleval($NumberValue);
    else
      $NumberValue = round($NumberValue, 0);
  }

  return $NumberValue;
}
//End CCParseNumber

//CCCleanNumber @0-CCD1C315
function CCCleanNumber($NumberValue, $FormatArray)
{
  global $CCSLocales;
  if(is_array($FormatArray))
  {
    $IsExtendedFormat = $FormatArray[0];

    if($IsExtendedFormat) // Extended format
    {
      $BeforeDecimal = $FormatArray[5];
      $AfterDecimal = $FormatArray[6];
    
      if(is_array($BeforeDecimal))
      {
        for($i = sizeof($BeforeDecimal); $i > 0; $i--) {
          if($BeforeDecimal[$i - 1] != "#" && $BeforeDecimal[$i - 1] != "0") 
          {
            $search = $BeforeDecimal[$i - 1];
            $search = ($search == "##" || $search == "00") ? $search[0] : $search;
            $NumberValue = str_replace($search, "", $NumberValue);
          }
        }
      }

      if(is_array($AfterDecimal))
      {
        for($i = sizeof($AfterDecimal); $i > 0; $i--) {
          if($AfterDecimal[$i - 1] != "#" && $AfterDecimal[$i - 1] != "0") 
          {
            $search = $AfterDecimal[$i - 1];
            $search = ($search == "##" || $search == "00") ? $search[0] : $search;
            $NumberValue = str_replace($search, "", $NumberValue);
          }
        }
      }
    }
    else // Simple format
    {
      if(strlen($FormatArray[5]))
        $NumberValue = str_replace($FormatArray[5], "", $NumberValue);
      if(strlen($FormatArray[6]))
        $NumberValue = str_replace($FormatArray[6], "", $NumberValue);
    }
    $DecimalSeparator = !is_null($FormatArray[2]) ? $FormatArray[2] : $CCSLocales->GetFormatInfo("DecimalSeparator");
    $PeriodSeparator = !is_null($FormatArray[3]) ? $FormatArray[3] : $CCSLocales->GetFormatInfo("GroupSeparator");

    $NumberValue = str_replace($PeriodSeparator, "", $NumberValue); // Period separator
    $NumberValue = str_replace($DecimalSeparator, ".", $NumberValue); // Decimal separator

    if(strlen($FormatArray[9]))
    {
      $NumberValue = str_replace("<FONT COLOR=\"" . $FormatArray[9] . "\">", "", $NumberValue);
      $NumberValue = str_replace("</FONT>", "", $NumberValue);
    }
    return $NumberValue;
  }
  $NumberValue = str_replace($CCSLocales->GetFormatInfo("GroupSeparator"), "", $NumberValue);
  $NumberValue = str_replace($CCSLocales->GetFormatInfo("DecimalSeparator"), ".", $NumberValue);
  $NumberValue = preg_replace("/^(-?)(\\.\\d+)$/", "\${1}0\${2}", $NumberValue);

  return $NumberValue;
}
//End CCCleanNumber

//CCParseInteger @0-FDF2EE85
function CCParseInteger($NumberValue, $FormatArray)
{
  return CCParseNumber($NumberValue, $FormatArray, ccsInteger);
}
//End CCParseInteger

//CCParseFloat @0-C9EAEA95
function CCParseFloat($NumberValue, $FormatArray)
{
  return CCParseNumber($NumberValue, $FormatArray, ccsFloat);
}
//End CCParseFloat

//CCValidateBoolean @0-DFB0ECFA
function CCValidateBoolean($BooleanValue, $Format)
{
  return $BooleanValue == ""
     || strtolower($BooleanValue) == "true"
     || strtolower($BooleanValue) == "false"
     || strval($BooleanValue) == "0"
     || strval($BooleanValue) == "1"
     || (is_array($Format) 
        && (strtolower($BooleanValue) == strtolower($Format[0])
            || strtolower($BooleanValue) == strtolower($Format[1])
            || strtolower($BooleanValue) == strtolower($Format[2]))); 
}
//End CCValidateBoolean

//CCFormatBoolean @0-5B3F5CF9
function CCFormatBoolean($BooleanValue, $Format)
{
  $Result = $BooleanValue;

  if(is_array($Format)) {
    if($BooleanValue == 1)
      $Result = $Format[0];
    else if(strval($BooleanValue) == "0" || $BooleanValue === false)
      $Result = $Format[1];
    else
      $Result = $Format[2];
  }

  return $Result;
}
//End CCFormatBoolean

//CCParseBoolean @0-1DA49599
function CCParseBoolean($Value, $Format)
{
  if (is_array($Format)) {
    if (strtolower(strval($Value)) == strtolower(strval($Format[0])))
      return true;
    if (strtolower(strval($Value)) == strtolower(strval($Format[1])))
      return false;
    if (strtolower(strval($Value)) == strtolower(strval($Format[2])))
      return "";
  }
  if (strval($Value) == "0" || strtolower(strval($Value)) == "false")
    return false;
  if (strval($Value) == "1" || strtolower(strval($Value)) == "true")
    return true;
  return "";
}
//End CCParseBoolean

//CCGetBooleanFormat @0-B9D3DA0C
function CCGetBooleanFormat($Format)
{
  $FormatString = "";
  if(is_array($Format))
  {
    for($i = 0; $i < sizeof($Format); $i++) {
      if(strlen($Format[$i])) {
        if(strlen($FormatString)) $FormatString .= ";";
        $FormatString .= $Format[$i];
      }
    }
  }
  return $FormatString;
}
//End CCGetBooleanFormat

//CCCompareValues @0-8D9B429E
function CCCompareValues($Value1,$Value2,$DataType = ccsText, $Format = "")
{
  switch ($DataType) {
    case ccsInteger:
    case ccsFloat:
      if(strcmp(trim($Value1),"") == 0 || strcmp(trim($Value2),"") == 0)
        return strcmp($Value1, $Value2);
      else if($Value1 > $Value2)
        return 1;
      else if($Value1 < $Value2)
        return -1;
      else
        return 0;
  
    case ccsText:
    case ccsMemo:
      return strcmp($Value1,$Value2);

    case ccsBoolean:
      if (is_bool($Value1))
        $val1=$Value1;
      else if (strlen($Value1)!= 0 && CCValidateBoolean($Value1,$Format))
        $val1=CCParseBoolean($Value1,$Format);
      else 
        return 1;

      if (is_bool($Value2))
        $val2=$Value2;
      else if (strlen($Value2)!= 0 && CCValidateBoolean($Value2,$Format))
        $val2=CCParseBoolean($Value2,$Format);
      else 
        return 1;

      return $val1 xor $val2;
  
    case ccsDate:
      if (is_array($Value1) && is_array($Value2)) {
        $compare = array(ccsYear, ccsMonth, ccsDay, ccsHour, ccsMinute, ccsSecond);
        foreach ($compare as $ind => $val) {
          if ($Value1[$val] < $Value2[$val])
            return -1;
          elseif ($Value1[$val] > $Value2[$val])          
            return 1;
        }
        return 0;
      } else if(is_array($Value1)) {
        $FormattedValue = CCFormatValue($Value1, $Format, $DataType);
        return CCCompareValues($FormattedValue, $Value2);
      } else if(is_array($Value2)) {
        $FormattedValue = CCFormatValue($Value2, $Format, $DataType);
        return CCCompareValues($Value1,$FormattedValue);
      } else {
        return CCCompareValues($Value1,$Value2);
      }
    
  }
}
//End CCCompareValues

//CCDateAdd @0-7D13ED6A
function CCDateAdd($date, $value) {
  if (CCValidateDate($date)) {
    $FormatArray = array("yyyy", "-", "mm", "-", "dd", " ", "HH", ":", "nn", ":", "ss");
    $value = strtolower($value);
    preg_match_all("/([-+]?)(\\d+)\\s*(year(s?)|month(s?)|day(s?)|hour(s?)|minute(s?)|second(s?)|[ymdhns])/", $value, $pieces);
    for($i=0; $i<count($pieces[0]); $i++) {
      $rel = $pieces[1][$i] == "-" ? -$pieces[2][$i] : $pieces[2][$i];
      switch($pieces[3][$i]) {
        case "years":
        case "year":
        case "y": 
          $date[ccsYear] += $rel;
          break;
        case "months":
        case "month":
        case "m":
          $date[ccsMonth] += $rel;
          break;
        case "weeks":
        case "week":
        case "w":
          $date[ccsDay] += $rel * 7;
          break;
        case "days":
        case "day":
        case "d":
          $date[ccsDay] += $rel;
          break;
        case "hours":
        case "hour":
        case "h":
          $date[ccsHour] += $rel;
          break;
        case "minutes":
        case "minute":
        case "min":
        case "n":
          $date[ccsMinute] += $rel;
          break;
        case "seconds":
        case "second":
        case "sec":
        case "s":
          $date[ccsSecond] += $rel;
          break;
      }
      if ($date[ccsSecond] >= 60) {
        $date[ccsMinute] += floor($date[ccsSecond] / 60);
        $date[ccsSecond] = $date[ccsSecond] % 60;
      } elseif ($date[ccsSecond] < 0) {
        $date[ccsMinute] += floor($date[ccsSecond] / 60);
        $date[ccsSecond] = (($date[ccsSecond]) % 60 + 60) % 60;
      }
      if ($date[ccsMinute] >= 60) {
        $date[ccsHour] += floor($date[ccsMinute] / 60);
        $date[ccsMinute] = $date[ccsMinute] % 60;
      } elseif ($date[ccsMinute] < 0) {
        $date[ccsHour] += floor($date[ccsMinute] / 60);
        $date[ccsMinute] = ($date[ccsMinute] % 60 + 60) % 60;
      }
      if ($date[ccsHour] >= 24) {
        $date[ccsDay] += floor($date[ccsHour] / 24);
        $date[ccsHour] = $date[ccsHour] % 24;
      } elseif ($date[ccsHour] < 0) {
        $date[ccsDay] += floor($date[ccsHour] / 24);
        $date[ccsHour] = ($date[ccsHour] % 24 + 24) % 24;
      }
      if ($date[ccsMonth] > 12) {
        $date[ccsYear] += floor(($date[ccsMonth]) / 12);
        $date[ccsMonth] = ($date[ccsMonth]) % 12;
      } elseif ($date[ccsMonth] < 1) {
        $date[ccsYear] += floor(($date[ccsMonth] - 1) / 12);
        $date[ccsMonth] = (($date[ccsMonth] - 1) % 12 + 12) % 12 + 1;
      }
      $days = CCDaysInMonth($date[ccsYear], $date[ccsMonth]);
      while ($date[ccsDay] > $days) {
        $date[ccsMonth] += 1;
        if ($date[ccsMonth] > 12) {
          $date[ccsYear] += 1;
          $date[ccsMonth] = 1;
        }
        $date[ccsDay] = $date[ccsDay] - $days;
        $days = CCDaysInMonth($date[ccsYear], $date[ccsMonth]);
      }
      $tmpDate = "";
      while ($date[ccsDay] < 1) {
        if ($tmpDate == "")
          $tmpDate = CCParseDate(CCFormatDate($date, array("yyyy","-","mm","-01")), array("yyyy","-","mm","-","dd"));
        $tmpDate = CCDateAdd($tmpDate, "-1month");
        $days = CCDaysInMonth($tmpDate[ccsYear], $tmpDate[ccsMonth]);
        $date[ccsMonth] -= 1;
        if ($date[ccsMonth] == 0) {
          $date[ccsYear] -= 1;
          $date[ccsMonth] = 12;
        }
        $date[ccsDay] = $date[ccsDay] + $days;
      }
    }
    return $date;
  }
  return false;
}
//End CCDateAdd

//CCDaysInMonth @0-4DFC9A98
function CCDaysInMonth($year, $month) {
  switch ($month) {
    case 4:
    case 6:
    case 9:
    case 11:
      return 30;
    case 2:
       if ($year % 4)
         return 28;
       elseif ($year % 100)
         return 29;
       elseif ($year % 400)
         return 28;
       else return 29;
    default:
      return 31;
  }

}
//End CCDaysInMonth

//CCDayOfWeek @0-479679B3
function CCDayOfWeek($date) {
  //return 1 - Sun, 2 - Mon, 3 - Tue ...
  $year = $date[ccsYear];
  $month = $date[ccsMonth];
  $day = $date[ccsDay];
  $century = $year - ( $year % 100 );
  $base = array( 3, 2, 0, 5 );
  $base = $base[(($century - 1500) / 100 + 16) % 4];
  $twelves = intval(($year - $century )/12);
  $rem = ($year - $century) % 12;
  $fours = intval($rem / 4);
  $doomsday = $base + ($twelves + $rem + $fours) % 7;
  $doomsday = $doomsday % 7;

  $base = array( 0, 0, 7, 4, 9, 6, 11, 8, 5, 10, 7, 12 );
  if (CCDaysInMonth($year, 2) == 29) {
    $base[0] = 32;
    $base[1] = 29;
  } else {
    $base[0] = 31;
    $base[1] = 28;
  }
  $on = $day - $base[$month - 1];
  $on = $on % 7;
  return ($doomsday + $on + 7) % 7 + 1;
}
//End CCDayOfWeek

//CCDayOfYear @0-D35E28C6
function CCDayOfYear($date) {
  $days = 0;
  for ($month = 1; $month < $date[ccsMonth]; $month++)
    $days += CCDaysInMonth($date[ccsYear], $month);
  return $days + $date[ccsDay];
}
//End CCDayOfYear

//CCConvertEncoding @0-5177A761
function CCConvertEncoding($text, $from, $to)
{
    return $text;
}
//End CCConvertEncoding

//CCConvertEncodingArray @0-1F8BB9EF
function CCConvertEncodingArray($array, $from="", $to="")
{
    if (strlen($from) && strlen($to) && strcmp($from, $to)) {
        while (list($key, $value) = each($array))
            $array[$key] = CCConvertEncoding($value, $from, $to);
    }
    return $array;
}
//End CCConvertEncodingArray

//CCConvertDataArrays @0-303D5215
function CCConvertDataArrays($from="", $to="")
{
    global $FileEncoding;
    global $TemplateEncoding;
    global $CCSLocales;
    if ($from == "")
        $from = $CCSLocales->GetFormatInfo("PHPEncoding");
    if ($from == "")
        $from = $TemplateEncoding;
    if ($to == "")
        $to = $FileEncoding;
    if (strlen($from) && strlen($to) && strcmp($from, $to)) {
        $_POST = CCConvertEncodingArray($_POST, $from, $to);
        $_GET = CCConvertEncodingArray($_GET, $from, $to);
    }
}
//End CCConvertDataArrays

//CCGetOriginalFileName @0-16048768
function CCGetOriginalFileName($value)
{
    return preg_match("/^\d{14,}\./", $value) ? substr($value, strpos($value, ".") + 1) : $value;
}
//End CCGetOriginalFileName

//ComposeStrings @0-B7BE7781
function ComposeStrings($str1, $str2, $delimiter = "<br>")
{
    return $str1 . (strlen($str1) && strlen($str2) ? $delimiter : "") . $str2;
}
//End ComposeStrings

//CCSelectProjectStyle @0-943152D8
function CCSelectProjectStyle() {
    global $CCProjectStyle;
    $QueryStyle = CCGetFromGet("style");
    if ($QueryStyle) {
        CCSetProjectStyle($QueryStyle);
        CCSetSession("style", $CCProjectStyle);
        CCSetCookie("style", $CCProjectStyle, time() + 31536000);
        return;;
      
    }
    if (CCSetProjectStyle(CCGetSession("style")));
        return;
    CCSetProjectStyle(CCGetCookie("style"));
}
//End CCSelectProjectStyle

//CCSetProjectStyle @0-E7A8832F
function CCSetProjectStyle($NewStyle) {
    global $CCProjectStyle;
    $NewStyle = trim($NewStyle);
    if ($NewStyle && file_exists(RelativePath . "/Styles/" . $NewStyle . "/Style.css")) {
        $CCProjectStyle = $NewStyle;
        return true;
    }
    return false;
}
//End CCSetProjectStyle

//CCStrLen @0-3660E806
function CCStrLen($str, $encoding = false) {
    return strlen($str);
}
//End CCStrLen

//CCSubStr @0-552E6589
function CCSubStr($str, $offset, $length = null, $encoding = false) {
    return is_null($length) ? substr($str, $offset) : substr($str, $offset, $length);
}
//End CCSubStr

//CCStrPos @0-BA504839
function CCStrPos($haystack, $needle, $offset = "", $encoding = false) {
    return strpos($haystack, $needle, $offset);
}
//End CCStrPos

//CCCheckSSL @0-A8E1366D
function CCCheckSSL()
{
    $HTTPS = isset($_SERVER["HTTPS"]) ? strtolower($_SERVER["HTTPS"]) : "";
    if($HTTPS != "on")
    {
        echo "SSL connection error. This page can be accessed only via secured connection.";
        exit;
    }
}
//End CCCheckSSL

//CCSecurityRedirect @0-F212A7B7
function CCSecurityRedirect($GroupsAccess, $URL)
{
    global $_SERVER;
    $ReturnPage = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "";
    if(!strlen($ReturnPage)) {
        $ReturnPage = isset($_SERVER["SCRIPT_NAME"]) ? $_SERVER["SCRIPT_NAME"] : "";
        $QueryString = CCGetQueryString("QueryString", "");
        if($QueryString !== "")
            $ReturnPage .= "?" . $QueryString;
    }
    $ErrorType = CCSecurityAccessCheck($GroupsAccess);
    if($ErrorType != "success")
    {
        if(!strlen($URL))
            $Link = ServerURL . "login.php";
        else
            $Link = $URL;
        header("Location: " . $Link . "?ret_link=" . urlencode($ReturnPage) . "&type=" . $ErrorType);
        exit;
    }
}
//End CCSecurityRedirect

//CCSecurityAccessCheck @0-7B496647
function CCSecurityAccessCheck($GroupsAccess)
{
    $ErrorType = "success";
    if(!strlen(CCGetUserID()))
    {
        $ErrorType = "notLogged";
    }
    else
    {
        $GroupID = CCGetGroupID();
        if(!strlen($GroupID))
        {
            $ErrorType = "groupIDNotSet";
        }
        else
        {
            if(!CCUserInGroups($GroupID, $GroupsAccess))
                $ErrorType = "illegalGroup";
        }
    }
    return $ErrorType;
}
//End CCSecurityAccessCheck

//CCGetUserID @0-6FAFFFAE
function CCGetUserID()
{
    return CCGetSession("UserID");
}
//End CCGetUserID

//CCGetGroupID @0-89F10997
function CCGetGroupID()
{
    return CCGetSession("GroupID");
}
//End CCGetGroupID

//CCGetUserLogin @0-ACD25564
function CCGetUserLogin()
{
    return CCGetSession("UserLogin");
}
//End CCGetUserLogin

//CCGetUserPassword @0-D67B1DE1
function CCGetUserPassword()
{
    return "";
}
//End CCGetUserPassword

//CCUserInGroups @0-51407098
function CCUserInGroups($GroupID, $GroupsAccess)
{
    $Result = "";
    if(strlen($GroupsAccess))
    {
        $GroupNumber = intval($GroupID);
        while(!$Result && $GroupNumber > 0)
        {
            $Result = (strpos(";" . $GroupsAccess . ";", ";" . $GroupNumber . ";") !== false);
            $GroupNumber--;
        }
    }
    else
    {
        $Result = true;
    }
    return $Result;
}
//End CCUserInGroups

//CCLoginUser @0-83DAF025
function CCLoginUser($login, $password)
{
    $db = new clsDBcalendar();
    $SQL = "SELECT user_id, user_level FROM users WHERE user_login=" . $db->ToSQL($login, ccsText) . " AND user_password=" . $db->ToSQL($password, ccsText);
    $db->query($SQL);
    $Result = $db->next_record();
    if($Result)
    {
        CCSetSession("UserID", $db->f("user_id"));
        CCSetSession("UserLogin", $login);
        CCSetSession("GroupID", $db->f("user_level"));
    }
    $db->close();
    return $Result;
}
//End CCLoginUser

//CCLogoutUser @0-55C59DC5
function CCLogoutUser()
{
    CCSetSession("UserID", "");
    CCSetSession("UserLogin", "");
    CCSetSession("GroupID", "");
}
//End CCLogoutUser



global $CalendarIsInstalled;
$CalendarIsInstalled = true;

if ($CalendarIsInstalled) {
	include(RelativePath . "/phpmail.php");
	include(RelativePath . "/common_functions.php");
} else {
	if (FileName != "install.php")
		header("Location: " . RelativePath . "/install/install.php");
}

?>
