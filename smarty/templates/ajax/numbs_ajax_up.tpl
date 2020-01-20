<script type="text/javascript" src="static/js/js.js"></script>
<script>
$(document).ready(function () {
	// функция проверки соответствия размеру надписи и соответственного уменьшения текста
	function send_count_numbers(specid, docid, date_str, dayweek, strdat, range, survid)
	{
		window.location.href = "numbers_free_time.php?specid="+specid+"&docid="+docid+"&date_str="+date_str+"&dayweek="+dayweek+"&strdat="+strdat+"&range="+range+"&survid="+survid;
	}
	
	$(".count_numbs_yellow").click(function () {
		var specid = $(this).children("#specid").val();
		var docid = $(this).children("#docid").val();
		var date_str = $(this).children("#date_str").val();
		var dayweek = $(this).children("#dayweek").val();
		var strdat = $(this).children("#strdat").val();
		var range = $(this).children("#range").val();
		var survid = $("#hid_surv").val();
		
		send_count_numbers(specid, docid, date_str, dayweek, strdat, range, survid);
	});
	
	// для каждого!
	$(".yellow_button").each(function (i) {
		var span = $(this).children('span').height();
		if (span > 71)
		{
			// изменить шрифт в спане
			$(this).css("font-size", "20pt");
			 $(this).children('span').css("top", "15px");
		}		
	});
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var hid_dat = $("#hid_dat").val();
		var hid_surv = $("#hid_surv").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_numbs_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord,
				hid_dat: hid_dat,
				hid_surv: hid_surv
			},
			success: function(html) {
				$("#numbers").children(".numbers_free_time, .hidden_borders, .scroll_arrows").remove();
				$("#numbers").append(html);
			}
		});	
	}
	
	function click_less()
	{
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var hid_dat = $("#hid_dat").val();
		var hid_surv = $("#hid_surv").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_numbs_up.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord,
				hid_dat: hid_dat,
				hid_surv: hid_surv
			},
			success: function(html) {
				$("#numbers").children(".numbers_free_time, .hidden_borders, .scroll_arrows").remove();
				$("#numbers").append(html);
			}
		});	
	}
	
	// нажатие кнопок
	// вверх
	$(".scroll_arrow_up").mouseup(function () {
		$(this).removeClass("scroll_arrow_up_in");
		$(this).addClass("scroll_arrow_up");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less.png' class='arr_up' />");
		click_less();
	});
	$(".scroll_arrow_up").mousedown(function () {
		$(this).removeClass("scroll_arrow_up");
		$(this).addClass("scroll_arrow_up_in");
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less_in.png' class='arr_up_in' />");
	});
	$(".scroll_arrow_up").mouseout(function () {
		$(this).removeClass("scroll_arrow_up_in");
		$(this).addClass("scroll_arrow_up");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less.png' class='arr_up' />");
	});	
	
	// вниз
	$(".scroll_arrow_down").mouseup(function () {
		$(this).removeClass("scroll_arrow_down_in");
		$(this).addClass("scroll_arrow_down");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more.png' class='arr_down' />");
		click_more();
	});
	$(".scroll_arrow_down").mousedown(function () {
		$(this).removeClass("scroll_arrow_down");
		$(this).addClass("scroll_arrow_down_in");
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more_in.png' class='arr_down_in' />");
	});
	$(".scroll_arrow_down").mouseout(function () {
		$(this).removeClass("scroll_arrow_down_in");
		$(this).addClass("scroll_arrow_down");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more.png' class='arr_down' />");
	});	
});
</script>
	{section name=row loop=$DATA}
	<table class="numbers_free_time">
		<tr>
			<td>
				<span class="nums_datastr">{$DATA[row].DATE_STR},</span>
				<span class="nums_dayweek">{$DATA[row].DAYWEEK}</span>
				<br />
				<span class="nums_range">{$DATA[row].RANGE}</span>
			</td>
			<td>
				<div class="count_numbs_yellow">
					<span>{$DATA[row].COUNT_FULL}</span>
					<input type="hidden" id="specid" value="{$smarty.session.SPECID}" />
					<input type="hidden" id="docid" value="{$DOCID}" />
					<input type="hidden" id="date_str" value="{$DATA[row].DATE_STR}" />
					<input type="hidden" id="dayweek" value="{$DATA[row].DAYWEEK}" />
					<input type="hidden" id="strdat" value="{$DATA[row].STRDAT}" />
					<input type="hidden" id="range" value="{$DATA[row].RANGE}" />
				</div>
			</td>
		</tr>
	</table>
	{/section}
	<div class="hidden_borders">
		<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
		<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />
		<input type="hidden" id="hid_dat" value="{$DAT}" />
		<input type="hidden" id="hid_surv" value="{$SURVID}" />
	</div>
	<div style="clear: both; "></div>
	<div class="scroll_arrows">
	{if $UP eq 1}		
		<div class="scroll_arrow_up">
			<img src="static/img/buttons/moreless/arrow_less.png" />
		</div>
	{/if}
	{if $UP_X eq 1}
		<div class="scroll_arrow_up_x">
			<img src="static/img/buttons/moreless/arrow_less_x.png" />
		</div>
	{/if}	
		<div class="scroll_arrow_down">
			<img src="static/img/buttons/moreless/arrow_more.png" />
		</div>
	</div>