<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleServiceCenter extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Vehicle_service_center_model');
		$this->load->model('Vehicle_service_details_model');
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Vehicle_service_center_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('service_center_name', 'service_center_name', 'required');
		$this->form_validation->set_rules('service_center_contact', 'service_center_contact', 'required');
		$this->form_validation->set_rules('service_center_address', 'service_center_address', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'service_center_name'	=>	$this->input->post('service_center_name'),
				'service_center_contact'	=>	$this->input->post('service_center_contact'),
				'service_center_address' =>	$this->input->post('service_center_address'),
				'is_active_vhcl_srv_cntr'	=>	$this->input->post('is_active_vhcl_srv_cntr')
			);

			$this->Vehicle_service_center_model->insert($data);

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
				'service_center_name'	=>	form_error('service_center_name'),
				'service_center_contact'	=>	form_error('service_center_contact'),
				'service_center_address'	=>	form_error('service_center_address')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Vehicle_service_center_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Vehicle_service_center_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Vehicle_service_center_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->Vehicle_service_center_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$data = $this->Vehicle_service_center_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('service_center_id', 'service_center_id', 'required');
		$this->form_validation->set_rules('service_center_name', 'service_center_name', 'required');
		$this->form_validation->set_rules('service_center_contact', 'service_center_contact', 'required');
		$this->form_validation->set_rules('service_center_address', 'service_center_address', 'required');
		
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_srv_cntr') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				vehicle_revenue_licens*/
			
				$status = 0;
				$status += ($this->Vehicle_service_details_model->fetch_all_by_service_center_id($this->input->post('service_center_id')))->num_rows();
									
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Service Center is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'service_center_name'	=>	$this->input->post('service_center_name'),
						'service_center_contact'	=>	$this->input->post('service_center_contact'),
						'service_center_address' =>	$this->input->post('service_center_address'),
						'is_active_vhcl_srv_cntr'	=>	$this->input->post('is_active_vhcl_srv_cntr')
					);
					
					$this->Vehicle_service_center_model->update_single($this->input->post('service_center_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'service_center_name'	=>	$this->input->post('service_center_name'),
					'service_center_contact'	=>	$this->input->post('service_center_contact'),
					'service_center_address' =>	$this->input->post('service_center_address'),
					'is_active_vhcl_srv_cntr'	=>	$this->input->post('is_active_vhcl_srv_cntr')
				);

				$this->Vehicle_service_center_model->update_single($this->input->post('service_center_id'), $data);

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
				'service_center_id'	=>	form_error('service_center_id'),
				'service_center_name'	=>	form_error('service_center_name'),
				'service_center_contact'	=>	form_error('service_center_contact'),
				'service_center_address'	=>	form_error('service_center_address')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->Vehicle_service_center_model->delete_single($this->input->post('id')))
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
