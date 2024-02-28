<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RetailInvoice extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Inventory_retail_invoice_header_model');
		$this->load->model('Inventory_retail_invoice_detail_model');
		$this->load->model('Inventory_retail_total_stock_model');
		$this->load->model('Company_model');
		$this->load->model('Customer_model');
		$this->load->model('Order_payment_model');
		$this->load->library('pdf');
		$this->load->library('Ciqrcode');
		
		//var_dump();
		
		/* if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} */
		
	}

	
	
	function insert()
	{				
		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$customerDataArr = array();
		$selectedItemsArr = array();
		$customerDataArr = $phparray["customerDataArr"];
		$selectedItemsArr = $phparray["selectedItemsArr"];
		
		$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		date_default_timezone_set('Asia/Colombo');
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		
				
		//var_dump($this->session->userdata());
		$customerData  = $this->Customer_model->fetch_single_by_nic($customerDataArr[0]->customer_old_nic_no);
		//var_dump($customerData[0]['customer_id']);				
		
				
		if(isset($customerData[0]['customer_id']) && !empty($customerData[0]['customer_id']))
		{
			
			$data1 = array(
				'customer_name' =>	$customerDataArr[0]->customer_name,							
				'customer_working_address' => $customerDataArr[0]->customer_working_address,
				'customer_shipping_address' =>	$customerDataArr[0]->customer_shipping_address,
				'customer_contact_no' =>	$customerDataArr[0]->customer_contact_no,
				'customer_email' =>	$customerDataArr[0]->customer_email
			);
			
			
			$this->Customer_model->update_single($customerData[0]['customer_id'], $data1);
			
			
			$data2 = array(
				'branch_id' 	=>	$branch_id,							
				'emp_id' 		=> 	$created_by ,
				'customer_id' 	=>	$customerData[0]['customer_id'],
				'total_amount' 	=>	0,
				'created_date'	=>	$date,
				'create_time' 	=>	$time,
				'is_pos'		=>	1,
				'is_active_inv_retail_invoice_hdr' =>	1,
				'is_complete' =>	0
			);	
			
			$invoice_header_header_id  = $this->Inventory_retail_invoice_header_model->insert($data2);
			
			$status = 0;
			$total = 0;
			foreach($selectedItemsArr as $value){
								
				if($invoice_header_header_id){
					$itemData = array(
						'invoice_id' =>	$invoice_header_header_id,
						'item_id' =>	$value->item_id,
						'no_of_items' =>	$value->qty,
						'item_price' =>	$value->unit_price,
						'is_active_inv_retail_invoice_detail' =>	1
					);

					$total += $value->unit_price*$value->qty;
					
					$status += $this->Inventory_retail_invoice_detail_model->insert($itemData);					
				}
			}
			
			$totalData = array(
				'total_amount' =>	$total
			);
			
			$this->Inventory_retail_invoice_header_model->update_single($invoice_header_header_id, $totalData);
			
			$array = array(
				'success'		=>	true,
				'invoice_header_header_id'=>$invoice_header_header_id,
				'message'		=>	'Data Saved!'
			);
			
			
			
		}
		else
		{
			$data1 = array(
				'customer_name' =>	$customerDataArr[0]->customer_name,							
				'customer_working_address' => $customerDataArr[0]->customer_working_address,
				'customer_shipping_address' =>	$customerDataArr[0]->customer_shipping_address,
				'customer_contact_no' =>	$customerDataArr[0]->customer_contact_no,
				'customer_email' =>	$customerDataArr[0]->customer_email,
				'customer_old_nic_no' =>	$customerDataArr[0]->customer_old_nic_no,
				'is_active_customer' =>	1
			);
			
			
			$cusId = $this->Customer_model->insert($data1);
						
			$data2 = array(
				'branch_id' 	=>	$branch_id,							
				'emp_id' 		=> 	$created_by ,
				'customer_id' 	=>	$cusId,
				'total_amount' 	=>	0,
				'created_date'	=>	$date,
				'create_time' 	=>	$time,
				'is_pos'		=>	1,
				'is_active_inv_retail_invoice_hdr' =>	1,
				'is_complete' =>	0
			);	
			
			$invoice_header_header_id  = $this->Inventory_retail_invoice_header_model->insert($data2);
			
			$status = 0;
			$total = 0;
			foreach($selectedItemsArr as $value){
								
				if($invoice_header_header_id){
					$itemData = array(
						'invoice_id' =>	$invoice_header_header_id,
						'item_id' =>	$value->item_id,
						'no_of_items' =>	$value->qty,
						'item_price' =>	$value->unit_price,
						'is_active_inv_retail_invoice_detail' =>	1
					);

					$total += $value->unit_price*$value->qty;
					
					$status += $this->Inventory_retail_invoice_detail_model->insert($itemData);					
				}
			}
			
			$totalData = array(
				'total_amount' =>	$total
			);
			
			$this->Inventory_retail_invoice_header_model->update_single($invoice_header_header_id, $totalData);
			
			$array = array(
				'success'		=>	true,
				'invoice_header_header_id'=>$invoice_header_header_id,
				'message'		=>	'Data Saved!'
			);
		}
		echo json_encode($array);
	}
	
	function updatePayment()
	{				
		$json = json_decode(file_get_contents("php://input"));
		
		$phparray = (array) $json;
		
		$paymentArr = array();
		$paymentArr = $phparray["paymentArr"];
		
		$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		date_default_timezone_set('Asia/Colombo');
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		
		//var_dump($paymentArr);
				
		if($created_by != '' )
		{
			$payMethod = "";
			
			if($paymentArr[0]->payement_method == 'cashBtn'){
				$payMethod = 'Cash';
			}
			else if($paymentArr[0]->payement_method == 'bankTransferBtn'){
				$payMethod = 'Bank Transfer';
			}
			elseif($paymentArr[0]->payement_method == 'qrBtn'){
				$payMethod = 'Lanka QR Payment';
			}
			else if($paymentArr[0]->payement_method == 'bankCardBtn'){
				$payMethod = 'Bank Card Payment';
			}
			
			$data1 = array(
				'cust_id' =>	$paymentArr[0]->customer_id,							
				'order_id' => $paymentArr[0]->invoice_header_header_id,
				'payment_method' =>	$payMethod,
				'payment_date' =>	$date,
				'payment_time' =>	$time,
				'reference' =>	$paymentArr[0]->payment_reference,
				'is_retail_order' =>	1,
				'is_complete' =>	1
			);
						
			$this->Order_payment_model->insert($data1);			
			
			$array = array(
				'success'		=>	true,
				'message'		=>	'Payment Updated!'
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
	
	function printInvoice(){
		
		if($this->input->get('id'))
		{
			date_default_timezone_set('Asia/Colombo');
			$date = date('Y-m-d');
			$time = date('H:i:s');

			$branch_id = $this->session->userdata('emp_branch_id');
			$created_by = $this->session->userdata('user_id');	
			$invoiceData = $this->Inventory_retail_invoice_header_model->fetch_all_by_branch_id_invoice_id($branch_id, $this->input->get('id'));
			$invoiceData = $invoiceData->result_array();
			$invoice_no = $invoiceData[0]["invoice_id"];
			$total_amount = $invoiceData[0]["total_amount"];
			
			
			$customerData  = $this->Customer_model->fetch_single($invoiceData[0]['customer_id']);
			
			$itemData  = $this->Inventory_retail_invoice_detail_model->fetch_all_by_invoice_id($invoice_no);
			$itemData  = $itemData->result_array();
			
			
			
			$itemHtml = '';
			
			foreach($itemData as $item){
				
				$itemHtml .='<tr>
							<th>'.$item['item_name'].'</th>
							<th>'.$item['item_desc'].'</th>
							<th style="text-align: right;">'.$item['no_of_items'].'</th>
							<th style="text-align: right;">'.(float)($item['item_price']*$item['no_of_items']).'</th>
						  </tr>';
			}
			
			
								
			$compData = $this->Company_model->fetch_all_active();
			$compData = $compData->result_array();
			
			
			$company_logo = base_url().'assets/img/logo.jpg';
			
			$message = file_get_contents(base_url().'assets/template/invoice.html'); 
			//echo base_url().'assets/template/email.html';
			$message = str_replace('%company_logo%', $compData[0]['company_logo'], $message); 
			$message = str_replace('%company_name%', $compData[0]['company_name'], $message); 
			$message = str_replace('%company_address%', $compData[0]['company_address'], $message); 
			$message = str_replace('%company_contact%', $compData[0]['company_contact'], $message); 
			//$message = str_replace('%company_email%', $compData[0]['company_logo'], $message); 
			$message = str_replace('%customer_name%', $customerData[0]['customer_name'], $message); 
			$message = str_replace('%customer_address%', $customerData[0]['customer_working_address'], $message); 
			$message = str_replace('%customer_contact%', $customerData[0]['customer_contact_no'], $message); 
			$message = str_replace('%customer_email%', $customerData[0]['customer_email'], $message); 
			$message = str_replace('%created_date%', $date, $message); 
			$message = str_replace('%created_time%', $time, $message); 
			$message = str_replace('%invoice_no%', $invoice_no, $message); 
			$message = str_replace('%itemArr%',$itemHtml, $message); 
			$message = str_replace('%total_amount%',$total_amount, $message); 
					
			//---------------PDF----------------------//
			//$html = $this->load->view('template/pdfInvoice', $data, true);
			$pdfUrl = $this->pdf->createPDF($message, 'Invoice', true);
			//---------------PDF----------------------//
		
		}
		
		
	}
	
	function send(){
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
		$mail->addReplyTo('denuwan9@gmail.com', 'denuwan9@gmail.com');

		// Add a recipient	
		$mail->addAddress('denuwan0@gmail.com');

		// Add cc or bcc 
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		$company_name = "DCS Enterprices";
		$company_address = "Wattala";
		$company_contact = "989767654";
		$company_email = "info@dcsenterprices.com";
		
		$customer_name = "Charith";
		$customer_address = "156, Gongothota, Wattala";
		$customer_contact = "21212212";
		$customer_email = "denuwan0@gmail.com";
		
		$invoice_no = "12144";
		$created_date = date("Y-m-d");
		$order_no = "123";
		$status = "Paid";
		
		//---------------QR CODE----------------------//		
		$params['data'] = 'https://www.google.com/';
		$params['level'] = 'H';
		$params['size'] = 2;
		//echo base_url().'/assets/img/qr/'.$order_no.'.png';
		//$params['savename'] = base_url().'assets/img/qr/'.$order_no.'.png';//
		$qrCode = base_url().'assets/img/qr/'.$order_no.'.png';
		$params['savename'] = FCPATH.'/assets/img/qr/'.$order_no.'.png';
		//exit;
		$this->ciqrcode->generate($params);
		if(file_exists($params['savename'])){
			$mail->AddAttachment($params['savename'], $order_no.'.png');
		}
		//---------------QR CODE----------------------//
		
		$company_logo = base_url().'assets/img/logo.jpg';
		
		$message = file_get_contents(base_url().'assets/template/email.html'); 
		//echo base_url().'assets/template/email.html';
		$message = str_replace('%company_logo%', $company_logo, $message); 
		$message = str_replace('%company_name%', $company_name, $message); 
		$message = str_replace('%company_address%', $company_address, $message); 
		$message = str_replace('%company_contact%', $company_contact, $message); 
		$message = str_replace('%company_email%', $company_email, $message);
		$message = str_replace('%customer_name%', $customer_name, $message); 
		$message = str_replace('%customer_address%', $customer_address, $message); 
		$message = str_replace('%customer_contact%', $customer_contact, $message); 
		$message = str_replace('%customer_email%', $customer_email, $message); 
		$message = str_replace('%invoice_no%', $invoice_no, $message); 
		$message = str_replace('%created_date%', $created_date, $message); 
		$message = str_replace('%order_no%', $order_no, $message); 
		$message = str_replace('%status%', $status, $message); 
		//$message = str_replace('%testpassword%', $password, $message); 
				
		//---------------PDF----------------------//
		//$html = $this->load->view('template/pdfInvoice', $data, true);
        $pdfUrl = $this->pdf->createPDF($message, $order_no, false);
		//---------------PDF----------------------//
		
		if($pdfUrl != ''){
			$mail->AddAttachment($pdfUrl, $order_no.'.pdf');	
		}

		// Email subject
		$mail->Subject = 'DCS Enterprices Invoice No:'.$order_no;

		// Set email format to HTML
		$mail->isHTML(true);

		// Email body content
		$mailContent = '<table class="table">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col">#</th>
				  <th scope="col">First</th>
				  <th scope="col">Last</th>
				  <th scope="col">Handle</th>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <th scope="row">1</th>
				  <td>Mark</td>
				  <td>Otto</td>
				  <td>@mdo</td>
				</tr>
				<tr>
				  <th scope="row">2</th>
				  <td>Jacob</td>
				  <td>Thornton</td>
				  <td>@fat</td>
				</tr>
				<tr>
				  <th scope="row">3</th>
				  <td>Larry</td>
				  <td>the Bird</td>
				  <td>@twitter</td>
				</tr>
			  </tbody>
			</table>';

		$mail->Body = $mailContent;

		// Send email
		if(!$mail->send()){
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}else{
			echo 'Message has been sent';
		}
	}
	
	function fetch_all_active()
	{	
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Inventory_retail_invoice_header_model->fetch_all_active();
			echo json_encode($data->result_array());
		}
		else if($sys_user_group_name == "Manager"){
			$data = $this->Inventory_retail_invoice_header_model->fetch_all_active_by_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
	
		
	}
	
	function fetch_all_active_not_complete()
	{	
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Inventory_retail_invoice_header_model->fetch_all_active_not_complete();
			echo json_encode($data->result_array());
		}
		else if($sys_user_group_name == "Manager"){
			$data = $this->Inventory_retail_invoice_header_model->fetch_all_active_by_branch_id_not_complete($emp_branch_id);
			echo json_encode($data->result_array());
		}
	
		
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
		//$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		$approved_by = $this->session->userdata('user_id');
		$date = date('Y-m-d');
		$status = false;
		$retail_stock_header_id = $phparray["stockHeader"][0]->retail_stock_header_id;
		$branch_id  = $phparray["stockHeader"][0]->branch_id;
		
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
						'branch_id' =>	$phparray["stockHeader"][0]->branch_id,						
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
					'branch_id' =>	$phparray["stockHeader"][0]->branch_id,						
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
					
					$this->Inventory_retail_total_stock_model->update_all_by_item_id($this->input->post('item_id'), $data);

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

				$this->Inventory_retail_total_stock_model->update_all_by_item_id($this->input->post('item_id'), $data);

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
	
}
