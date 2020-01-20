<script type="text/javascript" src="static/js/popup.js"></script>
<script>
$(document).ready(function () {
	// для каждого!
	$(".mainsection_price, .li_tabs").each(function (i) {
		var span = $(this).children('span').height();
		var span_w = $(this).children('span').width();
		var pt = 30;
		while (span > 71 || span_w > 700)
		{
			pt -= 1;
			// изменить шрифт в спане
			$(this).css("font-size", pt+"pt");
			$(this).children('span').css("top", "15px");
			var span = $(this).children('span').height();
			var span_w = $(this).children('span').width();			
		}		
	});
	// тут будет функция для чередования фона строк
	$(".services_list tr").each(function (i) {
		if (i % 2 == 0)
		{
			$(this).css("background", "white");
		}
	});

	$(".helper_for_patient").hide();	
	var count_yb = $(".li_tabs").length;
	if (count_yb == 0)
	{
		
		$("#right_side").append("<br><br><br><span class='specname_num'>Услуг нет.</span>");
		
	}
	
	// для переключения и изменения шрифта при длинном названии услуги
	$(".service_name").each(function (i) {
		var span = $(this).height();
		var span_w = $(this).width();
		var pt = 20;
		while (span > 32 || span_w > 700)
		{
			pt -= 2;
			$(this).css("font-size", pt+"pt");
			var span = $(this).height();
			var span_w = $(this).width();			
		}
	});
	
	// ajax-функция
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var hid_keyid1 = $("#hid_keyid1").val();
		
		$.ajax({
			type: "POST",
			url: "ajax/ajax_serv_down.php",
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
	
	// кнопки
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
});
</script>
{if $EMPTY == 'YES'}
<div>
	<span>Услуг по разделу не найдено.</span>
</div>
{else}
<div class="prices" id="prices">
	<div class="hidden_borders">
		<input type="hidden" id="hid_down_bord" value="{$DOWN_BORDER}" />
		<input type="hidden" id="hid_up_bord" value="{$UP_BORDER}" />	
		<input type="hidden" id="hid_keyid1" value="{$KEYID1}">
	</div>
	<table class="services_list">
	{section loop=$DATA name=row}
		<tr>
			<td>
				<span class="service_name">{$DATA[row].TEXT}</span>
				<input type="hidden" class="data_fulltext" value="{$DATA[row].FULLTEXT}" />
				<input type="hidden" class="data_keyid" value="{$DATA[row].KEYID}" />
				<input type="hidden" class="data_price" value="{$DATA[row].PRICE}" />
			</td>
			<td>
				<span class="service_price">{if $DATA[row].PRICE == ''} 0 {else} {$DATA[row].PRICE} {/if} р.</span>
			</td>
		</tr>
	{/section}
	</table>
	<span class="service_name" style="position: relative; top: 100px; color: #6e0e29;" >Нажмите на услугу для просмотра полного названия.</span>
{if $MORELESS eq 1}	
	<div class="scroll_arrows">
		<div class="scroll_arrow_up_x">
			<img src="static/img/buttons/moreless/arrow_less_x.png" />
		</div>
		<div class="scroll_arrow_down">
			<img src="static/img/buttons/moreless/arrow_more.png" />
		</div>
	</div>
{else}
	<div class="scroll_arrows">
		<div class="scroll_arrow_up_x">
			<img src="static/img/buttons/moreless/arrow_less_x.png" />
		</div>
		<div class="scroll_arrow_down_x">
			<img src="static/img/buttons/moreless/arrow_more_x.png" />
		</div>
	</div>
{/if}	
</div>
{/if}
<div id="popupContact">
	<img class="close_modal" src="static/img/close_modal.png" />
	<div style="clear: both; "></div>
	<div id="name_service">
		<span></span>
	</div>
	<div id="price_service">
		<span></span>
	</div>	
	<div id="cond_service">
		<span></span>
	</div>
</div>
<div id="backgroundPopup"></div>
<div id="for_ajax"></div>