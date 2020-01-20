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
  
  $specid = $_SESSION['SPECID'];
  $dms = $_SESSION['DMS']; 
  $spec_type = $_SESSION['DOCTYPEID'];
  $struct_code = $_SESSION['STRUCTCODE'];
  
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  // если запрос на список врачей по специальности
 	 getDoctorsServices($smarty, $bord_down, $bord_up, $specid, $dms, $errorText);
	 $smarty->assign("HEAD_NAME", 'УСЛУГИ ВРАЧЕЙ');
     $smarty->display("../smarty/templates/ajax/docservices_ajax_up.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка врачей по специальности:
   function getDoctorsServices($smarty, $bord_down, $bord_up, $specid, $dms, $errorText, $spec_type, $struct_code)
    {
        require_once '../conn.php';
        $command = "INFOMAT_SPECSERVICES";
        $params = array(array("NAME" => "SPECID", "VALUE" => $specid),
						array("NAME" => "SPECTYPE", "VALUE" => $spec_type),
						array("NAME" => "STRUCTCODE", "VALUE" => $struct_code),					
                        array("NAME" => "COMPANYID", "VALUE" => $dms));
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
       // print_r($result);
        if ($errorMsg != "")
        {
            if ($errorMsg != "")
                $errorText = $errorMsg;
            else
                $errorText = "Список пуст";
            return FALSE;
        }
        $data = array();
		$j = 0;	
        if (is_array($result) && count($result) > 0)
		{	
			// сравниваем по переданной границе:
			foreach ($result as $element)
			{
				$rownum = $element['ROWNUM'];
				if ($rownum < $bord_up)
				{
					$data[$j]['SRVDEP_ID'] = $element['SRVDEP_ID'];
					$data[$j]['TEXT'] = $element['TEXT'];
					$data[$j]['SPECID'] = $element['SPECID'];
					$j++;
				}
			}
			// проверить количество записей (в этом блоке - положительное)
				// от 1 до 5
			if (count($data) == 5)
			{
				// если количество строк равно 5, значит это первая страница, и нужно блокировать кнопку ВВЕРХ
				$smarty->assign("UP_X", 1);
				// границы:
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 5);
				$smarty->assign('DOCSERVICES', $data);	
			}	
				// больше 5
			elseif (count($data) > 5)	
			{
			$c2 = $bord_up - 1;
			$c1 = $bord_up - 5;
				$i = 1;
				foreach ($data as $value)
				{
					if ($i <= $c2 && $i >= $c1)
					{
						$data5[] = $value;
					}
					$i++;
				}
				$smarty->assign("UP", 1);		
				$smarty->assign("DOWN_BORDER", $bord_up - 1);
				$smarty->assign("UP_BORDER", $bord_up - 5);
				$smarty->assign('DOCSERVICES', $data5);	
			}
			//print_r($data5);			
		}
        unset($result);
		unset($data);
        return TRUE;
    }
?>