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
		<span style="font: bold 25pt Calibri; ">{$LPU_NAME}</span><br />
		<span style="font: normal 20pt Calibri; ">{$LPU_ADDRESS}</span><br />
		<br />
		<span>************************************************</span><br />	
		<span style="font: normal 18pt Calibri; ">Пациент: {$smarty.session.PATIENT_INFO}</span><br />		
		<br />
		<span>************************************************</span><br />	
		<span style="font: normal 18pt Calibri; ">Врач: {$DOCNAME}</span><br />
		<span style="font: normal 18pt Calibri; ">{$SPECNAME}</span><br />
		<br />
		<span style="font: normal 18pt Verdana; ">Дата и время приема: <br />{$TIME}</span><br />
		<span></span><br />
		<span style="font: normal 20pt Verdana;"><b> каб. {$smarty.session.CAB}</b></span>
		<span></span><br />
		{if $smarty.session.STRUCTADDRESS != ''}
		<span style="font: normal 18pt Calibri; ">{$smarty.session.STRUCTADDRESS}</span>
		<span></span><br />
		{/if}
		<span></span><br />
		<br />
		<span style="font: normal 20pt Calibri; ">БУДЬТЕ ЗДОРОВЫ!</span><br />
	</div>
</div>