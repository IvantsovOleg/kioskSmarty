<script>
$(document).ready(function () {
	function send_count_numbers(specid, docid, date_str, dayweek, strdat, range, survid, room)
	{
		window.location.href = "numbers_free_time.php?specid="+specid+"&docid="+docid+"&date_str="+date_str+"&dayweek="+dayweek+"&strdat="+strdat+"&range="+range+"&survid="+survid+"&room="+room;
	}
	
	$(".count_numbs_yellow").click(function () {
		$(".ajaxwait, .ajaxwait_image").show();
		var specid = $(this).children("#specid").val();
		var docid = $(this).children("#docid").val();
		var date_str = $(this).children("#date_str").val();
		var dayweek = $(this).children("#dayweek").val();
		var strdat = $(this).children("#strdat").val();
		var range = $(this).children("#range").val();
		var survid = $("#hid_surv").val();
		var room = $("#room").val();
		
		send_count_numbers(specid, docid, date_str, dayweek, strdat, range, survid, room);
	});
	
	var count_yb = $(".count_numbs_yellow").length;
	if (count_yb == 1)
	{
		$(".numbers_free_time").before("<input type='hidden' value='days1' id='helper_value'>");	
	}
	if (count_yb > 1)
	{
		$(".numbers_free_time").before("<input type='hidden' value='days2_5' id='helper_value'>");	
	}
	if (count_yb == 0)
	{
		$(".numbers_free_time").before("<input type='hidden' value='' id='helper_value'>");	
		$(".helper_for_patient").hide();
		$("#numbers").append("<br><br><br><span class='specname_num'>Номерков нет.</span>");
	}	
	
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
	
	// кнопки фильтрации
	$(".white").click(function () {
		window.location.href = "doctors_surves.php"
	});
});

$(".ajaxwait, .ajaxwait_image").hide();
</script>
<script type="text/javascript" src="static/js/js_userhelper.js"></script>
<div class="numbers" id="numbers">
	<span class="docname_num">{$DOCNAME}</span>
	<br />
	<span class="specname_num">{$smarty.session.SPECNAME}</span>
	{if $SUR == 1}
	<div class="surv_menu">
		<div class="grey">
			<span>Первичные номерки</span>
		</div>
		<div class="white">
			<span>Вид исследований</span>
		</div>
	</div>
	{/if}
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
					<input type="hidden" id="docid" value="{$smarty.session.DOCID}" />
					<input type="hidden" id="date_str" value="{$DATA[row].DATE_STR}" />
					<input type="hidden" id="dayweek" value="{$DATA[row].DAYWEEK}" />
					<input type="hidden" id="strdat" value="{$DATA[row].STRDAT}" />
					<input type="hidden" id="range" value="{$DATA[row].RANGE}" />
					<input type="hidden" id="room" value="{$DATA[row].ROOM}" />
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
	<div class="scroll_arrows">
	{if $MORELESS eq 1}
		<div class="scroll_arrow_up_x">
			<img src="static/img/buttons/moreless/arrow_less_x.png" />
		</div>
		<div class="scroll_arrow_down">
			<img src="static/img/buttons/moreless/arrow_more.png" />
		</div>
	{elseif $MORELESS eq 0}
		<div class="scroll_arrow_up_x">
			<img src="static/img/buttons/moreless/arrow_less_x.png" />
		</div>
		<div class="scroll_arrow_down_x">
			<img src="static/img/buttons/moreless/arrow_more_x.png" />
		</div>
	{/if}	
	</div>	
</div>