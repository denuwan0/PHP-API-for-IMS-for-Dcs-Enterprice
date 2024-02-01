<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemSubCategory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_item_category_model');
		$this->load->model('inventory_item_sub_category_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->inventory_item_sub_category_model->fetch_all_join();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('item_category_id', 'Item Category', 'required');
		$this->form_validation->set_rules('sub_cat_name', 'Sub Categry Name', 'required');
		$this->form_validation->set_rules('sub_cat_description', 'Sub Categry Description', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'item_category_id'	=>	$this->input->post('item_category_id'),
				'sub_cat_name'	=>	$this->input->post('sub_cat_name'),
				'sub_cat_description'	=>	$this->input->post('sub_cat_description'),
				'is_active_inv_item_sub_cat' =>	$this->input->post('is_active_inv_item_sub_cat')
			);

			$this->inventory_item_sub_category_model->insert($data);

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
				'item_category_id'	=>	form_error('item_category_id'),
				'sub_cat_name'	=>	form_error('sub_cat_name'),
				'sub_cat_description'	=>	form_error('sub_cat_description')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->inventory_item_sub_category_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_sub_category_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_sub_category_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->inventory_item_sub_category_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('item_sub_cat_id', 'Item Sub Category Id', 'required');
		$this->form_validation->set_rules('item_category_id', 'Item Category', 'required');
		$this->form_validation->set_rules('sub_cat_name', 'Sub Categry Name', 'required');
		$this->form_validation->set_rules('sub_cat_description', 'Sub Categry Description', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_inv_item_sub_cat') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('bank_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				bank
				bank_branch */
			
				$status = 0;
				//$status += ($this->bank_branch_model->fetch_all_by_bank_id($this->input->post('bank_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Item Sub Category is being used by other modules at the moment!'
					);
				}
				else{
					
					$data = array(
						'item_category_id'	=>	$this->input->post('item_category_id'),
						'sub_cat_name'	=>	$this->input->post('sub_cat_name'),
						'sub_cat_description'	=>	$this->input->post('sub_cat_description'),
						'is_active_inv_item_sub_cat' =>	$this->input->post('is_active_inv_item_sub_cat')
					);
										
					$this->inventory_item_sub_category_model->update_single($this->input->post('item_sub_cat_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'item_category_id'	=>	$this->input->post('item_category_id'),
					'sub_cat_name'	=>	$this->input->post('sub_cat_name'),
					'sub_cat_description'	=>	$this->input->post('sub_cat_description'),
					'is_active_inv_item_sub_cat' =>	$this->input->post('is_active_inv_item_sub_cat')
				);

				$this->inventory_item_sub_category_model->update_single($this->input->post('item_sub_cat_id'), $data);

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
			if($this->inventory_item_sub_category_model->delete_single($this->input->post('id')))
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
