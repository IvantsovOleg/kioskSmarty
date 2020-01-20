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
  
  // кнопки главной страницы
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  getButton($smarty, $bord_up, $bord_down);

  $smarty->display("../smarty/templates/ajax/index_ajax_up.tpl");
?>

<?php 
// работа с кнопками на главной странице 
function getButton($smarty, $bord_up, $bord_down)
{
	$data = array();
	$i = 0;
	$j = 1;
	$query = mysql_query("select * from main_buttons order by name");
	while ($result = mysql_fetch_array($query))
	{
		if ($j < $bord_up)
		{
			$data[$i]['NAME'] = $result['NAME'];
			$data[$i]['PAGE_URL'] = $result['PAGE_URL'];
			$i++;
		}
		$j++;
	}
	if (count($data) == 5)
	{
		// если количество строк равно 5, значит это первая страница, и нужно блокировать кнопку ВВЕРХ
		$smarty->assign("UP_X", 1);
		// границы:
		$smarty->assign("UP_BORDER", 1);
		$smarty->assign("DOWN_BORDER", 5);
		$smarty->assign('BUTTONS', $data);	
	}
	elseif (count($data) > 5)	
	{
	// если количество больше 5, значит это НЕ первая страница. Обе кнопки должны быть разблокированы
	// массив передать только из 5 строк
	// обозначить новые границы
		$data5 = array();
		$c2 = count($data);
		$c1 = $c2 - 5;
		$i = 1;
		foreach ($data as $key => $value)
		{
			if ($i <= $c2 && $i > $c1)
			{
				$data5[$key] = $value;
			}
			$i++;
		}
		$smarty->assign("UP", 1);		
		$smarty->assign("DOWN_BORDER", $bord_up - 1);
		$smarty->assign("UP_BORDER", $bord_up - 5);
		$smarty->assign('BUTTONS', $data5);	
	}
	
}
?>