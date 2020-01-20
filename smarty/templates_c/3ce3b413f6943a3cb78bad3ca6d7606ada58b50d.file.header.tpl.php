<?php /* Smarty version Smarty-3.0.8, created on 2014-05-08 16:16:13
         compiled from "smarty/templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15976536b758dd4b8c6-75975682%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ce3b413f6943a3cb78bad3ca6d7606ada58b50d' => 
    array (
      0 => 'smarty/templates/header.tpl',
      1 => 1385364804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15976536b758dd4b8c6-75975682',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
    <head>
		<title></title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta http-equiv="X-UA-compatible" content="IE=EmulateIE8"/>
        <link rel="stylesheet" type="text/css" href="static/css/main.css" media="all"/>
		<?php if ($_SESSION['PRINT_CH_KIND']==3){?>
		<link rel="stylesheet" type="text/css" href="static/css/talon.css" media="all"/>
		<?php }?>
		<script type="text/javascript" src="static/js/jquery-1.6.4.js"></script>
		<script type="text/javascript" src="static/js/jquery.print.js"></script>
		<script type="text/javascript" src="static/js/jquery-ui-1.8.15.custom.min.js"></script>
		<script type="text/javascript" src="static/js/js.js"></script>	  
		<script type="text/javascript" src="static/js/bytescoutbarcode128_1.00.07.js"></script>	  
</head>
    <body>
<script>
$(document).ready(function () {
	$(".ajaxwait, .ajaxwait_image").hide();
	$(".ajaxwait, .ajaxwait_image").ajaxSend(function(event, xhr, options) {
		$(this).show();			
			 }).ajaxStop(function() {
		$(this).hide();
	});

	$(".hhome").click(function () {
		window.location.href='index.php';
	});
	
	$(".hback").not(".pat_n").click(function () {
		history.back();
	});	
	
	// нажимание кнопки "ДОМОЙ"
	$(".hhome").mouseup(function () {
		$(this).removeClass("hhome_press");
		$(this).addClass("hhome");
	});
	$(".hhome").mousedown(function () {
		$(this).removeClass("hhome");
		$(this).addClass("hhome_press");
	});
	$(".hhome").mouseout(function () {
		$(this).removeClass("hhome_press");
		$(this).addClass("hhome");
	});
	
	// нажимание кнопки "НАЗАД"
	$(".hback").mouseup(function () {
		$(this).removeClass("hback_press");
		$(this).addClass("hback");
	});
	$(".hback").mousedown(function () {
		$(this).removeClass("hback");
		$(this).addClass("hback_press");
	});
	$(".hback").mouseout(function () {
		$(this).removeClass("hback_press");
		$(this).addClass("hback");
	});	
	
	// сжимаем название специальности, если слишком длинное
	var span = $(".side_header .head_name").width();
	var pt = 30;
	while (span > 600)
	{
		pt -= 1;
		// изменить шрифт в спане
		$(".side_header").css("font-size", pt+"pt");
		var span = $(".side_header .head_name").width();
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
			var span = $(this).children('span').height();
			var span_w = $(this).children('span').width();
		}		
	});
	
	$(".go_home").click(function () {
		window.location.href = "index.php";
	});
	
/*	setTimeout(function () {
		window.location.href = "index.php";
	}, 180000);
	*/
});
</script>
<div class="ajaxwait"></div>
<div class="ajaxwait_image">
	<img src="static/img/ajaxloader.gif" />
</div>
		<div class="header">
			<?php if ($_smarty_tpl->getVariable('HOME')->value=='no'){?>
			<div class="center_header">
				<span class="head_name"><?php echo $_smarty_tpl->getVariable('HEAD_NAME')->value;?>
</span>
			</div>
			<?php }elseif($_smarty_tpl->getVariable('HOME')->value=='yes'){?>
			<div class="home_n_back_buttons">
					<div class="hback">
						<img src="static/img/buttons/01_Arrow.png" class="hback_img_ar" />
						<img src="static/img/buttons/01_Back.png" class="hback_img_b" />
					</div>
					<div class="hhome"  style="left: 50px; ">
						<img class="hhome_img" src="static/img/buttons/01_Home.png" />
					</div>					
			</div>
			<div style="clear: both; "></div>
			<div class="side_header">
				<span class="head_name"><?php echo $_smarty_tpl->getVariable('HEAD_NAME')->value;?>
</span>
			</div>
			<div style="clear: both; "></div>
			<?php }?> 
		</div>
		<div class="helper_for_patient" style="position: absolute; z-index: 1000; ">
			<span></span>
		</div>
		<div class="content">