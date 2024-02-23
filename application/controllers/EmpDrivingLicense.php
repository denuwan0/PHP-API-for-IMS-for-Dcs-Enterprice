<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpDrivingLicense extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_drive_license_model');
		$this->load->model('emp_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_drive_license_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('license_number', 'License No', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid from', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid to', 'required');
		$this->form_validation->set_rules('license_type', 'Vehicle Category', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'license_number'	=>	$this->input->post('license_number'),
				'emp_id'	=>	$this->input->post('emp_id'),
				'valid_from_date'	=>	$this->input->post('valid_from_date'),
				'valid_to_date'	=>	$this->input->post('valid_to_date'),
				'license_type'	=>	$this->input->post('license_type'),
				'is_active_driving_lice' =>	$this->input->post('is_active_driving_lice')
			);

			$this->emp_drive_license_model->insert($data);

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
				'license_number'		=>	form_error('license_number'),
				'emp_id'		=>	form_error('emp_id'),
				'valid_from_date'		=>	form_error('valid_from_date'),
				'valid_to_date'		=>	form_error('valid_to_date'),
				'license_type'		=>	form_error('license_type')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_drive_license_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_drive_license_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_drive_license_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_drive_license_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('driving_license_id', 'License Id', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('license_number', 'License No', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid from', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid to', 'required');
		$this->form_validation->set_rules('license_type', 'Vehicle Category', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_driving_lice') == 0){	
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('driving_license_id')
					AND TABLE_SCHEMA='dcs_db'; */
			
				$status = $this->emp_model->fetch_single_by_emp_drive_license_id($this->input->post('driving_license_id'));
				if(count($status)>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Driving Lisence is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'emp_id'	=>	$this->input->post('emp_id'),
						'license_number'	=>	$this->input->post('license_number'),
						'valid_from_date'	=>	$this->input->post('valid_from_date'),
						'valid_to_date'	=>	$this->input->post('valid_to_date'),
						'license_type'	=>	$this->input->post('license_type')
					);

					$this->emp_drive_license_model->update_single($this->input->post('driving_license_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'emp_id'	=>	$this->input->post('emp_id'),
					'license_number'	=>	$this->input->post('license_number'),
					'valid_from_date'	=>	$this->input->post('valid_from_date'),
					'valid_to_date'	=>	$this->input->post('valid_to_date'),
					'license_type'	=>	$this->input->post('license_type'),
					'is_active_driving_lice' =>	$this->input->post('is_active_driving_lice')
				);

				$this->emp_drive_license_model->update_single($this->input->post('driving_license_id'), $data);

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
			if($this->emp_drive_license_model->delete_single($this->input->post('id')))
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
