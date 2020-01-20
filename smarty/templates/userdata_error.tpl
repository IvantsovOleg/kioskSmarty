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
	<span style="position: relative; top: 50px; left: 30px; ">{$smarty.session.ERRORTEXT}</span>
	<br />
	{if $ENTERING == 1}
	<input type="button" value="Ввести заново" class="confirm_yes" style="width: 200px; left: 40px;" />
	{/if}
	<input type="button" value="Начать сначала" class="confirm_no" style="width: 200px; left: 40px;" />
</div>