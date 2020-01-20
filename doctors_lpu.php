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
  $docid = GetGet('docid');
  $docname = GetGet('docname');
  $specid = GetGet('specid');
  $servid = GetGet('servid');
  $survid = GetGet('survid');
  
  if ($specid == '')
	$specid = $_SESSION['SPECID'];
	
  if ($servid == '')
	$servid = 0;
	
  $_SESSION['SERVID'] = $servid;	
	
  if ($mode == '')
	$mode = 1;	
  
  $flag = GetGet('flag');
  $inet_filter = $_SESSION['FILTER_INET'];
  $dms = $_SESSION['DMS'];
  $spec_type = $_SESSION['DOCTYPEID'];
  $struct_code = $_SESSION['STRUCTCODE'];
  $_SESSION['REG_CODE'] = $spec_type;
  
  $cab = GetGet('cab');
  $_SESSION['CAB'] = $cab;
 // echo $_SESSION['CAB'];
  
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  
  // если запрос на список врачей по специальности
  if ($specid != '' && $docid == '')
  {
	 if (($servid == 0 && $flag == 0) || $servid > 0)	// показать полный список врачей		
	 {
		getDoclist($smarty, $specid, $inet_filter, $servid, $dms, $mode, $errorText, $spec_type, $struct_code);
		$smarty->display("smarty/templates/header.tpl");
		$smarty->display("smarty/templates/doctors_lpu.tpl");				
	 }
	 elseif ($servid == 0 && $flag == 1)	// показать список услуг врачей с отметкой 1
	 {
		getSpecServices($smarty, $specid, $dms, $errorText, $spec_type, $struct_code);
		if (!getSpecServices($smarty, $specid, $dms, $errorText, $spec_type, $struct_code))
			header("Location: doctors_lpu.php?specid=".$specid."&flag=0");
		// назначение переменных
		$smarty->assign("HEAD_NAME", 'УСЛУГИ ВРАЧЕЙ');
		$smarty->display("smarty/templates/header.tpl");
		$smarty->display("smarty/templates/doctors_services.tpl");	
	 }
  }
  //////////////////////////////////////////////////////////////////////////////// 
  // если запрос на список номерков конкретного врача
  elseif ($docid != '' && $docname != '')
  {
	// проверяем, запись или расписание
	if ($mode == 1)			// запись
	{
		// назначение переменных
		$smarty->assign("HEAD_NAME", 'СВОБОДНЫЕ НОМЕРКИ');
		$smarty->assign("DOCNAME", $docname);
		
		$smarty->assign("HOMEREF", 1);
		
		$smarty->display("smarty/templates/header.tpl");
		
		$dat = date("Y-m-d");
		$_SESSION['DOCNAME'] = $docname;
		if ($survid != '')
			$first_surv = $survid;
		else
			$first_surv = '';
			
		getSurvey($smarty, $docid, $dms, $inet_filter);
		
		getNumbs($smarty, $dat, $_SESSION['SPECID'], $docid, $first_surv, $dms, $inet_filter);
		$smarty->display("smarty/templates/numbers_free_count.tpl");		
	}
	elseif ($mode == 2)		// расписание
	{
		header("Location: doctors_time.php?docid=".$docid);
	}
  }
  
  // отображение переменных
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка услуг врачей по специальности
  function getSpecServices($smarty, $specid, $dms, $errorText, $spec_type, $struct_code)
    {
        require_once 'conn.php';
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
		// print_r($result);
		$data = array();
		$j = 0;	
		if (count($result) == 0)
			return false;
		foreach ($result as $element)
		{
			if ($j < 5)
			{
				$data[$j]['SRVDEP_ID'] = $element['SRVDEP_ID'];
				$data[$j]['TEXT'] = $element['TEXT'];
				$data[$j]['SPECID'] = $element['SPECID'];
				$_SESSION['SPECID'] = $specid;
			}			
			$j++;
		}
		if (is_array($data) && count($data) > 0)
			$smarty->assign('DOCSERVICES', $data);
		// для отображения кнопок
		if (count($result) > 5)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
		}
		else
			$smarty->assign("MORELESS", 0);
			$smarty->assign("HEAD_NAME", $_SESSION['SPECNAME']);  
		unset($result);
		unset($data);
        return TRUE;
    }

