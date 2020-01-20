<script>
$(document).ready(function () {
	$(".helper_for_patient").hide();
	// тут можно считать дни недели, присваивать соответствующий класс
});
</script>
{if $NOT_SCH eq 0}
<span style="position: relative; left: 30px; top: 30px; " class="docname_num">{$DOCNAME},</span>
<span style="position: relative; left: 40px; top: 30px; " class="specname_num">{$SPECNAME}</span>
<div class="doctors_time">
	<div class="days_block">
	{foreach from=$DATA item=week}
		<div class="weeks">
		{foreach from=$week item=day}
			<div class="day_params">
			{foreach from=$day item=pval}
				{if $pval|@count == 1}
					<div class="dt_params empty_day">
						<span class="dt_datestr">&nbsp; &nbsp;   </span>
						<span class="dt_dayweek"> &nbsp;  &nbsp; </span>
						<span class="dt_range">   &nbsp; &nbsp; </span>
					</div>
				{elseif $pval|@count > 1}
					{if $pval.RANGE == '00:00-00:00'}
					<div class="dt_params no_recept">
						<span class="dt_datestr">{$pval.DATE_STR}</span>
						<span class="dt_dayweek">{$pval.DAYWEEK}</span>
						<span class="dt_range">   &nbsp; &nbsp; </span>
					</div>
					{else}	<!-- проверяем, выходной день или будний -->
						{if $pval.DAYWEEK == 'суббота' || $pval.DAYWEEK == 'воскресенье'}
						<div class="dt_params output_day">
							<span class="dt_datestr">{$pval.DATE_STR}</span>
							<span class="dt_dayweek">{$pval.DAYWEEK}</span>
							<span class="dt_range">{$pval.RANGE}</span>
						</div>						
						{else}
						<div class="dt_params recepting">
							<span class="dt_datestr">{$pval.DATE_STR}</span>
							<span class="dt_dayweek">{$pval.DAYWEEK}</span>
							<span class="dt_range">{$pval.RANGE}</span>
						</div>						
						{/if}
					{/if}
				{/if}
			{/foreach}
			</div>
		{/foreach}
		</div>
	{/foreach}
	</div>
</div>
{elseif $NOT_SCH eq 1}
<span style="position: relative; left: 30px; top: 30px; " class="docname_num">Расписание не обозначено.</span>
{/if}