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
  
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  $inet_filter = $_SESSION['FILTER_INET'];
  $patientid = $_SESSION['PATIENTID']; 
  
  getPatientNumbs($smarty, $inet_filter, $bord_up, $bord_down, $errorText, $patientid);
    
  $smarty->display("smarty/templates/ajax/patnums_ajax_up.tpl");
?>

<?php 
// ======================= блок, описывающий функции 
// получение списка врачей по специальности:
function getPatientNumbs($smarty, $inet_filter, $bord_up, $bord_down, $errorText, $patientid)
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
			if ($rownum < $bord_up)
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
			if (count($data) == 5)
			{
				// если количество строк равно 5, значит это первая страница, и нужно блокировать кнопку ВВЕРХ
				$smarty->assign("UP_X", 1);
				// границы:
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 5);
				$smarty->assign('DATA', $data);	
			}	
			// больше 5
			elseif (count($data) > 5)	
			{
				$data5 = array();
				$c2 = $bord_up + 4;
				$c1 = $bord_up;
				$i = 1;
				foreach ($data as $value)
				{
					if ($i <= $c2 && $i >= $c1)
					{
						$data5[] = $value;
					}
					$i++;
				}
				$smarty->assign("UP", 1);		
				$smarty->assign("DOWN_BORDER", $bord_up - 1);
				$smarty->assign("UP_BORDER", $bord_up - 5);
				$smarty->assign('DATA', $data5);	
			}
	}
    unset($result);
    unset($data);
    return TRUE;
}
?>