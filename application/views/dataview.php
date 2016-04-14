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
		Here are the order of parameter: <b>limit/agent/player</b>.  Example:  /data/certificates/0/a01/noname
		<ul>
			<li>limit = Number of recent records to extract.  Use 0 to get all records.</li>
			<li>agent = (OPTIONAL) Agent Code.</li>
			<li>player = (OPTIONAL) Player Name.  <b>Agent code must be provided for this to work.</b>  If this is left out then all records for agent specified will be returned.</li>
		</ul>
	</p>
	<ul>
		{available}
		<li><a href="/data/{datum}">{datum}</a></li>
		{/available}
	</ul>
</div>
