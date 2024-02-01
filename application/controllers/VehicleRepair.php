<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleRepair extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_repair_model');
		$this->load->model('vehicle_insuarance_claim_details_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_repair_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('repair_invoice_number', 'repair_invoice_number', 'required');
		$this->form_validation->set_rules('repair_description', 'repair_description', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		$this->form_validation->set_rules('start_date', 'start_date', 'required');
		$this->form_validation->set_rules('end_date', 'end_date', 'required');
		$this->form_validation->set_rules('repair_type', 'repair_type', 'required');
		$this->form_validation->set_rules('repair_location', 'repair_location', 'required');
		$this->form_validation->set_rules('repair_cost', 'repair_cost', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'repair_invoice_number'	=>	$this->input->post('repair_invoice_number'),
				'repair_description'	=>	$this->input->post('repair_description'),
				'vehicle_id' =>	$this->input->post('vehicle_id'),
				'start_date'	=>	$this->input->post('start_date'),
				'end_date'	=>	$this->input->post('end_date'),
				'repair_type'	=>	$this->input->post('repair_type'),
				'repair_location' =>	$this->input->post('repair_location'),
				'repair_cost'	=>	$this->input->post('repair_cost'),
				'is_active_vhcl_repair'	=>	$this->input->post('is_active_vhcl_repair'),
				'is_complete'	=>	0
			);

			$this->vehicle_repair_model->insert($data);

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
				'repair_invoice_number'	=>	form_error('repair_invoice_number'),
				'repair_description'	=>	form_error('repair_description'),
				'vehicle_id'	=>	form_error('vehicle_id'),
				'start_date'	=>	form_error('start_date'),
				'end_date'	=>	form_error('end_date'),
				'repair_type'	=>	form_error('repair_type'),
				'repair_location'	=>	form_error('repair_location'),
				'repair_cost'	=>	form_error('repair_cost')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_repair_model->fetch_all_active_and_complete_join();
		echo json_encode($data);
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_repair_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_repair_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_repair_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->vehicle_repair_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('repair_invoice_number', 'repair_invoice_number', 'required');
		$this->form_validation->set_rules('repair_description', 'repair_description', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		$this->form_validation->set_rules('start_date', 'start_date', 'required');
		$this->form_validation->set_rules('end_date', 'end_date', 'required');
		$this->form_validation->set_rules('repair_type', 'repair_type', 'required');
		$this->form_validation->set_rules('repair_location', 'repair_location', 'required');
		$this->form_validation->set_rules('repair_cost', 'repair_cost', 'required');
		$this->form_validation->set_rules('repair_id', 'repair_id', 'required');
		
		//var_dump($_POST);
		
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_repair') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				vehicle_revenue_licens*/
			
				$status = 0;
				$status += ($this->vehicle_insuarance_claim_details_model->fetch_all_by_repair_id($this->input->post('repair_id')))->num_rows();
									
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Vehicle Repair is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'repair_invoice_number'	=>	$this->input->post('repair_invoice_number'),
						'repair_description'	=>	$this->input->post('repair_description'),
						'vehicle_id' =>	$this->input->post('vehicle_id'),
						'start_date'	=>	$this->input->post('start_date'),
						'end_date'	=>	$this->input->post('end_date'),
						'repair_type'	=>	$this->input->post('repair_type'),
						'repair_location' =>	$this->input->post('repair_location'),
						'repair_cost'	=>	$this->input->post('repair_cost'),
						'is_active_vhcl_repair'	=>	$this->input->post('is_active_vhcl_repair'),
						'is_complete'	=>	$this->input->post('is_complete')
					);
					
					$this->vehicle_repair_model->update_single($this->input->post('repair_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'repair_invoice_number'	=>	$this->input->post('repair_invoice_number'),
					'repair_description'	=>	$this->input->post('repair_description'),
					'vehicle_id' =>	$this->input->post('vehicle_id'),
					'start_date'	=>	$this->input->post('start_date'),
					'end_date'	=>	$this->input->post('end_date'),
					'repair_type'	=>	$this->input->post('repair_type'),
					'repair_location' =>	$this->input->post('repair_location'),
					'repair_cost'	=>	$this->input->post('repair_cost'),
					'is_active_vhcl_repair'	=>	$this->input->post('is_active_vhcl_repair'),
					'is_complete'	=>	$this->input->post('is_complete')
				);

				$this->vehicle_repair_model->update_single($this->input->post('repair_id'), $data);

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
				'repair_loc_id'	=>	form_error('repair_loc_id'),
				'repair_loc_name'	=>	form_error('repair_loc_name'),
				'repair_loc_address'	=>	form_error('repair_loc_address'),
				'repair_loc_contact'	=>	form_error('repair_loc_contact')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->vehicle_repair_model->delete_single($this->input->post('id')))
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
