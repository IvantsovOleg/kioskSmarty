<script type="text/javascript" src="static/js/js.js"></script>
<script>
$(document).ready(function () {

	$(".count_numbs_yellow").click(function () {	
		var numbid = $(this).children("input[type='hidden']").val();
		$("#confirm").show();
		$("#confirm").addClass(numbid);
	});
	
	$(".confirm_no").click(function () {
		var numbid = $(this).children("input[type='hidden']").val();
		$(this).parent().removeClass(numbid);
		$("#confirm").hide();
	});
	
	$(".confirm_yes").click(function () {		// по нажатию кнопки "отменить номерок"
		var numbid = $(this).parent().attr("class");
		$(this).parent().removeClass(numbid);
		$("#confirm").hide();
		$.ajax({
			type: "POST",
			url: "ajax_del_numbs.php",
			data: {
				numbid: numbid
			},
			success: function(html) {
				$(".numbers_free_time tr."+numbid).find("span, input, br, .count_numbs_yellow").remove();
				$(".numbers_free_time tr."+numbid).children().append(html);
				$(".numbers_free_time tr."+numbid).css("background", "#f6bdb2");
				$(".numbers_free_time tr."+numbid).children("td:first").append("<span style='color: #652912; font: bold 20pt Calibri; margin: 10px; '>Номерок отменён.</span>");
			}
		});			
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
			url: "ajax_patnums_down.php",
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
			url: "ajax_patnums_up.php",
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
		<tr class="{$DATA[row].KEYID}">
			<td>
				<span class="nums_datastr">{$DATA[row].DAT},</span>
				<span class="nums_dayweek">{$DATA[row].TIME}</span>
				<br />
				<span class="nums_range">{$DATA[row].SPECNAME},</span>
				<span class="nums_dayweek">{$DATA[row].DOCNAME}</span>
			</td>
			<td>
				<div class="count_numbs_yellow">
					<span>отменить</span>
					<input type="hidden" id="specid" value="{$DATA[row].KEYID}" />
				</div>
			</td>
		</tr>
	</table>
	{/section}
	<div class="hidden_borders">
		<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
		<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />
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