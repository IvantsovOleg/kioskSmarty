<?php

session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$app_path = $_SERVER['DOCUMENT_ROOT'];


function displayError($errorText = "Общая ошибка выполнения запроса.")
{
        echo "<div class=\"logon\"><H2><font color=red>$errorText</font></H2><br>" .
             "Нажмите <a href='index.php' >здесь</a> для возврата</div>";
}


function fixXML($data)
{
    while (strpos($data, "\r") === 0) $data = substr($data, 1);
    while (strpos($data, "\n") === 0) $data = substr($data, 1);
    
//    if (strpos($data, "\n") === strlen($data)-1) $data = substr($data, 0, strlen($data)-1);
    return $data;
}

function SanitizeString($var)
{
    $var = strip_tags($var);
//    $var = htmlentities($var, null, 'utf-8', false);
    return stripslashes($var);
};

function GetPost($var)
{
  return SanitizeString($_POST[$var]);
};

function GetGet($var)
{
  return SanitizeString($_GET[$var]);
};

    function fwrite_stream($fp, $string) {
        for ($written = 0; $written < strlen($string); $written += $fwrite) {
            $fwrite = fwrite($fp, substr($string, $written));
            if ($fwrite === false) {
                return $written;
            }
        }
        return $written;
    }

    function fread_stream($fp) 
    {
        while (strpos($line, "\r\n") === FALSE)
            $line .= fgets($fp, 512);
        return $line;
    }
   
    function _debug($str)
    {
      echo '<pre>';
      print_r(is_array($str) ? $str : htmlentities($str));
      echo '</pre>';
    }
?>