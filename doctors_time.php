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
  $smarty->assign("HEAD_NAME", 'ВРЕМЯ ПРИЕМА');
  
   $docid = GetGet('docid');
  // $docid = 732;
  // $docid = 580;
  
  // получение данных
  getDoctorsTime($smarty, $docid);
  
  // отображение переменных
  
  $smarty->display("smarty/templates/header.tpl");
  $smarty->display("smarty/templates/doctors_time.tpl");
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// =================	блок, описывающий функции команд

// время приема врачей
function getDoctorsTime($smarty, $docid)
{
	    require_once 'conn.php';
        $command = "INFOMAT_GET_DOCTIMES";
        $params = array(array("NAME" => "MODE", "VALUE" => 1),
						array("NAME" => "DOCID", "VALUE" => $docid));
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
			// HTML:
			// - каждая строка записи (неделя месяца) - отдельная таблица, максимум 6 строк
			// В таблице:
				// если диапазон 00:00-00:00, то выводить столбец с крестиком
				// если дни выходные (суббота и воскресенье, то фон жёлтый)
		if (is_array($result) && count($result) > 0)
		{
			// то, что одинаково во всем результате
			$docname = $result[0]['TEXT'];
			$specname = $result[0]['SPEC'];
			$smarty->assign("DOCNAME", $docname);
			$smarty->assign("SPECNAME", $specname);
			
			$data = array(); 		// основной массив недель
			$week = array();		// массив дней
			$days = array();		// массив времени, самый нижний уровень
			$params_day = array();
			// $data - массив из маленьких массивов-столбцов
			// строка массива $data это:
				// в $data столбики будут обрабатываться во внутреннем цикле
				// в каждом столбике (квадратике):
					// DATE_STR - 00 месяца
					// DAYWEEK
					// RANGE
			
			// переменные данные, переборка по неделям
			foreach ($result as $element)
			{
				$week = array();		// массив дней
				$middle = array();
				$middle[] = $element['MON1'];
				$middle[] = $element['TUE1'];
				$middle[] = $element['WED1'];
				$middle[] = $element['THU1'];
				$middle[] = $element['FRI1'];
				$middle[] = $element['SAT1'];
				$middle[] = $element['SUN1'];
				
				// преобразуем каждое из значений столбцов в маленький массив, переборка по дням
				foreach ($middle as $value)
				{
					// разделяем переменную на массив из 3х строк
					// этот массив записываем в массив $days, дальше посмотрим
					if ($value != '0')
					{
						$for_dw = explode(" ", $value);
						// день недели
						$dayweek = $for_dw[0];
						// со скольки до скольки (00:00-00:00 проверяется в smarty)
						$range = $for_dw[2];
						// "читабельная" дата
						$short_day = $for_dw[1];
						$today = date('m.Y');
						$date_ = $short_day.".".$today;
						$date_str = dateStringMonth($date_);
						// В массив дней:
						$params_day['DATE_STR'] = $date_str;
						$params_day['RANGE'] = $range;
						$params_day['DAYWEEK'] = $dayweek;
						$days[] = $params_day;
					}
					// если равна 0, так и записываем, проверять в smarty
					else
					{
						$days[] = 'none';
					}
					unset($params_day);
				}
				// print_r($days);
				$week[] = $days;
				unset($days);
				// чистка: 
				unset($middle);
				$data[] = $week;
				unset($week);	
				$smarty->assign("NOT_SCH", 0);
			}
		}
		else
		{
			$smarty->assign("NOT_SCH", 1);
		}
		$smarty->assign("DATA", $data);
		return;
}
?>