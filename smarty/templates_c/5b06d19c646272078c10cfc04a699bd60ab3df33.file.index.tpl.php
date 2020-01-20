<?php /* Smarty version Smarty-3.0.8, created on 2014-05-08 16:16:19
         compiled from "smarty/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3434536b7593924e91-59588710%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b06d19c646272078c10cfc04a699bd60ab3df33' => 
    array (
      0 => 'smarty/templates/index.tpl',
      1 => 1382424703,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3434536b7593924e91-59588710',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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
		<span><?php echo $_smarty_tpl->getVariable('INDEX_MES')->value;?>
</span>
	</div>
	<div style="position: absolute; left: 200px; top: 50px; font: normal 18pt Verdana; color: #04375a;">
		<span>Запись через терминал возможна только при наличии амбулаторной карты в регистратуре.</span>
	</div>
	<div class="left_side">
		<img src="static/img/icons/ICON_Home_big.png" />
	</div>
	<div class="right_side" id="right_side">
		<input type="hidden" id="hid_down_bord" value="<?php echo $_smarty_tpl->getVariable('DOWN_BORDER')->value;?>
" />
		<input type="hidden" id="hid_up_bord" value="<?php echo $_smarty_tpl->getVariable('UP_BORDER')->value;?>
" />	
		<ul class="main_menu">
		<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('BUTTONS')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total']);
?>
			<li>
				<div class="yellow_button">
					<span><?php echo $_smarty_tpl->getVariable('BUTTONS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['NAME'];?>
</span>
					<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('BUTTONS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['PAGE_URL'];?>
" />
				</div>
			</li>
		<?php endfor; endif; ?>
		<?php if ($_smarty_tpl->getVariable('MORELESS')->value==1){?>
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
		<?php }?>	
		</ul>
	</div>