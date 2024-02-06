<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpLeaveQuota extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_leave_quota_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Emp_leave_quota_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('year', 'year', 'required');
		$this->form_validation->set_rules('leave_type_id', 'leave_type_id', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid_from_date', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid_to_date', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'year'	=>	$this->input->post('year'),
				'leave_type_id'	=>	$this->input->post('leave_type_id'),
				'valid_from_date'	=>	$this->input->post('valid_from_date'),
				'valid_to_date'	=>	$this->input->post('valid_to_date'),
				'amount'	=>	$this->input->post('amount'),
				'is_active_leave_quota' =>	$this->input->post('is_active_leave_quota')
			);

			$this->Emp_leave_quota_model->insert($data);

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
				'year'		=>	form_error('year'),
				'leave_type_id'		=>	form_error('leave_type_id'),
				'valid_from_date'		=>	form_error('valid_from_date'),
				'valid_to_date'		=>	form_error('valid_to_date'),
				'amount'		=>	form_error('amount')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_leave_quota_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_leave_quota_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_leave_quota_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->Emp_leave_quota_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
	function fetch_all_active_join()
	{	
		$data = $this->Emp_leave_quota_model->fetch_all_active_join();
		
		echo json_encode($data->result_array());
	}

	function update()
	{
		$this->form_validation->set_rules('leave_quota_id', 'leave_quota_id ', 'required');
		$this->form_validation->set_rules('year', 'year', 'required');
		$this->form_validation->set_rules('leave_type_id', 'leave_type_id', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid_from_date', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid_to_date', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_leave_quota') == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('branch_id')
					AND TABLE_SCHEMA='dcs_db'; */	
				$status = 0;
				//$status += $this->Emp_leave_quota_model->fetch_single($this->input->post('leave_quota_id'));
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Leave Quota is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
						'year'	=>	$this->input->post('year'),
						'leave_type_id'	=>	$this->input->post('leave_type_id'),
						'valid_from_date'	=>	$this->input->post('valid_from_date'),
						'valid_to_date'	=>	$this->input->post('valid_to_date'),
						'amount'	=>	$this->input->post('amount'),
						'is_active_leave_quota' =>	$this->input->post('is_active_leave_quota')
					);

					$this->Emp_leave_quota_model->update_single($this->input->post('leave_quota_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
					'year'	=>	$this->input->post('year'),
					'leave_type_id'	=>	$this->input->post('leave_type_id'),
					'valid_from_date'	=>	$this->input->post('valid_from_date'),
					'valid_to_date'	=>	$this->input->post('valid_to_date'),
					'amount'	=>	$this->input->post('amount'),
					'is_active_leave_quota' =>	$this->input->post('is_active_leave_quota')
				);

				$this->Emp_leave_quota_model->update_single($this->input->post('leave_quota_id'), $data);

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
			if($this->Emp_leave_quota_model->delete_single($this->input->post('id')))
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
