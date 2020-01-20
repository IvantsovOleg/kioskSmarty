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
  
  // print_r($_POST);
  // выполняем ту же команду со спецами, только вывод на экран в smarty урезаем верхней и нижней границами
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  $dat = $_POST['hid_dat'];
  $first_surv = $_POST['hid_surv'];
  $docid = $_SESSION['DOCID'];
  $specid = $_SESSION['SPECID'];
  $dms = $_SESSION['DMS'];
   $inet_filter = $_SESSION['FILTER_INET'];
  getNumbs($smarty, $dat, $specid, $docid, $first_surv, $dms, $bord_up, $bord_down, $inet_filter);
    
  $smarty->display("../smarty/templates/ajax/numbs_ajax_up.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка с количеством свободных номерков
	function getNumbs($smarty, $dat, $specid, $docid, $first_surv, $dms, $bord_up, $bord_down, $inet_filter)
	{
        require_once '../conn.php';
        $command = "INFOMAT_NUMB_DAY";
        $params = array(array("NAME" => "MODE", "VALUE" => 1),
						array("NAME" => "COMPANYID", "VALUE" => $dms),
						array("NAME" => "SPECID", "VALUE" => $specid),
						array("NAME" => "DOCID", "VALUE" => $docid),
                        array("NAME" => "DAT", "VALUE" => $dat),
						array("NAME" => "FIRST", "VALUE" => 0),
						array("NAME" => "SURVID", "VALUE" => $first_surv),
						array("NAME" => "FILTER", "VALUE" => $inet_filter),
                        array("NAME" => "PAYTYPE", "VALUE" => 0));
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
        
        if ($errorMsg != "")
        {
            if ($errorMsg != "")
                $errorText = $errorMsg;
            else
                $errorText = "Список пуст";
            return FALSE;
        }
		$data = array();
		$i = 0;		
		foreach($result as $element)
		{
			$rownum = $element['ROWNUM'];
			if ($rownum < $bord_up)
			{
				$data[$i]['DATE_STR'] = dateStringMonth($element['STRDAT']);
				$data[$i]['COUNT_FULL'] = $element['QTY']." ".endingNumsWord($element['QTY']);
				$data[$i]['STRDAT'] = $element['STRDAT'];
				$data[$i]['RANGE'] = $element['STRTIME'];
				$data[$i]['DAYWEEK'] = $element['DAYOFWEEK'];
				$i++;
			}	
		}
		if (count($data) == 5)
		{
				$smarty->assign("UP_X", 1);
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 5);
				$smarty->assign('DATA', $data);	
		}
		elseif (count($data) > 5)
		{
				$data5 = array();
				$c2 = count($data);
				$c1 = $c2 - 5;
				$i = 0;
				$j = 1;
				foreach ($data as $value)
				{
					if ($j <= $c2 && $j > $c1)
					{
						foreach ($value as $k => $v)
						{
							$data5[$i][$k] = $v;
						}
						$i++;
					}
					$j++;
				}
				$smarty->assign("UP", 1);		
				$smarty->assign("DOWN_BORDER", $bord_up - 1);
				$smarty->assign("UP_BORDER", $bord_up - 5);
				$smarty->assign('DATA', $data5);	
		}
		$smarty->assign("DOCID", $docid);
		$smarty->assign("DAT", $dat);
		$smarty->assign("SURVID", $first_surv);
		return;
	}
?>