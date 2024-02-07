<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpSpecialTask extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_special_task_header_model');
		$this->load->model('Sys_user_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Emp_special_task_header_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('this_med_checkup_date', 'this_med_checkup_date', 'required');
		$this->form_validation->set_rules('next_med_checkup_date', 'next_med_checkup_date', 'required');
		$this->form_validation->set_rules('special_note', 'special_note', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('med_loc_id', 'med_loc_id', 'required');
		$this->form_validation->set_rules('emp_med_status', 'emp_med_status', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'this_med_checkup_date'	=>	$this->input->post('this_med_checkup_date'),
				'next_med_checkup_date'	=>	$this->input->post('next_med_checkup_date'),
				'special_note'	=>	$this->input->post('special_note'),
				'emp_id' =>	$this->input->post('emp_id'),
				'med_loc_id'	=>	$this->input->post('med_loc_id'),
				'emp_med_status' =>	$this->input->post('emp_med_status'),
				'is_active_medical_records' =>	$this->input->post('is_active_medical_records')
			);

			$this->Emp_special_task_header_model->insert($data);

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
				'this_med_checkup_date'		=>	form_error('this_med_checkup_date'),
				'next_med_checkup_date'		=>	form_error('next_med_checkup_date'),
				'special_note'		=>	form_error('special_note'),
				'emp_id'		=>	form_error('emp_id'),
				'med_loc_id'		=>	form_error('med_loc_id'),
				'emp_med_status'		=>	form_error('emp_med_status')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_special_task_header_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_special_task_header_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_special_task_header_model->fetch_single_join($id);
			
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_all_join()
	{	
		//var_dump($this->session->userdata());
	
		$user_id = $this->session->userdata('user_id');
		$branch_id = $this->session->userdata('emp_branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		
		$emp_data = $this->Sys_user_model->fetch_single($user_id);
		$emp_id = $emp_data[0]['emp_cust_id'];
		
		
		if($user_group_name == "Admin"){			
			$data = $this->Emp_special_task_header_model->fetch_all_join();
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_special_task_header_model->fetch_all_join_by_branch_id($branch_id);
		}
		else if($user_group_name == "Staff"){		
			$data = $this->Emp_special_task_header_model->fetch_single_join_by_emp_id($emp_id);
		}
		
		
			
		echo json_encode($data->result_array());
	}

	function update()
	{
		$this->form_validation->set_rules('med_record_id', 'med_record_id', 'required');
		$this->form_validation->set_rules('this_med_checkup_date', 'this_med_checkup_date', 'required');
		$this->form_validation->set_rules('next_med_checkup_date', 'next_med_checkup_date', 'required');
		$this->form_validation->set_rules('special_note', 'special_note', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('med_loc_id', 'med_loc_id', 'required');
		$this->form_validation->set_rules('emp_med_status', 'emp_med_status', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_medical_records') == 0){	
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('med_record_id')
					AND TABLE_SCHEMA='dcs_db'; */
				$status = 0;
				//$status += $this->branch_model->fetch_single($this->input->post('location_id'));
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Medical Record is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'this_med_checkup_date'	=>	$this->input->post('this_med_checkup_date'),
						'next_med_checkup_date'	=>	$this->input->post('next_med_checkup_date'),
						'special_note'	=>	$this->input->post('special_note'),
						'emp_id' =>	$this->input->post('emp_id'),
						'med_loc_id'	=>	$this->input->post('med_loc_id'),
						'emp_med_status' =>	$this->input->post('emp_med_status'),
						'is_active_medical_records' =>	$this->input->post('is_active_medical_records')
					);

					$this->Emp_special_task_header_model->update_single($this->input->post('med_record_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'this_med_checkup_date'	=>	$this->input->post('this_med_checkup_date'),
						'next_med_checkup_date'	=>	$this->input->post('next_med_checkup_date'),
						'special_note'	=>	$this->input->post('special_note'),
						'emp_id' =>	$this->input->post('emp_id'),
						'med_loc_id'	=>	$this->input->post('med_loc_id'),
						'emp_med_status' =>	$this->input->post('emp_med_status'),
						'is_active_medical_records' =>	$this->input->post('is_active_medical_records')
					);

				$this->Emp_special_task_header_model->update_single($this->input->post('med_record_id'), $data);

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
			if($this->Emp_special_task_header_model->delete_single($this->input->post('id')))
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
	
	function fetch_all_active_join()
	{	
		//var_dump($this->session->userdata());
	
		$user_id = $this->session->userdata('user_id');
		$branch_id = $this->session->userdata('emp_branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		
		$emp_data = $this->Sys_user_model->fetch_single($user_id);
		$emp_id = $emp_data[0]['emp_cust_id'];
		
		
		if($user_group_name == "Admin"){			
			$data = $this->Emp_special_task_header_model->fetch_all_active_join();
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_special_task_header_model->fetch_all_active_join_by_branch_id($branch_id);
		}
		else if($user_group_name == "Staff"){		
			$data = $this->Emp_special_task_header_model->fetch_all_active_join_by_emp_id($emp_id);
		}
		
		
			
		echo json_encode($data->result_array());
	}
	
}
