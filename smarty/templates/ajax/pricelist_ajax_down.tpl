<script>
$(document).ready(function () {
	// функция обрезки тире и замены css-свойств span'а
	$(".li_tabs").each(function (i) {
		var text1 = $(this).children("span").text();
		if (text1.match(/^([-]+)/))
		{
			// строки с тире
			var new_text = text1.substring(1, text1.length);
			$(this).children("span").text(new_text);
			$(this).children("span").css("left", "100px");
		}
		else 
		{
			$(this).children('span').css("font-size", "30pt");
			$(this).children('span').css("top", "10px");
		}
	});
	// для каждого!
	$(".mainsection_price, .li_tabs").each(function (i) {
		var span = $(this).children('span').height();
		var span_w = $(this).children('span').width();
		var pt = 30;
		while (span > 71 || span_w > 680)
		{
			pt -= 1;
			// изменить шрифт в спане
			$(this).css("font-size", pt+"pt");
			$(this).children('span').css("top", "15px");
			var span = $(this).children('span').height();
			var span_w = $(this).children('span').width();			
		}		
	});	
	// функция показа услуг по keyid подраздела
	function subsection_service(keyid1, text1)
	{
		window.location.href = "pricelist_service.php?keyid1="+keyid1+"&text1="+text1;
	}
	
	$(".li_tabs").mouseup(function () {
		$(this).removeClass('li_tabs_in');
		$(this).addClass('li_tabs');		
	});
	$(".li_tabs").mousedown(function () {
		$(this).removeClass('li_tabs');
		$(this).addClass('li_tabs_in');	
	});
	$(".li_tabs").mouseout(function () {
		$(this).removeClass('li_tabs_in');
		$(this).addClass('li_tabs');		
	});		
	
		// ajax-функция, вниз
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var hid_keyid1 = $("#hid_keyid1").val();
		
		$.ajax({
			type: "POST",
			url: "ajax/ajax_pricelist_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord,
				hid_keyid1: hid_keyid1
			},
			success: function(html) {
				$("#prices").children().remove();
				$("#prices").append(html);
			}
		});	
	}
	
	// ajax-функция, вверх
	function click_less()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var hid_keyid1 = $("#hid_keyid1").val();
		
		$.ajax({
			type: "POST",
			url: "ajax/ajax_pricelist_up.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord,
				hid_keyid1: hid_keyid1
			},
			success: function(html) {
				$("#prices").children().remove();
				$("#prices").append(html);
			}
		});	
	}
	
	
	// mouse, для кнопок разделов и подразделов
	$(".mainsection_price, .li_tabs").mousedown(function () {
		var keyid1 = $(this).children("input[type='hidden']").val();
		var text1 = $(this).children("span").text();
		subsection_service(keyid1, text1);
	});
	
	// mouse, для кнопок управления - стрелок
	// кнопки вниз
	$(".scroll_arrow_down").mouseup(function () {
		$(this).removeClass("scroll_arrow_down_in");
		$(this).addClass("scroll_arrow_down");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more.png' class='arr_down' />");
	});
	$(".scroll_arrow_down").mousedown(function () {
		$(this).removeClass("scroll_arrow_down");
		$(this).addClass("scroll_arrow_down_in");
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more_in.png' class='arr_down_in' />");
		click_more();
	});
	$(".scroll_arrow_down").mouseout(function () {
		$(this).removeClass("scroll_arrow_down_in");
		$(this).addClass("scroll_arrow_down");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_more.png' class='arr_down' />");
	});		
	
	// кнопки вверх
	$(".scroll_arrow_up").mouseup(function () {
		$(this).removeClass("scroll_arrow_up_in");
		$(this).addClass("scroll_arrow_up");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less.png' class='arr_up' />");
	});
	$(".scroll_arrow_up").mousedown(function () {
		$(this).removeClass("scroll_arrow_up");
		$(this).addClass("scroll_arrow_up_in");
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less_in.png' class='arr_up_in' />");
		click_less();
	});
	$(".scroll_arrow_up").mouseout(function () {
		$(this).removeClass("scroll_arrow_up_in");
		$(this).addClass("scroll_arrow_up");	
		// сменить картинки
		$(this).children('img').remove();
		$(this).append("<img src='static/img/buttons/moreless/arrow_less.png' class='arr_up' />");
	});		
});
</script>
<div class="hidden_borders">
	<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
	<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />	
</div>
<div class="price_block">
	<ul style="list-style: none;">
	{section loop=$DATA name=datarow}
		<li>
			<div class="li_tabs">
				<span>{$DATA[datarow].TEXT1}</span>
				<input type="hidden" value="{$DATA[datarow].KEYID1}">
			</div>
		</li>
	{/section}
	</ul>
</div>
<div style="height: 700px;" class="scroll_arrows">
	<div class="scroll_arrow_up">
		<img src="static/img/buttons/moreless/arrow_less.png" />
	</div>
{if $DOWN eq 1}
	<div class="scroll_arrow_down">
		<img src="static/img/buttons/moreless/arrow_more.png" />
	</div>
{elseif $DOWN_X eq 1}
	<div class="scroll_arrow_down_x">
		<img src="static/img/buttons/moreless/arrow_more_x.png" />
	</div>	
{/if}
</div>