<?php
// Вспомогательные функции

// Достаём номер xml-сервера
function xmlServerSelect()
{
	$xq = mysql_query("select XMLSERVER_URL from lpu");
	$xr = mysql_fetch_array($xq);
	$xml = $xr['XMLSERVER_URL'];
	return $xml;
}

function lpuParamsSelect($xml, $param)
{
	$xq = mysql_query("select $param from lpu where XMLSERVER_URL ='".$xml."'");
	$xr = mysql_fetch_array($xq);
	$lu = $xr[$param];
	return $lu;		
}

function filtr($txt)
{
	preg_match("/(\d+)/i", $txt, $matches1);
	return $matches1[0];
}

function text_filtr($txt)
{
	preg_match("/([а-яА-Яa-zA-Z-_*]+)/", $txt, $new_text);
	return $new_text[0];
}

function tire($data)
{
	if (preg_match("/([0-9\-]+)/", $data) && !preg_match("/([a-zA-Zа-яА-Я]+)/", $data))
		return true;
	else
		return false;
}

function cutNulls($data)
{
	$mon_arr = str_split($data);
	if ($mon_arr[0] == 0)
		return $mon_arr[1];
	else 
		return $data;
}

function dateStringMonth($data)				// входная дата в формате dd.mm.yyyy
{
	$str_mons = array("01" => "января", "02" => "февраля", "03" => "марта", "04" => "апреля", "05" => "мая", "06" => "июня", "07" => "июля", "08" => "августа", "09" => "сентября", "10" => 'октября', "11" => 'ноября', "12" => 'декабря');	
	$data_arr = explode('.', $data);
	$day = $data_arr[0];
	$mon = $data_arr[1];
	$rday = cutNulls($day);
	
	foreach ($str_mons as $key => $value)
	{
		if ($mon == $key)
			$rmon = $value;
	}
	$new_date = $rday." ".$rmon;
	return $new_date;
}

function endingNumsWord($numcount)
{
	$ends = array("1" => "номерок", "2" => "номерка", "3" => "номерка", "4" => "номерка", "5" => "номерков", "6" => "номерков", "7" => "номерков", "8" => "номерков", "9" => "номерков", "0" => "номерков", "11" => "номерков", "12" => "номерков", "13" => "номерков", "14" => "номерков");
	$last = substr($numcount, strlen($numcount) - 1, 1);		// обрезанное число, по которому идет проверка окончаний 
	foreach ($ends as $key => $value)
	{
		if ($key != "11" && $key != "12" && $key != "13" && $key != "14" && $numcount != "11" && $numcount != "12" && $numcount != "13" && $numcount != "14")
		{
			if ($last == $key)
				$ending = $value;
		}
		elseif ($numcount == "11" || $numcount == "12" || $numcount == "13" || $numcount == "14") 
			$ending = "номерков";
	}
	return $ending;
}

function date_toXscale($data)
{
	$str_mons = array("01" => "Янв", "02" => "Фев", "03" => "Мар", "04" => "Апр", "05" => "Май", "06" => "Июн", "07" => "Июл", "08" => "Авг", "09" => "Сен", "10" => 'Окт', "11" => 'Ноя', "12" => 'Дек');
	$data_arr = explode('-', $data);
	$day = $data_arr[2];
	$mon = $data_arr[1];
	$mon1 = explode(" ", $day);
	$day = $mon1[0];
	foreach ($str_mons as $key => $value)
	{
		if ($key == $mon)
			$result = cutNulls($day)." ".$value;
	}
	return $result;
}

function textValid($text)
{
	$error = 0;
	$t = text_filtr($text);
	if (strlen($t) < 2 || $t == '')
	{
		$error++;
	}
	return $error;
}

function dateDiffDays($dat1, $dat2)
{
	$arr1 = explode('.', $dat1);
	$arr2 = explode('.', $dat2);
	$time1 = mktime(0,0,0,$arr1[1],$arr1[0],$arr1[2]);
	$time2 = mktime(0,0,0,$arr2[1],$arr2[0],$arr2[2]);
	$dif = ($time2 - $time1) / 86400;
	return $dif;
}

