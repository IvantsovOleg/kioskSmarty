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
  
  $mode = GetGet('mode');
  $dms = GetGet('dms');
  
  $_SESSION['MODE'] = $mode;
  $_SESSION['DMS'] = $dms; 
  
  // если нет разделения на врачей
  if ($_SESSION['DOCTORS_TYPE'] == 0 && $_SESSION['STRUCTURE_SEPARATE'] == 0)
  {	  
	  $inet_filter = $_SESSION['FILTER_INET'];
		
	  getSpeclist($smarty, $inet_filter, $dms, $mode);
	  
	  // назначение переменных
	  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
	  $smarty->assign("HEAD_NAME", 'СПЕЦИАЛЬНОСТИ ВРАЧЕЙ');
	  
	  // отображение страницы
	  $smarty->display("smarty/templates/header.tpl");
	  $smarty->display("smarty/templates/speciality.tpl");
	  $smarty->display("smarty/templates/footer.tpl");
  }
  elseif ($_SESSION['DOCTORS_TYPE'] == 1)	  // если есть разделение на врачей
  {
	header("Location: doctors_type.php");
  }
  elseif ($_SESSION['STRUCTURE_SEPARATE'] == 1 && $_SESSION['DOCTORS_TYPE'] == 0)
  {
	header("Location: structure_lpu.php");
  }
?>

<?php 
// ======================= блок, описывающий функции 

// получение специальностей врачей:
function getSpeclist($smarty, $inet_filter, $dms, $mode)
{
        require_once 'conn.php';
        $command = "INFOMAT_SPECLIST";
        $params = array(array("NAME" => "MODE", "VALUE" => $mode), 
						array("NAME" => "FILTER", "VALUE" => $inet_filter),
                        array("NAME" => "COMPANYID", "VALUE" => $dms),
						array("NAME" => "SPECTYPE", "VALUE" => ''),
                        array("NAME" => "STRUCTCODE", "VALUE" => '')); 
        $result = array();
		
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
		$data = array();
        if (count($result) <= 0)
            return false; 	
		$i = 0;	
        foreach ($result as $element)
        {
			if ($i < 5)
			{
				$data[$i]['SPECID'] = $element['SPECID'];
				$data[$i]['SPECNAME'] = $element['SPECNAME'];
				$data[$i]['ATTR_FLAG'] = $element['ATTR_FLAG'];
			}
			$i++;
		}
        if (is_array($data) && count($data) > 0)
            $smarty->assign('SPECS', $data);
		// для отображения кнопок
		if (count($result) > 5)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
		}
		else
			$smarty->assign("MORELESS", 0);
        unset($data);
		unset ($result);
        return true;
}
?>