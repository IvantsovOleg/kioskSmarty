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
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'ВВОД ДАННЫХ');
   
  // echo $_SESSION['CAB'];
  // echo $_SESSION['KART'];

	$dms = $_SESSION['DMS'];
	$SEARCH_BY_POLICE = $_SESSION['SEARCH_BY_POLICE'];	
  
  if ($_POST)
  {
	// для окна подтверждения:
	$dayweek = $_POST['dayweek'];
	$date_str = $_POST['date_str'];
	$dat = $_POST['dat'];
	$numbid = $_POST['numbid'];
	$userdata = $_POST['userdata'];
	$pat_numbers = $_POST['pat_numbers'];
	//print_r($_POST);
	
	if ($SEARCH_BY_POLICE == 1 && $dms != 1)	// Запись по ОМС и полису
	{
		$seria = $userdata[0];
		$number_police = $userdata[1];
		$birthday = $userdata[2];
		$policeid = doCheckPatientNew($seria, $number_police, $birthday, '');
	}
	elseif ($SEARCH_BY_POLICE == 0 && $dms == 0)	// запись по ОМС и ФИО
	{
		// print_r($userdata);
		$lastname = $userdata[0];
		$firstname = $userdata[1];
		$secondname = $userdata[2];
		$birthday = $userdata[3];
		$policeid = doCheckPatientAdvanced($lastname, $firstname, $secondname, $birthday, '');		
	}
	// если он есть, записать
	if ($policeid > 0 && $policeid != '')
	{
			// выдать окошко подтверждения с таблицей: дата-время, и кнопкой "подтвердить"
		
			$_SESSION['DAT'] = $dat;
			$_SESSION['DAYWEEK'] = $dayweek;
			$_SESSION['DATE_STR'] = $date_str;
			$_SESSION['NUMBID'] = $numbid;
			$_SESSION['STATUS'] = 0;
			
			if ($pat_numbers == 1)
				echo "<script>window.location.href='pat_numbers.php?PAT_NUMBERS=".$_SESSION['PATIENTID']."'</script>";
			else
				echo "<script>window.location.href='userdata_confirm.php'</script>";
	}
	// если полиса и пациента нет, выдать сообщение об ошибке	
	elseif (($policeid <= 0 || $policeid == '') || $dms == 1)
	{
		$lastname = $userdata[0];
		$firstname = $userdata[1];
		$secondname = $userdata[2];
		$birthday = $userdata[3];
		// тут прописать функцию поиска пациента по ФИО в случае, если у него нет полиса
		$patientid = doCheckPatientByFio($lastname, $firstname, $secondname, $birthday, '');
		//echo $patientid;
		
		$_SESSION['DAT'] = $dat;
		$_SESSION['DAYWEEK'] = $dayweek;
		$_SESSION['DATE_STR'] = $date_str;
		$_SESSION['NUMBID'] = $numbid;
		$_SESSION['STATUS'] = 0;		
		
		if ($patientid > 0)
		{
			if ($pat_numbers == 1)
				echo "<script>window.location.href='pat_numbers.php?PAT_NUMBERS=".$_SESSION['PATIENTID']."'</script>";
			else
				echo "<script>window.location.href='userdata_confirm.php'</script>";
		}
		else
		{
			if ($_SESSION['CREATE_PATIENT'] == 1 && $pat_numbers != 1)		// разрешено
			{
				// запомнить телефон
				$_SESSION['PATIENT_INFO'] = $lastname.' '.$firstname.' '.$secondname. '(' . $birthday . ')';
				echo "<script>window.location.href='userdata_confirm.php'</script>";
			}
			elseif ($_SESSION['CREATE_PATIENT'] == 0 || $pat_numbers == 1)		// НЕ разрешено
			{
				// вывести блок с сообщением о неверных данных
				$smarty->assign("ENTERING", 1);
				$smarty->display("smarty/templates/userdata_error.tpl");	
			}
		}
	}
  }
  // если никакие данные не передавались POST, только GET
  elseif (!$_POST)
  {
	   $smarty->display("smarty/templates/header.tpl");
	  $dayweek = GetGet('dayweek');
	  $date_str = GetGet('date_str');
	  $dat = GetGet('dat');
	  $room = GetGet('room');
	  $numbid = GetGet('numbid');	
	  $room = GetGet('room');	  
	  
	  if ($_SESSION['SEARCH_BY_POLICE'] == 0 || $dms == 1)
		$smarty->assign("SEARCH_BY_POLICE", 0);
	  elseif ($_SESSION['SEARCH_BY_POLICE'] == 1 && $dms != 1)
		$smarty->assign("SEARCH_BY_POLICE", 1);
	  
	 // переданные переменные сохранить в Smarty - hidden.
	  $smarty->assign("DAYWEEK", $dayweek);
	  $smarty->assign("DATE_STR", $date_str);
	  $smarty->assign("DAT", $dat);
	  $smarty->assign("NUMBID", $numbid);
      $smarty->display("smarty/templates/userdata.tpl");
	  $smarty->display("smarty/templates/footer.tpl");
  }
  
  // временная блокировка номерка между тем как пользователь выбрал номерок и пока еще не авторизовался
  if (isset($numbid)) {
	blockNumbById($numbid);
  }
