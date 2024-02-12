<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockRetail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Inventory_stock_retail_header_model');
		$this->load->model('Inventory_stock_retail_detail_model');
		$this->load->model('Inventory_stock_purchase_header_model');
		$this->load->model('Inventory_stock_purchase_detail_model');
		$this->load->model('Inventory_retail_total_stock_model');
		$this->load->model('Inventory_item_model');
		
		//var_dump();
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Inventory_stock_retail_header_model->fetch_all();
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->Inventory_stock_retail_header_model->fetch_all_join_by_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
		
		
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
				'retail_stock_assigned_date' => $date,
				'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
				'created_by' =>	$created_by,
				'approved_by' =>	0,
				'is_approved_inv_stock_retail' =>	0,
				'is_active_inv_stock_retail' =>	$phparray["stockHeader"][0]->is_active_inv_stock_retail
			);	
			
			$retail_stock_header_id  = $this->Inventory_stock_retail_header_model->insert($itemData);
			
			foreach($phparray["itemsArr"] as $value){
				//var_dump($value);
				
				
				//var_dump($retail_stock_header_id);
				$status = 0;
				if($retail_stock_header_id){
					$itemData = array(
						'retail_stock_header_id' =>	$retail_stock_header_id,
						'item_id' =>	$value->item_id,
						'full_stock_count' =>	$value->full_stock_count,
						'is_sub_item' =>	$value->is_sub_item,
						'is_active_retail_stock_detail' =>	1
					);	
					
					$status = $this->Inventory_stock_retail_detail_model->insert($itemData);					
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
		$data = $this->Inventory_stock_retail_header_model->fetch_all_active();
		echo json_encode($data->result_array());
	}
	
	function fetch_all_total_stock_join()
	{		
		
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Inventory_retail_total_stock_model->fetch_all_join();
		echo json_encode($data->result_array());
		}
		else{
			$data = $this->Inventory_retail_total_stock_model->fetch_all_join_by_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_all_total_stock_join_by_id()
	{		
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$data = $this->Inventory_retail_total_stock_model->fetch_all_join_by_stock_id($id);
			echo json_encode($data->result_array());
		}
		
	}
	
	
	function remove_detail_item_by_line_id()
	{	

		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$retail_stock_detail_id = $phparray["retail_stock_detail_id"];
		$is_active_retail_stock_detail = $phparray["is_active_retail_stock_detail"];
	
		if($retail_stock_detail_id)
		{		
			$data = $this->Inventory_stock_retail_detail_model->inactive_single($retail_stock_detail_id, $phparray);
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
			$data = $this->Inventory_stock_retail_header_model->fetch_all_active_details_by_batch_id($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Inventory_stock_retail_header_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$retail_stock_header_id = $this->input->get('id');
			$data1 = $this->Inventory_stock_retail_header_model->fetch_single($retail_stock_header_id);
			
			//var_dump($data1);
			
			$retail_stock_header_id = $this->input->get('id');
			$data2 = $this->Inventory_stock_retail_detail_model->fetch_all_active_by_retail_stock_header_id($retail_stock_header_id)->result_array();
			
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
			$data = $this->Inventory_stock_retail_header_model->fetch_all_join_by_item_admin();
			echo json_encode($data);
		}
		else{
			$data = $this->Inventory_stock_retail_header_model->fetch_all_join_by_item($emp_branch_id);
			
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
		$retail_stock_header_id = $phparray["stockHeader"][0]->retail_stock_header_id;
		
		
		if($phparray["stockHeader"][0]->stock_purchase_date != '' )
		{			
			if($phparray["stockHeader"][0]->is_active_inv_stock_retail == 0 && $phparray["stockHeader"][0]->is_approved_inv_stock_retail == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('retail_stock_header_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				inventory_stock_rental
				inventory_stock_retail */
				
								
				$status = 0;
				$status += ($this->Inventory_stock_retail_header_model->fetch_all_approved_by_retail_stock_header_id($phparray["stockHeader"][0]->retail_stock_header_id))->num_rows();
				//$status += ($this->Inventory_stock_retail_detail_model->fetch_all_by_retail_stock_header_id($phparray["stockHeader"][0]->retail_stock_header_id))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Retail Stock Allocation is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'retail_stock_header_id' =>	$retail_stock_header_id,
						'branch_id' =>	$branch_id,							
						'retail_stock_assigned_date' => $date,
						'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
						'created_by' =>	$created_by,
						'approved_by' =>	($phparray["stockHeader"][0]->is_approved_inv_stock_retail == 1 ? $approved_by : 0),
						'is_approved_inv_stock_retail' =>	$phparray["stockHeader"][0]->is_approved_inv_stock_retail,
						'is_active_inv_stock_retail' =>	$phparray["stockHeader"][0]->is_active_inv_stock_retail
					);	
					
					$status = $this->Inventory_stock_retail_header_model->update_single($phparray["stockHeader"][0]->retail_stock_header_id, $data);
					
					
					foreach($itemArray as $value){
						$status = 0;
						if($retail_stock_header_id){							
							$itemData = array(
								'retail_stock_header_id' =>	$retail_stock_header_id,
								'item_id' =>	$value->item_id,
								'full_stock_count' =>	$value->full_stock_count,
								'is_sub_item' =>	$value->is_sub_item
							);	
							
							$status = $this->Inventory_stock_retail_detail_model->update_single($retail_stock_header_id, $value->retail_stock_detail_id, $itemData);
							
						}
					}
					
				}
				
				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			if($phparray["stockHeader"][0]->is_active_inv_stock_retail == 1 && $phparray["stockHeader"][0]->is_approved_inv_stock_retail == 0){		

				$data = array(
					'retail_stock_header_id' =>	$retail_stock_header_id,
					'branch_id' =>	$branch_id,							
					'retail_stock_assigned_date' => $date,
					'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
					'created_by' =>	$created_by,
					'approved_by' =>	($phparray["stockHeader"][0]->is_approved_inv_stock_retail == 1 ? $approved_by : 0),
					'is_approved_inv_stock_retail' =>	$phparray["stockHeader"][0]->is_approved_inv_stock_retail,
					'is_active_inv_stock_retail' =>	$phparray["stockHeader"][0]->is_active_inv_stock_retail
				);	
				
				$status = $this->Inventory_stock_retail_header_model->update_single($phparray["stockHeader"][0]->retail_stock_header_id, $data);
				
				
				foreach($itemArray as $value){
					$status = 0;
					if($retail_stock_header_id){
						$itemData = array(
							'retail_stock_header_id' =>	$retail_stock_header_id,
							'item_id' =>	$value->item_id,
							'full_stock_count' =>	$value->full_stock_count,
							'is_sub_item' =>	$value->is_sub_item
						);	
						
						$status = $this->Inventory_stock_retail_detail_model->update_single($retail_stock_header_id, $value->retail_stock_detail_id, $itemData);					
					}
				}
				
				
				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			if($phparray["stockHeader"][0]->is_active_inv_stock_retail == 1 && $phparray["stockHeader"][0]->is_approved_inv_stock_retail == 1){
				
				$data = array(
					'retail_stock_header_id' =>	$retail_stock_header_id,
					'stock_batch_id' =>	$phparray["stockHeader"][0]->stock_batch_id,
					'approved_by' =>	$approved_by,
					'is_approved_inv_stock_retail' =>	$phparray["stockHeader"][0]->is_approved_inv_stock_retail
				);	
				
				$status = $this->Inventory_stock_retail_header_model->update_single($phparray["stockHeader"][0]->retail_stock_header_id, $data);
				
				foreach($itemArray as $value){
					
					$itemData1 = array(
						'item_id' =>	$value->item_id,
						'full_stock_count' =>	$value->full_stock_count,
						'is_sub_item' =>	$value->is_sub_item,
						'is_active_retail_stock_detail' =>	1
					);
					
					$status = $this->Inventory_stock_retail_detail_model->update_single($phparray["stockHeader"][0]->retail_stock_header_id, $value->retail_stock_detail_id, $itemData1);
					
					$available_no_of_items = $this->Inventory_stock_purchase_detail_model->fetch_available_no_of_items_by_main_and_sub_item_id_item_type($phparray["stockHeader"][0]->stock_batch_id, $value->item_id, $value->is_sub_item);
					
					$allocated_no_of_items = (int)$available_no_of_items[0]["allocated_no_of_items"];
					$available_no_of_items = (int)$available_no_of_items[0]["available_no_of_items"];
										
					if($available_no_of_items){
						
						$available_no_of_items = $available_no_of_items - $value->full_stock_count;					
						$allocated_no_of_items = ( $allocated_no_of_items) + ($value->full_stock_count);
										
						$itemData2 = array(
							'allocated_no_of_items' =>	$allocated_no_of_items,
							'available_no_of_items' =>	$available_no_of_items
						);
						
						$this->Inventory_stock_purchase_detail_model->update_single_main_and_sub_item_with_item_type($phparray["stockHeader"][0]->stock_batch_id, $value->item_id, $value->is_sub_item, $itemData2);
												
					}
					
					$totStockData = $this->Inventory_retail_total_stock_model->fetch_single_by_branch_id_item_id_is_sub($value->item_id, $branch_id, $value->is_sub_item);
					
					
					if(empty($totStockData)){
						
						$itemData1 = array(
							'item_id' =>	$value->item_id,
							'full_stock_count' =>	$value->full_stock_count,
							'is_sub_item' =>	$value->is_sub_item,
							'branch_id' =>	$branch_id,
							'is_active_retail_stock' =>	1
						);
						
						$this->Inventory_retail_total_stock_model->insert($itemData1);
					}
					else{
						$full_stock_count = $totStockData[0]["full_stock_count"] + $value->full_stock_count;
						$retail_stock_id = $totStockData[0]["retail_stock_id"];
						
						$itemData1 = array(
							'item_id' =>	$value->item_id,
							'full_stock_count' =>	$full_stock_count,
							'is_sub_item' =>	$value->is_sub_item,
							'branch_id' =>	$branch_id,
							'is_active_retail_stock' =>	1
						);
						
						$this->Inventory_retail_total_stock_model->update_single($retail_stock_id, $itemData1);
					}
					
					
				}
				
				$available_sum = $this->Inventory_stock_purchase_detail_model->fetch_sum_of_available_items($phparray["stockHeader"][0]->stock_batch_id);
				if($available_sum[0]["available_no_of_items"] == 0){
					
					$data = array(
						'is_allocated_stock' =>	1
					);
					
					$available_sum = $this->Inventory_stock_purchase_header_model->update_single($phparray["stockHeader"][0]->stock_batch_id, $data);
				}
					
					

				$array = array(
					'success'		=>	true,
					'message'		=>	'Data Updated!'
				);
			}
			if($phparray["stockHeader"][0]->is_active_inv_stock_retail == 0 && $phparray["stockHeader"][0]->is_approved_inv_stock_retail == 1){
				
				$array = array(
					'success'		=>	false,
					'message'		=>	'Cannot approve inactive document!'
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
	
	function update_item_details()
	{
		$this->form_validation->set_rules('retail_stock_id', 'retail_stock_id', 'required');
		$this->form_validation->set_rules('item_id', 'item_id', 'required');
		$this->form_validation->set_rules('max_sale_price', 'max_sale_price', 'required');
		$this->form_validation->set_rules('min_sale_price', 'min_sale_price', 'required');
		$this->form_validation->set_rules('stock_re_order_level', 'stock_re_order_level', 'required');
				
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_retail_stock') == 0){	
			
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('retail_stock_id')
					AND TABLE_SCHEMA='dcs_db'; */
					
				/*
				bank
				bank_branch */
			
				$status = 0;
				//$status += ($this->bank_branch_model->fetch_all_by_bank_id($this->input->post('bank_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Retail Stock is being used by other modules at the moment!'
					);
				}
				else{
					
					$data = array(
						'item_id'	=>	$this->input->post('item_id'),
						'max_sale_price'	=>	$this->input->post('max_sale_price'),
						'min_sale_price'	=>	$this->input->post('min_sale_price'),
						'stock_re_order_level'	=>	$this->input->post('stock_re_order_level'),
						'is_active_retail_stock'	=>	$this->input->post('is_active_retail_stock')
					);
					
					$this->Inventory_retail_total_stock_model->update_single($this->input->post('retail_stock_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				
				$data = array(
					'item_id'	=>	$this->input->post('item_id'),
					'max_sale_price'	=>	$this->input->post('max_sale_price'),
					'min_sale_price'	=>	$this->input->post('min_sale_price'),
					'stock_re_order_level'	=>	$this->input->post('stock_re_order_level'),
					'is_active_retail_stock'	=>	$this->input->post('is_active_retail_stock')
				);

				$this->Inventory_retail_total_stock_model->update_single($this->input->post('retail_stock_id'), $data);

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
				'message'		=>	'Please Fill Required Fields!',
				'item_id'	=>	form_error('item_id'),
				'max_sale_price'	=>	form_error('max_sale_price'),
				'min_sale_price'	=>	form_error('min_sale_price'),
				'stock_re_order_level'	=>	form_error('stock_re_order_level')
			);
		}
		
		echo json_encode($array);
	}
	
}
