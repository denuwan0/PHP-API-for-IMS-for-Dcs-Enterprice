<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_details_model');
		$this->load->model('vehicle_eco_test_model');
		$this->load->model('vehicle_insuarance_details_model');
		$this->load->model('vehicle_repair_model');
		$this->load->model('vehicle_revenue_license_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_details_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('license_plate_no', 'Registered Name', 'required');
		$this->form_validation->set_rules('vehicle_yom', 'YOM', 'required');
		$this->form_validation->set_rules('vehicle_type_id', 'Type', 'required');
		$this->form_validation->set_rules('vehicle_category_id', 'Category', 'required');
		$this->form_validation->set_rules('chasis_no', 'Chasis No', 'required');
		$this->form_validation->set_rules('engine_no', 'Engine No', 'required');
		$this->form_validation->set_rules('number_of_passengers', 'No of Passengers', 'required');
		$this->form_validation->set_rules('max_load', 'Max Load', 'required');
		$this->form_validation->set_rules('branch_id', 'Branch Id', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'license_plate_no'	=>	$this->input->post('license_plate_no'),
				'vehicle_yom'	=>	$this->input->post('vehicle_yom'),
				'vehicle_type_id' =>	$this->input->post('vehicle_type_id'),
				'vehicle_category_id'	=>	$this->input->post('vehicle_category_id'),
				'chasis_no'	=>	$this->input->post('chasis_no'),
				'engine_no' =>	$this->input->post('engine_no'),
				'number_of_passengers'	=>	$this->input->post('number_of_passengers'),
				'max_load'	=>	$this->input->post('max_load'),
				'branch_id' =>	$this->input->post('branch_id'),
				'is_active_vhcl_details'	=>	$this->input->post('is_active_vhcl_details')
			);

			$this->vehicle_details_model->insert($data);

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
				'license_plate_no'	=>	form_error('license_plate_no'),
				'vehicle_yom'	=>	form_error('vehicle_yom'),
				'vehicle_type_id'	=>	form_error('vehicle_type_id'),
				'vehicle_category_id'	=>	form_error('vehicle_category_id'),
				'chasis_no'	=>	form_error('chasis_no'),
				'engine_no'	=>	form_error('engine_no'),
				'number_of_passengers'	=>	form_error('number_of_passengers'),
				'max_load'	=>	form_error('max_load'),
				'branch_id'	=>	form_error('branch_id')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_details_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_details_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_details_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_details_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->vehicle_details_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('license_plate_no', 'license_plate_no', 'required');
		$this->form_validation->set_rules('vehicle_yom', 'vehicle_yom', 'required');
		$this->form_validation->set_rules('vehicle_type_id', 'vehicle_type_id', 'required');
		$this->form_validation->set_rules('vehicle_category_id', 'vehicle_category_id', 'required');
		$this->form_validation->set_rules('chasis_no', 'chasis_no', 'required');
		$this->form_validation->set_rules('engine_no', 'engine_no', 'required');
		$this->form_validation->set_rules('number_of_passengers', 'number_of_passengers', 'required');
		$this->form_validation->set_rules('max_load', 'max_load', 'required');
		$this->form_validation->set_rules('branch_id', 'branch_id', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		
		//var_dump($_POST);
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_details') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				vehicle_details
				vehicle_eco_test
				vehicle_insuarance_details
				vehicle_repair
				vehicle_revenue_license
				vehicle_service_details */
			
				$status = 0;
				$status += ($this->vehicle_eco_test_model->fetch_all_by_vehicle_id($this->input->post('vehicle_id')))->num_rows();
				$status += ($this->vehicle_insuarance_details_model->fetch_all_by_vehicle_id($this->input->post('vehicle_id')))->num_rows();
				$status += ($this->vehicle_repair_model->fetch_all_by_vehicle_id($this->input->post('vehicle_id')))->num_rows();
				$status += ($this->vehicle_revenue_license_model->fetch_all_by_vehicle_id($this->input->post('vehicle_id')))->num_rows();
									
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Vehicle is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'license_plate_no'	=>	$this->input->post('license_plate_no'),
						'vehicle_yom'	=>	$this->input->post('vehicle_yom'),
						'vehicle_type_id' =>	$this->input->post('vehicle_type_id'),
						'vehicle_category_id'	=>	$this->input->post('vehicle_category_id'),
						'chasis_no'	=>	$this->input->post('chasis_no'),
						'engine_no' =>	$this->input->post('engine_no'),
						'number_of_passengers'	=>	$this->input->post('number_of_passengers'),
						'max_load'	=>	$this->input->post('max_load'),
						'branch_id' =>	$this->input->post('branch_id'),
						'is_active_vhcl_details'	=>	$this->input->post('is_active_vhcl_details')
					);
					
					$this->vehicle_details_model->update_single($this->input->post('vehicle_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'license_plate_no'	=>	$this->input->post('license_plate_no'),
					'vehicle_yom'	=>	$this->input->post('vehicle_yom'),
					'vehicle_type_id' =>	$this->input->post('vehicle_type_id'),
					'vehicle_category_id'	=>	$this->input->post('vehicle_category_id'),
					'chasis_no'	=>	$this->input->post('chasis_no'),
					'engine_no' =>	$this->input->post('engine_no'),
					'number_of_passengers'	=>	$this->input->post('number_of_passengers'),
					'max_load'	=>	$this->input->post('max_load'),
					'branch_id' =>	$this->input->post('branch_id'),
					'is_active_vhcl_details'	=>	$this->input->post('is_active_vhcl_details')
				);

				$this->vehicle_details_model->update_single($this->input->post('vehicle_id'), $data);

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
				'license_plate_no'	=>	form_error('license_plate_no'),
				'vehicle_yom'	=>	form_error('vehicle_yom'),
				'vehicle_type_id'	=>	form_error('vehicle_type_id'),
				'vehicle_category_id'	=>	form_error('vehicle_category_id'),
				'chasis_no'	=>	form_error('chasis_no'),
				'engine_no'	=>	form_error('engine_no'),
				'number_of_passengers'	=>	form_error('number_of_passengers'),
				'max_load'	=>	form_error('max_load'),
				'branch_id'	=>	form_error('branch_id')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->vehicle_details_model->delete_single($this->input->post('id')))
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
