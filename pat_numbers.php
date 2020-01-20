<?php
  header("Content-Type: text/html; charset=utf-8");    

  require_once "utils.php";
  require_once "smarty/libs/smarty.class.php";
  require_once "conn.php";
  require_once "xmlhelper.php";

  session_start();
  
  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'ВВОД ДАННЫХ - ОТМЕНА ЗАПИСИ');
  
  // ввести данные
  if ($_POST && !$_GET['PAT_NUMBERS'])
  {
	$police_search = $_SESSION['SEARCH_BY_POLICE']; 
	if ($police_search == 0)		// ФИО
	{
		$lastname = GetPost('lastname');
		$firstname =  GetPost('firstname');
		$secondname =  GetPost('secondname');
		$bd =  GetPost('birthday');
		
		$patientid = doCheckPatientByFio($lastname, $firstname, $secondname, $bd, $companyid);
	}
	elseif ($police_search == 1)	// полис
	{
		$ser =  GetPost('seria');
		$num =  GetPost('number_police');
		$bd =  GetPost('birthday');
		
		$patientid = doCheckPatient($ser, $num, $bd);
	}
	
	if ($patientid == '' || $patientid <= 0)		// пациент не найден
	{
		$smarty->assign("PAT_ERRORMES", 1);
	}
	elseif ($patientid > 0)			// пациент найден
	{
		$smarty->assign("PAT_ERRORMES", 0);
		getPatientNumbs($smarty, $patientid);
	}
	
	$smarty->display("smarty/templates/header.tpl");
	$smarty->display("smarty/templates/pat_numbers.tpl");
	$smarty->display("smarty/templates/footer.tpl");
  }
  elseif (!$_POST && !$_GET['PAT_NUMBERS'])
  {
	  // назначить текстовое поле, отвечающее за то, откуда проведена запись
	  $smarty->assign("PAT_NUMBERS", 1);
	  $smarty->display("smarty/templates/header.tpl");
	  $smarty->display("smarty/templates/userdata.tpl");
	  $smarty->display("smarty/templates/footer.tpl");	
  }
  // если тут прислан id пациента просто гэтом, ищем для него номерки
  elseif (!$_POST && $_GET['PAT_NUMBERS'])
  {
	$patientid = GetGet('PAT_NUMBERS');
	$smarty->assign("PAT_ERRORMES", 0);
	getPatientNumbs($smarty, $patientid);
	
	$smarty->display("smarty/templates/header.tpl");
	$smarty->display("smarty/templates/pat_numbers.tpl");
	$smarty->display("smarty/templates/footer.tpl");
  }
?>

<?php
// получение номерков пациентов
function getPatientNumbs($smarty, $patientid)	
{
	require_once 'conn.php';
    $command = "INFOMAT_PATIENT_NUMBS";
    $params = array(array("NAME" => "PATIENTID", "VALUE" => $patientid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	$i = 0;
	$data = array();
	
	if (is_array($result) && count($result) > 0)
	{
		foreach ($result as $element)
		{
			if ($i < 5)
			{
				$data[$i]['KEYID'] = $element['KEYID'];
				$data[$i]['DOCNAME'] = $element['DOCNAME'];
				$data[$i]['SPECNAME'] = $element['SPECNAME'];
				$data[$i]['DAT'] = dateStringMonth($element['DAT']);
				$data[$i]['TIME'] = $element['TIME'];
				$data[$i]['DAYWEEK'] = $element['DAYWEEK'];
			}
			$i++;
		}
		if (is_array($data) && count($data) > 0)
			$smarty->assign("DATA", $data);
		if (count($result) > 5)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
		}
		else
			$smarty->assign("MORELESS", 0);
		
		unset ($result);
		unset ($data);
	}
	else 
	{
		$smarty->assign("NO_NUM", 1);
	}
}

function doCheckPatient($ser, $num, $birthday2)
{
    require_once 'conn.php';
    $command = "INFOMAT_CHECK_PATIENT_NEW";
    $params = array(array("NAME" => "SER",          "VALUE" => $ser),
                    array("NAME" => "NUM",          "VALUE" => $num),
                    array("NAME" => "BIRTHDAY2",    "VALUE" => $birthday2),
                    array("NAME" => "COMPANYID",    "VALUE" => ''));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
    
    if (!is_array($result) || $errorMsg != "")
        return "ERR:-3;";
     
    $policeid     = $result[0]['POLICEID'];
    $patientid    = $result[0]['PATIENTID'];
    $patient_info = $result[0]['PATIENT_INFO'];
     
    unset ($result);
        
    $_SESSION['POLICEID'] = $policeid;
    $_SESSION['PATIENTID'] = $patientid;
    $_SESSION['PATIENT_INFO'] = $patient_info;
    return $patientid;
}

	// идентификатор пациента
	function doCheckPatientByFio($lastname, $firstname, $secondname, $birthday, $companyid)
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
		$patientid    = $result[0]['PATIENTID'];
		$patient_info = $result[0]['PATIENT_INFO'];    
		unset ($result);    

		$_SESSION['PATIENTID'] = $patientid;
		$_SESSION['PATIENT_INFO'] = $patient_info;
		
		return $patientid;
	}  
?>