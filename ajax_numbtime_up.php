<?php
  header("Content-Type: text/html; charset=utf-8");    

  require "utils.php";
  require "smarty/libs/smarty.class.php";
  require "conn.php";
  require "xmlhelper.php";

  session_start();

  $smarty = new Smarty();
 
  $smarty->template_dir = "smarty/templates";
  $smarty->compile_dir  = "smarty/templates_c";
  $smarty->cache_dir    = "smarty/cache";
  $smarty->config_dir   = "smarty/config";
  
  // выполняем ту же команду со спецами, только вывод на экран в smarty урезаем верхней и нижней границами
  $bord_up = $_POST['hid_up_bord'];
  $bord_down = $_POST['hid_down_bord'];
  $dat = $_POST['hid_dat'];
  $first_surv = $_POST['survid'];
  $dayweek = $_POST['dayweek'];
  $date_str = $_POST['date_str'];
  
  $docid = $_SESSION['DOCID'];
  $specid = $_SESSION['SPECID'];
  $dms = $_SESSION['DMS'];
  $inet_filter = $_SESSION['FILTER_INET'];
  $data = getNumbs($smarty, $dat, $specid, $docid, $first_surv, $dms, $bord_up, $bord_down, $inet_filter);
  
  $i = 0;
  foreach ($data as $value)
  {
	$numbs[$i] = doConfirm($smarty, $docid, $specid, $value, $errorText, $dms, $inet_filter);
	$i++;
  }  

   $smarty->assign("NUMBS", $numbs);
   $smarty->assign("DAYWEEK", $dayweek);
   $smarty->assign("DATE_STR", $date_str);
  
  $smarty->display("smarty/templates/ajax/numbtime_ajax_up.tpl");
?>

<?php 
// ======================= блок, описывающий функции 

// получение списка с количеством свободных номерков
	function getNumbs($smarty, $dat, $specid, $docid, $first_surv, $dms, $bord_up, $bord_down, $inet_filter)
	{
        require_once 'conn.php';
        $command = "INFOMAT_NUMBLIST";
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
		foreach ($result as $element)
		{
			$rownum = $element['ROWNUM'];
			if ($rownum < $bord_up)
			{
				if ($element['STRDAT'] == $_SESSION['STRDAT'])
				{
					$data[] = $element['DAT']; 
				}
			}	
		}
		if (count($data) == 35)
		{
				$smarty->assign("UP_X", 1);
				$smarty->assign("UP_BORDER", 1);
				$smarty->assign("DOWN_BORDER", 35);
				$data5 = $data;
		}
		elseif (count($data) > 35)
		{
				$data5 = array();
				$c2 = count($data);
				$c1 = $c2 - 34;
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
				$smarty->assign("UP_BORDER", $bord_up - 35);
		}
		$smarty->assign("DAT", $dat);
		$smarty->assign("SURVID", $first_surv);
		return $data5;
	}
	
	// вывод списка номерков
    function doConfirm($smarty, $docid, $specid, $dat, $errorText, $dms, $inet_filter)
    {
        require_once 'conn.php';
        $XMLCmd = new xml_output();
        $XMLCmd->startXML();

        
        $XMLCmd->elementStart("CMD", array("name" => "INFOMAT_NUMBCONFIRM", "userid" => "0000+-2"));
        $XMLCmd->element("PARAM",array("name" => "SPECID"),$specid);
        $XMLCmd->element("PARAM",array("name" => "DOCID"),$docid);
        $XMLCmd->element("PARAM",array("name" => "DAT"),$dat);
        $XMLCmd->element("PARAM",array("name" => "COMPANYID"), $dms);
		$XMLCmd->element("PARAM",array("name" => "FILTER"), $inet_filter);
		
        $XMLCmd->elementEnd("CMD");
        $xmlData = $XMLCmd->endXML();
        $g_XMLServerURL = $_SESSION['XMLServerURL'];
        $fp = @stream_socket_client($g_XMLServerURL, $errno, $errstr, 10);
        if (!$fp) 
        {
           return FALSE;
        }
        else  
            fwrite_stream($fp, $xmlData . "\r\n");

        $result = fread_stream($fp);        
        fclose($fp);
        fixXML($result);
        $xmlInput = new xml_input($result);
        $xmlInput->parseXML();

        
        if ($xmlInput->isTable == FALSE || $xmlInput->errorText != "")
        {
            if ($xmlInput->errorText != "")
                $errorText = $xmlInput->errorText;
            else
                $errorText = "Список пуст";
            return FALSE;
        }        
        unset ($result);
        foreach ($xmlInput->tableData as $element)
        {
            $result["numbid"] = $element["NUMBID"];
            $result["dat"] = cutDate($element["DAT"]);
        }
		return $result;
    }	
?>