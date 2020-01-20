$(document).ready(function () {
	function press_key(symb)
	{
		// узнать, какое поле сейчас в фокусе и добавить в него символ
		var hid=$("#active_field").val();

		if (hid != 'birthday')
		{
			var text_val = $(".user_rec_block input[type='text']."+hid).val();
			$(".user_rec_block input[type='text']."+hid).val(text_val+symb);
			$(".user_rec_block input[type='text']."+hid).focus();
		}
		else
		{
			var text_val1 = $(".user_rec_block input[type='text']."+hid).val();
			// если цифра - ввести
			if (symb.match(/^[0-9]$/))
			{
				var tv_length = text_val1.length;
				if (tv_length != 2 && tv_length != 5 && tv_length < 10)
				{
					$(".user_rec_block input[type='text']."+hid).val(text_val1+symb);
					$(".user_rec_block input[type='text']."+hid).focus();
				}
				// заново длина, чтоб понять, нужна ли точка
				var text_val2 = $(".user_rec_block input[type='text']."+hid).val();
				var tv_length2 = text_val2.length;
				if (tv_length2 == 2 || tv_length2 == 5)
				{
					$(".user_rec_block input[type='text']."+hid).val(text_val2+".");
					$(".user_rec_block input[type='text']."+hid).focus();				
				}
			}
		}
	}
	
	function latin()
		{
			var focus_field = $("#active_field").val();

			var butt = $(".latin input").val();
			// alert(butt);
			if (butt == 'рус')
			{
				$(".keyboard_table_lat").remove();
				$(".keyboard_symbols_buttons").load('smarty/templates/keyboard_rus.tpl');
			}
			else 
			{
				$(".keyboard_table_rus").remove();
				$(".keyboard_symbols_buttons").load('smarty/templates/keyboard_lat.tpl');		
			}
			$("."+focus_field).focus();
			$("."+focus_field).parent().parent().addClass("selected_tr");
		} 


	
	// при нажатии на блок-кнопку
	$(".key_yellow_button").not(".latin").click(function () {
		//var symb = $(this).children('input').val();
		//press_key(symb);
	});
	
	$(".latin").click(function () {
		latin();
	});
	
	// когда кнопки нажаты
	$(".key_yellow_button").mousedown(function () {
		$(this).removeClass("key_yellow_button");
		$(this).addClass("key_green_button");
	});
	// кнопка отпущена
	$(".key_yellow_button").not(".latin").mouseup(function () {
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
	
	// especially for backspace
	$(".backspace").mousedown(function () {
		$(this).removeClass("backspace");
		$(this).addClass("backspace_green");
	});
	// кнопка отпущена
	$(".backspace").mouseup(function () {
		$(this).removeClass("backspace_green");
		$(this).addClass("backspace");
	});
	
	// кнопка отпущена
	$(".backspace").mouseout(function () {
		$(this).removeClass("backspace_green");
		$(this).addClass("backspace");
	});	
	
	// especially for lat & space
	$(".probel").mousedown(function () {
		$(this).removeClass("probel");
		$(this).addClass("probel_green");
	});
	// кнопка отпущена
	$(".probel").mouseup(function () {
		$(this).removeClass("probel_green");
		$(this).addClass("probel");
	});
	
	// кнопка отпущена
	$(".probel").mouseout(function () {
		$(this).removeClass("probel_green");
		$(this).addClass("probel");
	});	
	
	$(".latin").mousedown(function () {
		$(this).removeClass("latin");
		$(this).addClass("latin_green");
	});
	// кнопка отпущена
	$(".latin").mouseup(function () {
		$(this).removeClass("latin_green");
		$(this).addClass("latin");
	});
	
	// кнопка отпущена
	$(".latin").mouseout(function () {
		$(this).removeClass("latin_green");
		$(this).addClass("latin");
	});	
	
		// =======	активация и деактивация кнопки "ГОТОВО"
	$(".key_yellow_button, .backspace, .cancel").click(function () {
		var emp = 0;
		var bd = 0;
		$("input[type='text']").not('.seria').each(function (i) {
			if ($(this).val() == '')
			{
				emp += 1;
			}
		});
		var bd_text = $(".birthday").val();
		var bd_text_length = bd_text.length;
		if (bd_text_length == 10)
			bd += 1;
		else
			bd -= 1;
		if (emp > 0 && bd == 0)
		{
			$(".keyboard_control_buttons .not_ready img").remove();
			$(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
		}
		if (emp == 0 && bd > 0)
		{
			$(".keyboard_control_buttons .not_ready img").remove();
			$(".ajaxwait, .ajaxwait_image").show();
			$(".keyboard_control_buttons .not_ready").append("<img class='ready' src='static/img/ready.png'>");	
			$(".ajaxwait, .ajaxwait_image").hide();
		}
	});
	
	// нажатие кнопки "готово":
	$(".not_ready").mousedown(function () {
		if ($(".ready").length > 0)
		{
		//	$(this).children('img').remove();
			//$(this).append("<img class='ready' src='static/img/ready.png'>");
		}
	});
	
	// ajax-проверка правильности данных пользователя
	$(".not_ready").mouseup(function () {
		if ($(".ready").length > 0)
		{
			//$("#userdata").submit();			
			
			var ser_fio = $('.seria').length;		// проверка на серию-полис/ФИО
			var userdata = [];
			var pat_numbers = $("#pat_numbers").val();
			
			$('#userdata input[type="text"]').each(function (i) {
				var text = $(this).val();
				userdata[i] = text;
			});
			
			var dayweek = $('.dayweek').val();
			var date_str = $('.date_str').val();
			var numbid = $('.numbid').val();
			var dat = $('.dat').val();
			
			// отправляем на проверку
			$.ajax({
				type: "POST",
				url: "userdata.php",
				data: {
					userdata: userdata,
					ser_fio: ser_fio,
					dayweek: dayweek,
					date_str: date_str,
					dat: dat,
					numbid: numbid,
					pat_numbers: pat_numbers
				},
				success: function(html) {
					$('.header').before(html);
				}
			});
		}
	});
	$(".not_ready").mouseout(function () {
		if ($(".ready").length > 0)
		{
			$(this).children('img').remove();
			$(this).append("<img class='ready' src='static/img/ready.png'>");
		}
	});
});