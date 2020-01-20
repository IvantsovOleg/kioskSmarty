<script>
$(document).ready(function () {
	$(".li_tabs").click(function () {
		var survid = $(this).children("input[type='hidden']").val();
		var docname = $("#docname").val();
		var docid = $("#docid").val();		
		window.location.href = "doctors_lpu.php?docid="+docid+"&docname="+docname+"&survid="+survid;
	});
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_survs_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord
			},
			success: function(html) {
				$("#numbers").children("table, .hidden_borders, .scroll_arrows").remove();
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
		var docname = $("#docname").val();
		var docid = $("#docid").val();
		window.location.href = "doctors_lpu.php?docid="+docid+"&docname="+docname
	});
	
});
</script>
<div class="numbers" id="numbers">
	<input type="hidden" id="docid" value="{$smarty.session.DOCID}" />
	<input type="hidden" id="docname" value="{$smarty.session.DOCNAME}" />
	<span class="docname_num">{$smarty.session.DOCNAME}</span>
	<br />
	<span class="specname_num">{$smarty.session.SPECNAME}</span>
	<div class="surv_menu">
		<div class="white">
			<span>Первичные номерки</span>
		</div>
		<div class="grey">
			<span>Вид исследований</span>
		</div>
	</div>
	{section name=row loop=$DATA}
	<table style="position: relative; top: 50px; left: 10px;">
		<tr>
			<td>
			</td>
				<div class="li_tabs" style="top: 70px; text-align: center;">
					<span style="font-size: 30px; top: 15px;">{$DATA[row].TEXT}</span>
					<input type="hidden" value="{$DATA[row].RES_ID}" />
				</div>
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
</div>