<?php
  require "../utils.php";
  require "../smarty/libs/smarty.class.php";
  require "../conn.php";
  require "../xmlhelper.php";
  include "../php_serial.class.php";
  
  error_reporting(0);
  
  $time = iconv("utf-8", "cp866", $_POST['time']);
  $pat_info = iconv("utf-8", "cp866", $_POST['pat_info']);
  $specname = iconv("utf-8", "cp866", $_POST['specname']);
  $docname = iconv("utf-8", "cp866", $_POST['docname']);
  $mode = iconv("utf-8", "cp866", $_POST['mode']);
  $cab_number = iconv("utf-8", "cp866", $_POST['cab']);
  $kart_number = iconv("utf-8", "cp866", $_POST['kart']);
  $lpu_addr = iconv("utf-8", "cp866", $_POST['lpu_addr']);
  $lpu_name = iconv("utf-8", "cp866", $_POST['lpu_name']);  
  
  if ($mode == 1)
	$dms = 'ДМС (платный)';
  else
	$dms = 'ОМС (бесплатный)';
  
  function getComByIp ($ip)
	{
		$com_q = mysql_query("select * from COM_by_IP where IP_address = '".$ip."'");
		$com_r = mysql_fetch_array($com_q);
		$com = $com_r['COM_number'];
		
		return $com;
	}

	$serial = new phpSerial;
  
	$ip = $_SERVER['REMOTE_ADDR'];
	$com = getComByIp($ip);
	$serial->confBaudRate(19200);
	$serial->deviceSet("COM".$com);
	
	$serial->deviceOpen();
	// const
	$a = $lpu_name;
	$b = $lpu_addr;
	$c = "Время: ";
	
	$d = $time;
	$fio = $pat_info;
	$e = "Врач: ".$specname;
	$doc = $docname;
	$mode = "Режим приема: ".$dms;
	$cab = "кабинет ".$cab_number;
	$kart = "карточка ".$kart_number;
	$tire = "------------------------------------------";
	
	// памятка:
	$rem = "ПАМЯТКА ДЛЯ ПАЦИЕНТА";
	$oms_message = "При посещении центра возьмите с собой амбулаторную карту ребенка или выписку из нее.";
	$oms_message_docs = "Если Вы направлены в рамках ОМС, Вам необходимы  следующие документы: ";

	$p1 = " - направление из поликлиники по месту жительства с печатью и штампами учреждения (направление действительно  в течение 2 месяцев с момента выдачи);";
	$p2 = " - действующий полис ОМС;";
	$p3 = " - свидетельство о рождении или паспорт ребенка;";
	$p4 = " - паспорт родителя.";

	$mes_lo = "  Для жителей Ленинградской области и других регионов необходим паспорт родителя с пропиской в данном регионе (с кем прописан ребенок).";
	$mes_otk = "  Обращаем Ваше внимание, что отсутствие необходимых правильно оформленных документов является основанием для отказа в проведении бесплатной консультации и исследований. ";

	// инициализация принтера
	$serial->sendMessage(chr(0x1B).chr(0x40));
	$serial->sendMessage(chr(0x1B).chr(0x1D).chr(0x74).chr(0x22));
	$serial->sendMessage(chr(0x1D).chr(0x21).chr(0x01));
	
	// содержательная часть, данные пациента
	$serial->sendMessage("  ".$a.chr(0x0A)); 
	$serial->sendMessage(chr(0x09).chr(0x1D).chr(0x21).chr(0x00).chr(0x1B).chr(0x21).chr(0x1B).$b);
	$serial->sendMessage(chr(0x0A));
	$serial->sendMessage(chr(0x0A).chr(0x1B).chr(0x21).chr(0x00));
	$serial->sendMessage(chr(0x1D).chr(0x21).chr(0x00));
	$serial->sendMessage($c.$d.", ".$cab.chr(0x0A)); 
	$serial->sendMessage(chr(0x0A));
	$serial->sendMessage($fio.", ".$kart.chr(0x0A)); 
	$serial->sendMessage(chr(0x0A));
	$serial->sendMessage($e.", ".$doc.chr(0x0A)); 
	$serial->sendMessage($mode.chr(0x0A)); 
	$serial->sendMessage($tire.chr(0x0A)); 
	$serial->sendMessage(chr(0x0A));
	
	// памятка для пациента
	$serial->sendMessage(chr(0x09).chr(0x1D).chr(0x21).chr(0x01).$rem.chr(0x0A));
	$serial->sendMessage(chr(0x0A).chr(0x1B).chr(0x21).chr(0x00));

	$serial->sendMessage($oms_message.chr(0x0A));
	$serial->sendMessage(chr(0x0A));
	$serial->sendMessage($oms_message_docs.chr(0x0A));
	$serial->sendMessage(chr(0x0A));

	$serial->sendMessage($p1.chr(0x0A));
	$serial->sendMessage($p2.chr(0x0A));
	$serial->sendMessage($p3.chr(0x0A));
	$serial->sendMessage($p4.chr(0x0A));
	$serial->sendMessage(chr(0x0A));

	$serial->sendMessage($mes_lo.chr(0x0A));
	$serial->sendMessage($mes_otk.chr(0x0A));
	$serial->sendMessage(chr(0x0A));

	// финальное тире и отрезка чека
	$serial->sendMessage($tire.chr(0x0A)); 
	$serial->sendMessage(chr(0x0A));
	$serial->sendMessage(chr(0x0C)); 	
	
// If you want to change the configuration, the device must be closed
$serial->deviceClose();

// Здесь поставить функцию на таймауте!!!!!!

echo "<script>
	setTimeout(function () {
		window.location.href = 'index.php';
	}, 60000);
	$('.go_home').click(function () {
		window.location.href = 'index.php';
	});
	</script>";
?>