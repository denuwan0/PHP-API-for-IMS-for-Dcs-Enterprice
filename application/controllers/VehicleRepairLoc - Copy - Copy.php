<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleRepairLoc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_repair_location_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_repair_location_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('repair_loc_name', 'Location Name', 'required');
		$this->form_validation->set_rules('repair_loc_address', 'Address', 'required');
		$this->form_validation->set_rules('repair_loc_contact', 'Contact', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'repair_loc_name'	=>	$this->input->post('repair_loc_name'),
				'repair_loc_address'	=>	$this->input->post('repair_loc_address'),
				'repair_loc_contact' =>	$this->input->post('repair_loc_contact'),
				'is_active_vhcl_repair_loc'	=>	$this->input->post('is_active_vhcl_repair_loc')
			);

			$this->vehicle_repair_location_model->insert($data);

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
				'repair_loc_name'	=>	form_error('repair_loc_name'),
				'repair_loc_address'	=>	form_error('repair_loc_address'),
				'repair_loc_contact'	=>	form_error('repair_loc_contact')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_repair_location_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_repair_location_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_repair_location_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_repair_location_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->vehicle_repair_location_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('repair_loc_id', 'Location Id', 'required');
		$this->form_validation->set_rules('repair_loc_name', 'Location Name', 'required');
		$this->form_validation->set_rules('repair_loc_address', 'Address', 'required');
		$this->form_validation->set_rules('repair_loc_contact', 'Contact', 'required');
		
		//var_dump($_POST);
		
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_repair_loc') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				vehicle_revenue_licens*/
			
				$status = 0;
				//$status += ($this->vehicle_eco_test_model->fetch_all_by_vehicle_id($this->input->post('vehicle_id')))->num_rows();
									
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Repair Location is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'repair_loc_name'	=>	$this->input->post('repair_loc_name'),
						'repair_loc_address'	=>	$this->input->post('repair_loc_address'),
						'repair_loc_contact' =>	$this->input->post('repair_loc_contact'),
						'is_active_vhcl_repair_loc'	=>	$this->input->post('is_active_vhcl_repair_loc')	
					);
					
					$this->vehicle_repair_location_model->update_single($this->input->post('repair_loc_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'repair_loc_name'	=>	$this->input->post('repair_loc_name'),
					'repair_loc_address'	=>	$this->input->post('repair_loc_address'),
					'repair_loc_contact' =>	$this->input->post('repair_loc_contact'),
					'is_active_vhcl_repair_loc'	=>	$this->input->post('is_active_vhcl_repair_loc')				
				);

				$this->vehicle_repair_location_model->update_single($this->input->post('repair_loc_id'), $data);

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
			if($this->vehicle_repair_location_model->delete_single($this->input->post('id')))
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
