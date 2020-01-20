<?php
  header("Content-Type: text/html; charset=utf-8");    

  require_once "utils.php";
  require_once "smarty/libs/smarty.class.php";
  require_once "conn.php";
  require_once "xmlhelper.php";
  include "php_serial.class.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
  // назначение переменных
  $smarty->assign("HOME", 'yes');
  $smarty->assign("HEAD_NAME", 'ВВОД ДАННЫХ');
 $smarty->display("smarty/templates/header.tpl");
  
  $policeid = $_SESSION['POLICEID'];
  $patientid = $_SESSION['PATIENTID'];
  $numbid = $_POST['numbid'];
  $newphone = $_POST['newphone'];
  
  // если разрешено создание пациентов, то занести в базу с нулевой картой
  if ($_SESSION['CREATE_PATIENT'] == 1 && $patientid <= 0)
  {
    $policeid = 0;
    $patientid = createTempPatient($smarty, $newphone, $numbid);
	
	  if (doAssignComplete($smarty, $numbid, $patientid, $errorText))
	  {
		  $lu = lpuParamsSelect($_SESSION['XMLServerURL'], "NAME");
		  $addr = lpuParamsSelect($_SESSION['XMLServerURL'], "ADDRESS");
		  getDataForStattalon($smarty, $numbid);
		  
		  // Необходимые параметры для печати номерка
		  $smarty->assign("TIME", $_SESSION['DATE_STR'].", ".$_SESSION['DAT']);
		  $smarty->assign("PAT_INFO", $_SESSION['PATIENT_INFO']);
		  $smarty->assign("SPECNAME", $_SESSION['SPECNAME']);
		  $smarty->assign("DOCNAME", $_SESSION['DOCNAME']);
		  $smarty->assign("MODE", $_SESSION['DMS']);
		  $smarty->assign("CAB", $_SESSION['CAB']);
		  $smarty->assign("KART", $_SESSION['KART']);
		  $smarty->assign("LPU_NAME", $lu);
		  $smarty->assign("LPU_ADDRESS", $addr);
		  
		  // Для штрих-кода
		  $smarty->assign("VISITID", $_SESSION['VISITID']);
		  $smarty->display("smarty/templates/userdata_success.tpl");		
	  }
	  else 
	  {
		  // сообщение об ошибке
		  $smarty->assign("ERR_MES", 'Запись не прошла!Попробуйте ещё раз.');
		  $smarty->assign("ENTERING", 0);
		  $smarty->display("smarty/templates/userdata_error.tpl");
	  } 
  }
  elseif ($_SESSION['CREATE_PATIENT'] == 0 || ($_SESSION['CREATE_PATIENT'] == 1 && $patientid > 0))
  {
	  if (doAssignComplete($smarty, $numbid, $policeid, $errorText))
	  {
		  $lu = lpuParamsSelect($_SESSION['XMLServerURL'], "NAME");
		  $addr = lpuParamsSelect($_SESSION['XMLServerURL'], "ADDRESS");
		 // echo $_SESSION['CAB'];
		  // тут получить все для статталона
		  getDataForStattalon($smarty, $numbid);
		  
		  // сообщение об успешной записи
		  $smarty->assign("STATUS", 1);
		  
		  // Необходимые параметры для печати номерка
		  $smarty->assign("TIME", $_SESSION['DATE_STR'].", ".$_SESSION['DAT']);
		  $smarty->assign("PAT_INFO", $_SESSION['PATIENT_INFO']);
		  $smarty->assign("SPECNAME", $_SESSION['SPECNAME']);
		  $smarty->assign("DOCNAME", $_SESSION['DOCNAME']);
		  $smarty->assign("MODE", $_SESSION['DMS']);
		  $smarty->assign("CAB", $_SESSION['CAB']);
		  $smarty->assign("KART", $_SESSION['KART']);
		  $smarty->assign("LPU_NAME", $lu);
		  $smarty->assign("LPU_ADDRESS", $addr);
		  
		 // Для штрих-кода
		  $smarty->assign("VISITID", $_SESSION['VISITID']);
		  $smarty->display("smarty/templates/userdata_success.tpl");
	  }
	  else 
	  {
		  // сообщение об ошибке
		  $smarty->assign("ERR_MES", 'Запись не прошла!Попробуйте ещё раз.');
		  $smarty->assign("ENTERING", 0);
		  $smarty->display("smarty/templates/userdata_error.tpl");
	  } 
  }

  $smarty->display("smarty/templates/footer.tpl");
?>

<?php
// ======================= блок, описывающий функции

// создание временной карты пациента
function createTempPatient($smarty, $newphone, $numbid)
{
	$command = "INFOMAT_CREATE_TEMP_PAT";
	$params = array(array("NAME" => "MODE", "VALUE" => 1),
					array("NAME" => "NUMBID", "VALUE" => $numbid),
					array("NAME" => "NEWPHONE", "VALUE" => $newphone));
	$result = array();
	$errorMsg = "";
	makeRequest($command, $params, $result, $errorMsg);
	
	// получаем patientid
	if (!is_array($result) || $errorMsg != "")
		return "-1";
		
	$patientid = $result[0]['PATIENTID'];	
	
	unset ($result);
	
	$_SESSION['PATIENTID'] = $patientid;
	
	return $patientid;
}

