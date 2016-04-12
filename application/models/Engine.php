<?php

/**
 * Game engine
 * 
 */
class Engine extends CI_Model {

	var $state = -1;
	var $next_event = -1;

	public function __construct()
	{
		parent::__construct();

		$CI = &get_instance();
		$this->state = $CI->properties->get('state');
		$this->next_event = $CI->properties->get('next_event');
	}

	// Check for an alarm gone off; handle it
	function check()
	{
		$CI = &get_instance();
		$state = $CI->properties->get('state');

		$now = time();
		$alarm = $CI->properties->get('alarm');
		if ($now > $alarm)
			$this->gearChange($state);

		if ($state == GAME_OPEN)
			$this->processQueue();
	}

	// advance the game state
	function gearChange($state)
	{
		$CI = &get_instance();
		switch ($state)
		{
			case GAME_CLOSED:
				// flush the round-specific tables
				$CI->transactions->truncate();
				$CI->certificates->truncate();
				break;
			case GAME_SETUP:
				// which bots shall we use?
				$this->pickBots();
				// generate movements
				$this->generateCards();
				// eliminate stale players or agents
				$this->tossStale();
				// reset starting cash & certificates
				$this->cleanSlate();
				// update the round #
				$round = $CI->properties->get('round');
				$CI->properties->put('round', $round + 1);
				break;
			case GAME_READY:
				// brief pause for commercials; nothing to do
				break;
			case GAME_OPEN:
				// replenish card inventory?
				$this->generateCards();
				break;
			case GAME_OVER:
			default:
				// nothing to do but wait
				break;
		}

		// advance to the next state
		$state = ($state + 1) % (GAME_OVER + 1);
		$CI->properties->put('state', $state);
		$next_alarm = time() + (int) ($CI->config->item('state_countdowns')[$state]);
		$CI->properties->put('alarm', $next_alarm);
	}

	// homepage report
	function report()
	{
		$CI = &get_instance();
		$parms = array();
		$state_descs = $CI->config->item('game_states');
		$state_countdowns = $CI->config->item('state_countdowns');
		$current = $CI->properties->get('state');
		$upcoming = ($current + 1) % GAME_OVER;
		$parms['current'] = $state_descs[$current];
		$parms['duration'] = $state_countdowns[$current];
		$parms['upcoming'] = $state_descs[$upcoming];
		$parms['alarm'] = date(SHORT_DATE, $CI->properties->get('alarm'));
		$parms['round'] = $CI->properties->get('round');
		$parms['now'] = date(SHORT_DATE);
		return $CI->parser->parse('status_report', $parms, true);
	}

	// Pick the bots to use for the current round
	function pickBots()
	{
		$CI = &get_instance();
//		$CI->stocks->truncate();
//		$size = $CI->candidates->size();
//		$choices = rand(6, $size / 2); // choose a number
//		$pool = $CI->candidates->results();
//		for ($index = 0; $index < $choices; $index++)
//		{
//			$pick = rand(0, $size);
//			$pickme = $pool->row($pick);
//			if (!$CI->stocks->exists($pickme->code)) {
//				$pickme->value = 100; // all start at 100
//				$CI->stocks->add($pickme);
//			}
//		}
	}

	// Generate an appropriate set of cards to buy
	function generateCards()
	{
		$CI = &get_instance();
		$count = $CI->config->item('state_countdowns')[GAME_OPEN];
		$start = time();

//		// generate candidate movements
//		$upcoming = array();
//		foreach ($CI->stocks->all() as $stock)
//		{
//			$stock_type = $stock->category;
//			$limit = $count * $genx[$stock_type];
//			$dice = $genz[$stock_type];
//			$amounts = array(5, 10, 20);
//			for ($i = 0; $i < $limit; $i++)
//			{
//				$maybe = $CI->movement->create();
//				$maybe->datetime = $start + rand(0, $count);
//				$maybe->code = $stock->code;
//				$maybe->action = $dice[array_rand($dice)];
//				$maybe->amount = $amounts[array_rand($amounts)];
//				$key = $maybe->datetime . (1000 + $i);
//				$upcoming[$key] = $maybe;
//			}
//		}
//
	}

	// Eliminate stale players or agents
	function tossStale()
	{
		$CI = &get_instance();
		$cutoff = $CI->properties->get('round') - 2;
		// clean up the players
		foreach ($CI->players->all() as $player)
			if ($player->round < $cutoff)
				$CI->players->delete($player->seq);
		// clean up the agents
		foreach ($CI->users->all() as $user)
			if ($user->last_round < $cutoff)
				$CI->users->delete($user->code);
	}

	// Clear all player slates
	function cleanSlate()
	{
		$CI = &get_instance();
		$CI->certificates->truncate();
		$pot = $CI->properties->get('startcash');
		foreach ($CI->players->all() as $player)
		{
			$player->cash = $pot;
			$CI->players->update($player);
		}
	}


}
