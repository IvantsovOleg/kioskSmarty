<?php
  header("Content-Type: text/html; charset=utf-8");    

  require "../utils.php";
  require "../smarty/libs/smarty.class.php";
  require "../conn.php";
  require "../xmlhelper.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "../marty/templates";
  $smarty->compile_dir  = "../smarty/templates_c";
  $smarty->cache_dir    = "../smarty/cache";
  $smarty->config_dir   = "../smarty/config";
  
  // print_r($_POST);
  // выполняем ту же команду со спецами, только вывод на экран в smarty урезаем верхней и нижней границами
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  $specid = $_SESSION['SPECID'];
  $inet_filter = $_SESSION['FILTER_INET'];
  $servid = $_SESSION['SERVID']; 
  $reg_code = $_SESSION['REG_CODE']; 
  getDoctorsName($smarty, $specid, $inet_filter, $servid, $bord_down, &$errorText, $reg_code);
    
  $smarty->display("../smarty/templates/ajax/doctors_ajax_down.tpl");
?>

<?php 
// ======================= блок, описывающий функции 
// получение списка врачей по специальности:
function getDoctorsName($smarty, $specid, $inet_filter, $servid, $bord_down, &$errorText, $reg_code)
{
    require_once '../conn.php';
    $command = "INFOMAT_DOCLIST";
    $params = array(array("NAME" => "MODE", "VALUE" => 1),
                    array("NAME" => "SPECID", "VALUE" => $specid),
					array("NAME" => "FILTER", "VALUE" => $inet_filter),
					array("NAME" => "SERVID", "VALUE" => $servid),
					array("NAME" => "REG_CODE", "VALUE" => $reg_code),
                    array("NAME" => "COMPANYID", "VALUE" => $_SESSION['DMS']));
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
		foreach ($result as $elememt)
		{
			$rownum = $elememt['ROWNUM'];
			if ($rownum > $bord_down)
			{
				$data[$j]['DOCID'] = $elememt['DOCID'];
				$data[$j]['DOCNAME'] = $elememt['DOCNAME'];
				$data[$j]['SPECID'] = $elememt['SPECID'];
				$data[$j]['SPECNAME'] = $elememt['SPECNAME'];
				$data[$j]['DEPNAME'] = $elememt['DEPNAME'];
				$data[$j]['ROOM'] = $elememt['ROOM'];
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
				$smarty->assign('DOCS', $data);	
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
				$smarty->assign('DOCS', $data5);	
			}
		$_SESSION['SPECID'] = $specid;
	}
    unset($result);
    unset($data);
    return TRUE;
}
?>