<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('branch_model');
		$this->load->model('bank_deposit_model');
		$this->load->model('inventory_invoice_hdr_model');
		$this->load->model('inventory_rental_invoice_header_model');
		$this->load->model('inventory_retail_invoice_header_model');
		$this->load->model('inventory_stock_rental_header_model');
		$this->load->model('Inventory_stock_retail_header_model');
		$this->load->model('vehicle_details_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->branch_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('company_id', 'Company', 'required');		
		$this->form_validation->set_rules('company_branch_name', 'Name', 'required');
		$this->form_validation->set_rules('location_id', 'Location', 'required');
		$this->form_validation->set_rules('branch_contact', 'Contact', 'required');
		$this->form_validation->set_rules('branch_manager', 'Manager', 'required');
		$this->form_validation->set_rules('branch_address', 'Address', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'company_id'	=>	$this->input->post('company_id'),
				'company_branch_name'	=>	$this->input->post('company_branch_name'),
				'location_id'	=>	$this->input->post('location_id'),
				'branch_contact'	=>	$this->input->post('branch_contact'),
				'branch_manager'	=>	$this->input->post('branch_manager'),
				'branch_address'	=>	$this->input->post('branch_address'),
				'is_active_branch' =>	$this->input->post('is_active_branch')
			);

			$this->branch_model->insert($data);

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
				'company_branch_name'	=>	form_error('company_branch_name'),
				'location_id'	=>	form_error('location_id'),
				'branch_contact'	=>	form_error('branch_contact'),
				'branch_manager'	=>	form_error('branch_manager'),
				'branch_address'	=>	form_error('branch_address')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->branch_model->fetch_all_active();
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->branch_model->fetch_all_active_by_emp_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
		
	}
	
	function fetch_all_active_other_branches()
	{		
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		$data = $this->branch_model->fetch_all_active_other_branches_by_emp_branch_id($emp_branch_id);
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->branch_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->branch_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->branch_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('company_id', 'Company', 'required');	
		$this->form_validation->set_rules('company_branch_id', 'Branch Id', 'required');	
		$this->form_validation->set_rules('company_branch_name', 'Name', 'required');
		$this->form_validation->set_rules('location_id', 'Location', 'required');
		$this->form_validation->set_rules('branch_contact', 'Contact', 'required');
		$this->form_validation->set_rules('branch_manager', 'Manager', 'required');
		$this->form_validation->set_rules('branch_address', 'Address', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_branch') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('branch_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				bank_deposit
				inventory_invoice_hdr
				inventory_rental_invoice_header
				inventory_retail_invoice_header
				inventory_stock_rental
				inventory_stock_retail
				vehicle_details */
			
				$status = 0;
				$status += ($this->bank_deposit_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				$status += ($this->inventory_invoice_hdr_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				$status += ($this->inventory_rental_invoice_header_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				$status += ($this->inventory_retail_invoice_header_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				$status += ($this->inventory_stock_rental_header_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				$status += ($this->Inventory_stock_retail_header_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
				$status += ($this->vehicle_details_model->fetch_all_by_branch_id($this->input->post('company_branch_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Branch is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'company_id'	=>	$this->input->post('company_id'),
						'company_branch_name'	=>	$this->input->post('company_branch_name'),
						'location_id'	=>	$this->input->post('location_id'),
						'branch_contact'	=>	$this->input->post('branch_contact'),
						'branch_manager'	=>	$this->input->post('branch_manager'),
						'branch_address'	=>	$this->input->post('branch_address'),
						'is_active_branch'	=>	$this->input->post('is_active_branch')
					);
					
					$this->branch_model->update_single($this->input->post('company_branch_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'company_id'	=>	$this->input->post('company_id'),
					'company_branch_name'	=>	$this->input->post('company_branch_name'),
					'location_id'	=>	$this->input->post('location_id'),
					'branch_contact'	=>	$this->input->post('branch_contact'),
					'branch_manager'	=>	$this->input->post('branch_manager'),
					'branch_address'	=>	$this->input->post('branch_address'),
					'is_active_branch'	=>	$this->input->post('is_active_branch')
				);

				$this->branch_model->update_single($this->input->post('company_branch_id'), $data);

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
