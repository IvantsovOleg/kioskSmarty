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
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  
  // кнопки главной страницы
  getButton($smarty, $bord_down);
  
  // отображение переменных
  $smarty->display("../smarty/templates/ajax/index_ajax_down.tpl");
?>

<?php 
// работа с кнопками на главной странице 
function getButton($smarty, $bord_down)
{
	$data = array();
	$i = 0;
	$j = 1;
	$query = mysql_query("select * from main_buttons order by name");
	while ($result = mysql_fetch_array($query))
	{
		if ($j > $bord_down)
		{
			$data[$i]['NAME'] = $result['NAME'];
			$data[$i]['PAGE_URL'] = $result['PAGE_URL'];
			$i++;
		}
		$j++;
	}
	if (count($data) <= 5)
	{
		// старую нижнюю границу сделать верхней для другой функции
		// отобразить данные
		$smarty->assign("DOWN_X", 1);
		$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница			
		$smarty->assign('BUTTONS', $data);	
	}	
		// больше 5
	elseif (count($data) > 5)	
	{
		// записать в массив $data только те строки, ROWNUM'ы которых: верхняя граница $new_bord_up = $bord_down + 1,
		// а нижняя - $new_bord_down = $bord_down + 5;	
		$data5 = array();
		$i = 1;
		foreach ($data as $key => $value)
		{
			if ($i <= 5)
			{
				$data5[$key] = $value;
			}
			$i++;
		}
		$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница						
		$smarty->assign("DOWN", 1);
		$smarty->assign("DOWN_BORDER", $bord_down + 5);
		$smarty->assign('BUTTONS', $data5);	
	}
}
?>