<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleInsuranceCompany extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_insuarance_company_model');
		$this->load->model('vehicle_insuarance_details_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_insuarance_company_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('insuar_comp_name', 'insuar_comp_name', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'insuar_comp_name'	=>	$this->input->post('insuar_comp_name'),
				'is_active_ins_comp'	=>	$this->input->post('is_active_ins_comp')
			);

			$this->vehicle_insuarance_company_model->insert($data);

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
				'insuar_comp_name'	=>	form_error('insuar_comp_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_insuarance_company_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_insuarance_company_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_insuarance_company_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_insuarance_company_model->fetch_all();
		
		echo json_encode($data);
	}
	
	
	function fetch_all_join()
	{	
		$data = $this->vehicle_insuarance_company_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('insuar_comp_id', 'insuar_comp_id', 'required');
		$this->form_validation->set_rules('insuar_comp_name', 'insuar_comp_name', 'required');
		
		//var_dump($_POST);
		
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_rev_lice') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('insuar_comp_id ')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				vehicle_revenue_licens*/
			
				$status = 0;
				$status += ($this->vehicle_insuarance_details_model->fetch_all_by_vehicle_id($this->input->post('insuar_comp_id')))->num_rows();
									
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Insurance Company is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'insuar_comp_id'	=>	$this->input->post('insuar_comp_id'),
						'insuar_comp_name'	=>	$this->input->post('insuar_comp_name'),
						'is_active_ins_comp'	=>	$this->input->post('is_active_ins_comp')
					);
					
					$this->vehicle_insuarance_company_model->update_single($this->input->post('insuar_comp_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'insuar_comp_id'	=>	$this->input->post('insuar_comp_id'),
					'insuar_comp_name'	=>	$this->input->post('insuar_comp_name'),
					'is_active_ins_comp'	=>	$this->input->post('is_active_ins_comp')
				);

				$this->vehicle_insuarance_company_model->update_single($this->input->post('insuar_comp_id'), $data);

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
				'insuar_comp_name'	=>	form_error('insuar_comp_name')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->vehicle_insuarance_company_model->delete_single($this->input->post('id')))
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
