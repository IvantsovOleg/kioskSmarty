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
  $inet_filter = $_SESSION['FILTER_INET'];
  $dms = $_SESSION['DMS'];
  
  getSpeclist($smarty, $bord_up, $bord_down, $inet_filter, $dms);
    
  $smarty->display("../smarty/templates/ajax/speciality_ajax_up.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение специальностей врачей:
function getSpeclist($smarty, $bord_up, $bord_down, $inet_filter, $dms)
{
        require_once '../conn.php';
        $command = "INFOMAT_SPECLIST";
		$params = array(array("NAME" => "MODE", "VALUE" => $mode), 
					array("NAME" => "FILTER", "VALUE" => $inet_filter),
					array("NAME" => "COMPANYID", "VALUE" => $dms),
					array("NAME" => "REG_CODE", "VALUE" => $_SESSION['DOCTYPEID'])); 
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
		$data = array();	// промежуточный массив
        if (count($result) <= 0)
            return false; 
		$i = 0;
        if (is_array($result) && count($result) > 0)
		{	
			// сравниваем по переданной границе:
			foreach ($result as $element)
			{
				$rownum = $element['ROWNUM'];
				if ($rownum < $bord_up)
				{
					$data[$i]['SPECID'] = $element['SPECID'];
					$data[$i]['SPECNAME'] = $element['SPECNAME'];
					$data[$i]['ATTR_FLAG'] = $element['ATTR_FLAG'];
					$i++;
				}
			}
			// проверить количество записей (в этом блоке - положительное)
				// от 1 до 5
			if (count($data) == 5)
			{
				$smarty->assign("UP_X", 1);
				// границы:
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 5);
				$smarty->assign('SPECS', $data);	
			}	
				// больше 5
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
				$smarty->assign('SPECS', $data5);	
			}		
		}
		unset($result);
        return true;
}
?>