<script type="text/javascript" src="static/js/js.js"></script>
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
	
	function click_less()
	{
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_surves_up.php",
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
	<input type="hidden" id="docid" value="{$smarty.session.DOCID}" />
	<input type="hidden" id="docname" value="{$smarty.session.DOCNAME}" />
	{section name=row loop=$DATA}
	<table style="position: relative; top: 50px; left: 10px;">
		<tr>
			<td>
				<div class="li_tabs">
					<span style="font-size: 40px; top: 7px;">{$DATA[row].TEXT}</span>
					<input type="hidden" value="{$DATA[row].RES_ID}" />
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