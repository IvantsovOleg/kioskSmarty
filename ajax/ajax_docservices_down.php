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
 	 getDoctorsServices($smarty, $bord_down, $specid, $dms, $errorText);
	 $smarty->assign("HEAD_NAME", 'УСЛУГИ ВРАЧЕЙ');
     $smarty->display("../smarty/templates/ajax/docservices_ajax_down.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка врачей по специальности:
   function getDoctorsServices($smarty, $bord_down, $specid, $dms, $errorText, $spec_type, $struct_code)
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
		
		 if (is_array($result) && count($result) > 0)
		{	
			$data = array();
			$j = 0;
			// сравниваем по переданной границе:
			foreach ($result as $element)
			{
				$rownum = $element['ROWNUM'];
				if ($rownum > $bord_down)
				{
					$data[$j]['SRVDEP_ID'] = $element['SRVDEP_ID'];
					$data[$j]['TEXT'] = $element['TEXT'];
					$data[$j]['SPECID'] = $element['SPECID'];
					$j++;
				}
			}
			if (count($data) <= 5)
			{
				$smarty->assign("DOWN_X", 1);
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница			
				$smarty->assign('DOCSERVICES', $data);	
			}	
				// больше 5
			elseif (count($data) > 5)	
			{
				$data5 = array();
				$i = 1;
				foreach ($data as $key => $value)
				{
					if ($i <= 5)
					{
						$data5[$key] = $value;
					}
					$i++;
				}
				
				$smarty->assign("UP_BORDER", $bord_down + 1);		// верхняя граница						
				$smarty->assign("DOWN", 1);
				$smarty->assign("DOWN_BORDER", $bord_down + 5);
				$smarty->assign('DOCSERVICES', $data5);	
			}	
		}
        return TRUE;
    }
?>