function addNulls($str)
{
	$stl = strlen($str);
	if ($stl == 1)
		$new_str = str_pad($str, 2, '0', STR_PAD_LEFT);
	else
		$new_str = $str;
	return $new_str;
}

function dateDiff_countDat2($dat1, $dif)
{
	$arr1 = explode('.', $dat1);
	$time1 = mktime(0,0,0,$arr1[1],$arr1[0],$arr1[2]);
	$time2 = $time1 - $dif*86400;
	$getdate = getdate($time2);
	$day_ = $getdate['mday'];
	$mon_ = $getdate['mon'];
	$year = $getdate['year'];	
	
	$day = addNulls($day_);
	$mon = addNulls($mon_);
	
	$dat2 = $day.".".$mon.".".$year;
	return $dat2;
}

function curdate()
{
	$cd_q = mysql_query("select curdate()");
	$cd_r = mysql_fetch_array($cd_q);
	$cd = $cd_r['curdate()'];
	
	return $cd;
}

function curdateSep()
{
	$today = date("d.m.Y");
	$today_array = explode('.', $today);
	
	return $today_array;		// Массив: день, месяц, год
}

// Определение количества дней (на входе формат месяца 'mm')

function daysCount($d_mon, $d_year)
{
	$cmons = array("01" => 31, "02" => 28, "03" => 31, "04" => 30, "05" => 31, "06" => 30, "07" => 31, "08" => 31, "09" => 30, "10" => 31, "11" => 30, "12" => 31);
	if (($d_year % 4) == 0)		// Високосный год, ага^^
		$cmons["02"] = 29;
	
	foreach ($cmons as $m => $cd)
	{
		if ($m == $d_mon)
			$days_count = $cd;
	}
	return $days_count;
}	

// функция, считающая первое число предыдущего месяца и количество дней в нем (соответственно, последнее число месяца)
function prevMonth()
{
	$result_datas = array();
	$date = date("d.n.Y");
	$date_array = explode('.', $date);
	$day = $date_array[0];
	$mon = $date_array[1];
	$year = $date_array[2];
	if ($mon == 1)
	{
		$result_mon = 12;
		$result_year = $year - 1;
	}
	else
	{
		$result_mon = addNulls($mon - 1);
		$result_year = $year;
	}
	//echo $result_mon;
	$count_days = daysCount($result_mon, $result_year);
	$data1 = "01.".$result_mon.".".$result_year;
	$data2 = $count_days.".".$result_mon.".".$result_year;
	$result_datas[] = $data1;
	$result_datas[] = $data2;	
	return $result_datas;	// возвращает МАССИВ: обе даты
}

// Преобразование даты для записи в базу
function data_tobase($data)
{
	$dataex = explode(".", $data);
	$day = $dataex[0];
	$month = $dataex[1];
	$year = $dataex[2];
	
	$datecur = $year."-".$month."-".$day;
	return $datecur;
}

// PHP-функция для сравнения дат (вторая дата - сегодняшняя), просрочен, если $label равно 1
function compareDate($d1, $d2)
{
	$date1 = explode(".", $d1);
	$date2 = explode(".", $d2);
	$label = 0;
	
	// Разбили первую дату
	$year1 = $date1[2];
	$mon1 = $date1[1];
	$day1 = $date1[0];
	
	// Разбили вторую дату
	$year2 = $date2[2];
	$mon2= $date2[1];
	$day2 = $date2[0];	
	
	// Сравниваем
	// 1.год
	if ($year1 < $year2)		// Просрочен, проверка заканчивается
	{
		$label++;
		return $label;
	}
	elseif ($year1 > $year2) 	// НЕ просрочен точно
		return $label;
	elseif ($year1 == $year2)	// Неизвестно, сравниваем месяцы
	{
		if ($mon1 > $mon2)		// НЕ просрочен
		return $label;
		elseif ($mon1 < $mon2)	// Просрочен
		{
			$label++;
			return $label;			
		}
		elseif ($mon1 == $mon2)		// Неизвестно, сравниваем дни
		{
			if ($day1 > $day2)		// НЕ просровен
			return $label;
			else					// Просрочен
			{
				$label++;
				return $label;			
			}
		}
	}		
}

