<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SysUserGroup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sys_user_group_model');
		$this->load->model('sys_user_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->sys_user_group_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('sys_user_group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('sys_user_group_desc', 'Description', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'sys_user_group_name'	=>	$this->input->post('sys_user_group_name'),
				'sys_user_group_desc'	=>	$this->input->post('sys_user_group_desc'),
				'is_active_sys_user_group' =>	$this->input->post('is_active_sys_user_group')
			);

			$this->sys_user_group_model->insert($data);

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
				'sys_user_group_name'	=>	form_error('sys_user_group_name'),
				'sys_user_group_desc'	=>	form_error('sys_user_group_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->sys_user_group_model->fetch_all_active();
		echo json_encode($data);
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->sys_user_group_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->sys_user_group_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->sys_user_group_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('sys_user_group_id', 'User Group Id', 'required');
		$this->form_validation->set_rules('sys_user_group_name', 'User Group Name', 'required');
		$this->form_validation->set_rules('sys_user_group_desc', 'Description', 'required');
		
		//var_dump($_POST);
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_sys_user_group') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_type_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				sys_user */
			
				$status = 0;
				$status += ($this->sys_user_model->fetch_all_by_user_group_id($this->input->post('sys_user_group_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'User Group is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'sys_user_group_name'	=>	$this->input->post('sys_user_group_name'),
						'sys_user_group_desc'	=>	$this->input->post('sys_user_group_desc'),
						'is_active_sys_user_group' =>	$this->input->post('is_active_sys_user_group')
					);
					
					$this->sys_user_group_model->update_single($this->input->post('sys_user_group_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'sys_user_group_name'	=>	$this->input->post('sys_user_group_name'),
					'sys_user_group_desc'	=>	$this->input->post('sys_user_group_desc'),
					'is_active_sys_user_group' =>	$this->input->post('is_active_sys_user_group')
				);

				$this->sys_user_group_model->update_single($this->input->post('sys_user_group_id'), $data);

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
			if($this->sys_user_group_model->delete_single($this->input->post('id')))
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