function getDataForStattalon($smarty, $numbid)
{
	require_once 'conn.php';
    $command = "INFOMAT_DATA_STATTALON";
    $params = array(array("NAME" => "NUMBID",     "VALUE" => $numbid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);

		$num = $result[0]['NUM'];
		$fio = $result[0]['FIO'];
		$bd = $result[0]['BIRTH_DATE'];
		$social_status = $result[0]['SOCIAL_STATUS'];
		$company = $result[0]['COMPANY'];
		$police = $result[0]['POLICE'];
		$passport = $result[0]['PASSPORT'];
		$address = $result[0]['ADDRESS'];
		$priv = $result[0]['PRIV'];
		$years = $result[0]['YEARS'];
		$sex = $result[0]['SEX'];
		$phone = $result[0]['PHONE'];
		$snils = $result[0]['SNILS'];
		$room = $result[0]['ROOM'];
		$time = $result[0]['TIME'];
		$doctor = $result[0]['DOCTOR'];
	
	// обработка "года-лет"
	//$age = getYears($years);
	
	$smarty->assign("NUM", $num);
	$smarty->assign("FIO", $fio);
	$smarty->assign("BIRTH_DATE", $bd);
	$smarty->assign("SOCIAL_STATUS", $social_status);
	$smarty->assign("COMPANY", $company);
	$smarty->assign("POLICE", $police);
	$smarty->assign("PASSPORT", $passport);
	$smarty->assign("ADDRESS", $address);
	$smarty->assign("PRIV", $priv);
	$smarty->assign("YEARS", $years);
	$smarty->assign("SEX", $sex);
	$smarty->assign("PHONE", $phone);
	$smarty->assign("SNILS", $snils);
	$smarty->assign("ROOM", $room);
	$smarty->assign("TIME", $time);
	$smarty->assign("DOCTOR", $doctor);	
}


// функция записи пользователя:
function doAssignComplete($smarty, $fnumbid, $policeid, $errorText)
{
    require_once 'conn.php';
	
	if ($_SESSION['POLICEID'] <= 0)
	{
		$com = "INFOMAT_ASSIGN_COMPLETE_PAT";
		$p = "PATIENTID";
		$policeid = $_SESSION['PATIENTID'];
	}
	elseif ($_SESSION['POLICEID'] > 0)
	{
		$com = "INFOMAT_ASSIGN_COMPLETE";
		$p = "POLICEID";
		$policeid = $_SESSION['POLICEID'];
	}
	
    $XMLCmd = new xml_output();
    $XMLCmd->startXML();
    $XMLCmd->elementStart("CMD", array("name" => $com, "userid" => "0000+-2"));
    $XMLCmd->element("PARAM",array("name" => $p),  $policeid);
    $XMLCmd->element("PARAM",array("name" => "NUMBID"),    $fnumbid);
    $XMLCmd->element("PARAM",array("name" => "COMPANYID"), '');
	$XMLCmd->elementEnd("CMD");
    $xmlData = $XMLCmd->endXML();
    $g_XMLServerURL = $_SESSION['XMLServerURL'];
    $fp = @stream_socket_client($g_XMLServerURL, $errno, $errstr, 10);
    if (!$fp) 
        return FALSE;
    else  
        fwrite_stream($fp, $xmlData . "\r\n");
    $result = fread_stream($fp);        
    fclose($fp);
    fixXML($result);
    $xmlInput = new xml_input($result);
    $xmlInput->parseXML();
   if ($xmlInput->isTable == FALSE || $xmlInput->errorText != "")
    {
        if ($xmlInput->errorText != "")
            $errorText = $xmlInput->errorText;
        else
            $errorText = "Ошибка получения данных";
			
		$_SESSION['ERRORTEXT'] = $errorText;
		//echo $_SESSION['ERRORTEXT'];			
			
        return FALSE;
    }
    unset ($result);
    if ($xmlInput->tableData[0]['ERROR_TEXT'] != "")
    {
        $errorText = $xmlInput->tableData[0]['ERROR_TEXT'];
        $errorText = str_replace(chr(10), '</br></br>', $errorText);
		$_SESSION['ERRORTEXT'] = $errorText;
		//	echo $_SESSION['ERRORTEXT'];
        return false;
    }
	
	$_SESSION['VISITID'] = $xmlInput->tableData[0]['VISITID'];
	
    $smarty->assign("dat"   , $xmlInput->tableData[0]['DAT']);
    $smarty->assign("doctor", $xmlInput->tableData[0]['DOCTOR']);
    $smarty->assign("spec"  , $xmlInput->tableData[0]['SPEC']);
    return true;
}

  function clearSession()
   {
       foreach ($_SESSION as $key => $value)
	   {
			unset($_SESSION[$key]);	
	   }
   }
?>