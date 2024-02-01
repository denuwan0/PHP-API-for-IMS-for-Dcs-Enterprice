<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('location_name', 'Location Name', 'required');
		$this->form_validation->set_rules('country_id', 'Country', 'required');
		$this->form_validation->set_rules('location_desc', 'Description', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'location_name'	=>	$this->input->post('location_name'),
				'country_id'	=>	$this->input->post('country_id'),
				'location_desc'	=>	$this->input->post('location_desc'),
				'is_active_location' =>	$this->input->post('is_active_location')
			);

			$this->emp_model->insert($data);

			$array = array(
				'success'		=>	true,
				'message'		=>	'Data Saved!'
			);
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!',
				'location_name'		=>	form_error('location_name'),
				'country_id'		=>	form_error('country_id'),
				'location_desc'		=>	form_error('location_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('location_id', 'Location Id', 'required');
		$this->form_validation->set_rules('location_name', 'Location Name', 'required');
		$this->form_validation->set_rules('country_id', 'Country', 'required');
		$this->form_validation->set_rules('location_desc', 'Description', 'required');
		//$this->form_validation->set_rules('is_active_country', 'Description', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_location') == 0){				
				$status = $this->branch_model->fetch_single($this->input->post('location_id'));
				if(count($status)>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Location is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'location_id'	=>	$this->input->post('location_id'),
						'country_id'	=>	$this->input->post('country_id'),
						'location_name'	=>	$this->input->post('location_name'),
						'location_desc'	=>	$this->input->post('location_desc'),
						'is_active_location'	=>	$this->input->post('is_active_location')
					);

					$this->emp_model->update_single($this->input->post('location_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'location_id'	=>	$this->input->post('location_id'),
					'location_name'	=>	$this->input->post('location_name'),
					'country_id'	=>	$this->input->post('country_id'),
					'location_desc'		=>	$this->input->post('location_desc'),
					'is_active_location'	=>	$this->input->post('is_active_location')
				);

				$this->emp_model->update_single($this->input->post('location_id'), $data);

				$array = array(
					'success'		=>	true,
					'message'		=>	'Changes Updated!'
				);
			}			
			
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Please Fill Required Fields!'
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->emp_model->delete_single($this->input->post('id')))
			{
				$array = array(

					'success'	=>	true
				);
			}
			else
			{
				$array = array(
					'error'		=>	true
				);
			}
			echo json_encode($array);
		}
	}
	
}
