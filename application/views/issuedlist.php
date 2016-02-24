<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Present list of transactions
 */
?>
<div>
	<h1>Cards Issued</h1>
	<table class="table">
		<tr><th>#</th><th>Piece</th><th>agent</th><th>Player</th><th>Date/Time</th></tr>
		{issued}
		<tr>
			<td>{token}</td>
			<td>{piece}</td>
			<td>{broker}</td>
			<td>{player}</td>
			<td>{datetime}</td>
		</tr>
		{/issued}
	</table>
	<div class="alert alert-info">The card certificates shown above are those 
		outstanding at the end of the most recent round of trading.</div>
</div>
