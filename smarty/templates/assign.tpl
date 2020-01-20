<script>
function send_count_numbers(specid, docid)
{
	
}
</script>
<div class="numbers">
	<span>{$smarty.session.DOCNAME}</span>
	<br />
	<span>{$smarty.session.SPECNAME}</span>
	<table class="numbers_free_time">
	{section name=row loop=$DATA}
		<tr>
			<td>
				<span>{$DATA[row].DATE_STR},</span>
				<span>{$DATA[row].DAYWEEK}</span>
				<br />
				<span>{$DATA[row].RANGE}</span>
			</td>
			<td>
				<input type="button" value="{$DATA[row].COUNT_FULL}" onClick="send_count_numbers();" />
			</td>
		</tr>
	{/section}	
	</table>
</div>
<div class="scroll_arrows">
	<img class="scroll_arrow_up" src="" />
	<img class="scroll_arrow_down" src="" />
</div>