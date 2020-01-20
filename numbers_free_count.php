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
  $smarty->assign("HEAD_NAME", 'СВОБОДНЫЕ НОМЕРКИ');
  
  // отображение переменных
  
  $smarty->display("smarty/templates/header.tpl");
  $smarty->display("smarty/templates/numbers_free_count.tpl");
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// блок, описывающий функции команд
?>