?>

<?php 
// ======================= блок, описывающий функции 
// функция записи пациента:
function doCheckPatientAdvanced($lastname, $firstname, $secondname, $birthday, $companyid)
{
    require_once 'conn.php';
    $command = "INFOMAT_CHECK_PATIENT_ADVANCED";
    $params = array(array("NAME" => "LASTNAME",     "VALUE" => $lastname),
                    array("NAME" => "FIRSTNAME",    "VALUE" => $firstname),
                    array("NAME" => "SECONDNAME",   "VALUE" => $secondname),
                    array("NAME" => "BIRTHDAY",     "VALUE" => $birthday),
                    array("NAME" => "COMPANYID",    "VALUE" => $companyid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
    if (!is_array($result) || $errorMsg != "")
        return "ERR:-1;";
    $policeid     = $result[0]['POLICEID'];
    $patientid    = $result[0]['PATIENTID'];
    $patient_info = $result[0]['PATIENT_INFO'];   
	$errorText = $result[0]['ERROR_TEXT'];   
    unset ($result);    
	
    $_SESSION['POLICEID'] = $policeid;
    $_SESSION['PATIENTID'] = $patientid;
    $_SESSION['PATIENT_INFO'] = $patient_info;
	$_SESSION['ERRORTEXT'] = $errorText;
    return $policeid;
}

function doCheckPatientNew($seria, $number_police, $birthday, $companyid)
{
    require_once 'conn.php';
    $command = "INFOMAT_CHECK_PATIENT_NEW";
       $params = array(array("NAME" => "SER",          "VALUE" => $seria),
                        array("NAME" => "NUM",          "VALUE" => $number_police),
                        array("NAME" => "BIRTHDAY2",    "VALUE" => $birthday),
                        array("NAME" => "COMPANYID",    "VALUE" => $companyid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	
    if (!is_array($result) || $errorMsg != "")
        return "ERR:-1;";
    $policeid     = $result[0]['POLICEID'];
    $patientid    = $result[0]['PATIENTID'];
    $patient_info = $result[0]['PATIENT_INFO'];   
	$errorText = $result[0]['ERROR_TEXT'];   
    unset ($result);    
	
    $_SESSION['POLICEID'] = $policeid;
    $_SESSION['PATIENTID'] = $patientid;
    $_SESSION['PATIENT_INFO'] = $patient_info;
	$_SESSION['ERRORTEXT'] = $errorText;
    return $policeid;	
}

function doCheckPatientByFio ($lastname, $firstname, $secondname, $birthday, $companyid)
{
	require_once 'conn.php';
    $command = "INFOMAT_CHECK_PATIENT_FIO";
    $params = array(array("NAME" => "LASTNAME",     "VALUE" => $lastname),
                    array("NAME" => "FIRSTNAME",    "VALUE" => $firstname),
                    array("NAME" => "SECONDNAME",   "VALUE" => $secondname),
                    array("NAME" => "BIRTHDAY",     "VALUE" => $birthday),
                    array("NAME" => "COMPANYID",    "VALUE" => $companyid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
    if (!is_array($result) || $errorMsg != "")
        return "ERR:-1;";
    $policeid     = $result[0]['POLICEID'];
    $patientid    = $result[0]['PATIENTID'];
    $patient_info = $result[0]['PATIENT_INFO'];   
	$errorText = $result[0]['ERROR_TEXT'];   
    unset ($result);    
	
    $_SESSION['POLICEID'] = $policeid;
    $_SESSION['PATIENTID'] = $patientid;
    $_SESSION['PATIENT_INFO'] = $patient_info;
	$_SESSION['ERRORTEXT'] = $errorText;
	
	return $patientid;
}

function blockNumbById($numbid) // функция временной блокировки номерка между тем как пользователь выбрал номерок и пока еще не авторизовался
{
    require_once 'conn.php';
    $command = "INFOMAT_NUMB_RESERVE";
    $params = array(array("NAME" => "NUMBID", "VALUE" => $numbid));
    $result = array();
    $errorMsg = "";
	makeRequest($command, $params, $result, $errorMsg);
    if ($errorMsg != "")
		return $errorMsg;
	else 
		return $result;
}
?>