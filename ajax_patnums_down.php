<?php
  header("Content-Type: text/html; charset=utf-8");    

  require "utils.php";
  require "smarty/libs/smarty.class.php";
  require "conn.php";
  require "xmlhelper.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
// print_r($_POST);
  
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  
  $patientid = $_SESSION['PATIENTID'];
 // echo $patientid;
  $inet_filter = $_SESSION['FILTER_INET'];
  getPatientNumbs($smarty, $inet_filter, $bord_down, $patientid);
    
  $smarty->display("smarty/templates/ajax/patnums_ajax_down.tpl");
?>

<?php 
// ======================= блок, описывающий функции 
// получение списка врачей по специальности:
function getPatientNumbs($smarty, $inet_filter, $bord_down, $patientid)
{
 	require_once 'conn.php';
    $command = "INFOMAT_PATIENT_NUMBS";
    $params = array(array("NAME" => "PATIENTID", "VALUE" => $patientid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);

	if ($errorMsg != "")
    {
        if ($errorMsg != "")
            $errorText = $errorMsg;
        else
            $errorText = "Список пуст";
        return FALSE;
    }
	if (is_array($result) && count($result) > 0) 
	{
		$data = array();
		$j = 0;
		foreach ($result as $element)
		{
			$rownum = $element['ROWNUM'];
			if ($rownum > $bord_down)
			{
				$data[$j]['KEYID'] = $element['KEYID'];
				$data[$j]['DOCNAME'] = $element['DOCNAME'];
				$data[$j]['SPECNAME'] = $element['SPECNAME'];
				$data[$j]['DAT'] = dateStringMonth($element['DAT']);
				$data[$j]['TIME'] = $element['TIME'];
				$data[$j]['DAYWEEK'] = $element['DAYWEEK'];
				$j++;
			}
		}
		// от 1 до 5
			if (count($data) <= 5)
			{
				// старую нижнюю границу сделать верхней для другой функции
				// отобразить данные
				$smarty->assign("DOWN_X", 1);
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница			
				$smarty->assign('DATA', $data);	
			}
				// больше 5
			elseif (count($data) > 5)	
			{
				// записать в массив $data только те строки, ROWNUM'ы которых: верхняя граница $new_bord_up = $bord_down + 1,
				// а нижняя - $new_bord_down = $bord_down + 5;	
				$data5 = array();
				$i = 1;
				foreach ($data as $value)
				{
					if ($i <= 5)
					{
						$data5[] = $value;
					}
					$i++;
				}
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница						
				$smarty->assign("DOWN", 1);
				$smarty->assign("DOWN_BORDER", $bord_down + 5);
				$smarty->assign('DATA', $data5);	
			}
	}
    unset($result);
    unset($data);
    return TRUE;
}
?>