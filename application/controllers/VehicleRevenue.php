<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleRevenue extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_revenue_license_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_revenue_license_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('rev_license_no', 'Revenue License No', 'required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
		$this->form_validation->set_rules('valid_from_date', 'Date from', 'required');
		$this->form_validation->set_rules('valid_to_date', 'Date to', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'rev_license_no'	=>	$this->input->post('rev_license_no'),
				'vehicle_id'	=>	$this->input->post('vehicle_id'),
				'valid_from_date' =>	$this->input->post('valid_from_date'),
				'valid_to_date'	=>	$this->input->post('valid_to_date'),
				'is_active_vhcl_rev_lice'	=>	$this->input->post('is_active_vhcl_rev_lice')
			);

			$this->vehicle_revenue_license_model->insert($data);

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
				'rev_license_no'	=>	form_error('rev_license_no'),
				'vehicle_id'	=>	form_error('vehicle_id'),
				'valid_from_date'	=>	form_error('valid_from_date'),
				'valid_to_date'	=>	form_error('valid_to_date')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_revenue_license_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_revenue_license_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_revenue_license_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_revenue_license_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->vehicle_revenue_license_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('rev_license_id', 'Revenue License Id', 'required');
		$this->form_validation->set_rules('rev_license_no', 'Revenue License No', 'required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
		$this->form_validation->set_rules('valid_from_date', 'Date from', 'required');
		$this->form_validation->set_rules('valid_to_date', 'Date to', 'required');
		
		//var_dump($_POST);
		
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_rev_lice') == 0){	
			
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
						'message'		=>	'License is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'rev_license_no'	=>	$this->input->post('rev_license_no'),
						'vehicle_id'	=>	$this->input->post('vehicle_id'),
						'valid_from_date' =>	$this->input->post('valid_from_date'),
						'valid_to_date'	=>	$this->input->post('valid_to_date'),
						'is_active_vhcl_rev_lice'	=>	$this->input->post('is_active_vhcl_rev_lice')
					);
					
					$this->vehicle_revenue_license_model->update_single($this->input->post('rev_license_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'rev_license_no'	=>	$this->input->post('rev_license_no'),
					'vehicle_id'	=>	$this->input->post('vehicle_id'),
					'valid_from_date' =>	$this->input->post('valid_from_date'),
					'valid_to_date'	=>	$this->input->post('valid_to_date')					
				);

				$this->vehicle_revenue_license_model->update_single($this->input->post('rev_license_id'), $data);

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
				'rev_license_no'	=>	form_error('rev_license_no'),
				'vehicle_id'	=>	form_error('vehicle_id'),
				'valid_from_date'	=>	form_error('valid_from_date'),
				'valid_to_date'	=>	form_error('valid_to_date')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->vehicle_revenue_license_model->delete_single($this->input->post('id')))
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
