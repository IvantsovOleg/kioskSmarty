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
  
    // назначение переменных
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'ПРЕЙСКУРАНТ');
  
  // получение данных прейскуранта
	// первые два уровня
  getPricelist_main($smarty);
  
  // отображение переменных
  
  $smarty->display("smarty/templates/header.tpl");
  $smarty->display("smarty/templates/pricelist.tpl");
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// =====================  блок, описывающий функции команд

// запрос первых двух уровней разделов прейскуранта
function getPricelist_main($smarty)
{
	require_once 'conn.php';
    $command = "INFOMAT_PRICELIST_MAIN";
    $params = array(array("NAME" => "MODE", "VALUE" => 1));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	if (is_array($result) && count($result) != 0)
	{
		$data = array();
		$sections = array();
		$i = 0;
		$j = 0;
		$k = 0;
		foreach ($result as $element)
		{
			// на этой странице вывести первый раздел и первые 5 его подразделов
			if ($j < 5)
			{
				$data[$j]['KEYID'] = $element['KEYID'];
				$data[$j]['KEYID1'] = $element['KEYID1'];
				$data[$j]['TEXT1'] = $element['TEXT1'];
				$data[$j]['TEXT'] = $element['WEBTEXT'];
				
				// проверить, не является ли название услуги дляннее 40 символов
				if (strlen($data[$j]['TEXT']) > 80)
				{
					$data[$j]['TEXT'] = iconv("utf-8", "utf-8", substr($element['WEBTEXT'], 0, 79))."...";
				}

				// проверить, не является ли название услуги дляннее 40 символов
				if (strlen($data[$j]['TEXT1']) > 80)
				{
					$data[$j]['TEXT1'] = iconv("utf-8", "utf-8", substr($element['TEXT1'], 0, 79))."...";
				}								
				
				$j++;
			}
		}
		if (count($result) > 5)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
		}
		else
		{
			$smarty->assign("MORELESS", 0);		// неактивные стрелки
		}
		$smarty->assign('DATA', $data);
	}
	unset($result);
	unset($data);
	return;
}
?>