<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockTransfer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('inventory_stock_transfer_header_model');
		$this->load->model('inventory_stock_transfer_detail_model');
		$this->load->model('inventory_stock_retail_header_model');
		$this->load->model('inventory_stock_retail_detail_model');
		$this->load->model('inventory_stock_rental_header_model');
		$this->load->model('inventory_stock_rental_detail_model');
		$this->load->model('Emp_model');
		$this->load->model('Company_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->inventory_stock_transfer_header_model->fetch_all();
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
		$emp_id =  $this->session->userdata('emp_id');
		
		
		
		if($phparray["stockHeader"][0]->create_date != '' )
		{
			$data = array(
				'create_date'	=>	$phparray["stockHeader"][0]->create_date,
				'branch_id_from' =>	$phparray["stockHeader"][0]->branch_id_from,
				'branch_id_to' =>	$phparray["stockHeader"][0]->branch_id_to,
				'created_by' =>	$created_by,
				'transfer_type' =>	$phparray["stockHeader"][0]->transfer_type,
				'stock_type' =>	$phparray["stockHeader"][0]->stock_type,
				'approved_by' =>	0,
				'is_approved' =>	0,
				'is_accepted' =>	0,
				'accepted_by' =>	0,
				'is_active_inv_stock_trans' =>	1
			);

			$header_id = $this->inventory_stock_transfer_header_model->insert($data);
			
			if($header_id){
				//$itemData = array();
				foreach($phparray["itemsArr"] as $value){
					//var_dump($value);
					
					if($value->is_sub_item == 0){
						$itemData = array(
							'inventory_stock_transfer_header_id' =>	$header_id ,
							'item_id' =>	$value->item_id,
							'no_of_items' =>	$value->no_of_items,
							'is_sub_item' =>	$value->is_sub_item,
							'is_active_stock_transfer_detail' =>	0
						);
					}
					if($value->is_sub_item == 1){
						$itemData = array(
							'inventory_stock_transfer_header_id' =>	$header_id ,
							'item_id' =>	$value->item_id,
							'no_of_items' =>	$value->no_of_items,
							'is_sub_item' =>	$value->is_sub_item,
							'is_active_stock_transfer_detail' =>	0
						);
					}			
					
					
					$this->inventory_stock_transfer_detail_model->insert($itemData);
				}
				
			}
			
			$userData = $this->Emp_model->fetch_single($emp_id);
			$this->stockTransferMail($userData);
			
			//var_dump($userData);

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
	
	function stockTransferMail($userData){
		
		
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
		$url = "http://localhost/dcs/stockTransfer/view";		
		
		$created_date = date("Y-m-d");
		
		$company_logo = base_url().'assets/img/logo.jpg';
		
		$company_logo_elem = '<img src="http://localhost/API/assets/img/logo.jpg" height="100" width="100"></img>';
		
		$message = file_get_contents(base_url().'assets/template/stockTransfer.html'); 
		//echo base_url().'assets/template/email.html';
		$message = str_replace('%company_logo%', $company_logo_elem, $message); 
		$message = str_replace('%company_name%', $company_name, $message); 
		$message = str_replace('%company_address%', $company_address, $message); 
		$message = str_replace('%company_contact%', $company_contact, $message); 
		$message = str_replace('%user_name%', $user_name, $message); 
		$message = str_replace('%user_contact%', $user_contact, $message); 
		$message = str_replace('%user_email%', $user_email, $message); 
		$message = str_replace('%created_date%', $created_date, $message); 
		$message = str_replace('%url%', $url, $message); 
				
		

		// Email subject
		$mail->Subject = 'You have received a Stock Tranfer Request';

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
	
	function fetch_all_active()
	{		
		$data = $this->inventory_stock_transfer_header_model->fetch_all_active();
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
			$data = $this->inventory_stock_transfer_header_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
				
		if($this->input->get('id'))
		{			
			$stock_batch_id = $this->input->get('id');
			$data1 = $this->inventory_stock_transfer_header_model->fetch_single($stock_batch_id);
			
			//var_dump($data1);
			
			$retail_stock_header_id = $this->input->get('id');
			$data2 = $this->inventory_stock_transfer_detail_model->fetch_single_join($stock_batch_id);
			
			$jsonArr = array('header' => $data1, 'detail' => $data2);
			
			echo json_encode($jsonArr);
		}
	}
	
	function fetch_all()
	{			
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->inventory_stock_transfer_header_model->fetch_all_join();		
			echo json_encode($data);
		}
		else{
			$data = $this->inventory_stock_transfer_header_model->fetch_all_by_branch_id($emp_branch_id);		
			echo json_encode($data);
		}
	}

	function fetch_all_join_active()
	{	
		$data = $this->inventory_stock_transfer_header_model->fetch_all_join_active();
		
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
				$status += ($this->inventory_stock_retail_detail_model->fetch_all_by_retail_stock_header_id($phparray["stockHeader"][0]->stock_batch_id))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Stock Purchase Batch is being used by other modules at the moment!'
					);
				}
				else{
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
				}
			}			
			else{
				$data = array(
					'stock_purchase_date'	=>	$phparray["stockHeader"][0]->stock_purchase_date,
					//'is_allocated_stock' =>	$phparray["stockHeader"][0]->is_allocated_stock,
					'is_approved_stock' =>	$phparray["stockHeader"][0]->is_approved_stock,
					'created_by' =>	$this->session->userdata('user_id'),
					'branch_id' =>	$this->session->userdata('emp_branch_id'),
					'is_active_stock_purchase' =>	1
				);

				$this->inventory_stock_transfer_header_model->update_single($phparray["stockHeader"][0]->stock_batch_id, $data);
				
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
		$data = $this->inventory_stock_transfer_header_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
}
