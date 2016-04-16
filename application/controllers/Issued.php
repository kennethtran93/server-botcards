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

		$this->data['issued'] = $certificates;
		$this->render();
	}

}
