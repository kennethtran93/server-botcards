<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Present list of transactions
 */
?>
<div>
	<h1>Transaction History</h1>
	<table class="table">
		<tr><th>#</th><th>Date/Time</th><th>agent</th><th>Player</th><th>Series</th><th>Action</th></tr>
		{transactions}
		<tr>
			<td>{id}</td>
			<td>{datetime}</td>
			<td>{broker}</td>
			<td>{player}</td>
			<td>{series}</td>
			<td>{trans}</td>
		</tr>
		{/transactions}
	</table>
	<div class="alert alert-info">The transactions shown above are those for 
		the current or most recent round of trading.</div>
</div>
