<?php

/**
 * Class Certificates
 *
 * Model for the issued trading cards
 * 
 */
class Certificates extends MY_Model {

	public function __construct()
	{
		parent::__construct('certificates', 'token');
	}

	function filter($count, $agent, $player)
	{
		// The trailing/ recent query
		if (!is_null($count))
		{
			$start = $this->db->count_all($this->_tableName) - $count;
			if ($start < 0)
				$start = 0;
			$this->db->limit($count, $start);
		}

		//The filter part
		$this->db->where('broker', $agent);

		if (!empty($player))
			$this->db->where('player', $player);

		$this->db->order_by($this->_keyField, 'asc');
		$query = $this->db->get($this->_tableName);
		return $query;
	}

}
