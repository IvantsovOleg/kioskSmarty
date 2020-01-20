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
  getListServices($smarty, $servid, $bord_up, $bord_down);
    
  $smarty->display("../smarty/templates/ajax/serv_ajax_up.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// функция, показывающая услуги
function getListServices($smarty, $servid, $bord_up, $bord_down)
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
			if ($rownum < $bord_up)
			{
				$data[$j]['KEYID'] = $element['KEYID'];
				$data[$j]['CODE'] = $element['CODE'];
				$data[$j]['TEXT'] = $element['TEXT'];
				$data[$j]['PRICE'] = $element['PRICE'];
				$data[$j]['FULLTEXT'] = $element['TEXT'];
				
				// проверить, не является ли название услуги дляннее 40 символов
				if (strlen($data[$j]['TEXT']) > 80)
				{
					$data[$j]['TEXT'] = iconv("utf-8", "utf-8", substr($element['TEXT'], 0, 79))."...";
				}			
				
				$j++;			
			}
		}
		if (count($data) == 15)
		{
				// старую нижнюю границу сделать верхней для другой функции
				// отобразить данные
				$smarty->assign("UP_X", 1);
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 15);
				$smarty->assign('DATA', $data);				
		}
		elseif (count($data) > 15)
		{
			$data5 = array();
			$c2 = count($data);
			$c1 = $c2 - 5;
			$i = 0;
			$j = 1;
			foreach ($data as $value)
			{
				if ($j <= $c2 && $j > $c1)
				{
					foreach ($value as $k => $v)
					{
						$data5[$i][$k] = $v;
					}
					$i++;
				}
				$j++;
			}
			$smarty->assign("UP", 1);		
			$smarty->assign("DOWN_BORDER", $bord_up - 1);
			$smarty->assign("UP_BORDER", $bord_up - 15);
			$smarty->assign('DATA', $data5);			
		}
		$smarty->assign("KEYID1", $servid);
	}
	return;
}
?>