<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenQR extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	function qrcode()
    {
        $this->load->library('ciqrcode');
		$params['data'] = 'http://localhost/dcs/login/';
		$params['level'] = 'H';
		$params['size'] = 2;
		$params['savename'] = FCPATH.'tes.png';
		$this->ciqrcode->generate($params);

		echo '<img src="'.base_url().'tes.png" />';
    }
		
}
