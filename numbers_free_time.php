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
  
  // назначение переменных
  $smarty->assign("HOME", 'yes');		// отображение кнопок "назад" и "домой"
  $smarty->assign("HEAD_NAME", 'СВОБОДНЫЕ НОМЕРКИ');
  
  // отображение переменных
 
  // GET_переменные 
  $specid = GetGet('specid');
  $docid = GetGet('docid');
  $date_str = GetGet('date_str');
  $range = GetGet('range');
  $dayweek = GetGet('dayweek');
  $strdat = GetGet('strdat');
  $dat = data_tobase($strdat);
  $room = GetGet('room');
  //echo $room;
  
  $_SESSION['CAB'] = $room;
  //echo $_SESSION['CAB'];
  $dms = $_SESSION['DMS'];
  $first_surv = GetGet('survid');
  $inet_filter = $_SESSION['FILTER_INET'];

  $data = array();
  $numbs = array();
  
  $data = getNumbs($dat, $specid, $docid, $strdat, $dms, $first_surv, $inet_filter);
 
  $dataSize = sizeof($data);
  for ($i=0; $i <$dataSize ; $i++) { 
   $tempData = numbConfirm($smarty, $docid, $specid, $data[$i], $errorText, $dms, $inet_filter);
   if(is_array($tempData)){
    if(sizeof($tempData)>0){
      array_push($numbs, $tempData);
    }
   }
  }

  
  $smarty->display("smarty/templates/header.tpl");
   if(sizeof($numbs)<1){
    $_SESSION['ERRORTEXT'] = 'В данный день отсутствуют свободные номерки!<br/>(информация для поддержки:<br/> процедура INFOMAT_NUMBCONFIRM вернула пустой ответ для каждого номерка)';
    $smarty->display("smarty/templates/userdata_error.tpl");  
    return;
  }else{
  $smarty->assign("NUMBS_ONLY", $numbs_only);
  $smarty->assign("DOCNAME", $_SESSION['DOCNAME']);
  $smarty->assign("SPECNAME", $_SESSION['SPECNAME']);
  $smarty->assign("DATE_STR", $date_str);
  $smarty->assign("RANGE", $range);
  $smarty->assign("DAYWEEK", $dayweek);
  $smarty->assign("ROOM", $room);
  $smarty->assign("NUMBS", $numbs);
    $smarty->display("smarty/templates/numbers_free_time.tpl");
  }
  $smarty->display("smarty/templates/footer.tpl");
?>

<?php 
// *********************************************		блок, описывающий функции команд

// получение списка характеристик свободных номерков
function getNumbs($dat, $specid, $docid, $strdat, $dms, $first_surv, $inet_filter)
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
		if (is_array($result) && count($result) > 0)
		{
			foreach ($result as $element)
			{
				if ($element['STRDAT'] == $strdat)
				{
					$data[] = $element['DAT']; 
					$i++;
				}
			}
		}
	//	print_r($data);
		return $data;
}		

    // вывод списка номерков
     function numbConfirm($smarty, $docid, $specid, $dat, $errorText, $dms, $inet_filter)
    {

       require_once 'conn.php';
       $command = "INFOMAT_NUMBCONFIRM";
        $params = array(
        array("NAME" => "SPECID", "VALUE" => $specid), 
        array("NAME" => "DOCID", "VALUE" => $docid),
        array("NAME" => "DAT", "VALUE" => $dat),
        array("NAME" => "COMPANYID", "VALUE" => $dms),
        array("NAME" => "FILTER", "VALUE" => $inet_filter)
        ); 
        $result = array();
    
        $errorMsg = "";
   
        makeRequest($command, $params, $result, $errorMsg);
        $data = array();

        if($errorMsg != ''&&sizeof($result)<1){
          return false;
        }else{

           foreach ($result as $element){
            $data["numbid"] = $element["NUMBID"];
            $data["dat"] = cutDate($element["DAT"]);
            $data["room"] = $element['ROOM'];
        }
        return $data;

        }

    }
?>