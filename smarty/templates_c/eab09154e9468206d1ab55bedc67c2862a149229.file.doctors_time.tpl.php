<?php /* Smarty version Smarty-3.0.8, created on 2014-05-08 16:31:33
         compiled from "smarty/templates/doctors_time.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27943536b7925b24496-25975750%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eab09154e9468206d1ab55bedc67c2862a149229' => 
    array (
      0 => 'smarty/templates/doctors_time.tpl',
      1 => 1382424702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27943536b7925b24496-25975750',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
$(document).ready(function () {
	$(".helper_for_patient").hide();
	// тут можно считать дни недели, присваивать соответствующий класс
});
</script>
<?php if ($_smarty_tpl->getVariable('NOT_SCH')->value==0){?>
<span style="position: relative; left: 30px; top: 30px; " class="docname_num"><?php echo $_smarty_tpl->getVariable('DOCNAME')->value;?>
,</span>
<span style="position: relative; left: 40px; top: 30px; " class="specname_num"><?php echo $_smarty_tpl->getVariable('SPECNAME')->value;?>
</span>
<div class="doctors_time">
	<div class="days_block">
	<?php  $_smarty_tpl->tpl_vars['week'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('DATA')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['week']->key => $_smarty_tpl->tpl_vars['week']->value){
?>
		<div class="weeks">
		<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['week']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value){
?>
			<div class="day_params">
			<?php  $_smarty_tpl->tpl_vars['pval'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['day']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pval']->key => $_smarty_tpl->tpl_vars['pval']->value){
?>
				<?php if (count($_smarty_tpl->tpl_vars['pval']->value)==1){?>
					<div class="dt_params empty_day">
						<span class="dt_datestr">&nbsp; &nbsp;   </span>
						<span class="dt_dayweek"> &nbsp;  &nbsp; </span>
						<span class="dt_range">   &nbsp; &nbsp; </span>
					</div>
				<?php }elseif(count($_smarty_tpl->tpl_vars['pval']->value)>1){?>
					<?php if ($_smarty_tpl->tpl_vars['pval']->value['RANGE']=='00:00-00:00'){?>
					<div class="dt_params no_recept">
						<span class="dt_datestr"><?php echo $_smarty_tpl->tpl_vars['pval']->value['DATE_STR'];?>
</span>
						<span class="dt_dayweek"><?php echo $_smarty_tpl->tpl_vars['pval']->value['DAYWEEK'];?>
</span>
						<span class="dt_range">   &nbsp; &nbsp; </span>
					</div>
					<?php }else{ ?>	<!-- проверяем, выходной день или будний -->
						<?php if ($_smarty_tpl->tpl_vars['pval']->value['DAYWEEK']=='суббота'||$_smarty_tpl->tpl_vars['pval']->value['DAYWEEK']=='воскресенье'){?>
						<div class="dt_params output_day">
							<span class="dt_datestr"><?php echo $_smarty_tpl->tpl_vars['pval']->value['DATE_STR'];?>
</span>
							<span class="dt_dayweek"><?php echo $_smarty_tpl->tpl_vars['pval']->value['DAYWEEK'];?>
</span>
							<span class="dt_range"><?php echo $_smarty_tpl->tpl_vars['pval']->value['RANGE'];?>
</span>
						</div>						
						<?php }else{ ?>
						<div class="dt_params recepting">
							<span class="dt_datestr"><?php echo $_smarty_tpl->tpl_vars['pval']->value['DATE_STR'];?>
</span>
							<span class="dt_dayweek"><?php echo $_smarty_tpl->tpl_vars['pval']->value['DAYWEEK'];?>
</span>
							<span class="dt_range"><?php echo $_smarty_tpl->tpl_vars['pval']->value['RANGE'];?>
</span>
						</div>						
						<?php }?>
					<?php }?>
				<?php }?>
			<?php }} ?>
			</div>
		<?php }} ?>
		</div>
	<?php }} ?>
	</div>
</div>
<?php }elseif($_smarty_tpl->getVariable('NOT_SCH')->value==1){?>
<span style="position: relative; left: 30px; top: 30px; " class="docname_num">Расписание не обозначено.</span>
<?php }?>