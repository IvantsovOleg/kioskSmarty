<script type="text/javascript">
$(document).ready(function () {
	// по умолчанию фокус задан первому элементу
	$(".user_rec_block input[type='text']:first").focus();
	
	// если текстовое поле в фокусе 
	$(".user_rec_block input[type='text']").focus(function () {
		var hid = $(this).attr('class');
		$("#active_field").val(hid);
		$(".user_rec_block_table tr").removeClass("selected_tr");
		$(".user_rec_block input[type='text']."+hid).parent().parent().addClass("selected_tr");
	});
	
	$(".helper_for_patient").hide();
	$(".kdc").hide();

	function next_field()
	{
		var fields = [];
		$(".user_rec_block input[type='text']").each(function (i) {
			fields[i] = $(this).val();
		});
		
		var hid = $("#active_field").val();	
		var focus_val = $(".user_rec_block input[type='text']:last").attr('class');
		if (focus_val == hid)
		{
			$(".user_rec_block_table tr").removeClass("selected_tr");
			$(".user_rec_block input[type='text']:first").parent().parent().addClass("selected_tr");
			$(".user_rec_block input[type='text']:first").focus();
			var new_focus = $(".user_rec_block input[type='text']:first").attr('class');
			$("#active_field").val(new_focus);
		}
		else
		{
			$(".user_rec_block input[type='text']."+hid).parent().parent().next().children().children("input").focus();
			$(".user_rec_block_table tr").removeClass("selected_tr");
			$(".user_rec_block input[type='text']."+hid).parent().parent().next().addClass("selected_tr");
		}
	}

	// стереть символ
	function erase_symbol()
	{
		var hid=$("#active_field").val();
		var er_val = $(".user_rec_block input[type='text']."+hid).val();
		$(".user_rec_block input[type='text']."+hid).val(er_val.substring(0, er_val.length - 1));
		$(".user_rec_block input[type='text']."+hid).focus();
		
		var er_val2 = $(".user_rec_block input[type='text']."+hid).val();
		if (er_val2 == '')
		{
			$(".keyboard_control_buttons .not_ready img").remove();
			$(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
		}
		if (er_val2.length < 10 && hid == 'birthday')
		{
			$(".keyboard_control_buttons .not_ready img").remove();
			$(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");		
		}
	}
	
	// при нажатии на кнопку "стереть"
	$(".backspace").click(function () {
		erase_symbol();
	});

// отмена заполнения полей, стереть все
function cancel_entering()
{
	$(".user_rec_block input[type='text']").val('');
	$(".user_rec_block input[type='text']:first").focus();
	var hid = $(".user_rec_block input[type='text']:first").attr('class');
	$("#active_field").val(hid);
	$(".user_rec_block_table tr").removeClass("selected_tr");
	$(".user_rec_block input[type='text']:first").parent().parent().addClass("selected_tr");
	
	$(".keyboard_control_buttons .not_ready img").remove();
	$(".keyboard_control_buttons .not_ready").append("<img src='static/img/not_ready.png'>");
}
	
	// вызов функций
	
	// следующее поле:
	$(".next_field").mouseup(function () {
		$(this).children('img').remove();
		$(this).append("<img src='static/img/next_field.png'>");
	});
	$(".next_field").mousedown(function () {
		next_field();
		$(this).children('img').remove();
		$(this).append("<img src='static/img/next_field_in.png'>");
	});
	$(".next_field").mouseout(function () {
		$(this).children('img').remove();
		$(this).append("<img src='static/img/next_field.png'>");
	});
	
	// отмена:
	$(".cancel").mouseup(function () {
		$(this).children('img').remove();
		$(this).append("<img src='static/img/cancel.png'>");
	});
	$(".cancel").mousedown(function () {
		$(this).children('img').remove();
		$(this).append("<img src='static/img/cancel_in.png'>");
		cancel_entering();
	});
	$(".cancel").mouseout(function () {
		$(this).children('img').remove();
		$(this).append("<img src='static/img/cancel.png'>");
	});
	
		
	// когда кнопки нажаты
	$(".key_yellow_button").mousedown(function () {
		$(this).removeClass("key_yellow_button");
		$(this).addClass("key_green_button");
	});
	// кнопка отпущена
	$(".key_yellow_button").mouseup(function () {
		$(this).removeClass("key_green_button");
		$(this).addClass("key_yellow_button");
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
	
	$(".ajaxwait, .ajaxwait_image").hide();
});
</script>
<div class="user_rec_block">
{if $SEARCH_BY_POLICE eq 0}
	<input type="hidden" id="active_field" value="lastname" />
{else}
	<input type="hidden" id="active_field" value="seria" />
{/if}
	<input type="hidden" id="pat_numbers" value="{$PAT_NUMBERS}" />
	<form method="post" name="userdata" id="userdata">
		<table class="user_rec_block_table">
		{if $SEARCH_BY_POLICE eq 0}
			<tr class="selected_tr">
				<td>
					<span>Фамилия:</span>
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" type="text" class="lastname" name="lastname" />
				</td>
			</tr>
			<tr>
				<td>
					<span>Имя:</span>
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" type="text" class="firstname" name="firstname" />
				</td>
			</tr>
			<tr>
				<td>
					<span>Отчество:</span>
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" type="text" class="secondname" name="secondname" />
				</td>
			</tr>
			<tr>
				<td>
					<span>Дата рождения:</span> <!-- сделать маску -->
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" placeholder=" дд.мм.гггг" type="text" class="birthday" id="birthday" name="birthday" />
				</td>
			</tr>
		{elseif $SEARCH_BY_POLICE eq 1}	
			<tr class="selected_tr">
				<td>
					<span>Серия полиса:</span>
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" type="text" class="seria" name="seria" />
				</td>
			</tr>
			<tr>
				<td>
					<span>Номер полиса*:</span>
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" type="text" class="number_police" name="number_police" />
				</td>
			</tr>
			<tr>
				<td>
					<span>Дата рождения*:</span> <!-- сделать маску -->
				</td>
				<td>
					<input onkeydown="return false;" autocomplete="off" placeholder=" дд.мм.гггг" type="text" class="birthday" id="birthday" name="birthday" />
				</td>
			</tr>			
		{/if}			
		</table>
		<input type="hidden" name="dayweek" class="dayweek" value="{$DAYWEEK}" />
		<input type="hidden" name="date_str" class="date_str" value="{$DATE_STR}" />
		<input type="hidden" name="dat"  class="dat" value="{$DAT}" />
		<input type="hidden" name="numbid"  class="numbid" value="{$NUMBID}" />
	</form>
</div>
<div class="keyboard">
	<div class="keyboard_symbols_buttons">
	{include file='keyboard_rus.tpl'}
	</div>
	<div class="keyboard_control_buttons">
		<div class="next_field">
			<img src="static/img/next_field.png">
		</div>
		<div class="not_ready">
			<img src="static/img/not_ready.png">
		</div>
		<div class="cancel">
			<img src="static/img/cancel.png">
		</div>
	</div>
	<div class="backspace">
		<span>стереть</span>
	</div>	
</div>