<script>
$(document).ready(function () {

	$(".helper_for_patient, #confirm").hide();

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
	
	var count_yb = $(".count_numbs_yellow").length;
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
		$.ajax({
			type: "POST",
			url: "ajax_patnums_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord
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
	
});
</script>
					<div id="confirm" style="position: absolute; background: #fdf7ec; border: solid 3px #912813; width: 600px; height: 300px; z-index: 700; left: 300px; top: 100px; ">
						<span style="position: relative; top: 50px; left: 40px; ">Вы уверены, что хотите отменить номерок?</span>
						<br />
						<input type="button" value="Да" class="confirm_yes" />
						<input type="button" class="confirm_no" value="Нет" />
					</div>
<div class="numbers" id="numbers">
{if $PAT_ERRORMES != 1}
	<span class="docname_num">{$smarty.session.PATIENT_INFO}</span>
	<br />
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
{else}
	<span>Пациент не найден в базе. Проверьте правильность введенных данных!</span>
	<br />
	<br />
	<div class="hback pat_n">
		<img src="static/img/buttons/01_Arrow.png" class="hback_img_ar" />
		<img src="static/img/buttons/01_Back.png" class="hback_img_b" />
	</div>
{/if}	
</div>