function natdata($data_b)
{
	$year_b = substr($data_b, 0, 4);
	$mon_b = substr($data_b, 5, 2);
	$d_b = substr($data_b, 8, 2);
	$time_b = substr($data_b, 11, 5);

	$my_mons = array("01" => "янв", "02" => "фев", "03" => "мар", "04" => "апр", "05" => "мая", "06" => "июня", "07" => "июля", "08" => "авг", "09" => "сен", "10" => "окт", "11" => "ноя", "12" => "дек");	
	foreach ($my_mons as $k_dec => $v_mon)
	{
		if ($mon_b == $k_dec)
		$month_b = $v_mon;
	}
	// обрезка чисел, у которых нули в начале:
	$day = str_split($d_b);
	$day_ = $day[0];
	if ($day_ == 0)
	{
		$day_b = $day[1];
	}
	else 
	$day_b = $d_b; 	
	
	$data_nat = $day_b."&nbsp;".$month_b."&nbsp;".$year_b."г.&nbsp; в ".$time_b."";
	return $data_nat;	
}

function natdatatime($data_b)
{
	$mon_b = substr($data_b, 5, 2);			// месяц
	$d_b = substr($data_b, 8, 2);			// день
	$time_b = substr($data_b, 11, 5);		// время
	
	$my_mons = array("01" => "янв", "02" => "фев", "03" => "мар", "04" => "апр", "05" => "мая", "06" => "июня", "07" => "июля", "08" => "авг", "09" => "сен", "10" => "окт", "11" => "ноя", "12" => "дек");	

	foreach ($my_mons as $k_dec => $v_mon)
	{
		if ($mon_b == $k_dec)
		$month_b = $v_mon;
	}

	// обрезка чисел, у которых нули в начале:
	$day = str_split($d_b);
	$day_ = $day[0];
	if ($day_ == 0)
	{
		$day_b = $day[1];
	}
	else 
	$day_b = $d_b; 		
	
	$data_nat = $day_b."&nbsp;".$month_b."&nbsp; в ".$time_b."&nbsp;";
	return $data_nat;
}

function cutDate($data)
{
	$data_arr = explode(" ", $data);
	return $data_arr[1];
}

function getParametersUser($par)
{
	$query = mysql_query("select VALUE from settings where CODE = '".$par."'");
	$res = mysql_fetch_array($query);
	$value = $res['VALUE'];
	return $value;
}

// для параметров киоска:
function getKioskParams()
{
	$query = mysql_query("select * from kiosk_params");
	while ($result = mysql_fetch_array($query))
	{
		$name = $result['NAME'];
		$value = $result['VALUE'];
		$params[$name] = $value;
	}
	return $params;
}

function paramsToSession($params)
{
  foreach ($params as $key => $value)
  {
	$_SESSION[$key] = $value;
  }
}

function getYears($age)
{
	if ($age == 11 || $age == 12 || $age == 13 || $age == 14)
	{
		$str_age = $age." лет";
	}
	else
	{
		$i = strlen($age) - 1;
		$last = substr($age, $i);
		$ends = array("0" => "лет", "1" => "год", "2" => "года", "3" => "года", "4" => "года", "5" => "лет", "6" => "лет", "7" => "лет", "8" => "лет", "9" => "лет");
		
		foreach ($ends as $key => $value)
		{
			if ($last == $key)
				$str_age = $age." ".$value;
		}
	}
	
	return $str_age;
}

?>