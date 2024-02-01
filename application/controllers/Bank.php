<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bank_model');
		$this->load->model('bank_branch_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->bank_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('bank_name', 'Name', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'bank_name'	=>	$this->input->post('bank_name'),
				'is_active_bank' =>	$this->input->post('is_active_bank')
			);

			$this->bank_model->insert($data);

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
				'company_id'	=>	form_error('company_id'),
				'bank_name'	=>	form_error('bank_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->bank_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->bank_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->bank_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->bank_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('bank_id', 'Bank Id', 'required');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
		
		//var_dump($_POST);
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_bank') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('bank_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				bank
				bank_branch */
			
				$status = 0;
				$status += ($this->bank_branch_model->fetch_all_by_bank_id($this->input->post('bank_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Bank is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'bank_id'	=>	$this->input->post('bank_id'),
						'bank_name'	=>	$this->input->post('bank_name'),
						'is_active_bank'	=>	$this->input->post('is_active_bank')
					);
					
					$this->bank_model->update_single($this->input->post('bank_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'bank_id'	=>	$this->input->post('bank_id'),
					'bank_name'	=>	$this->input->post('bank_name'),
						'is_active_bank'	=>	$this->input->post('is_active_bank')
				);

				$this->bank_model->update_single($this->input->post('bank_id'), $data);

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
			if($this->bank_model->delete_single($this->input->post('id')))
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
