		<input type="hidden" id="h_lpu_name" value="{$LPU_NAME}">
		<input type="hidden" id="h_lpu_addr" value="{$LPU_ADDRESS}">
		
		<input type="hidden" id="h_num" value="{$NUM}" />
		<input type="hidden" id="h_fio" value="{$PAT_INFO}" />
		<input type="hidden" id="h_bd" value="{$BIRTH_DATE}" />
		<input type="hidden" id="h_socst" value="{$SOCIAL_STATUS}" />
		<input type="hidden" id="h_company" value="{$COMPANY}" />
		<input type="hidden" id="h_police" value="{$POLICE}" />
		<input type="hidden" id="h_passport" value="{$PASSPORT}" />
		<input type="hidden" id="h_address" value="{$ADDRESS}" />
		<input type="hidden" id="h_priv" value="{$PRIV}" />
		<input type="hidden" id="h_years" value="{$YEARS}" />
		<input type="hidden" id="h_sex" value="{$SEX}" />
		<input type="hidden" id="h_phone" value="{$PHONE}" />
		<input type="hidden" id="h_snils" value="{$SNILS}" />
		<input type="hidden" id="h_room" value="{$ROOM}" />
		<input type="hidden" id="h_time" value="{$TIME}" />
		<input type="hidden" id="h_doctor" value="{$DOCTOR}" />

<input type="hidden" id="visitid" value="abcd123456" />
<input type="hidden" id="time" value="{$TIME}" />
<input type="hidden" id="pat_info" value="{$PAT_INFO}" />
<input type="hidden" id="specname" value="{$SPECNAME}" />
<input type="hidden" id="docname" value="{$DOCNAME}" />
<input type="hidden" id="mode" value="{$MODE}" />
<input type="hidden" id="cab" value="{$CAB}" />
<input type="hidden" id="kart" value="{$KART}" />
<div class="success_confirm">
	<span class="nums_datastr">Запись прошла успешно!</span>
	<br />
	<div class="yellow_button go_home">
		<span>К общему списку</span>
	</div>
</div>
<script type="text/javascript">
	//jsPrintSetup.setSilentPrint(true);
	//jsPrintSetup.setShowPrintProgress(false);
</script>
<script>
$(document).ready(function () {
	$("#td_barcode").load("userdata_success_temp.html");
/*	function updateBarcode() 
	{
		var barcode = new bytescoutbarcode128();
		var value = document.getElementById("visitid").value;
		alert(typeof(value));
		barcode.valueSet(value);
		barcode.setMargins(5, 5, 5, 5);
		barcode.setBarWidth(2);

		var width = barcode.getMinWidth();

		barcode.setSize(width, 100);

		var barcodeImage = document.getElementById('barcodeImage');
		barcodeImage.src = barcode.exportToBase64(width, 100, 0);							
	}
	updateBarcode();*/
		/*$(".helper_for_patient, .hback").hide();
		// получение значений переменных
		var lpu_name = $("#h_lpu_name").val(); 
		var lpu_addr = $("#h_lpu_addr").val();
		var num = $("#h_num").val(); 
		var fio = $("#h_fio").val(); 
		var bd = $("#h_bd").val(); 
		var socst = $("#h_socst").val(); 
		var company = $("#h_company").val(); 
		var police = $("#h_police").val(); 
		var passport = $("#h_passport").val(); 
		var address = $("#h_address").val(); 
		var priv = $("#h_priv").val(); 
		var years = $("#h_years").val(); 
		var sex = $("#h_sex").val(); 
		var phone = $("#h_phone").val(); 
		var snils = $("#h_snils").val(); 
		var room = $("#h_room").val(); 
		
		var visitid = $("#visitid").val();
		var time = $("#h_time").val(); 
		var doctor = $("#h_doctor").val(); 
		var dat = $("#dat").val(); 
		var cab = $("#cab").val();
		var specname = $("#specname").val();
		//alert("Идёт печать вашего номерка...");
		
		$(".print_b").hide();
		setTimeout(function () {
					$("#vis_numb").text(visitid); 
					$("#lpu_name").text(lpu_name); 
					$("#pac_kart").text(num); 
					$("#fio_pac").text(fio);
					$("#bd_pac").text(bd);	
					$("#pac_priv").text(priv);	
					$("#pat_socst").text(socst);
					$("#pac_address b").text(address);
					$("#doc_name_ser_num").text(passport);
					$("#pac_snils b").text(snils);
					$("#pac_sk b").text(company);
					$("#pac_polic").text(police);
					$("#num_data").text(dat);
					$("#num_time").text(time);
					$("#doctor_name").text(doctor);
					$("#special_name").text(specname);
					$("#num_cab").text(cab);
					$("#pac_age").text(years);
					$("#pac_sex").text(sex);	
					$(".print_b").print();	
		}, 3000);	*/	
});
</script>
<div class="tt"></div>
<div class="print_b">
	<div>
	<style>
		table.lpu_info, table.talon_info, table.phones {
		position: relative;
		width: 100%;
		border-collapse: collapse;
		margin: 20px 0px;
	}
	table.phones {
		margin-top: 0px;
	}
	
	table.lpu_info {
		margin-bottom: 0px;
	}
	
	table.lpu_info tr td, table.talon_info tr td {
		text-align: center;
	}

	table.lpu_info tr td {
		border: 1px dotted #000;
	}

	table.talon_info tr td {
		border: 1px solid #000;
	}

	table.phones tr td {
		border-top: none;
		border-right: 1px dotted #000;
		border-bottom: 1px dotted #000;
		border-left: 1px dotted #000;
		text-align: center;
	}
	</style>
				<div>
					<table class="lpu_info">
						<tr>
							<td>
								<img src="static/img/logo_lpu.gif" />
							</td>
							<td>
								<span>Санкт-Петербургское государственное бюджетное учреждение здравоохранения</span>
								<br />
								<span style="font-family: 'Bookman Old Style'"><b>"Консультативно-диагностический центр для детей"</b></span>
							</td>
						</tr>
					</table>
					<table class="phones">
						<tr>
							<td>
								<span>192289, г.Cанкт-Петербург, ул. Олеко Дундича д.36 к.2</span>
							</td>
							<td>
								<img src="static/img/phone.gif" />
							</td>
							<td>
								<span style="font-family: 'Bookman Old Style'"><b>регистратуры: 708-29-36 (37), 778-1801,</b></span>
								<span><b>e-mail: </b>gdkcd@zdrav.spb.ru, <b>сайт:</b> www.kdcd.spb.ru</span>
							</td>
						</tr>
					</table>
					<p style='text-align:center'><b><span style='font-size: 11pt'>Талон для предварительной записи пациента</span></b></p>

					<table class="talon_info">
						<tr>
							<td>
								<span>Талон № </span>
								<span id="vis_numb"></span><!-- для штрих-кода -->
							</td>
							<td id="td_barcode">
							</td>
						</tr>
						<tr>
							<td>
								<span id="num_time"></span>
							</td>
							<td>
								<span id="num_cab"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span id="doctor_name"></span>
							</td>
							<td>
								<span id="special_name"></span>
							</td>
						</tr>
						<tr>
							<td colspan=2  style="text-align: left;">
									<h4>Информация для пациента:</h4>

