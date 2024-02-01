<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SysNotifyType extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sys_notify_type_model');
		$this->load->model('sys_notification_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->sys_notify_type_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('notify_name', 'Name', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'notify_name'	=>	$this->input->post('notify_name'),
				'is_active_sys_notify_type' =>	$this->input->post('is_active_sys_notify_type')
			);

			$this->sys_notify_type_model->insert($data);

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
				'notify_name'	=>	form_error('notify_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->sys_notify_type_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->sys_notify_type_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->sys_notify_type_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->sys_notify_type_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('sys_notify_type_id', 'Type Id', 'required');
		$this->form_validation->set_rules('notify_name', 'Type Name', 'required');
		
		//var_dump($_POST);
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_sys_notify_type') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('sys_notify_type_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				sys_notification
				sys_notify_type */
			
				$status = 0;
				$status += ($this->sys_notification_model->fetch_all_by_sys_notify_type_id($this->input->post('sys_notify_type_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Notify Type is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'sys_notify_type_id'	=>	$this->input->post('sys_notify_type_id'),
						'notify_name'	=>	$this->input->post('notify_name'),
						'is_active_sys_notify_type'	=>	$this->input->post('is_active_sys_notify_type')
					);
					
					$this->sys_notify_type_model->update_single($this->input->post('sys_notify_type_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'sys_notify_type_id'	=>	$this->input->post('sys_notify_type_id'),
					'notify_name'	=>	$this->input->post('notify_name'),
					'is_active_sys_notify_type'	=>	$this->input->post('is_active_sys_notify_type')
				);

				$this->sys_notify_type_model->update_single($this->input->post('sys_notify_type_id'), $data);

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
			if($this->sys_notify_type_model->delete_single($this->input->post('id')))
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
