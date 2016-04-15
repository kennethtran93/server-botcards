<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Botcards Trading Server - show issued cards
 */
class Issued extends Application {

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
		$this->data['pagebody'] = 'issuedlist';
		$certificates = $this->certificates->all();
		$result = array();
		foreach ($certificates as $one)
		{
			$one['datetime'] = date('Y-m-d H:i:s', $one['datetime']);
			$result[] = $one;
		}
		$this->data['issued'] = $result;
		$this->render();
	}

}
