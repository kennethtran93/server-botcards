<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * views/dataview.php
 *
 * Present the data that can be requested
 *
 */
?>
<div>
    <h1>Data available</h1>
	<p>The following data can be requested here, and will be returned as CSV.</p>
	<p>
		For Certificates and Transactions, you can do additonal filtering by specifying additional parameters.<br />
		Here are the parameter orders: <b>limit/agent/player</b>
		<ul>
			<li>limit = Number of recent records to extract.  Use 0 to get all records.</li>
			<li>agent = Agent Code.</li>
			<li>player = Player Name.  Agent code must be provided for this to work.</li>
		</ul>
	</p>
	<ul>
		{available}
		<li><a href="/data/{datum}">{datum}</a></li>
		{/available}
	</ul>
</div>
