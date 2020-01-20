<?php
  header("Content-Type: text/html; charset=utf-8");    

  require "../utils.php";
  require "../smarty/libs/smarty.class.php";
  require "../conn.php";
  require "../xmlhelper.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "../smarty/templates";
  $smarty->compile_dir  = "../smarty/templates_c";
  $smarty->cache_dir    = "../smarty/cache";
  $smarty->config_dir   = "../smarty/config";
  
    // назначение переменных
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'ПРЕЙСКУРАНТ');
  
  //print_r($_POST);
  $bord_down = $_POST['hid_down_bord'];
  // получение данных прейскуранта
	// первые два уровня
  getPricelist_main($smarty, $bord_down);
  
  // отображение переменных
  
  $smarty->display("../smarty/templates/ajax/pricelist_ajax_down.tpl");
?>

<?php 
// =====================  блок, описывающий функции команд

// запрос первых двух уровней разделов прейскуранта
function getPricelist_main($smarty, $bord_down)
{
	require_once '../conn.php';
    $command = "INFOMAT_PRICELIST_MAIN";
    $params = array(array("NAME" => "MODE", "VALUE" => 1));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	if (is_array($result) && count($result) != 0)
	{
		$data = array();
		$j = 0;
		foreach ($result as $element)
		{
			$rownum = $element['ROWNUM'];
			if ($rownum > $bord_down)
			{
				$data[$j]['KEYID'] = $element['KEYID'];
				$data[$j]['TEXT'] = $element['WEBTEXT'];
				$data[$j]['KEYID1'] = $element['KEYID1'];
				$data[$j]['TEXT1'] = $element['TEXT1'];				
				
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
		if (count($data) <= 5)
		{
			// старую нижнюю границу сделать верхней для другой функции
			// отобразить данные
			$smarty->assign("DOWN_X", 1);
			$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница			
			$smarty->assign('DATA', $data);	
		}
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
	return;
}
?>