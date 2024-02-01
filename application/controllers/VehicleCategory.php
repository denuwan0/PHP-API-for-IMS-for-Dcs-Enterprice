<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleCategory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('vehicle_category_model');
		$this->load->model('vehicle_details_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->vehicle_category_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('vehicle_category_name', 'Category Name', 'required');
		$this->form_validation->set_rules('vehicle_category_desc', 'Description', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'vehicle_category_name'	=>	$this->input->post('vehicle_category_name'),
				'vehicle_category_desc'	=>	$this->input->post('vehicle_category_desc'),
				'is_active_vhcl_cat' =>	$this->input->post('is_active_vhcl_cat')
			);

			$this->vehicle_category_model->insert($data);

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
				'vehicle_category_name'	=>	form_error('vehicle_category_name'),
				'vehicle_category_desc'	=>	form_error('vehicle_category_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->vehicle_category_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_category_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->vehicle_category_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->vehicle_category_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function update()
	{
		$this->form_validation->set_rules('vehicle_category_id', 'Vehicle Category Id', 'required');
		$this->form_validation->set_rules('vehicle_category_name', 'Category Name', 'required');
		$this->form_validation->set_rules('vehicle_category_desc', 'Description', 'required');
		
		//var_dump($_POST);
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_vhcl_cat') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('vehicle_category_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				vehicle_details */
			
				$status = 0;
				$status += ($this->vehicle_details_model->fetch_all_by_vehicle_category_id($this->input->post('vehicle_category_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Vehicle Category is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'vehicle_category_name'	=>	$this->input->post('vehicle_category_name'),
						'vehicle_category_desc'	=>	$this->input->post('vehicle_category_desc'),
						'is_active_vhcl_cat' =>	$this->input->post('is_active_vhcl_cat')
					);
					
					$this->vehicle_category_model->update_single($this->input->post('vehicle_category_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'vehicle_category_name'	=>	$this->input->post('vehicle_category_name'),
					'vehicle_category_desc'	=>	$this->input->post('vehicle_category_desc'),
					'is_active_vhcl_cat' =>	$this->input->post('is_active_vhcl_cat')
				);

				$this->vehicle_category_model->update_single($this->input->post('vehicle_category_id'), $data);

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
			if($this->vehicle_category_model->delete_single($this->input->post('id')))
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
