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
  
  $doctypeid = GetGet('doctypeid');
  
  // параметры для процедур
  $spec_type = $doctypeid;
  $mode = $_SESSION['MODE'];
  $inet_filter = $_SESSION['FILTER_INET'];
  $dms = $_SESSION['DMS'];
  if ($doctypeid != '')
	$_SESSION['DOCTYPEID'] = $doctypeid;
   
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  
  if ($_SESSION['STRUCTURE_SEPARATE'] == 1 && !$_GET['struct_code'])	
  {
	$smarty->assign("HEAD_NAME", 'ПОДРАЗДЕЛЕНИЯ ЛПУ');
	// получить список филиалов
	getStructures($smarty, $mode, $inet_filter, $dms, $spec_type);
	// отображение страницы
	$smarty->display("smarty/templates/header.tpl");
	$smarty->display("smarty/templates/structures.tpl");
	$smarty->display("smarty/templates/footer.tpl");		
  }
  elseif ($_SESSION['STRUCTURE_SEPARATE'] == 0 || $_GET['struct_code'])
  {
	$smarty->assign("HEAD_NAME", 'СПЕЦИАЛЬНОСТИ ВРАЧЕЙ');
	// сразу список специальностей
	$struct_code = GetGet('struct_code');
	$struct_address = GetGet('address');
	$_SESSION['STRUCTCODE'] = $struct_code;
	$_SESSION['STRUCTADDRESS'] = $struct_address;
	 
	getSpeclist($smarty, $mode, $inet_filter, $dms, $_SESSION['DOCTYPEID'], $struct_code);
	
	// отображение страницы
	  $smarty->display("smarty/templates/header.tpl");
	  $smarty->display("smarty/templates/speciality.tpl");
	  $smarty->display("smarty/templates/footer.tpl");	
  }
?>

<?php
// структурные подразделения
function getStructures($smarty, $mode, $inet_filter, $dms, $spec_type)
{
	require_once 'conn.php';
	$command = "INFOMAT_STRUCTURES";
	$params = array(array("NAME" => "MODE", "VALUE" => $mode), 
					array("NAME" => "FILTER", "VALUE" => $inet_filter),
					array("NAME" => "COMPANYID", "VALUE" => $dms),
					array("NAME" => "SPECTYPE", "VALUE" => $spec_type)); 
	$result = array();
	
	$errorMsg = "";
	makeRequest($command, $params, $result, $errorMsg);	
	$data = array();
	$i = 0;
	foreach ($result as $element)
	{
		$data[$i]['STR_CODE'] = $element['STR_CODE']; 
		$data[$i]['TEXT'] = $element['TEXT']; 
		$data[$i]['ROWNUM'] = $element['ROWNUM']; 
		$data[$i]['ADDRESS'] = $element['ADDRESS']; 
		$i++;
	}
	
	$smarty->assign('STRUCTURES', $data);
}

// специальности врачей
function getSpeclist($smarty, $mode, $inet_filter, $dms, $spec_type, $struct_code)
{
	require_once 'conn.php';
	$command = "INFOMAT_SPECLIST";
	$params = array(array("NAME" => "MODE", "VALUE" => $mode), 
					array("NAME" => "FILTER", "VALUE" => $inet_filter),
					array("NAME" => "COMPANYID", "VALUE" => $dms),
					array("NAME" => "REG_CODE", "VALUE" => $spec_type)
					); 
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