<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->customer_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('customer_name', 'customer_name', 'required');		
		$this->form_validation->set_rules('customer_working_address', 'customer_working_address', 'required');
		$this->form_validation->set_rules('customer_shipping_address', 'customer_shipping_address', 'required');
		$this->form_validation->set_rules('customer_old_nic_no', 'customer_old_nic_no', 'required');
		$this->form_validation->set_rules('customer_contact_no', 'customer_contact_no', 'required');
		$this->form_validation->set_rules('customer_email', 'customer_email', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'customer_name'	=>	$this->input->post('customer_name'),
				'customer_working_address'	=>	$this->input->post('customer_working_address'),
				'customer_shipping_address'	=>	$this->input->post('customer_shipping_address'),
				'customer_old_nic_no'	=>	$this->input->post('customer_old_nic_no'),
				'customer_contact_no'	=>	$this->input->post('customer_contact_no'),
				'customer_email'	=>	$this->input->post('customer_email'),
				'is_web' =>	$this->input->post('is_web'),
				'is_active_customer' =>	$this->input->post('is_active_customer')
			);

			$this->customer_model->insert($data);

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
				'customer_name'	=>	form_error('customer_name'),
				'customer_working_address'	=>	form_error('customer_working_address'),
				'customer_shipping_address'	=>	form_error('customer_shipping_address'),
				'customer_old_nic_no'	=>	form_error('customer_old_nic_no'),
				'customer_contact_no'	=>	form_error('customer_contact_no'),
				'customer_email'	=>	form_error('customer_email')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		
		
		/* $sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->customer_model->fetch_all_active();
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->customer_model->fetch_all_active_by_emp_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		} */
		
		$data = $this->customer_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->customer_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_by_nic()
	{
		
		if($this->input->get('nic'))
		{			
			$id = $this->input->get('nic');
			$data = $this->customer_model->fetch_single_by_nic($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->customer_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->customer_model->fetch_all();
		
		echo json_encode($data->result_array());
	}

	function update()
	{
		$this->form_validation->set_rules('customer_id', 'customer_id', 'required');	
		$this->form_validation->set_rules('customer_name', 'customer_name', 'required');		
		$this->form_validation->set_rules('customer_working_address', 'customer_working_address', 'required');
		$this->form_validation->set_rules('customer_shipping_address', 'customer_shipping_address', 'required');
		$this->form_validation->set_rules('customer_old_nic_no', 'customer_old_nic_no', 'required');
		$this->form_validation->set_rules('customer_contact_no', 'customer_contact_no', 'required');
		$this->form_validation->set_rules('customer_email', 'customer_email', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_customer') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('customer_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				inventory_rental_invoice_header
				inventory_retail_invoice_header
				online_shopping_kart_header 
				
				since these are historical data tables not going to check*/
			
				$status = 0;
				//$status += ($this->bank_deposit_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Customer is being used by other modules at the moment!'
					);
				}
				else{
					
					$data = array(
						'customer_id'	=>	$this->input->post('customer_id'),
						'customer_name'	=>	$this->input->post('customer_name'),
						'customer_working_address'	=>	$this->input->post('customer_working_address'),
						'customer_shipping_address'	=>	$this->input->post('customer_shipping_address'),
						'customer_old_nic_no'	=>	$this->input->post('customer_old_nic_no'),
						'customer_contact_no'	=>	$this->input->post('customer_contact_no'),
						'customer_email'	=>	$this->input->post('customer_email'),
						'is_web' =>	$this->input->post('is_web'),
						'is_active_customer' =>	$this->input->post('is_active_customer')
					);
					
					$this->customer_model->update_single($this->input->post('customer_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'customer_id'	=>	$this->input->post('customer_id'),
					'customer_name'	=>	$this->input->post('customer_name'),
					'customer_working_address'	=>	$this->input->post('customer_working_address'),
					'customer_shipping_address'	=>	$this->input->post('customer_shipping_address'),
					'customer_old_nic_no'	=>	$this->input->post('customer_old_nic_no'),
					'customer_contact_no'	=>	$this->input->post('customer_contact_no'),
					'customer_email'	=>	$this->input->post('customer_email'),
					'is_web' =>	$this->input->post('is_web'),
					'is_active_customer' =>	$this->input->post('is_active_customer')
				);

				$this->customer_model->update_single($this->input->post('customer_id'), $data);

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
			if($this->customer_model->delete_single($this->input->post('id')))
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
