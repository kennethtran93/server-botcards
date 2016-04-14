<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BCX Server - return data for agents
 */
class Data extends Application {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default entry point - shouldn't be used
	 */
	function index()
	{
		$parms = array(
			array('datum' => 'series'),
			array('datum' => 'certificates'),
			array('datum' => 'transactions'),
		);
		$this->data['available'] = $parms;
		$this->data['pagebody'] = 'dataview';
		$this->render();
	}

	// return the stocks for the current round,or just 1
	function series($code = null)
	{
		$this->load->dbutil();
		if ($code == null)
			$records = $this->series->results();
		else
			$records = $this->series->just1($code);
		echo $this->dbutil->csv_from_result($records);
	}

	// return the certificates outstanding
	function certificates($limit = 0, $agent = null, $player = null)
	{
		$this->load->dbutil();
		if ($limit < 1)
		{
			if (is_null($agent))
			{
				$records = $this->certificates->results();
			} else
			{
				$records = $this->certificates->filter(NULL, strtolower($agent), strtolower($player));
			}
		} else
		{
			if (is_null($agent))
			{
				$records = $this->certificates->trailing($limit);
			} else
			{
				$records = $this->certificates->filter($limit, strtolower($agent), strtolower($player));
			}
		}
		echo $this->dbutil->csv_from_result($records);
	}

	// return the transactions for the current round
	function transactions($limit = 0, $agent = null, $player = null)
	{
		$this->load->dbutil();
		if ($limit < 1)
		{
			if (is_null($agent))
			{
				$records = $this->transactions->results();
			} else
			{
				$records = $this->transactions->filter(NULL, strtolower($agent), strtolower($player));
			}
		} else
		{
			if (is_null($agent))
			{
				$records = $this->transactions->trailing($limit);
			} else
			{
				$records = $this->transactions->filter($limit, strtolower($agent), strtolower($player));
			}
		}
		echo $this->dbutil->csv_from_result($records);
	}

}
