<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('person_model','person');
	}
	public function index()
	{
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('posisi');
        $this->load->view('footer');
	}
	
}