<span style="font-size: 90%;"><b>Важно !!! Талон действителен до 19-00 </b></span><br />
<span>(АВТОМАТИЧЕСКИ ВПЕЧАТЫВАЕТСЯ ДАТА И ВРЕМЯ ОКОНЧАНИЯ ДЕЙСТВИЯ ТАЛОНА, ИСХОДЯ ИЗ ПРАВИЛ, УКАЗАННЫХ ВЫШЕ С УЧЕТОМ ДАТЫ ФОРМИРОВАНИЯ ТАЛОНА) XX/XX/2014 г.
Данный талон дает право предварительной брони даты и времени визита к выбранному Вами специалисту КДЦД. Для подтверждения брони необходимо зарегистрировать талон до указанного времени окончания срока действия талона, иначе бронь снимается, талон аннулируется и поступает в сеть для свободной записи. 
Регистрация талона осуществляется в окне №3 регистратуры КДЦД, расположенного по адресу: г.Cанкт-Петербург, ул. Олеко Дундича дом 36 корпус 2, с предоставлением следующих на документов:</span>
								<ol>
									<li>Направление из поликлиники форма № 057/у-04 "Направление на госпитализацию, восстановительное лечение, обследование, консультацию», правильно оформленное со  штампом, реквизитами и треугольной печатью амбулаторно-поликлинического учреждения Санкт-Петербурга</li>
									<li>Свидетельство о рождении ребенка или паспорт (при достижении возраста 14 лет)</li>
									<li>Действующий оригинал полиса обязательного медицинского страхования</li>
									<li>Выписку из истории развития ребенка (форма № 112/у)</li>
									<li>Справку о профилактических прививках и туберкулиновых пробах</li>
									<li>Результаты ранее выполненных обследований</li>
									<li>Паспорт законного представителя ребенка</li>
								</ol>
								<p><b>Регистрация НЕ производится, если:</b></p>
								<ul>
									<li>в талоне и в представленных документах не совпадают личные данные пациента (ФИО и дата рождения) </li>
									<li>отсутствуют или неправильно оформлены документы, указанные в перечне</li>
								</ul>
								<small>Первичная запись в системе ОМС осуществляется по основному заболеванию только к 1 специалисту КДЦД, согласно Распоряжению Комитета по здравоохранению Правительства Санкт-Петербурга от 31.10.2013 г. 
								№ 434-р "Об утверждении порядка направления пациентов в СПб ГУЗ "Консультативно-диагностический центр для детей". </small>
							</td>
						</tr>	
					</table>
				</div>
	</div>
</div>