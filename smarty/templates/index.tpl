<script type="text/javascript">
	// jsPrintSetup.setSilentPrint(true);
	// jsPrintSetup.setShowPrintProgress(false);
</script>	
<script>
$(document).ready(function () {
	$(".helper_for_patient").hide();
	//$(".print_b div").load("print_a5_2.html");
	
	//setTimeout(function () {
	//	$(".print_b").print();	
	//}, 3000); 

	$("#sch").click(function () {
		window.location.href='speciality.php?mode=2';
	});
	// alert("Разрешение вашего экрана: "+ screen.width + "x" + screen.height)

	// выравнивание списка жёлтых кнопок, чтоб не прилипал к верху
	var count_yb = $(".main_menu .yellow_button").length;
	if (count_yb <= 3 && count_yb > 0)
	{
		var content_height = $(".content").height();
		var menu_ul_height = $(".main_menu").height();
		var diff_height = ((content_height - menu_ul_height)/4).toFixed();
		$(".main_menu").css("position", "relative");
		$(".main_menu").css("top", diff_height+"px");
	}
	
	// для каждого!
	$(".yellow_button").each(function (i) {
		var span = $(this).children('span').height();
		var span_w = $(this).children('span').width();
		var pt = 30;
		while (span > 71 || span_w > 450)
		{
			pt -= 1;
			// изменить шрифт в спане
			$(this).css("font-size", pt+"pt");
			 $(this).children('span').css("top", "15px");
		}		
	});
	
	// mousedown, mouseout и mouseup
	$(".yellow_button").mouseup(function () {
		$(".ajaxwait, .ajaxwait_image").show();
		$(this).removeClass("yellow_button_press");
		$(this).addClass("yellow_button");
		
		// переход по ссылке
		var hb = $(this).children("input[type='hidden']").val();
		window.location.href = hb;		
		//$(".ajaxwait, .ajaxwait_image").hide();
	});
	$(".yellow_button").mousedown(function () {
		$(this).removeClass("yellow_button");
		$(this).addClass("yellow_button_press");
	});
	$(".yellow_button").mouseout(function () {
		$(this).removeClass("yellow_button_press");
		$(this).addClass("yellow_button");
	});
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_index_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord
			},
			success: function(html) {
				$("#right_side").children().remove();
				$("#right_side").append(html);
			}
		});	
	}
		
	// нажатие кнопок
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
	
		$(".ajaxwait, .ajaxwait_image").hide();
});
</script>
	<div class="print_b">
		<div></div>
	</div>	
	<div style="position: absolute; left: 100px; top: 600px; font: normal 18pt Verdana; color: #04375a;">
		<span>{$INDEX_MES}</span>
	</div>
	<div style="position: absolute; left: 200px; top: 50px; font: normal 18pt Verdana; color: #04375a;">
		<span>Запись через терминал возможна только при наличии амбулаторной карты в регистратуре.</span>
	</div>
	<div class="left_side">
		<img src="static/img/icons/ICON_Home_big.png" />
	</div>
	<div class="right_side" id="right_side">
		<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
		<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />	
		<ul class="main_menu">
		{section loop=$BUTTONS name=row}
			<li>
				<div class="yellow_button">
					<span>{$BUTTONS[row].NAME}</span>
					<input type="hidden" value="{$BUTTONS[row].PAGE_URL}" />
				</div>
			</li>
		{/section}
		{if $MORELESS eq 1}
			<li>
				<div class="moreless_up_x" id="ml_up"><!-- вверх -->
					<img class="arr_up" src="static/img/buttons/moreless/arrow_less_x.png" />
					<img style="left: 36px;" class="text_up" src="static/img/buttons/moreless/text_up_x.png" />
				</div>
				<div class="moreless_down" id="ml_down"><!-- вниз -->
					<img class="arr_down" src="static/img/buttons/moreless/arrow_more.png" />
					<img style="left: 36px;"  class="text_down" src="static/img/buttons/moreless/text_down.png" />
				</div>
			</li>
		{/if}	
		</ul>
	</div>