// получение списка врачей по специальности:
   function getDoclist($smarty, $specid, $inet_filter, $servid, $dms, $mode,  $errorText, $spec_type, $struct_code)
    {
        require_once 'conn.php';
        $command = "INFOMAT_DOCLIST";
        $params = array(array("NAME" => "MODE", "VALUE" => $mode),
                        array("NAME" => "SPECID", "VALUE" => $specid),
						array("NAME" => "SERVID", "VALUE" => $servid),
						array("NAME" => "FILTER", "VALUE" => $inet_filter),
						array("NAME" => "REG_CODE", "VALUE" => $spec_type),		
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
        foreach ($result as $elememt)
        {
			if ($j < 5)
			{
				$data[$j]['DOCID'] = $elememt['DOCID'];
				$data[$j]['DOCNAME'] = $elememt['DOCNAME'];
				$data[$j]['SPECID'] = $elememt['SPECID'];
				$data[$j]['SPECNAME'] = $elememt['SPECNAME'];
				$data[$j]['DEPNAME'] = $elememt['DEPNAME'];
				$data[$j]['ROOM'] = $elememt['ROOM'];

				$_SESSION['SPECID'] = $specid;
				$_SESSION['SPECNAME'] = $elememt['SPECNAME'];
			}			
			$j++;
        }
		if (is_array($data) && count($data) > 0)
            $smarty->assign('DOCS', $data);
		// для отображения кнопок
		if (count($result) > 5)
		{
			$smarty->assign("MORELESS", 1);			// если количество отображаемых данных больше 5, показать кнопки для дополнительного выбора
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
		}
		else
			$smarty->assign("MORELESS", 0);
			$smarty->assign("HEAD_NAME", $_SESSION['SPECNAME']);  
        unset($result);
        unset($data);
        return TRUE;
    }
	
// получение списка видов исследований конкретного врача
function getSurvey($smarty, $docid, $dms, $inet_filter)
{
       require_once 'conn.php';
        $command = "INFOMAT_DOC_SURVEY";
         $params = array(array("NAME" => "DOCID", "VALUE" => $docid),
						array("NAME" => "FILTER", "VALUE" => $inet_filter),
						array("NAME" => "COMPANYID", "VALUE" => $dms));
        $result = array();
        $errorMsg = "";
        makeRequest($command, $params, $result, $errorMsg);
        // print_r($result);
		$i = 0;
		$data = array();
		if (count($result) > 0)
		{
			$smarty->assign("SUR", 1);
		}
		else
		{
			$smarty->assign("SUR", 0);
		}
} 	
	
// получение списка с количеством свободных номерков
	function getNumbs($smarty, $dat, $specid, $docid, $first_surv, $dms, $inet_filter)
	{
        require_once 'conn.php';
        $command = "INFOMAT_NUMB_DAY";
        $params = array(array("NAME" => "MODE", "VALUE" => 1),
						array("NAME" => "COMPANYID", "VALUE" => $dms),
						array("NAME" => "SPECID", "VALUE" => $specid),
						array("NAME" => "DOCID", "VALUE" => $docid),
                        array("NAME" => "DAT", "VALUE" => $dat),
						array("NAME" => "FIRST", "VALUE" => 0),
						array("NAME" => "SURVID", "VALUE" => $first_surv),
						array("NAME" => "FILTER", "VALUE" => $_SESSION['FILTER_INET']),
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
		// print_r($result);
		
		$data = array();
		$i = 0;
		foreach($result as $element)
		{
			$data[$i]['DATE_STR'] = dateStringMonth($element['STRDAT']);
			$data[$i]['COUNT_FULL'] = $element['QTY']." ".endingNumsWord($element['QTY']);
			$data[$i]['STRDAT'] = $element['STRDAT'];
			$data[$i]['RANGE'] = $element['STRTIME'];
			$data[$i]['DAYWEEK'] = $element['DAYOFWEEK'];
			$data[$i]['ROOM'] = $element['ROOM'];
			$i++;
		}

		if (count($data) <= 5)
		{
			$smarty->assign("DATA", $data);		// назначать только в случае, когда count($data) <= 5
			$smarty->assign("MORELESS", 0);	
		}
		else
		{
			// В качестве верхней и нижней границ берутся собственные, заведенные уже в PHP rownum'ы. 
			$smarty->assign("MORELESS", 1);	
			$data5 = array();
			$k = 1;
			foreach ($data as $value)
			{
				if ($k <= 5)
				{
					$data5[] = $value;
				}
				$k++;
			}
			$smarty->assign("UP_BORDER", 1);		// верхняя граница
			$smarty->assign("DOWN_BORDER", 5);		// нижняя граница
			$smarty->assign("DATA", $data5);
		}
		$smarty->assign("DAT", $dat);
		$smarty->assign("SURVID", $first_surv);
		$_SESSION['DOCID'] = $docid; 
		return;
	}
?>