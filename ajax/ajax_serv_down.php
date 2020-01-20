<?php
  header("Content-Type: text/html; charset=utf-8");    

  require "../utils.php";
  require "../smarty/libs/smarty.class.php";
  require "../conn.php";
  require "../xmlhelper.php";

  error_reporting(0);
  
  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "../smarty/templates";
  $smarty->compile_dir  = "../smarty/templates_c";
  $smarty->cache_dir    = "../smarty/cache";
  $smarty->config_dir   = "../smarty/config";
  
  // print_r($_POST);
  // выполняем ту же команду со спецами, только вывод на экран в smarty урезаем верхней и нижней границами
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  $servid = $_POST['hid_keyid1'];
  getListServices($smarty, $servid, $bord_down);
    
  $smarty->display("../smarty/templates/ajax/serv_ajax_down.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// функция, показывающая услуги
function getListServices($smarty, $servid, $bord_down)
{
	require_once '../conn.php';
    $command = "INFOMAT_GET_SERVICES";
    $params = array(array("NAME" => "KEYID", "VALUE" => $servid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	
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
				$data[$j]['CODE'] = $element['CODE'];
				$data[$j]['PRICE'] = $element['PRICE'];
				$data[$j]['TEXT'] = $element['TEXT'];
				$data[$j]['FULLTEXT'] = $element['TEXT'];
				
				// проверить, не является ли название услуги дляннее 40 символов
				if (strlen($element['TEXT']) > 80)
				{
					$data[$j]['TEXT'] = iconv("utf-8", "utf-8", substr($element['TEXT'], 0, 79))."...";
				}
				else
				{
					$data[$j]['TEXT'] = $element['TEXT'];
				}
				
				$j++;			
			}
		}
		if (count($data) <= 15)
		{
				// старую нижнюю границу сделать верхней для другой функции
				// отобразить данные
				$smarty->assign("DOWN_X", 1);
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница			
				$smarty->assign('DATA', $data);				
		}
		elseif (count($data) > 15)
		{
			$data5 = array();
			$i = 1;
			foreach ($data as $value)
			{
				if ($i <= 15)
				{
					$data5[] = $value;
				}
				$i++;
			}
			$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница						
			$smarty->assign("DOWN", 1);
			$smarty->assign("DOWN_BORDER", $bord_down + 15);
			$smarty->assign('DATA', $data5);					
		}
		$smarty->assign("KEYID1", $servid);
	}
	return;
}
?>