<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller{

private $aData = array();

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form','url'));
		$this->load->library('parser');
		$this->aData = array(
			'surl'=>site_url()
		);
	}
 
	function index(){
		$this->parser->parse('header', $this->aData);
		$this->parser->parse('body', $this->aData);
		$this->parser->parse('menu', $this->aData);

	}
}