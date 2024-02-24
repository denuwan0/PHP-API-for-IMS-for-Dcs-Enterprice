<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpWiseLeaveQuota extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_wise_leave_quota_model');
		$this->load->model('Emp_leave_quota_model');
		$this->load->model('Emp_model');
		$this->load->model('Emp_leave_details_model');
		$this->load->library('form_validation');
		
		
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Emp_wise_leave_quota_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('leave_quota_id', 'leave_quota_id', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		
		$emp_id = $this->input->post('emp_id');
		
		$created_by = $this->session->userdata('user_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		
		
		if($this->form_validation->run())
		{
			$leave_quota_data = $this->Emp_leave_quota_model->fetch_single_join($this->input->post('leave_quota_id'));
			
			//var_dump($leave_quota_data);
						
			if($user_group_name = "Admin"){
				
				if($emp_id == 'all'){
					$data = $this->Emp_model->fetch_all_active();	
					$empList = $data->result_array();
					
					//var_dump($empList);
					
					$count = 0;
					
					foreach($empList as $item){
						$count += $this->Emp_wise_leave_quota_model->fetch_single_by_leave_quota_and_emp_id($this->input->post('leave_quota_id'), $empList[0]['emp_id'])->num_rows();
					}
					
					if($count>0){
						$array = array(
							'error'			=>	true,
							'message'		=>	'Leave Quota already created for some Employees, Please double check!'
						);
						
						echo json_encode($array);
					}
					else if($count==0){
						foreach($empList as $item){
					
					
							$empArray = array(
								'emp_id'	=>	$item["emp_id"],
								'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
								'balance_leave_quota'	=>	$leave_quota_data[0]['amount'],
								'is_hold_emp_wise_leave_quota' =>	0,
								'is_active_emp_wise_leave_quota' =>	1
							);
							
							$this->Emp_wise_leave_quota_model->insert($empArray);
							
						}
						
						
						
						$array = array(
							'success'		=>	true,
							'message'		=>	'Data Saved!'
						);
						echo json_encode($array);
					}
					
					
					
				}
				else{
					$empList = $this->Emp_model->fetch_single_by_emp_id($emp_id);	
					//$empList = $data->result_array();
					$count = 0;
					$count += $this->Emp_wise_leave_quota_model->fetch_single_by_leave_quota_and_emp_id($this->input->post('leave_quota_id'), $emp_id)->num_rows();
					if($count>0){
						$array = array(
							'error'			=>	true,
							'message'		=>	'Leave Quota already created for some Employees, Please double check!'
						);
						
						echo json_encode($array);
					}
					else if($count==0){
						$empArray = array(
							'emp_id'	=>	$emp_id,
							'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
							'balance_leave_quota'	=>	$leave_quota_data[0]['amount'],
							'is_hold_emp_wise_leave_quota' =>	0,
							'is_active_emp_wise_leave_quota' =>	1
						);
						
						$this->Emp_wise_leave_quota_model->insert($empArray);
						
						$array = array(
							'success'		=>	true,
							'message'		=>	'Data Saved!'
						);
						echo json_encode($array);
					}
				}
				
								
			}
			else {
				
				if($emp_id == 'all'){
					$data = $this->Emp_model->fetch_all_active_by_emp_branch_id($branch_id);
					$empList = $data->result_array();
					
					$count = 0;
					
					foreach($empList as $item){
						$count += $this->Emp_wise_leave_quota_model->fetch_single_by_leave_quota_and_emp_id($this->input->post('leave_quota_id'), $empList[0]['emp_id'])->num_rows();
					}
					
					if($count>0){
						$array = array(
							'error'			=>	true,
							'message'		=>	'Leave Quota already created for some Employees, Please double check!'
						);
						
						echo json_encode($array);
					}
					else if($count==0){
						foreach($empList as $item){
						
						
							$empArray = array(
								'emp_id'	=>	$item["emp_id"],
								'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
								'balance_leave_quota'	=>	$leave_quota_data[0]['amount'],
								'is_hold_emp_wise_leave_quota' =>	0,
								'is_active_emp_wise_leave_quota' =>	1
							);
							
							$this->Emp_wise_leave_quota_model->insert($empArray);
							
						}
						
						
						$array = array(
							'success'		=>	true,
							'message'		=>	'Data Saved!'
						);
						echo json_encode($array);
					}
					
					
				}
				else{
					$empList = $this->Emp_model->fetch_single_by_emp_id($emp_id);	
					//$empList = $data->result_array();
					$count = 0;
					$count += $this->Emp_wise_leave_quota_model->fetch_single_by_leave_quota_and_emp_id($this->input->post('leave_quota_id'), $emp_id)->num_rows();
					if($count>0){
						$array = array(
							'error'			=>	true,
							'message'		=>	'Leave Quota already created for this Employees, Please double check!'
						);
						
						echo json_encode($array);
					}
					else if($count==0){
						$empArray = array(
							'emp_id'	=>	$item["emp_id"],
							'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
							'balance_leave_quota'	=>	$leave_quota_data[0]['amount'],
							'is_hold_emp_wise_leave_quota' =>	0,
							'is_active_emp_wise_leave_quota' =>	1
						);
						
						$this->Emp_wise_leave_quota_model->insert($empArray);
						
						$array = array(
							'success'		=>	true,
							'message'		=>	'Data Saved!'
						);
						echo json_encode($array);
					}
				}
			}
			

			
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!',
				'leave_quota_id'		=>	form_error('leave_quota_id'),
				'balance_leave_exp_date'		=>	form_error('balance_leave_exp_date'),
				'emp_id'		=>	form_error('emp_id')
			);
			
			echo json_encode($array);
		}
		
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_wise_leave_quota_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_wise_leave_quota_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_wise_leave_quota_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$created_by = $this->session->userdata('user_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join();
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_branch_id($branch_id);
		}
		else if($user_group_name == "Staff"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join();
		}
	
		
		
		echo json_encode($data->result_array());
	}
	
	function fetch_all_active_join()
	{	
		$data = $this->Emp_wise_leave_quota_model->fetch_all_active_join();
		
		echo json_encode($data->result_array());
	}

	function update()
	{
		$this->form_validation->set_rules('emp_wise_leave_quota_id', 'emp_wise_leave_quota_id ', 'required');
		$this->form_validation->set_rules('leave_quota_id', 'leave_quota_id', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('balance_leave_quota', 'balance_leave_quota', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_emp_wise_leave_quota') == 0){	
				$status = 0;
				$status += $this->Emp_leave_details_model->fetch_single_by_emp_wise_leave_quota_id($this->input->post('emp_wise_leave_quota_id'))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Employee Wise Leave Quota is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
						'emp_id'	=>	$this->input->post('emp_id'),
						'balance_leave_quota'	=>	$this->input->post('balance_leave_quota'),
						'is_hold_emp_wise_leave_quota'	=>	$this->input->post('is_hold_emp_wise_leave_quota'),
						'is_active_emp_wise_leave_quota' =>	$this->input->post('is_active_emp_wise_leave_quota')
					);

					$this->Emp_wise_leave_quota_model->update_single($this->input->post('emp_wise_leave_quota_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'leave_quota_id'	=>	$this->input->post('leave_quota_id'),
					'emp_id'	=>	$this->input->post('emp_id'),
					'balance_leave_quota'	=>	$this->input->post('balance_leave_quota'),
					'is_hold_emp_wise_leave_quota'	=>	$this->input->post('is_hold_emp_wise_leave_quota'),
					'is_active_emp_wise_leave_quota' =>	$this->input->post('is_active_emp_wise_leave_quota')
				);

				$this->Emp_wise_leave_quota_model->update_single($this->input->post('emp_wise_leave_quota_id'), $data);

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
			if($this->Emp_wise_leave_quota_model->delete_single($this->input->post('id')))
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
	
	function fetch_all_join_for_select()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_emp_id($emp_id);
			echo json_encode($data);	
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_emp_id($emp_id);
			echo json_encode($data);
		}
		else if($user_group_name == "Staff"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_emp_id($emp_id);	
			//var_dump($data);
			echo json_encode($data);
		}
	
		
	}
	
}
