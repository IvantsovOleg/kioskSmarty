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
  
  // получение из mysql типы врачей
  $i = 0;
  $dt = mysql_query("select * from doctors_type");
  while ($dt_r = mysql_fetch_array($dt))
  {
	$doctypes[$i]['ID'] = $dt_r['ID'];
	$doctypes[$i]['NAME'] = $dt_r['NAME'];
	$i++;
  }
  
  // назначение переменных
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("DOCTYPES", $doctypes);
  $smarty->assign("HEAD_NAME", 'ТИП ВРАЧЕЙ');
  
  // отображение страницы
  $smarty->display("smarty/templates/header.tpl");
  $smarty->display("smarty/templates/doctors_type.tpl");
  $smarty->display("smarty/templates/footer.tpl");
?>