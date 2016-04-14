<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BSX Server - sell stock
 */
class Sell extends Application {

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

		// Checking game state
		if ($this->properties->get('state') != GAME_OPEN)
			$this->booboo('Cannot process sell request in the current state.  Please wait until state is open.');

		// extract parameters
		$team = $this->input->post_get('team');
		$token = $this->input->post_get('token');
		$player = $this->input->post_get('player');
		$top = $this->input->post_get('top');
		$middle = $this->input->post_get('middle');
		$bottom = $this->input->post_get('bottom');

		// existence testing
		if (empty($team))
			$this->booboo('You are missing an agency code');
		if (empty($token))
			$this->booboo('Your need your agent token');
		if (empty($player))
			$this->booboo('Which player is this transaction for?');
		if (empty($top))
			$this->booboo('Bot assembly missing a top');
		if (empty($middle))
			$this->booboo('Bot assembly missing a middle');
		if (empty($bottom))
			$this->booboo('Bot assembly missing a bottom');

		// verify the agent
		if (!$this->users->exists($team))
			$this->booboo('Unrecognized agent');
		$theteam = $this->users->get($team);
		if ($token != $theteam->password)
			$this->booboo('Bad agent token');

		// Verify the player, and create record if not found
		if (is_null($this->players->find($team, $player)))
			$this->booboo('Cannot sell anything until you buy something');

		//Grab player record
		$one = $this->players->find($team, $player);
		$one->round = $this->properties->get('round');
		$this->players->update($one);

		// Do they own what they are trying to sell?
		$card = $this->certificates->get($top);
		if ($card == null)
			$this->booboo('Non-existing top card');
		if ($card->broker != $team)
			$this->booboo('Top card not bought through this agent');
		if ($card->player != $player)
			$this->booboo('Top card does not belong to this player');

		$card = $this->certificates->get($middle);
		if ($card == null)
			$this->booboo('Non-existing middle card');
		if ($card->broker != $team)
			$this->booboo('Middle card not bought through this agent');
		if ($card->player != $player)
			$this->booboo('Middle card does not belong to this player');

		$card = $this->certificates->get($bottom);
		if ($card == null)
			$this->booboo('Non-existing bottom card');
		if ($card->broker != $team)
			$this->booboo('Bottom card not bought through this agent');
		if ($card->player != $player)
			$this->booboo('Bottom card does not belong to this player');

		// assemble the bot
		$topcard = $this->certificates->get($top);
		$midcard = $this->certificates->get($middle);
		$botcard = $this->certificates->get($bottom);

		// is this bot from the same series?
		$series = substr($topcard->piece, 0, 3);
		if ($series != substr($midcard->piece, 0, 3))
			$series = null;
		if ($series != substr($botcard->piece, 0, 3))
			$series = null;

		if ($series == null)
			$price = 5; 
		else
			$price = $this->series->get($series)->value;

		// add the money to their account
		$one->cash += $price;
		$this->players->update($one);

		// record the transaction
		$trx = $this->transactions->create();
		$trx->seq = 0;
		$trx->datetime = time();
		$trx->broker = $team;
		$trx->player = $player;
		$trx->series = $series;
		$trx->trans = 'sell';
		$this->transactions->add($trx);

		// void any consumed certificates
		$this->certificates->delete($top);
		$this->certificates->delete($middle);
		$this->certificates->delete($bottom);


		$response = new SimpleXMLElement('<ok/>');
		$response->price = $price;
		$this->output
				->set_content_type('text/xml')
				->set_output($response->asXML());
//		$this->booboo('Patience, young padawans - progressing the selling is');
	}

}
