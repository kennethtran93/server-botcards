<?php

/**
 * Class Series
 *
 * Model for the trading cards series
 * 
 */
class Series extends MY_Model {

	public function __construct()
	{
		parent::__construct('series','code');
	}

}
