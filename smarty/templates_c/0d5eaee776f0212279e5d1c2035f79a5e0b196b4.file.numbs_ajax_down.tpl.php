<?php /* Smarty version Smarty-3.0.8, created on 2014-05-13 09:33:31
         compiled from "../smarty/templates/ajax/numbs_ajax_down.tpl" */ ?>
<?php /*%%SmartyHeaderCode:208615371aeabd1b389-86168192%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d5eaee776f0212279e5d1c2035f79a5e0b196b4' => 
    array (
      0 => '../smarty/templates/ajax/numbs_ajax_down.tpl',
      1 => 1382424702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '208615371aeabd1b389-86168192',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="static/js/js.js"></script>
<script>
$(document).ready(function () {
	// функция проверки соответствия размеру надписи и соответственного уменьшения текста
	function send_count_numbers(specid, docid, date_str, dayweek, strdat, range, survid)
	{
		window.location.href = "numbers_free_time.php?specid="+specid+"&docid="+docid+"&date_str="+date_str+"&dayweek="+dayweek+"&strdat="+strdat+"&range="+range+"&survid="+survid;
	}
	
	$(".count_numbs_yellow").click(function () {
		var specid = $(this).children("#specid").val();
		var docid = $(this).children("#docid").val();
		var date_str = $(this).children("#date_str").val();
		var dayweek = $(this).children("#dayweek").val();
		var strdat = $(this).children("#strdat").val();
		var range = $(this).children("#range").val();
		var survid = $("#hid_surv").val();
		
		send_count_numbers(specid, docid, date_str, dayweek, strdat, range, survid);
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
			url: "ajax/ajax_numbs_down.php",
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
			url: "ajax/ajax_numbs_up.php",
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
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('DATA')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<table class="numbers_free_time">
		<tr>
			<td>
				<span class="nums_datastr"><?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DATE_STR'];?>
,</span>
				<span class="nums_dayweek"><?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DAYWEEK'];?>
</span>
				<br />
				<span class="nums_range"><?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['RANGE'];?>
</span>
			</td>
			<td>
				<div class="count_numbs_yellow">
					<span><?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['COUNT_FULL'];?>
</span>
					<input type="hidden" id="specid" value="<?php echo $_SESSION['SPECID'];?>
" />
					<input type="hidden" id="docid" value="<?php echo $_smarty_tpl->getVariable('DOCID')->value;?>
" />
					<input type="hidden" id="date_str" value="<?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DATE_STR'];?>
" />
					<input type="hidden" id="dayweek" value="<?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['DAYWEEK'];?>
" />
					<input type="hidden" id="strdat" value="<?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['STRDAT'];?>
" />
					<input type="hidden" id="range" value="<?php echo $_smarty_tpl->getVariable('DATA')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['RANGE'];?>
" />
				</div>
			</td>
		</tr>
	</table>
	<?php endfor; endif; ?>
	<div class="hidden_borders">
		<input type="hidden" id="hid_down_bord" value="<?php echo $_smarty_tpl->getVariable('DOWN_BORDER')->value;?>
" />
		<input type="hidden" id="hid_up_bord" value="<?php echo $_smarty_tpl->getVariable('UP_BORDER')->value;?>
" />
		<input type="hidden" id="hid_dat" value="<?php echo $_smarty_tpl->getVariable('DAT')->value;?>
" />
		<input type="hidden" id="hid_surv" value="<?php echo $_smarty_tpl->getVariable('SURVID')->value;?>
" />
	</div>
	<div style="clear: both; "></div>
	<div class="scroll_arrows">
		<div class="scroll_arrow_up">
			<img src="static/img/buttons/moreless/arrow_less.png" />
		</div>
	<?php if ($_smarty_tpl->getVariable('DOWN')->value==1){?>		
		<div class="scroll_arrow_down">
			<img src="static/img/buttons/moreless/arrow_more.png" />
		</div>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('DOWN_X')->value==1){?>
		<div class="scroll_arrow_down_x">
			<img src="static/img/buttons/moreless/arrow_more_x.png" />
		</div>
	<?php }?>	
	</div>