<?PHP
  $database = 'ariadnarec';
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  
  //откроем БД!
  mysql_connect($hostname, $username, $password);
  mysql_select_db($database);
  mysql_set_charset("UTF8");
  require "functions.php";
  //echo $_SESSION['SEARCH_BY_POLICE'];
  function getParam($paramCode, $table, $field)
  {
      $query = "select * from $table where $field = '$paramCode'";
      $queryresult = mysql_query($query);
      $rows = mysql_num_rows($queryresult);
      if ($rows > 0)
        $result[] = mysql_fetch_array($queryresult);
      else
        return false;
      return $result;
  }
  
  // Вернуться на основной сайт
	function getParametrsBackRef()
	{
		$par = getParam('ALLOW_BACK_REF', 'settings', 'code');
		$value = $par[0]['VALUE'];
		
		if ($value == '1')			// Ссылка определяется с помощью PHP-кода
		{
			$url = getenv("HTTP_REFERER"); 
			$rb = refer_back($url);
			if ($rb == 0)		// с внешнего сайта
			$_SESSION['MAINSITE'] = $url;
		}
		else			// Ссылка берётся из базы
		{
			$url = $value;
			$_SESSION['MAINSITE'] = $url;
		}
		
	}
  
  function makeRequest($command, $params, &$result, &$errorMsg)
  {
	    error_reporting(0);
		
		$XMLCmd = new xml_output();
        $XMLCmd->startXML();
        
        if ($_SESSION["USERID"] != "")
            $XMLCmd->elementStart("CMD", array("name" => $command, "userid" => "0000+-2"));
        else    
            $XMLCmd->elementStart("CMD", array("name" => $command));
        
        for ($i = 0; $i < count($params); $i++)
            $XMLCmd->element("PARAM",array("name" => $params[$i]["NAME"]),$params[$i]["VALUE"]);
      
        $XMLCmd->elementEnd("CMD");
        $xmlData = $XMLCmd->endXML();
		
		if ($_SESSION['XMLServerURL'] == '')
		$_SESSION['XMLServerURL'] = xmlServerSelect();
        $fp = @stream_socket_client($_SESSION['XMLServerURL'], $errno, $errstr, 10);
        
        if (!$fp) 
           return FALSE;
        else  
            fwrite_stream($fp, $xmlData . "\r\n");

        $XMLResult = fread_stream($fp);        
        fclose($fp);
        fixXML($XMLResult);
        $xmlInput = new xml_input($XMLResult);
        $xmlInput->parseXML();
        if ($xmlInput->isTable == FALSE && $xmlInput->errorText != "")
        {
                $errorMsg = $xmlInput->errorText;
                return FALSE;
        }
        if ($xmlInput->isTable)
            $result = $xmlInput->tableData;
        else
            $result = $xmlInput->valueData;
            
        return TRUE;
    }
?>