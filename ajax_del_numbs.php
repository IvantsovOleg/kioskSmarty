<?php
 header("Content-Type: text/html; charset=utf-8");    

  require "utils.php";
  require "smarty/libs/smarty.class.php";
  require "conn.php";
  require "xmlhelper.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "../smarty/templates";
  $smarty->compile_dir  = "../smarty/templates_c";
  $smarty->cache_dir    = "../smarty/cache";
  $smarty->config_dir   = "../smarty/config";
  
  // отменить номерок
  $numbid = GetPost('numbid');
  delNumbsAjax($numbid);
?>

<?php 
	function delNumbsAjax($idnumb)
	{
		require_once 'conn.php';
        
        $command = "INFOMAT_DELETE_RNUMBS";
        $params = array(array("NAME" => "NUMBID", "VALUE" => $idnumb));
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);		
		return;
	}
?>