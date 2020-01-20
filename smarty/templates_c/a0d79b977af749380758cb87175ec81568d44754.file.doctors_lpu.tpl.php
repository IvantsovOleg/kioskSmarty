<?php /* Smarty version Smarty-3.0.8, created on 2014-05-08 16:22:30
         compiled from "smarty/templates/doctors_lpu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26536b7706481706-35365463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a0d79b977af749380758cb87175ec81568d44754' => 
    array (
      0 => 'smarty/templates/doctors_lpu.tpl',
      1 => 1382424702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26536b7706481706-35365463',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
$(document).ready(function () {
	// функция проверки соответствия размеру надписи и соответственного уменьшения текста
	$(".yellow_button").click(function () {
		$(".ajaxwait, .ajaxwait_image").show();
		var docid = $(this).attr('id');
		var docname = $(this).children("input.docname").val();
		var cab = $(this).children("input.room").val();
		window.location.href = "doctors_lpu.php?docid="+docid+"&docname="+docname+"&cab="+cab;
	});
	
	// выравнивание списка жёлтых кнопок, чтоб не прилипал к верху
	// считаем количество кнопок в списке main_menu
	// если количество ЖК от 1 до 3, то устанавливаем определённые css-свойства
	var count_yb = $(".main_menu .yellow_button").length;
	if (count_yb <= 3 && count_yb > 0)
	{
		var content_height = $(".content").height();
		var menu_ul_height = $(".main_menu").height();
		var diff_height = ((content_height - menu_ul_height)/4).toFixed();
		$(".main_menu").css("position", "relative");
		$(".main_menu").css("top", diff_height+"px");
	}
	
	if (count_yb > 1 && count_yb <= 5)			// от 2х до 5ти
	{
		$(".left_side").before("<input type='hidden' value='docs2_5' id='helper_value'>");	
	}	
	
	if (count_yb == 1)
	{
		$(".left_side").before("<input type='hidden' value='docs1' id='helper_value'>");	
	}
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_docs_down.php",
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
	
	$(".ajaxwait, .ajaxwait_image").hide();
});
</script>
<script type="text/javascript" src="static/js/js_userhelper.js"></script>
	<div class="left_side">
		<img src="static/img/icons/ICON_Door.png" />
	</div>
	<div class="right_side" id="right_side">
		<input type="hidden" id="hid_down_bord" value="<?php echo $_smarty_tpl->getVariable('DOWN_BORDER')->value;?>
" />
		<input type="hidden" id="hid_up_bord" value="<?php echo $_smarty_tpl->getVariable('UP_BORDER')->value;?>
" />	
		<ul class="main_menu">
		<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('DOCS')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<div class="yellow_button" id="<?php echo $_smarty_tpl->getVariable('DOCS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DOCID'];?>
" >
					<span><?php echo $_smarty_tpl->getVariable('DOCS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DOCNAME'];?>
</span>
					<input type="hidden" class="docname" value="<?php echo $_smarty_tpl->getVariable('DOCS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DOCNAME'];?>
" />
					<input type="hidden" class="room" value="<?php echo $_smarty_tpl->getVariable('DOCS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['ROOM'];?>
" />
				</div>
			</li>
		<?php endfor; endif; ?>
		<?php if ($_smarty_tpl->getVariable('MORELESS')->value==1){?>			
			<li>		
				<div class="moreless_up_x"><!-- вверх -->
					<img class="arr_up" src="static/img/buttons/moreless/arrow_less_x.png" />
					<img class="text_up" src="static/img/buttons/moreless/text_up_x.png" />
				</div>
				<div class="moreless_down"><!-- вниз -->
					<img class="arr_down" src="static/img/buttons/moreless/arrow_more.png" />
					<img  style="left: 36px;"  class="text_down" src="static/img/buttons/moreless/text_down.png" />
				</div>
			</li>
		<?php }?>			
		</ul>
	</div>