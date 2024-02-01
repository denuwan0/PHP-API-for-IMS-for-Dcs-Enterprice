<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubItem extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_sub_item_model');
		$this->load->model('inventory_item_with_sub_items_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->inventory_sub_item_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{	
		$this->form_validation->set_rules('sub_item_name', 'Sub Item', 'required');
		$this->form_validation->set_rules('sub_item_category', 'Sub Item Category', 'required');
		
		if($this->form_validation->run())
		{
			
			$image_upload_path = "";
			
			if($_FILES['sub_item_image_url']['name'] != '' && ($_FILES['sub_item_image_url']['type'] == 'image/jpeg' || $_FILES['sub_item_image_url']['type'] == 'image/png')){
				$test = explode('.', $_FILES['sub_item_image_url']['name']);
				$extension = end($test);    
				$name = $_FILES['sub_item_image_url']['name'];
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/sub_items/'.$name;
				
				if(move_uploaded_file($_FILES['sub_item_image_url']['tmp_name'], $image_upload_path)){
					
					$sub_item_image_url = base_url().'assets/img/sub_items/'.$name;
				}
			}
			else{
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"]."/API/assets/img/download.png";
			}
			
			$data = array(
				'sub_item_name'	=>	$this->input->post('sub_item_name'),
				'sub_item_category'	=>	$this->input->post('sub_item_category'),
				'sub_item_image_url'	=>	$sub_item_image_url,
				'is_active_inv_sub_item' =>	$this->input->post('is_active_inv_sub_item')
			);

			$this->inventory_sub_item_model->insert($data);

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
				'sub_item_name'	=>	form_error('sub_item_name')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->inventory_sub_item_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_sub_item_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_sub_item_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->inventory_sub_item_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		//$this->form_validation->set_rules('line_id ', 'Line Id', 'required');
		$this->form_validation->set_rules('sub_item_id', 'Sub Item', 'required');
		$this->form_validation->set_rules('sub_item_name', 'Sub Item Name', 'required');
		$this->form_validation->set_rules('sub_item_category', 'Sub Item Category', 'required');
		
		if($this->form_validation->run())
		{	
			$image_upload_path = "";
			$sub_item_image_url = "";
				
			if($_FILES['sub_item_image_url']['name'] != '' && ($_FILES['sub_item_image_url']['type'] == 'image/jpeg' || $_FILES['sub_item_image_url']['type'] == 'image/png')){
				$test = explode('.', $_FILES['sub_item_image_url']['name']);
				$extension = end($test);    
				$name = $_FILES['sub_item_image_url']['name'];
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/sub_items/'.$name;
				
				if(move_uploaded_file($_FILES['sub_item_image_url']['tmp_name'], $image_upload_path)){					
					$sub_item_image_url = base_url().'assets/img/sub_items/'.$name;
				}
			}
			else{
				$sub_item_image_url = $this->input->post('old_image');
			}

	
			if($this->input->post('is_active_inv_sub_item') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('bank_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				bank
				bank_branch */
			
				$status = 0;
				$status += ($this->inventory_item_with_sub_items_model->fetch_all_by_sub_item_id($this->input->post('sub_item_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Sub Item is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'sub_item_name'	=>	$this->input->post('sub_item_name'),
						'is_active_inv_sub_item'	=>	$this->input->post('is_active_inv_sub_item')
					);
					
					$this->inventory_sub_item_model->update_single($this->input->post('sub_item_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'sub_item_name'	=>	$this->input->post('sub_item_name'),
					'is_active_inv_sub_item' =>	$this->input->post('is_active_inv_sub_item')
				);

				$this->inventory_sub_item_model->update_single($this->input->post('sub_item_id'), $data);

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
			if($this->inventory_sub_item_model->delete_single($this->input->post('id')))
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
	
	function fetch_all_join()
	{	
		$data = $this->inventory_sub_item_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
}
