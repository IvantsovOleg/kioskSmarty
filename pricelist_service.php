<?php
  header("Content-Type: text/html; charset=utf-8");    

  require_once "utils.php";
  require_once "smarty/libs/smarty.class.php";
  require_once "conn.php";
  require_once "xmlhelper.php";

  error_reporting(0);
  
  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
  // СТРАНИЦА УСЛУГ
  
  $servid = GetGet('keyid1');
  $text1 = GetGet('text1');
  
  // назначение переменных
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'ПРЕЙСКУРАНТ');
  $smarty->assign("SERVICENAME", $text1);
 
  // получение данных прейскуранта
	// последний уровень, сами услуги
  getListServices($smarty, $servid);
  
  // отображение переменных
  
  $smarty->display("smarty/templates/header.tpl");
  $smarty->display("smarty/templates/pricelist_services.tpl");
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// =====================  блок, описывающий функции команд

// функция, показывающая услуги
function getListServices($smarty, $servid)
{
	require_once 'conn.php';
    $command = "INFOMAT_GET_SERVICES";
    $params = array(array("NAME" => "KEYID", "VALUE" => $servid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	
	// нужны первые 5 штук
	if (is_array($result) && count($result) != 0)
	{
		$data = array();
		$j = 0;
		foreach ($result as $element)
		{
			if ($j < 15)
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
			}
			$j++;
		}
		if (count($result) > 15)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 15);		// нижняя граница			
		}
		else
		{
			$smarty->assign("MORELESS", 0);			// неактивные стрелки
		}
		$smarty->assign("EMPTY", 'NO');
		$smarty->assign("DATA", $data);
		$smarty->assign("KEYID1", $servid);
	}
	else
	{
		// написать, что в этом разделе пусто
		$smarty->assign("EMPTY", 'YES');
	}
	return;
}
?>