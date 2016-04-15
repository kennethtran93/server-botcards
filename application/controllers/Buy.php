<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BCX Server - buy stock
 */
class Buy extends Application {

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
			$this->booboo('Cannot process buy request in the current state.  Please wait until state is open.');
		
		// extract parameters - what do they want to do?
		$team = strtolower($this->input->post_get('team'));
		$token = $this->input->post_get('token');
		$player = strtolower($this->input->post_get('player'));

		// existence testing
		if (empty($team))
			$this->booboo('You are missing an agency code');
		if (empty($token))
			$this->booboo('Your need your agent token');
		if (empty($player))
			$this->booboo('Which player is this transaction for?');

		// verify the agent
		if (!$this->users->exists($team))
			$this->booboo('Unrecognized agent');
		$theteam = $this->users->get($team);
		if ($token != $theteam->password)
			$this->booboo('Bad agent token');

		// Verify the player, and create record if not found
		if (is_null($this->players->find($team, $player)))
		{
			// create new player record
			$one = $this->players->create();
			$one->agent = $team;
			$one->player = $player;
			$one->cash = $this->properties->get('startcash');
			$this->players->add($one);
		}
		//Grab player record
		$one = $this->players->find($team, $player);
		$one->round = $this->properties->get('round');
		$this->players->update($one);


		// finally, can they afford the transaction?
		$price = $this->properties->get('priceperpack');
		if ($price > $one->cash)
			$this->booboo('You cannot afford to buy that');

		// take the money out of their account
		$one->cash -= $price;
		$this->players->update($one);

		// record the transaction
		$trx = $this->transactions->create();
		$trx->seq = 0;
		$trx->datetime = time();
		$trx->broker = $team;
		$trx->player = $player;
		$trx->trans = 'buy';
		$this->transactions->add($trx);

		// Generate a buy receipt output
		$receipt = new SimpleXMLElement('<buyreceipt/>');
		
		// Generate Billing info data
		$billTo = $receipt->addChild('billTo');
		$billTo->agent = $one->agent;
		$billTo->player = $one->player;
		$billTo->cost = $price;
		$billTo->remaining = $one->cash;
		
		// give them 10 cards
		$cardpack = $receipt->addChild('cardpack');

		for ($i = 0; $i < 10; $i++)
		{
			$original = $this->pool->first();
			$certificate = $this->certificates->create();
			$certificate->token = $original->token;
			$certificate->piece = $original->piece;
			$certificate->broker = $team;
			$certificate->player = $player;
			$certificate->datetime = time();
			$this->certificates->add($certificate);
			$this->pool->delete($original->token);
			
			$cert = $cardpack->addChild('certificate');
			foreach (((array) $certificate) as $key => $value)
				$cert->$key = $value;
		}
		$this->output
				->set_content_type('text/xml')
				->set_output($receipt->asXML());
	}

}
