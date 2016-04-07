<?php


defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 */
class Application extends CI_Controller {

	protected $data = array();	  // parameters for view components
	protected $id;				  // identifier for our content

	/**
	 * Constructor.
	 * Establish view parameters & set a couple up
	 */

	function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->data['title'] = 'BotCards Trading Server';
		$this->data['school'] = 'British Columbia Institute of Technology';
		$this->data['outline'] = 'http://botcards.jlparry.com';
		$this->data['site'] = 'http://www.bcit.ca/study/outlines/20161073674';
		$this->errors = array();
	}

	/**
	 * Render this page
	 */
	function render()
	{
		if (!isset($this->data['pagetitle']))
			$this->data['pagetitle'] = $this->data['title'];

		// Massage the menubar
		$choices = $this->config->item('menu_choices');
		foreach ($choices['menudata'] as &$menuitem)
		{
			$menuitem['active'] = (ltrim($menuitem['link'], '/ ') == uri_string()) ? 'active' : '';
		}
		$this->data['menubar'] = $this->parser->parse('theme/menubar', $choices, true);

		$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
		
		// convert Caboose output into view parameters
		$this->data['caboose_styles'] = $this->caboose->styles();
		$this->data['caboose_scripts'] = $this->caboose->scripts();
		$this->data['caboose_trailings'] = $this->caboose->trailings();

		// title for all but the homepage
		$layout = empty($this->data['title']) ? 'jumbotitle' : 'title';
		$this->data['titleblock'] = $this->parser->parse('theme/' . $layout, $this->data, true);

		// finally, build the browser page!
		$this->data['data'] = &$this->data;
		$this->parser->parse('theme/template', $this->data);
	}


	// respond with an XML error message
	function booboo($message = "Unknown erorr")
	{
		$response = new SimpleXMLElement('<error/>');
		$response->message = $message;
		// return it to the user
		$this->output
				->set_content_type('text/xml')
				->set_output($response->asXML())
				->_display();
		exit;
	}

}
