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
  
  // список докторов или свободные номерки врача
  $docid = $_SESSION['DOCID'];
  $docname = $_SESSION['DOCNAME'];
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
   
  $inet_filter = $_SESSION['FILTER_INET'];
  $dms = $_SESSION['DMS'];
  
  getSurveyName($smarty, $docid, $bord_down, $dms, $inet_filter);

  $smarty->display("../smarty/templates/ajax/survs_ajax_down.tpl");	 
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка видов исследований конкретного врача
function getSurveyName($smarty, $docid, $bord_down, $dms, $inet_filter)
{
        require_once '../conn.php';
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
			$rownum = $element['ROWNUM'];
			if ($rownum > $bord_down)
			{
				$data[$i]['RES_ID'] = $element['RES_ID'];
				$data[$i]['TEXT'] = $element['TEXT'];
				$i++;
			}
		}
		if (count($data) <= 5)
		{
				// старую нижнюю границу сделать верхней для другой функции
				// отобразить данные
				$smarty->assign("DOWN_X", 1);
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница			
				$smarty->assign('DATA', $data);	
		}
		elseif (count($data) > 5)
		{
				$data5 = array();
				$i = 0;
				foreach ($data as $value)
				{
					if ($i < 5)
					{
						foreach ($value as $k => $v)
						{
							$data5[$i][$k] = $v;
						}
					}
					$i++;
				}
				
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница						
				$smarty->assign("DOWN", 1);
				$smarty->assign("DOWN_BORDER", $bord_down + 5);
				$smarty->assign('DATA', $data5);	
		}
		unset($result);
		unset($data);
} 	
?>