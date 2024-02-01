<?php

function sum($a, $b){
	return $a+$b;
}

defined('BASEPATH') OR exit('No direct script access allowed');

class UnitTest extends CI_Controller {

	public function __construct() {
        parent::__construct();
		$this->load->library('unit_test');
    }

	public function index()
	{
		$this->unit->run(sum(4,3),7,"Testing sum function");
		$this->load->view('test/test');
	}
}
