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
  
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  
    // назначение переменных
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'ПРЕЙСКУРАНТ');
 
  // получение данных прейскуранта
	// первые два уровня
  getPricelist_main($smarty, $bord_down, $bord_up);
  
  // отображение переменных
  $smarty->display("../smarty/templates/ajax/pricelist_ajax_up.tpl");
?>

<?php 
// =====================  блок, описывающий функции команд

// запрос первых двух уровней разделов прейскуранта
function getPricelist_main($smarty, $bord_down, $bord_up)
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
			// на этой странице вывести первый раздел и первые 5 его подразделов			
			if ($rownum < $bord_up)
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
		if (count($data) == 5)
		{
				// старую нижнюю границу сделать верхней для другой функции
				// отобразить данные
				$smarty->assign("UP_X", 1);
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 5);
				$smarty->assign('DATA', $data);			
		}
		elseif (count($data) > 5)
		{
			$data5 = array();
			$c2 = $bord_up - 1;
			$c1 = $bord_up - 5;
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
	return;
}
?>