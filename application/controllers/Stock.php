<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_stock_purchase_header_model');
		$this->load->model('inventory_stock_purchase_detail_model');
		$this->load->model('inventory_stock_retail_header_model');
		$this->load->model('inventory_stock_rental_header_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->inventory_stock_purchase_header_model->fetch_all_header();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{				
		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$itemArray = array();
		$itemArray = $phparray["itemsArr"];
		
		if($phparray["stockHeader"][0]->stock_purchase_date != '' )
		{
			$data = array(
				'stock_purchase_date'	=>	$phparray["stockHeader"][0]->stock_purchase_date,
				'is_allocated_stock' =>	0,
				'is_approved_stock' =>	0,
				'created_by' =>	$this->session->userdata('user_id'),
				'branch_id' =>	$this->session->userdata('emp_branch_id'),
				'is_allocated_stock' =>	0,
				'is_approved_stock' =>	0,
				'is_active_stock_purchase' =>	1
			);

			$header_id = $this->inventory_stock_purchase_header_model->insert($data);
			
			if($header_id){
				//$itemData = array();
				foreach($phparray["itemsArr"] as $value){
					//var_dump($value);
					
					if($value->item_type == 'main_item_id'){
						$itemData = array(
							'stock_batch_id' =>	$header_id,
							'item_id' =>	$value->item_id,							
							'item_cost' => $value->item_cost,
							'no_of_items' =>	$value->no_of_items,
							'allocated_no_of_items' =>	0,
							'available_no_of_items' =>	$value->no_of_items,
							'is_sub_item' =>	0
						);
					}
					if($value->item_type == 'sub_item_id'){
						$itemData = array(
							'stock_batch_id' =>	$header_id,
							'item_id' =>	$value->item_id,
							'item_cost' => $value->item_cost,
							'no_of_items' =>	$value->no_of_items,
							'allocated_no_of_items' =>	0,
							'available_no_of_items' =>	$value->no_of_items,
							'is_sub_item' =>	1
						);
					}			
					
					
					$this->inventory_stock_purchase_detail_model->insert($itemData);
				}
				
			}

			$array = array(
				'success'		=>	true,
				'message'		=>	'Data Saved!'
			);
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!'
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->inventory_stock_purchase_header_model->fetch_all_active();
		echo json_encode($data->result_array());
	}
	
	function fetch_all_active_details_by_batch_id()
	{		
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_stock_purchase_detail_model->fetch_all_active_details_by_batch_id($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->inventory_stock_purchase_header_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
				
		if($this->input->get('id'))
		{			
			$stock_batch_id = $this->input->get('id');
			$data1 = $this->inventory_stock_purchase_header_model->fetch_single($stock_batch_id);
			
			//var_dump($data1);
			
			$retail_stock_header_id = $this->input->get('id');
			$data2 = $this->inventory_stock_purchase_detail_model->fetch_single_join($stock_batch_id);
			
			//var_dump($data2);
			
			$jsonArr = array('header' => $data1, 'detail' => $data2);
			
			echo json_encode($jsonArr);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->inventory_stock_purchase_header_model->fetch_all();
		
		echo json_encode($data);
	}

	function fetch_all_join_active()
	{	
		$data = $this->inventory_stock_purchase_header_model->fetch_all_join_active();
		
		echo json_encode($data);
	}
	
	function update()
	{				
		$json = json_decode(file_get_contents("php://input"));
			
		$phparray = (array) $json;
		
		$itemArray = array();
		$itemArray = $phparray["itemsArr"];

		
		
		if($phparray["stockHeader"][0]->stock_purchase_date != '' )
		{			
			if($phparray["stockHeader"][0]->is_active_stock_purchase == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('bank_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				inventory_stock_rental
				inventory_stock_retail */
				
						
				
				$status = 0;
				$status += ($this->inventory_stock_retail_header_model->fetch_all_by_purchase_stock_header_id($phparray["stockHeader"][0]->stock_batch_id))->num_rows();
				
				$status += ($this->inventory_stock_rental_header_model->fetch_all_by_purchase_stock_header_id($phparray["stockHeader"][0]->stock_batch_id))->num_rows();
				
				
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Stock Purchase Batch is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'stock_purchase_date'	=>	$phparray["stockHeader"][0]->stock_purchase_date,
						'is_approved_stock' =>	$phparray["stockHeader"][0]->is_approved_stock,
						'created_by' =>	$this->session->userdata('user_id'),
						'branch_id' =>	$this->session->userdata('emp_branch_id'),
						'is_active_stock_purchase' =>	$phparray["stockHeader"][0]->is_active_stock_purchase
					);
					
					$this->inventory_stock_purchase_header_model->update_single($phparray["stockHeader"][0]->stock_batch_id, $data);
					
					$this->inventory_stock_purchase_detail_model->delete_all_items_by_stock_batch_id($phparray["stockHeader"][0]->stock_batch_id);	
					
					$db_count = $this->inventory_stock_purchase_detail_model->count_items_by_batch_id($phparray["stockHeader"][0]->stock_batch_id);
					
					if($db_count == 0){
					
						foreach($phparray["itemsArr"] as $value){
							//var_dump($value);
							if($value->item_type == 'main_item_id'){
								$itemData = array(
									'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
									'item_id' =>	$value->item_id,
									'item_cost' => $value->item_cost,
									'no_of_items' =>	$value->no_of_items,
									'allocated_no_of_items' =>	0,
									'available_no_of_items' =>	$value->no_of_items,
									'is_sub_item' =>	0
								);
							}
							if($value->item_type == 'sub_item_id'){
								$itemData = array(
									'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
									'item_id' =>	$value->item_id,
									'item_cost' => $value->item_cost,
									'no_of_items' =>	$value->no_of_items,
									'allocated_no_of_items' =>	0,
									'available_no_of_items' =>	$value->no_of_items,
									'is_sub_item' =>	1
								);
							}			
							
							$this->inventory_stock_purchase_detail_model->insert($itemData);
							
						}
						
					}

					$array = array(
						'success'		=>	true,
						'message'		=>	'Data Updated!'
					);
					
				}
			}			
			else{
				$data = array(
					'stock_purchase_date'	=>	$phparray["stockHeader"][0]->stock_purchase_date,
					'is_approved_stock' =>	$phparray["stockHeader"][0]->is_approved_stock,
					'created_by' =>	$this->session->userdata('user_id'),
					'branch_id' =>	$this->session->userdata('emp_branch_id'),
					'is_active_stock_purchase' =>	$phparray["stockHeader"][0]->is_active_stock_purchase
				);
				
				$this->inventory_stock_purchase_header_model->update_single($phparray["stockHeader"][0]->stock_batch_id, $data);
								
				$this->inventory_stock_purchase_detail_model->delete_all_items_by_stock_batch_id($phparray["stockHeader"][0]->stock_batch_id);	
				
				$db_count = $this->inventory_stock_purchase_detail_model->count_items_by_batch_id($phparray["stockHeader"][0]->stock_batch_id);		
				
					
				if($db_count == 0){
					
					foreach($phparray["itemsArr"] as $value){
						//var_dump($value);
						if($value->item_type == 'main_item_id'){
							$itemData = array(
								'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
								'item_id' =>	$value->item_id,
								'item_cost' => $value->item_cost,
								'no_of_items' =>	$value->no_of_items,
								'allocated_no_of_items' =>	0,
								'available_no_of_items' =>	$value->no_of_items,
								'is_sub_item' =>	0
							);
						}
						if($value->item_type == 'sub_item_id'){
							$itemData = array(
								'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
								'item_id' =>	$value->item_id,
								'item_cost' => $value->item_cost,
								'no_of_items' =>	$value->no_of_items,
								'allocated_no_of_items' =>	0,
								'available_no_of_items' =>	$value->no_of_items,
								'is_sub_item' =>	1
							);
						}			
						
						$this->inventory_stock_purchase_detail_model->insert($itemData);
						
					}
					
				}

				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!'
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
		$data = $this->inventory_stock_purchase_header_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
}
