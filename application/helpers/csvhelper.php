<?php

if (!defined('APPPATH'))
	exit('No direct script access allowed');

/**
 *  Convert a CSV string (returned from a CSV file read completely)
 * into an associative array, using the first row as keys
 * 
 * @param string $data CSV contents
 */
if (!function_exists('csv_to_assoc'))
{

	function csv_to_assoc($data)
	{
		$result = array();
		$lines = str_getcsv($data, '\n');
		$keys = array();
		$primed = FALSE;
		foreach ($lines as $row)
		{
			if ($primed)
				$result[] = array_combine($keys, str_getcsv($row, ','));
			else
			{
				$keys = str_getcsv($row, ',');
				$primed = TRUE;
			}
		}
		return $result;
	}

}
