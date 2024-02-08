<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryRentalInvoice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Inventory_rental_invoice_header_model');
		$this->load->model('Vehicle_service_details_model');
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Inventory_rental_invoice_header_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('service_center_id', 'service_center_id', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		$this->form_validation->set_rules('next_service_in_kms', 'next_service_in_kms', 'required');
		$this->form_validation->set_rules('next_service_in_months', 'next_service_in_months', 'required');
		$this->form_validation->set_rules('service_date', 'service_date', 'required');
		$this->form_validation->set_rules('service_invoice_number', 'service_invoice_number', 'required');
		$this->form_validation->set_rules('service_cost', 'service_cost', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('is_complete', 'is_complete', 'required');
		$this->form_validation->set_rules('is_active_vhcl_srv_detail', 'is_active_vhcl_srv_detail', 'required');
		
		if($this->form_validation->run())
		{
			$nextService_date = date('Y-m-d', strtotime("+".$this->input->post('next_service_in_months')." months", strtotime($this->input->post('service_date'))));
			$data = array(
				'service_center_id'	=>	$this->input->post('service_center_id'),
				'vehicle_id'	=>	$this->input->post('vehicle_id'),
				'next_service_in_kms' =>	$this->input->post('next_service_in_kms'),
				'next_service_in_months'	=>	$this->input->post('next_service_in_months'),
				'service_date'	=>	$this->input->post('service_date'),
				'next_service_date'	=>	$nextService_date,
				'service_invoice_number'	=>	$this->input->post('service_invoice_number'),
				'service_cost' =>	$this->input->post('service_cost'),
				'description'	=>	$this->input->post('description'),
				'is_complete' =>	$this->input->post('is_complete'),
				'is_active_vhcl_srv_detail'	=>	$this->input->post('is_active_vhcl_srv_detail')
			);

			$this->Inventory_rental_invoice_header_model->insert($data);

			$array = array(
				'success'		=>	true,
				'message'		=>	'Data Saved!'
			);
		}
		else
		{
			$nextService_date = date('Y-m-d', strtotime("+".$this->input->post('next_service_in_months')." months", strtotime($this->input->post('service_date'))));
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!',
				'service_center_id'	=>	form_error('service_center_id'),
				'vehicle_id'	=>	form_error('vehicle_id'),
				'next_service_in_kms'	=>	form_error('next_service_in_kms'),
				'next_service_in_months'	=>	form_error('next_service_in_months'),
				'service_date'	=>	form_error('service_date'),
				'service_invoice_number'	=>	form_error('service_invoice_number'),
				'service_cost'	=>	form_error('service_cost'),
				'description'	=>	form_error('description')
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
			$data = $this->Inventory_rental_invoice_header_model->fetch_all_active();
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->Inventory_rental_invoice_header_model->fetch_all_active_by_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_rental_invoice_header_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_all_join()
	{
		//echo $this->input->get('id');
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_rental_invoice_header_model->fetch_single_all_join($id);
			//var_dump($data);
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_rental_invoice_header_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->Inventory_rental_invoice_header_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->Inventory_rental_invoice_header_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
	function update()
	{
		$this->form_validation->set_rules('service_detail_id', 'service_detail_id', 'required');
		$this->form_validation->set_rules('service_center_id', 'service_center_id', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		$this->form_validation->set_rules('next_service_in_kms', 'next_service_in_kms', 'required');
		$this->form_validation->set_rules('next_service_in_months', 'next_service_in_months', 'required');
		$this->form_validation->set_rules('service_date', 'service_date', 'required');
		$this->form_validation->set_rules('service_invoice_number', 'service_invoice_number', 'required');
		$this->form_validation->set_rules('service_cost', 'service_cost', 'required');
		$this->form_validation->set_rules('description', 'description', 'required');
		$this->form_validation->set_rules('is_complete', 'is_complete', 'required');
		$this->form_validation->set_rules('is_active_vhcl_srv_detail', 'is_active_vhcl_srv_detail', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_srv_detail') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_id')
					AND TABLE_SCHEMA='dcs_db'; 
					
				vehicle_revenue_licens*/
			
				$status = 0;
				//$status += ($this->Inventory_rental_invoice_header_model->fetch_all_by_service_center_id($this->input->post('service_center_id')))->num_rows();
									
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Vehicle Service is being used by other modules at the moment!'
					);
				}
				else{
					$nextService_date = date('Y-m-d', strtotime("+".$this->input->post('next_service_in_months')." months", strtotime($this->input->post('service_date'))));
					$data = array(
						'service_detail_id'	=>	$this->input->post('service_detail_id'),
						'service_center_id'	=>	$this->input->post('service_center_id'),
						'vehicle_id' =>	$this->input->post('vehicle_id'),
						'next_service_in_kms'	=>	$this->input->post('next_service_in_kms'),
						'next_service_in_months'	=>	$this->input->post('next_service_in_months'),
						'service_date'	=>	$this->input->post('service_date'),
						'next_service_date'	=>	$nextService_date,
						'service_invoice_number' =>	$this->input->post('service_invoice_number'),
						'service_cost'	=>	$this->input->post('service_cost'),
						'description'	=>	$this->input->post('description'),
						'is_complete' =>	$this->input->post('is_complete'),
						'is_active_vhcl_srv_detail'	=>	$this->input->post('is_active_vhcl_srv_detail')
					);
					
					$this->Inventory_rental_invoice_header_model->update_single($this->input->post('service_detail_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$nextService_date = date('Y-m-d', strtotime("+".$this->input->post('next_service_in_months')." months", strtotime($this->input->post('service_date'))));
				$data = array(
						'service_detail_id'	=>	$this->input->post('service_detail_id'),
						'service_center_id'	=>	$this->input->post('service_center_id'),
						'vehicle_id' =>	$this->input->post('vehicle_id'),
						'next_service_in_kms'	=>	$this->input->post('next_service_in_kms'),
						'next_service_in_months'	=>	$this->input->post('next_service_in_months'),
						'service_date'	=>	$this->input->post('service_date'),
						'next_service_date'	=>	$nextService_date,
						'service_invoice_number' =>	$this->input->post('service_invoice_number'),
						'service_cost'	=>	$this->input->post('service_cost'),
						'description'	=>	$this->input->post('description'),
						'is_complete' =>	$this->input->post('is_complete'),
						'is_active_vhcl_srv_detail'	=>	$this->input->post('is_active_vhcl_srv_detail')
					);

				$this->Inventory_rental_invoice_header_model->update_single($this->input->post('service_detail_id'), $data);

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
				'message'		=>	'Error!',
				'service_detail_id'	=>	form_error('service_detail_id'),
				'service_center_id'	=>	form_error('service_center_id'),
				'vehicle_id'	=>	form_error('vehicle_id'),
				'next_service_in_kms'	=>	form_error('next_service_in_kms'),
				'next_service_in_months'	=>	form_error('next_service_in_months'),
				'service_date'	=>	form_error('service_date'),
				'service_invoice_number'	=>	form_error('service_invoice_number'),
				'service_cost'	=>	form_error('service_cost'),
				'description'	=>	form_error('description')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->Inventory_rental_invoice_header_model->delete_single($this->input->post('id')))
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
