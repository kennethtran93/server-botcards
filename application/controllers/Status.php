<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BSX Server - return the game status
 */
class Status extends Application {

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
		// build our state description
		$scoop = new SimpleXMLElement('<bcc/>');
		$scoop->round = $this->properties->get('round');
		$state = $this->properties->get('state');
		$scoop->state = $state;

		$state_descs = $this->config->item('game_states');
		$state_countdowns = $this->config->item('state_countdowns');
		
		$scoop->countdown = $this->properties->get('alarm') - time();

		$upcoming = ($state + 1) % count($state_descs);
		$scoop->current = (isset($state_descs[$state])) ? $state_descs[$state] : "Unknown";
		$scoop->duration = $state_countdowns[$state];
		$scoop->upcoming = $state_descs[$upcoming];
		$scoop->alarm = date(SHORT_DATE, $this->properties->get('alarm'));
		$scoop->now = date(SHORT_DATE);

		// return it to the user
		$this->output
				->set_content_type('text/xml')
				->set_output($scoop->asXML());
	}

}
