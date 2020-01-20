<?php
  header("Content-Type: text/html; charset=utf-8");    

  require_once "utils.php";
  require_once "smarty/libs/smarty.class.php";
  require_once "conn.php";
  require_once "xmlhelper.php";

  session_start();
  
  // очистка предыдущих данных сессии
  clearSession();
  
   // выбор параметров киоска из базы
  $kiosk_params = getKioskParams();
  paramsToSession($kiosk_params);
   
  // тестовый режим, в последствии исправить на соответствующий базе xml-сервер
  if ($_SESSION['XMLServerURL'] == '')
	$_SESSION['XMLServerURL'] = xmlServerSelect();
  $xml = $_SESSION['XMLServerURL'];
  $lu = lpuParamsSelect($_SESSION['XMLServerURL'], "NAME");
  $_SESSION['LU'] = $lu;
  // echo $xml;
  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
  // назначение переменных
  
  $index_mes = lpuParamsSelect($_SESSION['XMLServerURL'], "INDEX_MES");
  $smarty->assign("INDEX_MES", $index_mes);
  
  $smarty->assign("HOME", 'no');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", $lu);		// надпись в заголовке
  // отображение переменных
  // echo 'test';
  // кнопки главной страницы
  getButton($smarty);
  
  // echo $_SERVER['SERVER_ADDR'];
  
 $smarty->display("smarty/templates/header.tpl");
 $smarty->display("smarty/templates/index.tpl");
 $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// работа с кнопками на главной странице 
function getButton($smarty)
{
	$data = array();
	$i = 0;
	$query = mysql_query("select * from main_buttons WHERE stat = 1 order by name");
	while ($result = mysql_fetch_array($query))
	{
		if ($i < 5)
		{
			$data[$i]['NAME'] = $result['NAME'];
			$data[$i]['PAGE_URL'] = $result['PAGE_URL'];
			$smarty->assign("MORELESS", 0);
		}
		else
		{
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
			$smarty->assign("MORELESS", 1);
		}
		$i++;
	}
	$smarty->assign("BUTTONS", $data);
}

  function clearSession()
   {
       foreach ($_SESSION as $key => $value)
	   {
			unset($_SESSION[$key]);	
	   }
   }
?>