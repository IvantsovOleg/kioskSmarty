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
  
  // список докторов или свободные номерки врача
  $mode = $_SESSION['MODE'];
  $docid = $_SESSION['DOCID'];
  $docname = $_SESSION['DOCNAME'];
  $specid = $_SESSION['SPECID'];
  $servid = GetGet('servid');
  $survid = GetGet('survid');
  
  $inet_filter = $_SESSION['FILTER_INET'];
  $dms = $_SESSION['DMS'];
  
  getSurveyName($smarty, $docid, $dms, $inet_filter);
   
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  
  $smarty->assign("HEAD_NAME", 'ВИДЫ ИССЛЕДОВАНИЙ');
  $smarty->display("smarty/templates/header.tpl");
  $smarty->display("smarty/templates/numbers_surves.tpl");	 

  // отображение переменных
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка видов исследований конкретного врача
function getSurveyName($smarty, $docid, $dms, $inet_filter)
{
        require_once 'conn.php';
        $command = "INFOMAT_DOC_SURVEY";
        $params = array(array("NAME" => "DOCID", "VALUE" => $docid),
						array("NAME" => "FILTER", "VALUE" => $inet_filter),
						array("NAME" => "COMPANYID", "VALUE" => $dms));
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
        
		$i = 0;
		$data = array();
		foreach ($result as $element)
		{
			if ($i < 5)
			{
				$data[$i]['RES_ID'] = $element['RES_ID'];
				$data[$i]['TEXT'] = $element['TEXT'];
			}
			$i++;
		}
		if (count($result) > 5)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
		}
		else
			$smarty->assign("MORELESS", 0);
			
		$smarty->assign("DATA", $data);	
		unset($result);
		unset($data);
} 	
?>