<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpLeave extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->model('emp_leave_details_model');
		$this->load->model('emp_wise_leave_quota_model');			
		
		
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
		$this->form_validation->set_rules('leave_from_date', 'leave_from_date', 'required');
		$this->form_validation->set_rules('leave_to_date', 'leave_to_date', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('emp_wise_leave_quota_id', 'emp_wise_leave_quota_id', 'required');
		$this->form_validation->set_rules('leave_amount', 'leave_amount', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'leave_from_date'	=>	$this->input->post('leave_from_date'),
				'leave_to_date'	=>	$this->input->post('leave_to_date'),
				'emp_id'	=>	$this->input->post('emp_id'),
				'emp_wise_leave_quota_id'	=>	$this->input->post('emp_wise_leave_quota_id'),
				'leave_amount'	=>	$this->input->post('leave_amount'),
				'created_by_emp_id'	=>	$this->input->post('created_by_emp_id'),
				'is_active_leave_details' =>	$this->input->post('is_active_leave_details')
			);

			$this->emp_leave_details_model->insert($data);

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
				'leave_from_date'		=>	form_error('leave_from_date'),
				'leave_to_date'		=>	form_error('leave_to_date'),
				'emp_id'		=>	form_error('emp_id'),
				'emp_wise_leave_quota_id'		=>	form_error('emp_wise_leave_quota_id'),
				'leave_amount'		=>	form_error('leave_amount')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->emp_leave_details_model->fetch_all_active();
			echo json_encode($data->result_array());	
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_branch_id($branch_id);
			echo json_encode($data->result_array());
		}
		else if($user_group_name == "Staff"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_emp_id($emp_id);	
			//var_dump($data);
			echo json_encode($data);
		}
	
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_leave_details_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_leave_details_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->emp_leave_details_model->fetch_all_join();		
			echo json_encode($data->result_array());	
		}
		else if($user_group_name == "Manager"){
			$data = $this->emp_leave_details_model->fetch_all_join_by_branch_id($branch_id);
			echo json_encode($data->result_array());
		}
		else if($user_group_name == "Staff"){
			$data = $this->emp_leave_details_model->fetch_all_join_by_emp_id($emp_id);	
			//var_dump($data);
			echo json_encode($data->result_array());
		}
		
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

					$this->emp_leave_details_model->update_single($this->input->post('location_id'), $data);

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

				$this->emp_leave_details_model->update_single($this->input->post('location_id'), $data);

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
			if($this->emp_leave_details_model->delete_single($this->input->post('id')))
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
