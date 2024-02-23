<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notify extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notify_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		/* if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} */
		
	}

	function get_all_close_to_expire()
	{
		
		$data = json_decode(file_get_contents('php://input'), true);
		//var_dump($data);		
		$data = $this->Notify_model->get_all_close_to_expire($data);
		
		
		//echo json_encode($data->result_array());
	}
	
	
	
}
