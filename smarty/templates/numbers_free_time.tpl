<script>
$(document).ready(function () {
	function send_numb(numbid, dat, dayweek, date_str)
	{
		window.location.href = "userdata.php?numbid="+numbid+"&dat="+dat+"&dayweek="+dayweek+"&date_str="+date_str;
	}
	
	// нажатие кнопок ВВЕРХ и ВНИЗ hid_surv
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var survid = $("#hid_surv").val();
		var hid_dat = $("#hid_dat").val();
		var dayweek = $("#dayweek").val();
		var date_str = $("#date_str").val();
		
		$.ajax({
			type: "POST",
			url: "ajax_numbtime_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord,
				survid: survid,
				hid_dat: hid_dat,
				dayweek: dayweek,
				date_str: date_str
			},
			success: function(html) {
				$(".free_times_list").children().remove();
				$(".free_times_list").append(html);
			}
		});	
	}
	
	// вверх
	$(".moreless_up").mouseup(function () {
		$(this).removeClass("moreless_up_in");
		$(this).addClass("moreless_up");
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less.png' class='arr_up' />");
		$(this).append("<img src='static/img/buttons/moreless/text_up.png' class='text_up' />");
	});
	$(".moreless_up").mousedown(function () {
		$(this).removeClass("moreless_up");
		$(this).addClass("moreless_up_in");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less_in.png' class='arr_up_in' />");
		$(this).append("<img src='static/img/buttons/moreless/text_up_in.png' class='text_up_in' />");		
	});
	$(".moreless_up").mouseout(function () {
		$(this).removeClass("moreless_up_in");
		$(this).addClass("moreless_up");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less.png' class='arr_up' />");
		$(this).append("<img src='static/img/buttons/moreless/text_up.png' class='text_up' />");		
	});
	// вниз
	$(".moreless_down").mouseup(function () {
		$(this).removeClass("moreless_down_in");
		$(this).addClass("moreless_down");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more.png' class='arr_down' />");
		$(this).append("<img src='static/img/buttons/moreless/text_down.png' class='text_down' />");	
		click_more();		
	});
	$(".moreless_down").mousedown(function () {
		$(this).removeClass("moreless_down");
		$(this).addClass("moreless_down_in");
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more_in.png' class='arr_down_in' />");
		$(this).append("<img src='static/img/buttons/moreless/text_down_in.png' class='text_down_in' />");		
	});
	$(".moreless_down").mouseout(function () {
		$(this).removeClass("moreless_down_in");
		$(this).addClass("moreless_down");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more.png' class='arr_down' />");
		$(this).append("<img src='static/img/buttons/moreless/text_down.png' class='text_down' />");
	});
	
	// ------
	
	$(".times_numbs_yellow").click(function () {
		$(".ajaxwait, .ajaxwait_image").show();
		var numbid = $(this).children("#numbid").val();
		var dat = $(this).children("#dat").val();
		var dayweek = $(this).children("#dayweek").val();
		var date_str = $(this).children("#date_str").val();	
		send_numb(numbid, dat, dayweek, date_str);
	});
	
	$(".times_numbs_yellow").mouseup(function () {
		$(this).removeClass("times_numbs_yellow");
		$(this).addClass("times_numbs_yellow");
	});
	$(".times_numbs_yellow").mousedown(function () {
		$(this).removeClass("times_numbs_yellow");
		$(this).addClass("times_numbs_green");		
	});
	$(".times_numbs_yellow").mouseout(function () {
		$(this).removeClass("times_numbs_green");
		$(this).addClass("times_numbs_yellow");	
	});	
	
	$(".ajaxwait, .ajaxwait_image").hide();
});
</script>
<input type="hidden" value="times" id="helper_value">
<script type="text/javascript" src="static/js/js_userhelper.js"></script>
<div class="numbers" id="numtimes">
	<span class="docname_num">{$DOCNAME}</span>
	<br />
	<span class="specname_num">{$SPECNAME}</span>
	<br />
	{if $ROOM != ''}
	<span style="font-size: 14pt;" class="specname_num">{$ROOM} кабинет</span>
	{/if}
	<table class="numbers_freetime_list">
		<tr>
			<td>
				<span class="nums_datastr">{$DATE_STR},</span>
				<span class="nums_dayweek">{$DAYWEEK}</span>						
			</td>
			<td>
				<span class="nums_range">{$RANGE}</span>
			</td>
		</tr>
	</table>
	<div class="free_times_list">
		{section loop=$NUMBS name=row}
		<div class="times_numbs_yellow">
			<span>{$NUMBS[row].dat}</span>
			<input type="hidden" id="numbid" value="{$NUMBS[row].numbid}" />
			<input type="hidden" id="dat" value="{$NUMBS[row].dat}" />
			<input type="hidden" id="room" value="{$NUMBS[row].room}" />
			<input type="hidden" id="dayweek" value="{$DAYWEEK}" />
			<input type="hidden" id="date_str" value="{$DATE_STR}" />
		</div>
		{/section}
		<div class="hidden_borders">
			<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
			<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />
			<input type="hidden" id="hid_surv" value="{$SURVID}" />
			<input type="hidden" id="hid_dat" value="{$DAT}" />
		</div>
		{if $MORELESS eq 1}
		<div style="position: relative; top: 20px; left: 15px;">
				<div class="moreless_up_x" id="ml_up"><!-- вверх -->
					<img class="arr_up" src="static/img/buttons/moreless/arrow_less_x.png" />
					<img style="left: 36px;" class="text_up" src="static/img/buttons/moreless/text_up_x.png" />
				</div>
				<div class="moreless_down" id="ml_down"><!-- вниз -->
					<img class="arr_down" src="static/img/buttons/moreless/arrow_more.png" />
					<img style="left: 36px;"  class="text_down" src="static/img/buttons/moreless/text_down.png" />
				</div>
		</div>
		{/if}			
	</div>
</div>