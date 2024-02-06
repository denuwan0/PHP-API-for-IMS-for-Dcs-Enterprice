<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpMedicalLoc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_medical_checkup_location_model');
		$this->load->model('Emp_medical_records_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Emp_medical_checkup_location_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('emp_med_loc_name', 'emp_med_loc_name', 'required');
		$this->form_validation->set_rules('emp_med_loc_contact', 'emp_med_loc_contact', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'emp_med_loc_name'	=>	$this->input->post('emp_med_loc_name'),
				'emp_med_loc_contact'	=>	$this->input->post('emp_med_loc_contact'),
				'is_active_medical_checkup' =>	$this->input->post('is_active_medical_checkup')
			);

			$this->Emp_medical_checkup_location_model->insert($data);

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
				'emp_med_loc_name'		=>	form_error('emp_med_loc_name'),
				'emp_med_loc_contact'		=>	form_error('emp_med_loc_contact'),
				'is_active_medical_checkup'		=>	form_error('is_active_medical_checkup')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_medical_checkup_location_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_medical_checkup_location_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_medical_checkup_location_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->Emp_medical_checkup_location_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('emp_med_loc_id', 'emp_med_loc_id', 'required');
		$this->form_validation->set_rules('emp_med_loc_name', 'emp_med_loc_name', 'required');
		$this->form_validation->set_rules('emp_med_loc_contact', 'emp_med_loc_contact', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_medical_checkup') == 0){
				
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('branch_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				$status = 0;	
				$status += $this->Emp_medical_records_model->fetch_single_by_emp_med_loc_id($this->input->post('emp_med_loc_id'))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Medical Center is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'emp_med_loc_id'	=>	$this->input->post('emp_med_loc_id'),
						'emp_med_loc_name'	=>	$this->input->post('emp_med_loc_name'),
						'emp_med_loc_contact'	=>	$this->input->post('emp_med_loc_contact'),
						'is_active_medical_checkup'	=>	$this->input->post('is_active_medical_checkup')
					);

					$this->Emp_medical_checkup_location_model->update_single($this->input->post('emp_med_loc_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'emp_med_loc_id'	=>	$this->input->post('emp_med_loc_id'),
					'emp_med_loc_name'	=>	$this->input->post('emp_med_loc_name'),
					'emp_med_loc_contact'	=>	$this->input->post('emp_med_loc_contact'),
					'is_active_medical_checkup'	=>	$this->input->post('is_active_medical_checkup')
				);

				$this->Emp_medical_checkup_location_model->update_single($this->input->post('emp_med_loc_id'), $data);

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
			if($this->Emp_medical_checkup_location_model->delete_single($this->input->post('id')))
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
