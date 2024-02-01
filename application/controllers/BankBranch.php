<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankBranch extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bank_branch_model');
		$this->load->model('bank_account_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->bank_branch_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('bank_id', 'Bank', 'required');		
		$this->form_validation->set_rules('location_id', 'Location', 'required');
		$this->form_validation->set_rules('b_branch_code', 'Branch Code', 'required');
		$this->form_validation->set_rules('b_branch_address', 'Address', 'required');
		$this->form_validation->set_rules('b_branch_contact', 'Contact', 'required');
		$this->form_validation->set_rules('b_bank_swift_code', 'Swift Code', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'bank_id'	=>	$this->input->post('bank_id'),
				'location_id'	=>	$this->input->post('location_id'),
				'b_branch_code'	=>	$this->input->post('b_branch_code'),
				'b_branch_address'	=>	$this->input->post('b_branch_address'),
				'b_branch_contact'	=>	$this->input->post('b_branch_contact'),
				'b_bank_swift_code'	=>	$this->input->post('b_bank_swift_code'),
				'is_active_bank_b_branch' =>	$this->input->post('is_active_bank_b_branch')
			);

			$this->bank_branch_model->insert($data);

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
				'bank_id'	=>	form_error('bank_id'),
				'location_id'	=>	form_error('location_id'),
				'b_branch_code'	=>	form_error('b_branch_code'),
				'b_branch_address'	=>	form_error('b_branch_address'),
				'b_branch_contact'	=>	form_error('b_branch_contact'),
				'b_bank_swift_code'	=>	form_error('b_bank_swift_code')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->bank_branch_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->bank_branch_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->bank_branch_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->bank_branch_model->fetch_all_join();
		
		echo json_encode($data);
	}
	

	function update()
	{
		$this->form_validation->set_rules('b_branch_id', 'b branch', 'required');	
		$this->form_validation->set_rules('bank_id', 'Bank Id', 'required');	
		$this->form_validation->set_rules('location_id', 'Location', 'required');
		$this->form_validation->set_rules('b_branch_code', 'Branch Code', 'required');
		$this->form_validation->set_rules('b_branch_address', 'Address', 'required');
		$this->form_validation->set_rules('b_branch_contact', 'Contact', 'required');
		$this->form_validation->set_rules('b_bank_swift_code', 'Swift Code', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_bank_b_branch') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('b_branch_id')
					AND TABLE_SCHEMA='dcs_db'; 
					
				bank_account_details
				bank_branch	
					*/
					
				
			
				$status = 0;
				
				$status += ($this->bank_account_model->fetch_all_by_bank_branch_id($this->input->post('b_branch_id')))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Bank Branch is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'bank_id'	=>	$this->input->post('bank_id'),
						'location_id'	=>	$this->input->post('location_id'),
						'b_branch_code'	=>	$this->input->post('b_branch_code'),
						'b_branch_address'	=>	$this->input->post('b_branch_address'),
						'b_branch_contact'	=>	$this->input->post('b_branch_contact'),
						'b_bank_swift_code'	=>	$this->input->post('b_bank_swift_code'),
						'is_active_bank_b_branch'	=>	$this->input->post('is_active_bank_b_branch')
					);
					
					$this->bank_branch_model->update_single($this->input->post('b_branch_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'bank_id'	=>	$this->input->post('bank_id'),
					'b_branch_code'	=>	$this->input->post('b_branch_code'),
					'location_id'	=>	$this->input->post('location_id'),
					'b_branch_address'	=>	$this->input->post('b_branch_address'),
					'b_branch_contact'	=>	$this->input->post('b_branch_contact'),
					'b_bank_swift_code'	=>	$this->input->post('b_bank_swift_code'),
					'is_active_bank_b_branch'	=>	$this->input->post('is_active_bank_b_branch')
				);

				$this->bank_branch_model->update_single($this->input->post('b_branch_id'), $data);

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
			if($this->branch_model->delete_single($this->input->post('id')))
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
