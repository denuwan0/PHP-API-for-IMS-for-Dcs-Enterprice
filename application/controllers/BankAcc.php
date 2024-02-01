<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankAcc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bank_account_model');
		$this->load->model('bank_deposit_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->bank_account_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('account_no', 'Account No', 'required');		
		$this->form_validation->set_rules('account_name', 'Account Name', 'required');
		$this->form_validation->set_rules('b_branch_id', 'Branch', 'required');
		$this->form_validation->set_rules('contact_no', 'Contact', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'account_no'	=>	$this->input->post('account_no'),
				'account_name'	=>	$this->input->post('account_name'),
				'b_branch_id'	=>	$this->input->post('b_branch_id'),
				'contact_no'	=>	$this->input->post('contact_no'),
				'is_active_bank_acc' =>	$this->input->post('is_active_bank_acc')
			);

			$this->bank_account_model->insert($data);

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
				'account_no'	=>	form_error('account_no'),
				'account_name'	=>	form_error('account_name'),
				'b_branch_id'	=>	form_error('b_branch_id'),
				'contact_no'	=>	form_error('contact_no')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->bank_account_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->bank_account_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->bank_account_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->bank_account_model->fetch_all_join();
		
		echo json_encode($data);
	}
		

	function update()
	{
		$this->form_validation->set_rules('account_id', 'Acc Id', 'required');	
		$this->form_validation->set_rules('account_no', 'Acc No', 'required');	
		$this->form_validation->set_rules('account_name', 'Acc Name', 'required');
		$this->form_validation->set_rules('b_branch_id', 'Branch Id', 'required');
		$this->form_validation->set_rules('contact_no', 'Contact', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_bank_acc') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('account_id')
					AND TABLE_SCHEMA='dcs_db'; 
					
				bank_deposit	
					*/
									
			
				$status = 0;
				$status += ($this->bank_deposit_model->fetch_all_by_b_account_id($this->input->post('account_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Bank Account is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'account_id'	=>	$this->input->post('account_id'),
						'account_no'	=>	$this->input->post('account_no'),
						'account_name'	=>	$this->input->post('account_name'),
						'b_branch_id'	=>	$this->input->post('b_branch_id'),
						'contact_no'	=>	$this->input->post('contact_no'),
						'is_active_bank_acc'	=>	$this->input->post('is_active_bank_acc')
					);
					
					$this->bank_account_model->update_single($this->input->post('account_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'account_id'	=>	$this->input->post('account_id'),
					'account_no'	=>	$this->input->post('account_no'),
					'account_name'	=>	$this->input->post('account_name'),
					'b_branch_id'	=>	$this->input->post('b_branch_id'),
					'contact_no'	=>	$this->input->post('contact_no'),
					'is_active_bank_acc'	=>	$this->input->post('is_active_bank_acc')
				);

				$this->bank_account_model->update_single($this->input->post('account_id'), $data);

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
			if($this->bank_account_model->delete_single($this->input->post('id')))
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
