<script>
$(document).ready(function () {
	$(".servs").css("font-size", "30pt");

	// функция проверки соответствия размеру надписи и соответственного уменьшения текста
	$(".yellow_button").click(function () {
		var servid = $(this).attr('id');
		window.location.href = "doctors_lpu.php?servid="+servid;	
	});
	
	// для каждого!
	$(".yellow_button").each(function (i) {
		var span = $(this).children('span').height();
		var span_w = $(this).children('span').width();
		var pt = 30;
		while (span > 51 || span_w > 700)
		{
			pt -= 1;
			// изменить шрифт в спане
			$(this).css("font-size", pt+"pt");
			$(this).children('span').css("top", "15px");
			var span = $(this).children('span').height();
			var span_w = $(this).children('span').width();			
		}	
	});
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_docservices_down.php",
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
	
	function click_less()
	{
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_docservices_up.php",
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
		click_less();		
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
});
</script>
<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />
<ul class="main_menu">
		{section name=row loop=$DOCSERVICES}
			<li>	
				<div class="yellow_button servs" id="{$DOCSERVICES[row].SRVDEP_ID}" >
					<span>{$DOCSERVICES[row].TEXT}</span>
					<input type="hidden" value="{$DOCSERVICES[row].TEXT}" />
				</div>
			</li>
		{/section}
	<li>
	{if $UP eq 1}
		<div class="moreless_up" id="ml_up"><!-- вверх -->
			<img class="arr_up" src="static/img/buttons/moreless/arrow_less.png" />
			<img style="left: 36px;" class="text_up" src="static/img/buttons/moreless/text_up.png" />
		</div>
	{elseif $UP_X eq 1}	
		<div class="moreless_up_x" id="ml_down"><!-- вниз -->
			<img class="arr_up" src="static/img/buttons/moreless/arrow_less_x.png" />
			<img style="left: 36px;"  class="text_down" src="static/img/buttons/moreless/text_up_x.png" />
		</div>
	{/if}
		<div class="moreless_down" id="ml_down"><!-- вниз -->
			<img class="arr_down" src="static/img/buttons/moreless/arrow_more.png" />
			<img style="left: 36px;"  class="text_down" src="static/img/buttons/moreless/text_down.png" />
		</div>
	</li>
</ul>