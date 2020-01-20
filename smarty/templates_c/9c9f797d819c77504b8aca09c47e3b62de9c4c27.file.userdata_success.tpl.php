<?php /* Smarty version Smarty-3.0.8, created on 2014-05-12 09:11:04
         compiled from "smarty/templates/userdata_success.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3028537057e8ab6e05-76355236%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c9f797d819c77504b8aca09c47e3b62de9c4c27' => 
    array (
      0 => 'smarty/templates/userdata_success.tpl',
      1 => 1385039472,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3028537057e8ab6e05-76355236',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('STATUS')->value==0){?>
<?php if ($_smarty_tpl->getVariable('NEWPHONE')->value==1){?>
<script>
$(document).ready(function () {
	$('#newphone').focus();
	function press_key(symb)
	{
		var text_val = $("#newphone").val();
		// проверка на длину, максимальная 11

		if (symb != 'C')
		{
			if (text_val.length <= 11)
			{
				$("#newphone").val(text_val+symb);
				$('#newphone').focus();	
			}
		}
		else
		{
			$("#newphone").val(text_val.substring(0, text_val.length - 1));
			$('#newphone').focus();	
		}
		
		var text_val1 = $("#newphone").val();
		if (text_val1.length >= 7)			// активация кнопки
		{
			$('.yellow_button').removeClass('confirm_button_unact');
			$('.yellow_button').addClass('confirm_button');
		}
		else		// деактивация кнопки
		{
			$('.yellow_button').removeClass('confirm_button');
			$('.yellow_button').addClass('confirm_button_unact');			
		}
	}
	
	// когда кнопки нажаты
	$(".key_yellow_button").mousedown(function () {
		$(this).removeClass("key_yellow_button");
		$(this).addClass("key_green_button");
	});
	// кнопка отпущена
	$(".key_yellow_button").mouseup(function () {
		$(this).removeClass("key_green_button");
		$(this).addClass("key_yellow_button");
		var symb = $(this).children('input').val();
		press_key(symb);
	});	
	
	// кнопка отпущена
	$(".key_yellow_button").mouseout(function () {
		$(this).removeClass("key_green_button");
		$(this).addClass("key_yellow_button");
	});
	
	function confirm()
	{
		var numbid = $("#numbid").val();
		var date_str = $("#date_str").val();
		var dat = $("#dat").val();
		var dayweek = $("#dayweek").val();
		var newphone = $("#newphone").val();
		$("#confirm").submit();
	}	
	
	$(".yellow_button").click(function () {
		if ($(this).hasClass('confirm_button'))
		{
			confirm();
		}
	});
	
	$(".ajaxwait, .ajaxwait_image, .hback, .helper_for_patient").hide();
});
</script>
	<span style="position: relative; left: 100px;  top: 40px; font: normal 18pt Calibri;"><b>Внимание!</b> Вас нет в нашей базе, поэтому перед посещением врача необходимо с номерком оформить карточку в регистратуре.</span>
	<?php }else{ ?>
<script>
$(document).ready(function () {
	function confirm()
	{
		var numbid = $("#numbid").val();
		var date_str = $("#date_str").val();
		var dat = $("#dat").val();
		var dayweek = $("#dayweek").val();
		$("#confirm").submit();
	}
	function go_home()
	{
		window.location.href = "index.php";
	}
	
	$(".helper_for_patient").hide();
	$(".kdc").hide();
	
	$(".confirm_button").click(function () {
		confirm();
	});
	
	$(".ajaxwait, .ajaxwait_image, .hback").hide();
});
</script>	
	<?php }?>
<div class="confirm">
	<span class="nums_datastr your_num">Ваш номерок:</span>
	<br />
	<form method="post" name="confirm" id="confirm" action="userdata_success.php">
		<table class="num_confirm">
			<tr>
				<td style="text-align: right; padding-right: 15px;">
					<span class="specname_num">День</span>
				</td>
				<td>
					<span class="nums_datastr"><?php echo $_smarty_tpl->getVariable('DATE_STR')->value;?>
,</span>
					<span class="nums_dayweek"><?php echo $_smarty_tpl->getVariable('DAYWEEK')->value;?>
</span>
				</td>
			</tr>
			<tr>
				<td style="text-align: right; padding-right: 15px;">
					<span class="specname_num">Время</span>
				</td>
				<td>
					<span class="nums_dayweek"><?php echo $_smarty_tpl->getVariable('DAT')->value;?>
</span>
				</td>
			</tr>
			<?php if ($_smarty_tpl->getVariable('NEWPHONE')->value==1){?>
			<tr>
				<td style="text-align: right; padding-right: 15px;">
					<span class="specname_num">Телефон для связи</span>
					<br />
					<span style="font-size: 14pt; color: #06a5b8;">мобильный или городской</span>
				</td>
				<td>
					<input type="text" onkeydown="return false;" autocomplete="off" id="newphone" name="newphone" style="border: 1px solid #40af82; height: 40px; font-size: 24pt; max-width: 250px;" />
				</td>			
			</tr>
			<?php }?>
		</table>
		<?php if ($_smarty_tpl->getVariable('NEWPHONE')->value==1){?>
		<div class="keyboard_symbols_buttons" style="position: relative; top: 70px; left: -10px; ">
			<table class="keyboard_table_rus" style="position: absolute; background: #40af82; border-radius: 10px; left: 960px; top: -184px;">
				<tr>
					<td>
						<div class="key_yellow_button">
							<span>1</span>
							<input type="hidden" value="1">
						</div>
					</td>
					<td>
						<div class="key_yellow_button">
							<span>2</span>
							<input type="hidden" value="2">
						</div>
					</td>
					<td>
						<div class="key_yellow_button">
							<span>3</span>
							<input type="hidden" value="3">
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="key_yellow_button">
							<span>4</span>
							<input type="hidden" value="4">
						</div>
					</td>
					<td>
						<div class="key_yellow_button">
							<span>5</span>
							<input type="hidden" value="5">
						</div>
					</td>
					<td>
						<div class="key_yellow_button">
							<span>6</span>
							<input type="hidden" value="6">
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="key_yellow_button">
							<span>7</span>
							<input type="hidden" value="7">
						</div>
					</td>
					<td>
						<div class="key_yellow_button">
							<span>8</span>
							<input type="hidden" value="8">
						</div>
					</td>
					<td>
						<div class="key_yellow_button">
							<span>9</span>
							<input type="hidden" value="9">
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="key_yellow_button">
							<span>0</span>
							<input type="hidden" value="0">
						</div>
					</td>
					<td colspan=2>
						<div class="key_yellow_button butt_c" style="width: 135px;">
							<span>стереть</span>
							<input type="hidden" value="C">
						</div>
					</td>
				</tr>
			</table>	
		</div>
		<div class="yellow_button confirm_button_unact">
			<span>Подтвердить</span>
			<input type="hidden" id="numbid" name="numbid" value="<?php echo $_smarty_tpl->getVariable('NUMBID')->value;?>
" />
			<input type="hidden" id="date_str" name="date_str" value="<?php echo $_smarty_tpl->getVariable('DATE_STR')->value;?>
" />
			<input type="hidden" id="dat" name="dat" value="<?php echo $_smarty_tpl->getVariable('DAT')->value;?>
" />
			<input type="hidden" id="dayweek" name="dayweek" value="<?php echo $_smarty_tpl->getVariable('DAYWEEK')->value;?>
" />			
		</div>
		<?php }else{ ?>
		<div class="yellow_button confirm_button">
			<span>Подтвердить</span>
			<input type="hidden" id="numbid" name="numbid" value="<?php echo $_smarty_tpl->getVariable('NUMBID')->value;?>
" />
			<input type="hidden" id="date_str" name="date_str" value="<?php echo $_smarty_tpl->getVariable('DATE_STR')->value;?>
" />
			<input type="hidden" id="dat" name="dat" value="<?php echo $_smarty_tpl->getVariable('DAT')->value;?>
" />
			<input type="hidden" id="dayweek" name="dayweek" value="<?php echo $_smarty_tpl->getVariable('DAYWEEK')->value;?>
" />			
		</div>
		<?php }?>
	</form>
</div>
<?php }elseif($_smarty_tpl->getVariable('STATUS')->value==1){?>
		<input type="hidden" id="h_lpu_name" value="<?php echo $_smarty_tpl->getVariable('LPU_NAME')->value;?>
">
		<input type="hidden" id="h_lpu_addr" value="<?php echo $_smarty_tpl->getVariable('LPU_ADDRESS')->value;?>
">
		
		<input type="hidden" id="h_num" value="<?php echo $_smarty_tpl->getVariable('NUM')->value;?>
" />
		<input type="hidden" id="h_fio" value="<?php echo $_smarty_tpl->getVariable('FIO')->value;?>
" />
		<input type="hidden" id="h_bd" value="<?php echo $_smarty_tpl->getVariable('BIRTH_DATE')->value;?>
" />
		<input type="hidden" id="h_socst" value="<?php echo $_smarty_tpl->getVariable('SOCIAL_STATUS')->value;?>
" />
		<input type="hidden" id="h_company" value="<?php echo $_smarty_tpl->getVariable('COMPANY')->value;?>
" />
		<input type="hidden" id="h_police" value="<?php echo $_smarty_tpl->getVariable('POLICE')->value;?>
" />
		<input type="hidden" id="h_passport" value="<?php echo $_smarty_tpl->getVariable('PASSPORT')->value;?>
" />
		<input type="hidden" id="h_address" value="<?php echo $_smarty_tpl->getVariable('ADDRESS')->value;?>
" />
		<input type="hidden" id="h_priv" value="<?php echo $_smarty_tpl->getVariable('PRIV')->value;?>
" />
		<input type="hidden" id="h_years" value="<?php echo $_smarty_tpl->getVariable('YEARS')->value;?>
" />
		<input type="hidden" id="h_sex" value="<?php echo $_smarty_tpl->getVariable('SEX')->value;?>
" />
		<input type="hidden" id="h_phone" value="<?php echo $_smarty_tpl->getVariable('PHONE')->value;?>
" />
		<input type="hidden" id="h_snils" value="<?php echo $_smarty_tpl->getVariable('SNILS')->value;?>
" />
		<input type="hidden" id="h_room" value="<?php echo $_smarty_tpl->getVariable('ROOM')->value;?>
" />
		<input type="hidden" id="h_time" value="<?php echo $_smarty_tpl->getVariable('TIME')->value;?>
" />
		<input type="hidden" id="h_doctor" value="<?php echo $_smarty_tpl->getVariable('DOCTOR')->value;?>
" />
<input type="hidden" id="time" value="<?php echo $_smarty_tpl->getVariable('TIME')->value;?>
" />
<input type="hidden" id="pat_info" value="<?php echo $_smarty_tpl->getVariable('PAT_INFO')->value;?>
" />
<input type="hidden" id="specname" value="<?php echo $_smarty_tpl->getVariable('SPECNAME')->value;?>
" />
<input type="hidden" id="docname" value="<?php echo $_smarty_tpl->getVariable('DOCNAME')->value;?>
" />
<input type="hidden" id="mode" value="<?php echo $_smarty_tpl->getVariable('MODE')->value;?>
" />
<input type="hidden" id="cab" value="<?php echo $_smarty_tpl->getVariable('CAB')->value;?>
" />
<input type="hidden" id="kart" value="<?php echo $_smarty_tpl->getVariable('KART')->value;?>
" />
<div class="success_confirm">
	<span class="nums_datastr">Запись прошла успешно!</span>
	<br />
	<div class="yellow_button go_home">
		<span>К общему списку</span>
	</div>
</div>
	<?php if ($_SESSION['PRINT_CH_KIND']==1){?>
<script>
$(document).ready(function () {
	var time = $("#time").val();
	var pat_info = $("#pat_info").val();
	var specname = $("#specname").val();
	var docname = $("#docname").val();
	var mode = $("#mode").val();
	var cab = $("#cab").val();
	var kart = $("#kart").val();
	var lpu_name = $("#h_lpu_name").val();
	var lpu_addr = $("#h_lpu_addr").val();
	
	 setTimeout(function () {
		window.location.href = "index.php";
	}, 60000);
	
	$(".helper_for_patient, .hback").hide();
	
	$.ajax({
		url: "ajax/ajax_print.php", 
		type: "POST",
		data: 
		{
			time: time,
			pat_info: pat_info,
			specname: specname,
			docname: docname,
			mode: mode,
			cab: cab,
			kart: kart,
			lpu_name: lpu_name,
			lpu_addr: lpu_addr
		},
		success: function(html)
		{
			$(".success_confirm").append(html);
		}
	});
});
</script>
	<?php }elseif($_SESSION['PRINT_CH_KIND']==2){?>	
		<?php $_template = new Smarty_Internal_Template("print_block.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	<?php }elseif($_SESSION['PRINT_CH_KIND']==4){?>
<script type="text/javascript">
	 jsPrintSetup.setSilentPrint(true);
	 jsPrintSetup.setShowPrintProgress(false);
</script>	
<script>
$(document).ready(function () {
		$(".print_b div").load("print_a5_2.html");
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
		var time = $("#h_time").val(); 
		var doctor = $("#h_doctor").val(); 
		var dat = $("#dat").val(); 
		var cab = $("#cab").val();
		var specname = $("#specname").val();
		//alert("Идёт печать вашего номерка...");
		
		$(".print_b").hide();
		setTimeout(function () {
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
		}, 3000);		
});
</script>
<div class="tt"></div>
<div class="print_b">
	<div></div>
</div>
	<?php }elseif($_SESSION['PRINT_CH_KIND']==3){?>
<script type="text/javascript">
	 jsPrintSetup.setSilentPrint(true);
	 jsPrintSetup.setShowPrintProgress(false);
</script>	
<script>
$(document).ready(function () {
		$(".helper_for_patient, .hback").hide();
		$(".print_b div").load("print_a5_2.html");
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
		var time = $("#h_time").val(); 
		var doctor = $("#h_doctor").val(); 
		var dat = $("#dat").val(); 
		var cab = $("#cab").val();
		var specname = $("#specname").val();
		//alert("Идёт печать вашего номерка...");
		
		$(".print_b").hide();
		setTimeout(function () {
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
		}, 3000);		
});
</script>
<div class="barcode"></div>
<div class="tt"></div>
<div class="print_b">
	<div></div>
</div>		
	<?php }?>
<?php }?>