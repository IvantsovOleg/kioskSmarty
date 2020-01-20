<?php
  header("Content-Type: text/html; charset=utf-8");    

  require_once "utils.php";
  require_once "smarty/libs/smarty.class.php";
  require_once "conn.php";
  require_once "xmlhelper.php";
  include "php_serial.class.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
  // назначение переменных
  $smarty->assign("HOME", 'yes');
  $smarty->assign("HEAD_NAME", 'ПОДТВЕРЖДЕНИЕ НОМЕРКА');
  $smarty->display("smarty/templates/header.tpl");
  
  $policeid = $_SESSION['POLICEID'];
  $patientid = $_SESSION['PATIENTID'];
  $numbid = $_SESSION['NUMBID'];
  $status = $_SESSION['STATUS'];
  $dayweek = $_SESSION['DAYWEEK'];
  $date_str = $_SESSION['DATE_STR'];
  $dat = $_SESSION['DAT'];
  // echo $_SESSION['PATIENT_INFO'];
  
  			$smarty->assign("DAYWEEK", $dayweek);
			$smarty->assign("DATE_STR", $date_str);
			$smarty->assign("DAT", $dat);
			$smarty->assign("NUMBID", $numbid);	
			$smarty->assign("STATUS", $status);
  
			if ($_SESSION['CREATE_PATIENT'] == 1 && $policeid <= 0)
			{
				// В случае, если есть запись пациентов не из базы
				$smarty->assign('NEWPHONE', '1');
			}
  
  $smarty->display("smarty/templates/userdata_success.tpl");		

  $smarty->display("smarty/templates/footer.tpl");
?>