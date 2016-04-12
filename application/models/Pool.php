<?php

/**
 * Class Pool
 *
 * Model for the poolk of available trading cards
 * 
 */
class Pool extends MY_Model {

	public function __construct()
	{
		parent::__construct('pool', 'token');
	}

	// make a new pool entry
	function newguy($bot)
	{
		// we need 3 pieces for this bot
		$this->maker('' . $bot . '-0');
		$this->maker('' . $bot . '-1');
		$this->maker('' . $bot . '-2');
	}

	// "print" a new card
	function maker($piece)
	{
		$CI = &get_instance();
		$working = true;
		while ($working)
		{
			$token = dechex(rand(0, 1000000));
			if ($this->exists($token))
				continue;
			if ($CI->certificates->exists($token))
				continue;
			$record = $this->create();
			$record->token = $token;
			$record->piece = $piece;
			$this->add($record);
			$working = false;
		}
	}

}
