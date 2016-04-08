<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BCX Server - register an agent
 */
class Register extends Application {

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
		// extract parameters
		$team = strtolower($this->input->post_get('team'));
		$name = $this->input->post_get('name');
		$password = $this->input->post_get('password');

		if (empty($team))
			$this->booboo('Surely you are on a team.');
		if (empty($name))
			$this->booboo("Can't you remember your name?");
		if (empty($password))
			$this->booboo('The password of the day is on '
					. 'the main course page on D2L..');

		// verify these
		$set = substr($team, 0, 1);
		if (!in_array($set, array('b', 'g', 'o', 's')))
			$this->booboo('Unrecognized set');
		if (strlen($name) < 1)
			$this->booboo('You need a name');
		if ($password != $this->properties->get('potd'))
			$this->booboo('Incorrect password');

		// if they are already registered, confirm
		$agent = $this->users->get($team);
		if ($agent != null)
		{
			if ($agent->role != 'agent')
				$this->booboo('Nice try');
		} else
		{
			// so far, so good. add the agent
			$agent = $this->users->create();
			$agent->code = $team;
			$agent->name = $name;
			$agent->role = 'agent';
			$agent->password = md5($team . $name);
			$agent->last_round = $this->properties->get('round');

			$this->users->add((array) $agent);
		}
		$response = new SimpleXMLElement('<agent/>');
		$response->team = $agent->code;
		$response->token = $agent->password;
		$this->output
				->set_content_type('application/xml')
				->set_output($response->asXML());
	}

}
