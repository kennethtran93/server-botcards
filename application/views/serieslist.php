<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Present list of known series
 */
?>
<div>
	<h1>Bot Card Series</h1>
	<table class="table">
		<tr><th>Code</th><th>Description</th><th>Frequency</th><th>Value</th></tr>
		{series}
		<tr>
			<td>{code}</td>
			<td>{description}</td>
			<td>{frequency}</td>
			<td>{value}</td>
		</tr>
		{/series}
	</table>
	<div class="alert alert-info">The series shown above are those 
		available for trading.<br/>
		"Frequency" is an indication of rarity. A series with a frequency of 10 is 5 
		times more likely to be found than one with a frequency of 2.<br/>
		"Value" is the amount that a player receives for redeeming a completed bot
		from that series.<br/>
	</div>
</div>
