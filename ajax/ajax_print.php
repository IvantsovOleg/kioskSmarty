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
	$dms = '��� (�����)';
  else
	$dms = '��� (��ᯫ���)';
  
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
	$c = "�६�: ";
	
	$d = $time;
	$fio = $pat_info;
	$e = "���: ".$specname;
	$doc = $docname;
	$mode = "����� �ਥ��: ".$dms;
	$cab = "������� ".$cab_number;
	$kart = "����窠 ".$kart_number;
	$tire = "------------------------------------------";
	
	// ����⪠:
	$rem = "������� ��� ��������";
	$oms_message = "�� ���饭�� 業�� ���쬨� � ᮡ�� ���㫠���� ����� ॡ���� ��� �믨�� �� ���.";
	$oms_message_docs = "�᫨ �� ���ࠢ���� � ࠬ��� ���, ��� ����室���  ᫥���騥 ���㬥���: ";

	$p1 = " - ���ࠢ����� �� ����������� �� ����� ��⥫��⢠ � ������ � �⠬���� ��०����� (���ࠢ����� ����⢨⥫쭮  � �祭�� 2 ����楢 � ������ �뤠�);";
	$p2 = " - �������騩 ����� ���;";
	$p3 = " - ᢨ��⥫��⢮ � ஦����� ��� ��ᯮ�� ॡ����;";
	$p4 = " - ��ᯮ�� த�⥫�.";

	$mes_lo = "  ��� ��⥫�� ������ࠤ᪮� ������ � ��㣨� ॣ����� ����室�� ��ᯮ�� த�⥫� � �ய�᪮� � ������ ॣ���� (� ��� �ய�ᠭ ॡ����).";
	$mes_otk = "  ���頥� ��� ��������, �� ������⢨� ����室���� �ࠢ��쭮 ��ଫ����� ���㬥�⮢ ���� �᭮������ ��� �⪠�� � �஢������ ��ᯫ�⭮� �������樨 � ��᫥�������. ";

	// ���樠������ �ਭ��
	$serial->sendMessage(chr(0x1B).chr(0x40));
	$serial->sendMessage(chr(0x1B).chr(0x1D).chr(0x74).chr(0x22));
	$serial->sendMessage(chr(0x1D).chr(0x21).chr(0x01));
	
	// ᮤ�ঠ⥫쭠� ����, ����� ��樥��
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
	
	// ����⪠ ��� ��樥��
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

	// 䨭��쭮� �� � ��१�� 祪�
	$serial->sendMessage($tire.chr(0x0A)); 
	$serial->sendMessage(chr(0x0A));
	$serial->sendMessage(chr(0x0C)); 	
	
// If you want to change the configuration, the device must be closed
$serial->deviceClose();

// ����� ���⠢��� �㭪�� �� ⠩����!!!!!!

echo "<script>
	setTimeout(function () {
		window.location.href = 'index.php';
	}, 60000);
	$('.go_home').click(function () {
		window.location.href = 'index.php';
	});
	</script>";
?>