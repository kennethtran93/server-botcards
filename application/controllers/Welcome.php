<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Botcards Trading Server - homepage
 */
class Welcome extends Application {

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
		$this->data['pagebody'] = 'dashboard';

		// show some summary series data
		$result = '';
		foreach ($this->series->all() as $record)
		{
			if (strlen($result) > 0)
				$result .= ', ';
			$result .= $record->code;
		}
		$this->data['theseries'] = $result;

		$result = '';
		foreach ($this->users->all() as $record)
		{
			if (strlen($result) > 0)
				$result .= ', ';
			if ($record->role == 'agent')
				$result .= $record->name;
		}
		if (strlen($result) === 0)
			$result = 'None';
		$this->data['theagents'] = $result;

		$result = $this->certificates->size();
		$this->data['thecerts'] = $result;

		$result = '';
		$count = array();
		foreach ($this->transactions->all() as $record)
		{
			if (isset($count[$record->trans]))
				$count[$record->trans] ++;
			else
				$count[$record->trans] = 1;
		}
		foreach ($count as $type => $amount)
		{
			if (strlen($result) > 0)
				$result .= '; ';
			$result .= $amount . ' ' . $type . 's';
		}
		$this->data['thetrans'] = $result;

		$this->render();
	}

}
