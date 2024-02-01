<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleInsurance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_insuarance_details_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_insuarance_details_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('insuar_comp_id', 'insuar_comp_id', 'required');
		$this->form_validation->set_rules('insuarance_number', 'insuarance_number', 'required');
		$this->form_validation->set_rules('insuar_type', 'insuar_type', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid_from_date', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid_to_date', 'required');
		$this->form_validation->set_rules('premimum_amount', 'premimum_amount', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'insuar_comp_id'	=>	$this->input->post('insuar_comp_id'),
				'insuarance_number'	=>	$this->input->post('insuarance_number'),
				'insuar_type' =>	$this->input->post('insuar_type'),
				'valid_from_date'	=>	$this->input->post('valid_from_date'),
				'valid_to_date'	=>	$this->input->post('valid_to_date'),
				'premimum_amount'	=>	$this->input->post('premimum_amount'),
				'vehicle_id' =>	$this->input->post('vehicle_id'),
				'is_active_vhcl_ins_details'	=>	$this->input->post('is_active_vhcl_ins_details')
			);

			$this->vehicle_insuarance_details_model->insert($data);

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
				'insuar_comp_id'	=>	form_error('insuar_comp_id'),
				'insuarance_number'	=>	form_error('insuarance_number'),
				'insuar_type'	=>	form_error('insuar_type'),
				'valid_from_date'	=>	form_error('valid_from_date'),
				'valid_to_date'	=>	form_error('valid_to_date'),
				'premimum_amount'	=>	form_error('premimum_amount'),
				'vehicle_id'	=>	form_error('vehicle_id')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_insuarance_details_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_insuarance_details_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_insuarance_details_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_insuarance_details_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->vehicle_insuarance_details_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('insuar_detail_id', 'insuar_detail_id', 'required');
		$this->form_validation->set_rules('insuar_comp_id', 'insuar_comp_id', 'required');
		$this->form_validation->set_rules('insuarance_number', 'insuarance_number', 'required');
		$this->form_validation->set_rules('insuar_type', 'insuar_type', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid_from_date', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid_to_date', 'required');
		$this->form_validation->set_rules('premimum_amount', 'premimum_amount', 'required');
		$this->form_validation->set_rules('vehicle_id', 'vehicle_id', 'required');
		
		//var_dump($_POST);
		
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_ins_details') == 0){	
			
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
						'message'		=>	'Vehicle Insurance is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'insuar_comp_id'	=>	$this->input->post('insuar_comp_id'),
						'insuarance_number'	=>	$this->input->post('insuarance_number'),
						'insuar_type' =>	$this->input->post('insuar_type'),
						'valid_from_date'	=>	$this->input->post('valid_from_date'),
						'valid_to_date'	=>	$this->input->post('valid_to_date'),
						'premimum_amount'	=>	$this->input->post('premimum_amount'),
						'vehicle_id' =>	$this->input->post('vehicle_id'),
						'is_active_vhcl_ins_details'	=>	$this->input->post('is_active_vhcl_ins_details')
					);
					
					$this->vehicle_insuarance_details_model->update_single($this->input->post('insuar_detail_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'insuar_comp_id'	=>	$this->input->post('insuar_comp_id'),
					'insuarance_number'	=>	$this->input->post('insuarance_number'),
					'insuar_type' =>	$this->input->post('insuar_type'),
					'valid_from_date'	=>	$this->input->post('valid_from_date'),
					'valid_to_date'	=>	$this->input->post('valid_to_date'),
					'premimum_amount'	=>	$this->input->post('premimum_amount'),
					'vehicle_id' =>	$this->input->post('vehicle_id'),
					'is_active_vhcl_ins_details'	=>	$this->input->post('is_active_vhcl_ins_details')
				);

				$this->vehicle_insuarance_details_model->update_single($this->input->post('insuar_detail_id'), $data);

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
				'insuar_comp_id'	=>	form_error('insuar_comp_id'),
				'insuarance_number'	=>	form_error('insuarance_number'),
				'insuar_type'	=>	form_error('insuar_type'),
				'valid_from_date'	=>	form_error('valid_from_date'),
				'valid_to_date'	=>	form_error('valid_to_date'),
				'premimum_amount'	=>	form_error('premimum_amount'),
				'vehicle_id'	=>	form_error('vehicle_id')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->vehicle_insuarance_details_model->delete_single($this->input->post('id')))
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
