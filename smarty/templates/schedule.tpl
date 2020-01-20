<script>
$(document).ready(function () {
	$("#doc_time").click(function () {
		window.location.href='doctors_time.php';
	});
	
	$("#free_nums").click(function () {
		window.location.href='speciality.php';
	});
});
</script>
	<div class="left_side">
		<img src="static/img/icons/ICON_Clock.png" />
	</div>
	<div class="right_side">
		<ul style="position: relative; top: 60px;" class="main_menu">
			<li>
				<div class="yellow_button" id="doc_time" >
					<span>Время приёма врачей</span>
				</div>
			</li>
			<li>
				<div class="yellow_button" id="free_nums" >
					<span>Свободные номерки</span>
				</div>
			</li>
		</ul>
	</div>