<?php /* Smarty version Smarty-3.0.8, created on 2014-05-08 16:35:35
         compiled from "smarty/templates/userdata_error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10087536b7a177ebc23-56732219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '636847237dbbbf94f945493929c6f9f89fd0dac4' => 
    array (
      0 => 'smarty/templates/userdata_error.tpl',
      1 => 1382424701,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10087536b7a177ebc23-56732219',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script>
	$(document).ready(function () {
		$(".helper_for_patient").hide();
		
		// ввести заново
		$(".confirm_yes").click(function () {
			$('.backg, .error_data').remove();
		});
		
		// начать сначала
		$(".confirm_no").click(function () {
			window.location.href = "index.php";
		});
		
		$(".ajaxwait, .ajaxwait_image").hide();
	});
</script>
<div class="backg"></div>
<div class="error_data">
	<span style="position: relative; top: 50px; left: 30px; "><?php echo $_SESSION['ERRORTEXT'];?>
</span>
	<br />
	<?php if ($_smarty_tpl->getVariable('ENTERING')->value==1){?>
	<input type="button" value="Ввести заново" class="confirm_yes" style="width: 200px; left: 40px;" />
	<?php }?>
	<input type="button" value="Начать сначала" class="confirm_no" style="width: 200px; left: 40px;" />
</div>