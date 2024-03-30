<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Inventory_stock_retail_header_model');
		$this->load->model('Inventory_stock_retail_detail_model');
		$this->load->model('Inventory_stock_purchase_header_model');
		$this->load->model('Inventory_stock_purchase_detail_model');
		$this->load->model('Inventory_retail_total_stock_model');
		$this->load->model('Customer_model');
		$this->load->model('Sys_user_model');
		$this->load->model('Company_model');
		$this->load->model('Notify_model');
		$this->load->model('Inventory_item_model');
		$this->load->library('form_validation');
		
		$this->load->model('Emp_model');
		$this->load->model('Sys_user_group_model');
		//$this->load->helper('otp');
		
		//var_dump();
		
		/* if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} */
		
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
	
	function products()
	{		
		$data = $this->Inventory_stock_retail_header_model->fetch_all_active_retail_products_for_shopping_web();
		echo json_encode($data->result_array());
	}
	
	function productById($id)
	{		
		$data = $this->Inventory_stock_retail_header_model->fetch_all_active_retail_products_for_shopping_web();
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
	
	function get_retail_item_details_by_item_id_branch_id_is_sub_item()
	{	
		$item_id = $this->input->post('item_id');
		$is_sub_item = $this->input->post('is_sub_item');
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		
		$data = $this->Inventory_retail_total_stock_model->get_retail_item_details_by_item_id_branch_id_is_sub_item($item_id, $emp_branch_id, $is_sub_item);
		
		//var_dump($data->num_rows());
		
		if($data->num_rows() != 0){
			echo json_encode($data->result_array());
		}
		else{
			$array = array(
				'success'		=>	false,
				'message'		=>	'Product not Available at the moment!'
			);
			echo json_encode($array);
		}
		
		
		
	}
	
	function register_user()
	{	

		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$registerArr = array();
		$registerArr = $phparray["registerArr"];
		$date = date('Y-m-d');
		
				
		
		
		$phonenumber = $registerArr[0]->customer_contact_no;
		// Format phone number
		if (strpos($phonenumber, '+94') !== false) {
			// Remove '+' if present
			$phonenumber = str_replace('+94', '94', $phonenumber);
		} elseif (strpos($phonenumber, '0') === 0) {
			// Add '94' if it starts with '0'
			$phonenumber = '94' . substr($phonenumber, 1);
		}
		
		$dataMob = $this->Customer_model->fetch_single_by_mobile($phonenumber);	
		
		$dataEmail = $this->Customer_model->fetch_single_by_email($registerArr[0]->customer_email);
		
		
		
		if(empty($dataMob) && empty($dataEmail)){
			$data1 = array(
				'customer_name'	=>	$registerArr[0]->customer_name,
				'customer_working_address'	=>	$registerArr[0]->customer_working_address,
				'customer_shipping_address'	=>	$registerArr[0]->customer_shipping_address,
				'customer_old_nic_no'	=>	$registerArr[0]->customer_old_nic_no,
				'customer_contact_no'	=>	$phonenumber,
				'customer_email'	=>	$registerArr[0]->customer_email,
				'created_date'	=>	$date,
				'is_web'	=>	1,
				'is_active_customer'	=>	1,
			);
			
			$data = $this->Customer_model->insert($data1);
			
			
			$password = preg_replace('/\s/', '', $registerArr[0]->password);//remove spaces				
			$hash = hash('sha256', $password);
			
			$data2 = array(
				'emp_cust_id'	=>	$data,
				'sys_user_group_id'	=>	5,
				'username'	=>	$registerArr[0]->customer_email,
				'password'	=>	$hash,
				'is_customer'	=>	1,
				'is_active_sys_user'	=>	0,
			);
			
			$data = $this->Sys_user_model->insert($data2);
			
			$userData = $this->Customer_model->fetch_single_by_email($registerArr[0]->customer_email);
													
			$text = "DCS Account Activation!";
			$url = "http://localhost/web/Activation/prof/".$userData[0]["customer_id"];	
								
			$this->accountCreateMail($text, $userData, $url);
			
			$array = array(
				'success'		=>	false,
				'message'		=>	'Data Saved!'
			);
		}
		else{
			$array = array(
				'success'		=>	false,
				'message'		=>	'Customer already registered!'
			);
		}
		
				
	
		echo json_encode($array);
	}
	
	
	function accountCreateMail($text, $userData, $url){
		
		
		// Load PHPMailer library
		$this->load->library('phpmailer_lib');

		// PHPMailer object
		$mail = $this->phpmailer_lib->load();
		

		// SMTP configuration
		$mail->isSMTP();
		$mail->Host     = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'denuwan9@gmail.com';
		$mail->Password = 'rcvzygygidoddhvl';
		$mail->SMTPSecure = 'ssl';
		$mail->Port     = 465;
		//$mail->Port = 587;
		//$mail->SMTPSecure = 'tls';	
		
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);

		$mail->setFrom('denuwan9@gmail.com', 'DCS Enterprices');
		$mail->addReplyTo('denuwan9@gmail.com', 'DCS Enterprices');

		// Add a recipient	
		

		// Add cc or bcc 
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		$companyData1 = $this->Company_model->fetch_all_active();
		$companyData2 = $companyData1->result_array();
		
				
		$company_name = $companyData2[0]['company_name'];
		$company_address = $companyData2[0]['company_address'];
		$company_contact = $companyData2[0]['company_contact'];	
		
		

		$user_name = isset($userData[0]["customer_name"])? $userData[0]["customer_name"]: $userData[0]["emp_first_name"];
		$user_contact = isset($userData[0]["customer_contact_no"])? $userData[0]["customer_name"]: $userData[0]["emp_first_name"];
		$user_email = isset($userData[0]['customer_email'])? $userData[0]['customer_email']: $userData[0]['emp_email'];
		
		$mail->addAddress($user_email);
			
		
		$created_date = date("Y-m-d");
		
		$company_logo = base_url().'assets/img/logo.jpg';
		
		$company_logo_elem = '<img src="http://localhost/API/assets/img/logo.jpg" height="100" width="100"></img>';
		
		$message = file_get_contents(base_url().'assets/template/userAccountCreated.html'); 
		//echo base_url().'assets/template/email.html';
		$message = str_replace('%company_logo%', $company_logo_elem, $message); 
		$message = str_replace('%company_name%', $company_name, $message); 
		$message = str_replace('%company_address%', $company_address, $message); 
		$message = str_replace('%company_contact%', $company_contact, $message); 
		$message = str_replace('%user_name%', $user_name, $message); 
		$message = str_replace('%user_contact%', $user_contact, $message); 
		$message = str_replace('%user_email%', $user_email, $message); 
		$message = str_replace('%created_date%', $created_date, $message); 
		$message = str_replace('%activation_url%', $url, $message); 
		$message = str_replace('%text%', $text, $message); 		
		

		// Email subject
		//$mail->Subject = 'DCS Enterprices Online Plateform account created!';
		$mail->Subject = $text;

		// Set email format to HTML
		$mail->isHTML(true);

		// Email body content
		$mailContent = '';

		$mail->Body = $message;
		$mail->send();
		// Send email
		/* if(!$mail->send()){
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}else{
			echo 'Message has been sent';
		} */
	}
	
	function accountActivation()
	{
		
		$data = json_decode(file_get_contents('php://input'), true);
		//var_dump($data["id"]);
		
		$data1 = $this->Sys_user_model->fetch_single_join_by_cust_id($data["id"]);
		//var_dump($data1);
		
		$dataaArr = array(
			'is_active_sys_user'	=>	1,
		);
		
		$data2 = $this->Sys_user_model->update_single($data1[0]["user_id"], $dataaArr);
		
		$array = array(
			'success'		=>	true,
			'message'		=>	'Data Updated!'
		);
		
		echo json_encode($array);
	}
	
	function searchByEmail()
	{
		
		$json = json_decode(file_get_contents('php://input'), true);
		$phparray = (array) $json;
		
		$searchArr = array();
		//$searchArr = $phparray["email"];
		$date = date('Y-m-d');
		
		$data1 = $this->Customer_model->fetch_all_by_customer_email($phparray["searchArr"][0]["email"])->result_array();
		
		if(!empty($data1)){
			$data2 = $this->Sys_user_model->fetch_single_by_customer_id($data1[0]["customer_id"])->result_array();
		}
		
		
		//var_dump($data1);
		
		if(!empty($data2)){
			
			$user_id = $data2[0]['user_id'];
			$contact_no = strval($data1[0]['customer_contact_no']) ;
			
			$otp_code = random_int(100000, 999999);
							
			$data = array(
				'otp_code'		=>	$otp_code
			);
						
			$this->Sys_user_model->update_single($user_id, $data);
						
			$message = "Test: Your OTP Code for Password reset is: ".$otp_code;
			
			sendSms($contact_no, $message); //0753785231
			
			$array = array(
				'error'	=>	false,
				'user_id' => $user_id,
				'message'	=>	"Valid User!"
			);
			
						
		}
		else{
			$array = array(
				'success'		=>	false,
				'message'		=>	'Invalid User!'
			);
		}
		
		echo json_encode($array);
		
	}
	
	function resetPass()
	{	

		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$passArr = array();
		$passArr = $phparray["passArr"];
		$date = date('Y-m-d');
					
		$dataEmail = $this->Sys_user_model->fetch_single_join_by_user_id_and_otp($passArr[0]->user_id, $passArr[0]->otp);
			
		if(!empty($dataEmail)){
			$password = preg_replace('/\s/', '', $passArr[0]->password);//remove spaces				
			$hash = hash('sha256', $password);
			
			$data1 = array(
				'password'	=>	$hash
			);
			
			$data = $this->Sys_user_model->update_single($passArr[0]->user_id, $data1);
						
			$array = array(
				'success'		=>	false,
				'message'		=>	'Password reset successfull!'
			);
		}
		else{
			$array = array(
				'success'		=>	true,
				'message'		=>	'OTP validation failed!'
			);
		}
		
				
	
		echo json_encode($array);
	}
	
	function login()
	{
		$json = json_decode(file_get_contents('php://input'), true);
				
		$phparray = (array) $json;
		
		$loginArr = array();
		$loginArr = $phparray["loginArr"];
		$date = date('Y-m-d');
		
		
		
		$hash = hash('sha256', $loginArr[0]['password']);
			
		$user_data = $this->Sys_user_model->validate_user_join($loginArr[0]['username'], $hash);
		
		
				
		if(!empty($user_data)){
			
			$otp_code = random_int(100000, 999999);
			$token = bin2hex(random_bytes(10));
			
			$message = "Test: OTP Code: ".$otp_code;
			
			$data = array(
				'token'		=> $token,
				'otp_code'=> $otp_code
			);
			
			$this->Sys_user_model->update_single($user_data[0]['user_id'], $data);
			
			$user_details = $this->Sys_user_model->fetch_online_customer_join($user_data[0]['user_id'])->result_array();
			
														
			$userdata = array(
				'user_id'  			=> $user_details[0]['user_id'],
				'customer_id'  			=> $user_details[0]['emp_cust_id'],
				'token'   			=> $user_details[0]['token'],
				'customer_name'   			=> $user_details[0]['customer_name'],
				'customer_shipping_address'   			=> $user_details[0]['customer_shipping_address'],
				'customer_old_nic_no'   			=> $user_details[0]['customer_old_nic_no'],
				'customer_contact_no'   			=> $user_details[0]['customer_contact_no'],
				'customer_email'   			=> $user_details[0]['customer_email'],
				'otp_verify'   		=> TRUE,
				'logged_in' 		=> TRUE,
				'error'		=>	false
			);	
			
			sendSms($user_details[0]['customer_contact_no'], $message); //0753785231

			//$this->session->set_userdata($userdata);
			echo json_encode($userdata);	
			
		}
		else{
			$data = array(
				'error'		=>	true,
				'message'	=>	"Invalid credentials"
			);
			echo json_encode($data);
		}
				
		
	}
	
	function verifyOtp()
	{	

		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$otpArr = array();
		$otpArr = $phparray["otpArr"];
		$date = date('Y-m-d');
		
		$user_id = $otpArr[0]->user_id;
		$otp =  $otpArr[0]->otp;
		
					
		$dataEmail = $this->Sys_user_model->fetch_single_join_by_user_id_and_otp($user_id, $otp);
			
		if(!empty($dataEmail)){
					
			
			$user_details = $this->Sys_user_model->fetch_online_customer_join($dataEmail[0]['user_id'])->result_array();
			
														
			$userdata = array(
				'user_id'  			=> $user_details[0]['user_id'],
				'customer_id'  			=> $user_details[0]['emp_cust_id'],
				'token'   			=> $user_details[0]['token'],
				'customer_name'   			=> $user_details[0]['customer_name'],
				'customer_shipping_address'   			=> $user_details[0]['customer_shipping_address'],
				'customer_old_nic_no'   			=> $user_details[0]['customer_old_nic_no'],
				'customer_contact_no'   			=> $user_details[0]['customer_contact_no'],
				'customer_email'   			=> $user_details[0]['customer_email'],
				'otp_verify'   		=> TRUE,
				'logged_in' 		=> TRUE,
				'error'		=>	false
			);
						
			echo json_encode($userdata);
		}
		else{
			$array = array(
				'success'		=>	true,
				'message'		=>	'OTP validation failed!'
			);
			echo json_encode($array);
		}
		
				
	
		
	}
	
	function saveOrder()
	{	

		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$itemHeaderArr = array();
		$itemsArr = array();
		$itemHeaderArr = $phparray["itemHeaderArr"];
		$itemsArr = $phparray["itemsArr"];
		date_default_timezone_set('Asia/Colombo');
		$date = date('Y-m-d');
		$time = date('H:i:s');
		
					
		$dataEmail = $this->Sys_user_model->fetch_single_join_by_user_id_and_otp($user_id, $otp);
			
		if(!empty($dataEmail)){
					
			
			$user_details = $this->Sys_user_model->fetch_online_customer_join($dataEmail[0]['user_id'])->result_array();
			
														
			$userdata = array(
				'user_id'  			=> $user_details[0]['user_id'],
				'customer_id'  			=> $user_details[0]['emp_cust_id'],
				'token'   			=> $user_details[0]['token'],
				'customer_name'   			=> $user_details[0]['customer_name'],
				'customer_shipping_address'   			=> $user_details[0]['customer_shipping_address'],
				'customer_old_nic_no'   			=> $user_details[0]['customer_old_nic_no'],
				'customer_contact_no'   			=> $user_details[0]['customer_contact_no'],
				'customer_email'   			=> $user_details[0]['customer_email'],
				'otp_verify'   		=> TRUE,
				'logged_in' 		=> TRUE,
				'error'		=>	false
			);
						
			echo json_encode($userdata);
		}
		else{
			$array = array(
				'success'		=>	true,
				'message'		=>	'OTP validation failed!'
			);
			echo json_encode($array);
		}
		
				
	
		
	}
}
