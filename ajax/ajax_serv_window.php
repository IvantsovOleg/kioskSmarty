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
  
  $data_keyid = $_POST['data_keyid'];
  
  $info = getInfo($data_keyid);
  if ($info != '')
	$x = 'Условия прохождения услуги: <br />';
 
  $smarty->assign("INFO", $x.$info);
  $smarty->display("../smarty/templates/serv_info.tpl");
?>

<?php 
// функция, показывающая услуги
function getInfo($data_keyid)
{
	require_once '../conn.php';
    $command = "INFOMAT_SERVINFO";
    $params = array(array("NAME" => "KEYID", "VALUE" => $data_keyid));
    $result = array();
    $errorMsg = "";
    makeRequest($command, $params, $result, $errorMsg);
	
	// print_r($result);
	$info = $result[0]['INFO'];

	return $info;
}
?>