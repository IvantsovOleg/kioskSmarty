<?php /* Smarty version Smarty-3.0.8, created on 2014-05-19 16:35:48
         compiled from "smarty/templates\print_block.tpl" */ ?>
<?php /*%%SmartyHeaderCode:214705379faa4b41b38-53998625%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90a7d3f87dc95dfb921007e1708d8cb0c513f133' => 
    array (
      0 => 'smarty/templates\\print_block.tpl',
      1 => 1400502792,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214705379faa4b41b38-53998625',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
   jsPrintSetup.setSilentPrint(true);
</script>
<script>
	$(document).ready(function () {
		$(".helper_for_patient").hide();
		$("#for_print").hide();
		$("#for_print").print();
		
	setTimeout(function () {
		window.location.href = "index.php";
	}, 60000);
	
	$(".ajaxwait, .ajaxwait_image, .hback").hide();
});
</script>
<div id="for_print">
	<div>
		<span style="font: bold 25pt Calibri; "><?php echo $_smarty_tpl->getVariable('LPU_NAME')->value;?>
</span><br />
		<span style="font: normal 20pt Calibri; "><?php echo $_smarty_tpl->getVariable('LPU_ADDRESS')->value;?>
</span><br />
		<br />
		<span>************************************************</span><br />	
		<span style="font: normal 18pt Calibri; ">Пациент: <?php echo $_SESSION['PATIENT_INFO'];?>
</span><br />		
		<br />
		<span>************************************************</span><br />	
		<span style="font: normal 18pt Calibri; ">Врач: <?php echo $_smarty_tpl->getVariable('DOCNAME')->value;?>
</span><br />
		<span style="font: normal 18pt Calibri; "><?php echo $_smarty_tpl->getVariable('SPECNAME')->value;?>
</span><br />
		<br />
		<span style="font: normal 18pt Verdana; ">Дата и время приема: <br /><?php echo $_smarty_tpl->getVariable('TIME')->value;?>
</span><br />
		<span></span><br />
		<span style="font: normal 20pt Verdana;"><b> каб. <?php echo $_SESSION['CAB'];?>
</b></span>
		<span></span><br />
		<?php if ($_SESSION['STRUCTADDRESS']!=''){?>
		<span style="font: normal 18pt Calibri; "><?php echo $_SESSION['STRUCTADDRESS'];?>
</span>
		<span></span><br />
		<?php }?>
		<span></span><br />
		<br />
		<span style="font: normal 20pt Calibri; ">БУДЬТЕ ЗДОРОВЫ!</span><br />
	</div>
</div>