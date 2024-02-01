<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpLeaveType extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_leave_type_model');
		$this->load->model('emp_leave_quota_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_leave_type_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('leave_type_name', 'leave_type_name', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'leave_type_name'	=>	$this->input->post('leave_type_name'),
				'is_active_leave_type' =>	$this->input->post('is_active_leave_type')
			);

			$this->emp_leave_type_model->insert($data);

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
				'leave_type_name'		=>	form_error('leave_type_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_leave_type_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_leave_type_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_leave_type_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_leave_type_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}

	function update()
	{
		$this->form_validation->set_rules('leave_type_id', 'leave_type_id', 'required');
		$this->form_validation->set_rules('leave_type_name', 'leave_type_name', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_leave_type') == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('leave_type_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				$status = 0;
				$status += $this->emp_leave_quota_model->fetch_single_by_leave_type_id($this->input->post('leave_type_id'))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Employee Leave Type is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'leave_type_id'	=>	$this->input->post('leave_type_id'),
						'leave_type_name'	=>	$this->input->post('leave_type_name'),
						'is_active_leave_type'	=>	$this->input->post('is_active_leave_type')
					);

					$this->emp_leave_type_model->update_single($this->input->post('leave_type_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'leave_type_id'	=>	$this->input->post('leave_type_id'),
					'leave_type_name'	=>	$this->input->post('leave_type_name'),
					'is_active_leave_type'	=>	$this->input->post('is_active_leave_type')
				);

				$this->emp_leave_type_model->update_single($this->input->post('leave_type_id'), $data);

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
			if($this->emp_leave_type_model->delete_single($this->input->post('id')))
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
