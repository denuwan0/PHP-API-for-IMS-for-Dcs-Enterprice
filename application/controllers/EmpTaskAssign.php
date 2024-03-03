<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpTaskAssign extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_special_task_header_model');
		$this->load->model('Emp_special_task_assign_emp_model');
		$this->load->model('Sys_user_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Emp_special_task_assign_emp_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('special_task_id', 'special_task_id', 'required');
		$this->form_validation->set_rules('branch_id', 'branch_id', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('invoice_id', 'invoice_id', 'required');
		$this->form_validation->set_rules('order_type', 'order_type', 'required');
		$this->form_validation->set_rules('task_start_date', 'task_end_date', 'required');
		$this->form_validation->set_rules('task_end_date', 'task_end_date', 'required');
		//$this->form_validation->set_rules('is_active_sp_task_assign', 'is_active_sp_task_assign', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'special_task_id'	=>	$this->input->post('special_task_id'),
				'branch_id'	=>	$this->input->post('branch_id'),
				'emp_id'	=>	$this->input->post('emp_id'),
				'task_start_date'	=>	$this->input->post('task_start_date'),
				'task_end_date' =>	$this->input->post('task_end_date'),
				'invoice_id' =>	$this->input->post('invoice_id'),
				'order_type' =>	$this->input->post('order_type'),
				'is_active_sp_task_assign' =>	$this->input->post('is_active_sp_task_assign')
			);

			$this->Emp_special_task_assign_emp_model->insert($data);

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
				'special_task_id'		=>	form_error('special_task_id'),
				'branch_id'		=>	form_error('branch_id'),
				'emp_id'		=>	form_error('emp_id'),
				'task_start_date'		=>	form_error('task_start_date'),
				'task_end_date'		=>	form_error('task_end_date'),
				'invoice_id'		=>	form_error('invoice_id'),
				'order_type'		=>	form_error('order_type')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_special_task_assign_emp_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_special_task_assign_emp_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_special_task_assign_emp_model->fetch_single_join($id);
			
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
			$data = $this->Emp_special_task_assign_emp_model->fetch_all_join();
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_special_task_assign_emp_model->fetch_all_active_join_by_branch_id($branch_id);
		}
		else if($user_group_name == "Staff"){		
			$data = $this->Emp_special_task_assign_emp_model->fetch_all_active_join_by_emp_id($emp_id);
		}		
			
		echo json_encode($data->result_array());
	}

	function update()
	{
		$this->form_validation->set_rules('special_task_id', 'special_task_id', 'required');
		$this->form_validation->set_rules('task_name', 'task_name', 'required');
		$this->form_validation->set_rules('task_type', 'task_type', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_sp_task') == 0){	
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('med_record_id')
					AND TABLE_SCHEMA='dcs_db'; */
				$status = 0;
				$status += $this->Emp_special_task_assign_emp_model->fetch_single($this->input->post('special_task_id'))->num_rows();
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Task is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'special_task_id'	=>	$this->input->post('special_task_id'),
						'task_name'	=>	$this->input->post('task_name'),
						'task_type'	=>	$this->input->post('task_type'),
						'is_active_sp_task' =>	$this->input->post('is_active_sp_task')
					);

					$this->Emp_special_task_assign_emp_model->update_single($this->input->post('special_task_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'special_task_id'	=>	$this->input->post('special_task_id'),
						'task_name'	=>	$this->input->post('task_name'),
						'task_type'	=>	$this->input->post('task_type'),
						'is_active_sp_task' =>	$this->input->post('is_active_sp_task')
					);

				$this->Emp_special_task_assign_emp_model->update_single($this->input->post('special_task_id'), $data);

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
			if($this->Emp_special_task_assign_emp_model->delete_single($this->input->post('id')))
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
			$data = $this->Emp_special_task_assign_emp_model->fetch_all_active_join();
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_special_task_assign_emp_model->fetch_all_active_join_by_branch_id($branch_id);
		}
		else if($user_group_name == "Staff"){		
			$data = $this->Emp_special_task_assign_emp_model->fetch_all_active_join_by_emp_id($emp_id);
		}
		
		
			
		echo json_encode($data->result_array());
	}
	
}
