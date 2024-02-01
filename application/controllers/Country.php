<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('country_model');
		$this->load->model('location_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->country_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		//var_dump($this->input->post('country_name'),$this->input->post('country_desc'));
		$this->form_validation->set_rules('country_name', 'Country Name', 'required');
		$this->form_validation->set_rules('country_desc', 'Description', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'country_name'	=>	$this->input->post('country_name'),
				'country_desc'	=>	$this->input->post('country_desc'),
				'is_active_country'		=>	$this->input->post('is_active_country')
			);

			$this->country_model->insert($data);

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
				'country_name_error'		=>	form_error('country_name'),
				'country_desc_error'		=>	form_error('country_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->country_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->country_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('country_id', 'Country Id', 'required');
		$this->form_validation->set_rules('country_name', 'Country Name', 'required');
		$this->form_validation->set_rules('country_desc', 'Description', 'required');
		//$this->form_validation->set_rules('is_active_country', 'Description', 'required');
		if($this->form_validation->run())
		{	

			/* SELECT DISTINCT TABLE_NAME 
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE COLUMN_NAME IN ('country_id')
			AND TABLE_SCHEMA='dcs_db';

			country
			location */
	
			if($this->input->post('is_active_country') == 0){		
				$status = 0;
				$status += ($this->location_model->fetch_all_by_country_id($this->input->post('country_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Country is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'country_id'	=>	$this->input->post('country_id'),
						'country_name'	=>	$this->input->post('country_name'),
						'country_desc'		=>	$this->input->post('country_desc'),
						'is_active_country'		=>	$this->input->post('is_active_country')
					);

					$this->country_model->update_single($this->input->post('country_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'country_id'	=>	$this->input->post('country_id'),
					'country_name'	=>	$this->input->post('country_name'),
					'country_desc'		=>	$this->input->post('country_desc'),
					'is_active_country'		=>	$this->input->post('is_active_country')
				);

				$this->country_model->update_single($this->input->post('country_id'), $data);

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
			if($this->country_model->delete_single($this->input->post('id')))
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
