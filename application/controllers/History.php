<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Botcards Trading Server - present the transactions for this round
 */
class History extends Application {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default entry point
	 */
	function index()
	{
		$this->data['pagebody'] = 'translist';
		$transactions = $this->transactions->all();
		$result = array();
		foreach ($transactions as $one) {
			$one['datetime'] = date('Y-m-d H:i:s', $one['datetime']);
			$result[] = $one;
		}
		$this->data['transactions'] = $result;
		$this->render();
	}

}

