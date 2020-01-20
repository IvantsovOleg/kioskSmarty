<?php /* Smarty version Smarty-3.0.8, created on 2014-05-08 16:23:06
         compiled from "smarty/templates/numbers_free_time.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17704536b772a6beb50-31156796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28dfe27329782d5fd3ecf446d452da623f7ab706' => 
    array (
      0 => 'smarty/templates/numbers_free_time.tpl',
      1 => 1382424702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17704536b772a6beb50-31156796',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
$(document).ready(function () {
	function send_numb(numbid, dat, dayweek, date_str)
	{
		window.location.href = "userdata.php?numbid="+numbid+"&dat="+dat+"&dayweek="+dayweek+"&date_str="+date_str;
	}
	
	// нажатие кнопок ВВЕРХ и ВНИЗ hid_surv
	
	function click_more()
	{
		// верхняя и нижняя границы
		var hid_down_bord = $("#hid_down_bord").val();
		var hid_up_bord = $("#hid_up_bord").val();
		var survid = $("#hid_surv").val();
		var hid_dat = $("#hid_dat").val();
		var dayweek = $("#dayweek").val();
		var date_str = $("#date_str").val();
		
		$.ajax({
			type: "POST",
			url: "ajax_numbtime_down.php",
			data: {
				hid_down_bord: hid_down_bord,
				hid_up_bord: hid_up_bord,
				survid: survid,
				hid_dat: hid_dat,
				dayweek: dayweek,
				date_str: date_str
			},
			success: function(html) {
				$(".free_times_list").children().remove();
				$(".free_times_list").append(html);
			}
		});	
	}
	
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
	
	// ------
	
	$(".times_numbs_yellow").click(function () {
		$(".ajaxwait, .ajaxwait_image").show();
		var numbid = $(this).children("#numbid").val();
		var dat = $(this).children("#dat").val();
		var dayweek = $(this).children("#dayweek").val();
		var date_str = $(this).children("#date_str").val();	
		send_numb(numbid, dat, dayweek, date_str);
	});
	
	$(".times_numbs_yellow").mouseup(function () {
		$(this).removeClass("times_numbs_yellow");
		$(this).addClass("times_numbs_yellow");
	});
	$(".times_numbs_yellow").mousedown(function () {
		$(this).removeClass("times_numbs_yellow");
		$(this).addClass("times_numbs_green");		
	});
	$(".times_numbs_yellow").mouseout(function () {
		$(this).removeClass("times_numbs_green");
		$(this).addClass("times_numbs_yellow");	
	});	
	
	$(".ajaxwait, .ajaxwait_image").hide();
});
</script>
<input type="hidden" value="times" id="helper_value">
<script type="text/javascript" src="static/js/js_userhelper.js"></script>
<div class="numbers" id="numtimes">
	<span class="docname_num"><?php echo $_smarty_tpl->getVariable('DOCNAME')->value;?>
</span>
	<br />
	<span class="specname_num"><?php echo $_smarty_tpl->getVariable('SPECNAME')->value;?>
</span>
	<br />
	<?php if ($_smarty_tpl->getVariable('ROOM')->value!=''){?>
	<span style="font-size: 14pt;" class="specname_num"><?php echo $_smarty_tpl->getVariable('ROOM')->value;?>
 кабинет</span>
	<?php }?>
	<table class="numbers_freetime_list">
		<tr>
			<td>
				<span class="nums_datastr"><?php echo $_smarty_tpl->getVariable('DATE_STR')->value;?>
,</span>
				<span class="nums_dayweek"><?php echo $_smarty_tpl->getVariable('DAYWEEK')->value;?>
</span>						
			</td>
			<td>
				<span class="nums_range"><?php echo $_smarty_tpl->getVariable('RANGE')->value;?>
</span>
			</td>
		</tr>
	</table>
	<div class="free_times_list">
		<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('NUMBS')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<div class="times_numbs_yellow">
			<span><?php echo $_smarty_tpl->getVariable('NUMBS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['dat'];?>
</span>
			<input type="hidden" id="numbid" value="<?php echo $_smarty_tpl->getVariable('NUMBS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['numbid'];?>
" />
			<input type="hidden" id="dat" value="<?php echo $_smarty_tpl->getVariable('NUMBS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['dat'];?>
" />
			<input type="hidden" id="room" value="<?php echo $_smarty_tpl->getVariable('NUMBS')->value[$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']]['room'];?>
" />
			<input type="hidden" id="dayweek" value="<?php echo $_smarty_tpl->getVariable('DAYWEEK')->value;?>
" />
			<input type="hidden" id="date_str" value="<?php echo $_smarty_tpl->getVariable('DATE_STR')->value;?>
" />
		</div>
		<?php endfor; endif; ?>
		<div class="hidden_borders">
			<input type="hidden" id="hid_down_bord" value="<?php echo $_smarty_tpl->getVariable('DOWN_BORDER')->value;?>
" />
			<input type="hidden" id="hid_up_bord" value="<?php echo $_smarty_tpl->getVariable('UP_BORDER')->value;?>
" />
			<input type="hidden" id="hid_surv" value="<?php echo $_smarty_tpl->getVariable('SURVID')->value;?>
" />
			<input type="hidden" id="hid_dat" value="<?php echo $_smarty_tpl->getVariable('DAT')->value;?>
" />
		</div>
		<?php if ($_smarty_tpl->getVariable('MORELESS')->value==1){?>
		<div style="position: relative; top: 20px; left: 15px;">
				<div class="moreless_up_x" id="ml_up"><!-- вверх -->
					<img class="arr_up" src="static/img/buttons/moreless/arrow_less_x.png" />
					<img style="left: 36px;" class="text_up" src="static/img/buttons/moreless/text_up_x.png" />
				</div>
				<div class="moreless_down" id="ml_down"><!-- вниз -->
					<img class="arr_down" src="static/img/buttons/moreless/arrow_more.png" />
					<img style="left: 36px;"  class="text_down" src="static/img/buttons/moreless/text_down.png" />
				</div>
		</div>
		<?php }?>			
	</div>
</div>