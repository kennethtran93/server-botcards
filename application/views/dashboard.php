<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * views/organizer.php
 *
 * Present learning activities by week
 *
 */
?>
<div>
    <h1>Collect! Them! All!</h1>
	<p>Active series: {theseries}</p>
	<p>Active agents: {theagents}</p>
	<p>Cards in the wild: {thecerts}</p>
	<p>Transactions: {thetrans}</p>
	<div>{status_report}</div>
	<div class="row">
		<div class="col-xs-6">
			<h2>Recent Players</h2>
			<table class="table">
				{thepeeps}
			</table>
		</div>
		<div class="col-xs-6">
			<h2>Recent Transactions</h2>
			<table class="table">
				{thetrans}
			</table>
		</div>
	</div>
</div>
