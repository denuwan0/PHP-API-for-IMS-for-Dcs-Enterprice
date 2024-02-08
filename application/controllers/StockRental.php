<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockRental extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Inventory_stock_rental_header_model');
		$this->load->model('Inventory_stock_rental_detail_model');
		$this->load->model('Inventory_stock_purchase_header_model');
		$this->load->model('Inventory_stock_purchase_detail_model');
		$this->load->model('Inventory_item_model');
		
		//var_dump();
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Inventory_stock_rental_header_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{				
		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$itemArray = array();
		$itemArray = $phparray["itemsArr"];
		$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		$date = date('Y-m-d');
		
		
		
		$status = false;
		
		//var_dump($this->session->userdata());
				
		if($phparray["stockHeader"][0]->stock_batch_id != '' )
		{
			$itemData = array(
				'branch_id' =>	$branch_id,							
				'rental_stock_assigned_date' => $date,
				'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
				'created_by' =>	$created_by,
				'approved_by' =>	0,
				'is_approved_inv_stock_rental' =>	0,
				'is_active_inv_stock_rental' =>	$phparray["stockHeader"][0]->is_active_inv_stock_rental
			);	
			
			$rental_stock_header_id  = $this->Inventory_stock_rental_header_model->insert($itemData);
			//var_dump($rental_stock_header_id);
			
			foreach($phparray["itemsArr"] as $value){
				//var_dump($value);
				
				
				//var_dump($rental_stock_header_id);
				$status = 0;
				if($rental_stock_header_id){
					$itemData = array(
						'rental_stock_header_id' =>	$rental_stock_header_id,
						'item_id' =>	$value->item_id,
						'max_rent_price' =>	$value->max_rent_price,
						'min_rent_price' =>	$value->min_rent_price,
						'full_stock_count' =>	$value->full_stock_count,
						'out_stock_count' =>	0,
						'in_stock_count' =>	$value->full_stock_count,
						'damage_stock_count' =>	0,
						'repair_stock_count' =>	0,
						'stock_re_order_level' =>	$value->stock_re_order_level,
						'stock_re_order_level' =>	$value->stock_re_order_level,
						'is_sub_item' =>	$value->is_sub_item,
						'is_active_rental_stock_detail' =>	1
					);	
					
					$status = $this->Inventory_stock_rental_detail_model->insert($itemData);					
				}
			}
			if($status != null){
				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Saved!'
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
	
	function fetch_all_active()
	{		
		$data = $this->Inventory_stock_rental_header_model->fetch_all_active();
		echo json_encode($data->result_array());
	}
	
	function remove_detail_item_by_line_id()
	{	

		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$retail_stock_detail_id = $phparray["retail_stock_detail_id"];
		$is_active_rental_stock_detail = $phparray["is_active_rental_stock_detail"];
	
		if($retail_stock_detail_id)
		{		
			$data = $this->Inventory_stock_rental_detail_model->inactive_single($retail_stock_detail_id, $phparray);
			if($data){
				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			else{
				$array = array(
					'success'		=>	false,
					'message'		=>	'Data not Updated!'
				);	
			}
			
		}
		echo json_encode($array);
	}
	
	function fetch_all_active_details_by_batch_id()
	{		
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_stock_rental_header_model->fetch_all_active_details_by_batch_id($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_stock_rental_header_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$rental_stock_header_id = $this->input->get('id');
			$data1 = $this->Inventory_stock_rental_header_model->fetch_single($rental_stock_header_id);
			
			//var_dump($data1);
			
			$rental_stock_header_id = $this->input->get('id');
			$data2 = $this->Inventory_stock_rental_detail_model->fetch_all_active_by_rental_stock_header_id($rental_stock_header_id)->result_array();
			
			//var_dump($data2);
			
			$jsonArr = array('header' => $data1, 'detail' => $data2);
			
			echo json_encode($jsonArr);
		}
	}
	
	function fetch_all()
	{	
		$data = $this->Inventory_stock_purchase_header_model->fetch_all();
		
		echo json_encode($data);
	}
	
	function fetch_all_join_active_by_item()
	{			
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Inventory_stock_rental_header_model->fetch_all_join_by_item_admin();
			echo json_encode($data);
		}
		else{
			$data = $this->Inventory_stock_rental_header_model->fetch_all_join_by_item($emp_branch_id);
			
			echo json_encode($data);
		}
		
		
	}

	function fetch_all_join_active()
	{	
		$data = $this->Inventory_stock_purchase_header_model->fetch_all_join_active();
		
		echo json_encode($data);
	}
	
	function update()
	{				
		$json = json_decode(file_get_contents("php://input"));
			
		$phparray = (array) $json;
		
		$itemArray = array();
		$itemArray = $phparray["itemsArr"];
		$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		$approved_by = $this->session->userdata('user_id');
		$date = date('Y-m-d');
		$status = false;
		$rental_stock_header_id = $phparray["stockHeader"][0]->rental_stock_header_id;
		
		
		if($phparray["stockHeader"][0]->stock_purchase_date != '' )
		{			
			if($phparray["stockHeader"][0]->is_active_inv_stock_rental == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('rental_stock_header_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				inventory_stock_rental
				inventory_stock_retail */
				$status = 0;
				$status += ($this->Inventory_stock_rental_header_model->fetch_all_approved_by_rental_stock_header_id($phparray["stockHeader"][0]->rental_stock_header_id))->num_rows();
				//$status += ($this->Inventory_stock_rental_detail_model->fetch_all_by_rental_stock_header_id($phparray["stockHeader"][0]->rental_stock_header_id))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Retail Stock Allocation is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'rental_stock_header_id' =>	$rental_stock_header_id,
						'branch_id' =>	$branch_id,							
						'rental_stock_assigned_date' => $date,
						'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
						'created_by' =>	$created_by,
						'approved_by' =>	0,
						'is_approved_inv_stock_rental' =>	0,
						'is_active_inv_stock_rental' =>	$phparray["stockHeader"][0]->is_active_inv_stock_rental
					);	
					
					$status = $this->Inventory_stock_rental_header_model->update_single($phparray["stockHeader"][0]->rental_stock_header_id, $data);
					
					if($status != null){
						foreach($itemArray as $value){
							$status = 0;
							if($rental_stock_header_id){
								$itemData = array(
									'rental_stock_header_id' =>	$rental_stock_header_id,
									'item_id' =>	$value->item_id,
									'max_rent_price' =>	$value->max_rent_price,
									'min_rent_price' =>	$value->min_rent_price,
									'full_stock_count' =>	$value->full_stock_count,
									'stock_re_order_level' =>	$value->stock_re_order_level,
									'is_sub_item' =>	$value->is_sub_item
								);	
								
								$status = $this->Inventory_stock_rental_detail_model->update_single($value->retail_stock_detail_id, $itemData);					
							}
						}
					}
				}
				
				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			if($phparray["stockHeader"][0]->is_active_inv_stock_rental == 1){
				
				$data = array(
					'rental_stock_header_id' =>	$rental_stock_header_id,
					'branch_id' =>	$branch_id,							
					'rental_stock_assigned_date' => $date,
					'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
					'created_by' =>	$created_by,
					'approved_by' =>	0,
					'is_approved_inv_stock_rental' =>	0,
					'is_active_inv_stock_rental' =>	$phparray["stockHeader"][0]->is_active_inv_stock_rental
				);	
				
				$status = $this->Inventory_stock_rental_header_model->update_single($phparray["stockHeader"][0]->rental_stock_header_id, $data);
				
				if($status != null){
					foreach($itemArray as $value){
						$status = 0;
						if($rental_stock_header_id){
							$itemData = array(
								'rental_stock_header_id' =>	$rental_stock_header_id,
								'item_id' =>	$value->item_id,
								'max_rent_price' =>	$value->max_rent_price,
								'min_rent_price' =>	$value->min_rent_price,
								'full_stock_count' =>	$value->full_stock_count,
								'stock_re_order_level' =>	$value->stock_re_order_level,
								'is_sub_item' =>	$value->is_sub_item
							);	
							
							$status = $this->Inventory_stock_rental_detail_model->update_single($value->retail_stock_detail_id, $itemData);					
						}
					}
				}
				
				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			if($phparray["stockHeader"][0]->is_active_inv_stock_rental == 1 && $phparray["stockHeader"][0]->is_approved_inv_stock_rental == 1){
				$data = array(
					'rental_stock_header_id' =>	$rental_stock_header_id,
					'branch_id' =>	$branch_id,							
					'rental_stock_assigned_date' => $date,
					'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
					'created_by' =>	$created_by,
					'approved_by' =>	$approved_by,
					'is_approved_inv_stock_rental' =>	$phparray["stockHeader"][0]->is_approved_inv_stock_rental,
					'is_active_inv_stock_rental' =>	$phparray["stockHeader"][0]->is_active_inv_stock_rental
				);	
				
				$status = $this->Inventory_stock_rental_header_model->update_single($phparray["stockHeader"][0]->rental_stock_header_id, $data);
				$available_sum = 0;
				//if($status != null){
					//var_dump($itemArray);
					foreach($itemArray as $value){
						$status = 0;
						if($rental_stock_header_id){
							$itemData = array(
								'rental_stock_header_id' =>	$rental_stock_header_id,
								'item_id' =>	$value->item_id,
								'max_rent_price' =>	$value->max_rent_price,
								'min_rent_price' =>	$value->min_rent_price,
								'full_stock_count' =>	$value->full_stock_count,
								'stock_re_order_level' =>	$value->stock_re_order_level,
								'is_sub_item' =>	$value->is_sub_item
							);	
							
							$status = $this->Inventory_stock_rental_detail_model->update_single($rental_stock_header_id, $value->retail_stock_detail_id, $itemData);
												
						}
						
						$available_no_of_items = $this->Inventory_stock_purchase_detail_model->fetch_available_no_of_items_by_main_and_sub_item_id_item_type($phparray["stockHeader"][0]->stock_batch_id, $value->item_id, $value->is_sub_item);
						
						//var_dump($available_no_of_items);
						
						//var_dump($available_no_of_items[0]["available_no_of_items"]);
						if($available_no_of_items){
							$available_no_of_items = ($available_no_of_items[0]["available_no_of_items"]) - ($value->full_stock_count);
							
							$itemData1 = array(
								'allocated_no_of_items' =>	$value->full_stock_count,
								'available_no_of_items' =>	$available_no_of_items
							);
							
							$this->Inventory_stock_purchase_detail_model->update_single_main_and_sub_item_with_item_type($phparray["stockHeader"][0]->stock_batch_id, $value->item_id, $value->is_sub_item, $itemData1);
							
							
							
							
						}
						
						
										
						//var_dump($itemData);
						
					}
					
					$available_sum = $this->Inventory_stock_purchase_detail_model->fetch_sum_of_available_items($phparray["stockHeader"][0]->stock_batch_id);
					//var_dump($available_sum[0]["available_no_of_items"]);
					if($available_sum[0]["available_no_of_items"] == 0){
						$data = array(
							'is_allocated_stock' =>	1,
						);
						
						$this->Inventory_stock_purchase_header_model->update_single($phparray["stockHeader"][0]->stock_batch_id, $data);
					}
				//}

				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			if($phparray["stockHeader"][0]->is_active_inv_stock_rental == 0 && $phparray["stockHeader"][0]->is_approved_inv_stock_rental == 1){
				$array = array(
					'success'		=>	true,
					'message'		=>	'Cannont approve inactive document!'
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
