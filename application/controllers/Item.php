<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_item_model');
		$this->load->model('inventory_rental_invoice_detail_model');
		$this->load->model('inventory_retail_invoice_detail_model');
		$this->load->model('inventory_stock_rental_detail_model');
		$this->load->model('Inventory_stock_retail_detail_model');
		$this->load->model('inventory_sub_item_model');
		$this->load->model('online_buying_pattern_detail_model');
		$this->load->model('online_shopping_kart_detail_model');
		$this->load->model('online_special_offers_model');
		$this->load->model('Inventory_retail_total_stock_model');
		
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		/* if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} */
		
	}

	function index()
	{
		$data = $this->inventory_item_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('item_name', 'Name', 'required');
		$this->form_validation->set_rules('item_category', 'Name', 'required');
		
		if($this->form_validation->run())
		{
			$image_upload_path = "";
			
			if($_FILES['item_image_url']['name'] != '' && ($_FILES['item_image_url']['type'] == 'image/jpeg' || $_FILES['item_image_url']['type'] == 'image/png')){
				$test = explode('.', $_FILES['item_image_url']['name']);
				$extension = end($test);    
				$name = $_FILES['item_image_url']['name'];
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/items/'.$name;
				
				if(move_uploaded_file($_FILES['item_image_url']['tmp_name'], $image_upload_path)){
					
					$item_image_url = base_url().'assets/img/items/'.$name;
				}
			}
			else{
				$image_upload_path = $_SERVER["DOCUMENT_ROOT"]."/API/assets/img/download.png";
			}
			
			$data = array(
				'item_name'	=>	$this->input->post('item_name'),
				'item_category'	=>	$this->input->post('item_category'),
				'item_image_url'	=>	$item_image_url,
				'is_active_inv_item' =>	$this->input->post('is_active_inv_item'),
				'is_feature' =>	$this->input->post('is_feature')
			);

			$this->inventory_item_model->insert($data);

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
				'item_name'	=>	form_error('item_name'),
				'item_category'	=>	form_error('item_category')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->inventory_item_model->fetch_all_active();
		echo json_encode($data->result_array());
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_item_model->fetch_single_join($id);
			
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_single_join_for_web()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_retail_total_stock_model->fetch_item_detail_for_shopping_web($id);
			
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_all()
	{	
		$data = $this->inventory_item_model->fetch_all();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('item_id', 'Item Id', 'required');
		$this->form_validation->set_rules('item_name', 'Name', 'required');
		$this->form_validation->set_rules('item_category', 'Name', 'required');
		
		
		if($this->form_validation->run())
		{	

		$image_upload_path = "";
		$item_image_url = "";
			
		if(isset($_FILES['item_image_url']['name']) && $_FILES['item_image_url']['name'] != '' && ($_FILES['item_image_url']['type'] == 'image/jpeg' || $_FILES['item_image_url']['type'] == 'image/png')){
			$test = explode('.', $_FILES['item_image_url']['name']);
			$extension = end($test);    
			$name = $_FILES['item_image_url']['name'];
			$image_upload_path = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/items/'.$name;
			
			if(move_uploaded_file($_FILES['item_image_url']['tmp_name'], $image_upload_path)){
				
				$item_image_url = base_url().'assets/img/items/'.$name;
			}
		}
		else{
			$item_image_url = $this->input->post('old_image');
		}
	
			if($this->input->post('is_active_inv_item') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('item_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				bank
				bank_branch */
			
				$status = 0;
				$status += ($this->inventory_rental_invoice_detail_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				$status += ($this->inventory_retail_invoice_detail_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				$status += ($this->inventory_stock_rental_detail_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				$status += ($this->Inventory_stock_retail_detail_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				//$status += ($this->inventory_sub_item_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				$status += ($this->online_buying_pattern_detail_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				$status += ($this->online_shopping_kart_detail_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
				$status += ($this->online_special_offers_model->fetch_all_by_item_id($this->input->post('item_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Item is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'item_name'	=>	$this->input->post('item_name'),
						'item_category'	=>	$this->input->post('item_category'),
						'item_image_url'	=>	$item_image_url,
						'is_active_inv_item' =>	$this->input->post('is_active_inv_item'),
						'is_feature' =>	$this->input->post('is_feature')
					);
					
					$this->inventory_item_model->update_single($this->input->post('item_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				
				
				$data = array(
					'item_name'	=>	$this->input->post('item_name'),
					'item_category'	=>	$this->input->post('item_category'),
					'item_image_url'	=>	$item_image_url,
					'is_active_inv_item' =>	$this->input->post('is_active_inv_item'),
					'is_feature' =>	$this->input->post('is_feature')
				);

				$this->inventory_item_model->update_single($this->input->post('item_id'), $data);

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
			if($this->bank_model->delete_single($this->input->post('id')))
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
		$data = $this->inventory_item_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
	function fetch_all_main_sub_item_by_category_id()
	{	
	
	
		if($this->input->get('id'))
		{
			$data = $this->inventory_item_model->fetch_all_active_items_by_category_id($this->input->get('id'));
			//$mainItems = $mainItems->result_array();
			
			//var_dump(array_merge($mainItems,$subItems));
			echo json_encode($data);
		}
		
	}
	
	function fetch_all_items_by_category_id()
	{	
	
	
		if($this->input->get('id'))
		{
			$data = $this->inventory_item_model->fetch_all_active_items_by_category_id_for_pos($this->input->get('id'));
			//$mainItems = $mainItems->result_array();
			
			//var_dump(array_merge($mainItems,$subItems));
			echo json_encode($data);
		}
		
	}
	
}
