<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpLeave extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->model('Company_model');
		$this->load->model('emp_leave_details_model');
		$this->load->model('emp_wise_leave_quota_model');			
		
		
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		$emp_name = $this->session->userdata('emp_first_name');
				
		$this->form_validation->set_rules('leave_from_date', 'leave_from_date', 'required');
		$this->form_validation->set_rules('leave_to_date', 'leave_to_date', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('emp_wise_leave_quota_id', 'emp_wise_leave_quota_id', 'required');
		$this->form_validation->set_rules('leave_amount', 'leave_amount', 'required');
		
		if($this->form_validation->run())
		{
			if($this->input->post('is_active_leave_details') == 1){
				$data = array(
					'leave_from_date'	=>	$this->input->post('leave_from_date'),
					'leave_to_date'	=>	$this->input->post('leave_to_date'),
					'branch_id'	=>	$emp_branch_id,
					'emp_id'	=>	$this->input->post('emp_id'),
					'emp_wise_leave_quota_id'	=>	$this->input->post('emp_wise_leave_quota_id'),
					'leave_amount'	=>	$this->input->post('leave_amount'),
					'created_by'	=>	$created_by,
					'is_active_leave_details' =>	$this->input->post('is_active_leave_details')
				);
				
				$userData = $this->emp_leave_details_model->fetch_branch_manager_by_branch_id($emp_branch_id);
				//var_dump($userData);
				
				$text = 'You have received a Leave Request from '.$emp_name;
				$url = "http://localhost/dcs/EmpLeave/approve";
				
				$this->LeaveMail($text, $userData, $url);
											
				
			}
			else{
				$data = array(
					'leave_from_date'	=>	$this->input->post('leave_from_date'),
					'leave_to_date'	=>	$this->input->post('leave_to_date'),
					'branch_id'	=>	$emp_branch_id,
					'emp_id'	=>	$this->input->post('emp_id'),
					'emp_wise_leave_quota_id'	=>	$this->input->post('emp_wise_leave_quota_id'),
					'leave_amount'	=>	$this->input->post('leave_amount'),
					'created_by'	=>	$created_by,
					'is_active_leave_details' =>	$this->input->post('is_active_leave_details')
				);
			}
			
			

			$this->emp_leave_details_model->insert($data);

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
				'leave_from_date'		=>	form_error('leave_from_date'),
				'leave_to_date'		=>	form_error('leave_to_date'),
				'emp_id'		=>	form_error('emp_id'),
				'emp_wise_leave_quota_id'		=>	form_error('emp_wise_leave_quota_id'),
				'leave_amount'		=>	form_error('leave_amount')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$branch_id = $this->session->userdata('branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->emp_leave_details_model->fetch_all_active();
			echo json_encode($data->result_array());	
		}
		else if($user_group_name == "Manager"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_branch_id($branch_id);
			echo json_encode($data->result_array());
		}
		else if($user_group_name == "Staff"){
			$data = $this->Emp_wise_leave_quota_model->fetch_all_join_by_emp_id($emp_id);	
			//var_dump($data);
			echo json_encode($data);
		}
	
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_leave_details_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_leave_details_model->fetch_single_join($id);
			
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_all_join()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->emp_leave_details_model->fetch_all_join();		
			echo json_encode($data->result_array());	
		}
		else if($user_group_name == "Manager"){
			$data = $this->emp_leave_details_model->fetch_all_join_by_emp_id($emp_id);
			echo json_encode($data->result_array());
		}
		else if($user_group_name == "Staff"){
			$data = $this->emp_leave_details_model->fetch_all_join_by_emp_id($emp_id);	
			//var_dump($data);
			echo json_encode($data->result_array());
		}
		
	}
	
	function fetch_all_for_approve()
	{	
		$created_by = $this->session->userdata('user_id');
		$emp_id = $this->session->userdata('emp_id');
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == "Admin"){
			$data = $this->emp_leave_details_model->fetch_all_join();		
			echo json_encode($data->result_array());	
		}
		else if($user_group_name == "Manager"){
			$data = $this->emp_leave_details_model->fetch_all_join_by_branch_id_for_mgr_approve($emp_id, $emp_branch_id);
			echo json_encode($data->result_array());
		}
		
	}

	function update()
	{
		$created_by = $this->session->userdata('user_id');
		$approved_by = 0;
		
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == 'Admin' || $user_group_name == 'Manager'){
			$approved_by = $this->session->userdata('user_id');
		}
		
		$this->form_validation->set_rules('leave_detail_id', 'leave_detail_id', 'required');
		$this->form_validation->set_rules('leave_from_date', 'leave_from_date', 'required');
		$this->form_validation->set_rules('leave_to_date', 'leave_to_date', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('emp_wise_leave_quota_id', 'emp_wise_leave_quota_id', 'required');
		$this->form_validation->set_rules('leave_amount', 'leave_amount', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_leave_details') == 0 ){				
				//$status = $this->branch_model->fetch_single($this->input->post('location_id'));
				$status =0;
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Leave is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'leave_from_date'	=>	$this->input->post('leave_from_date'),
						'leave_to_date'	=>	$this->input->post('leave_to_date'),
						'emp_id'	=>	$this->input->post('emp_id'),
						'emp_wise_leave_quota_id'	=>	$this->input->post('emp_wise_leave_quota_id'),
						'leave_amount'	=>	$this->input->post('leave_amount'),
						'created_by'	=>	$created_by,
						'approved_by'	=>	$approved_by,
						'is_active_leave_details' =>	$this->input->post('is_active_leave_details'),
						'is_approved_leave' =>	$this->input->post('is_approved_leave')
					);

					$this->emp_leave_details_model->update_single($this->input->post('leave_detail_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'leave_from_date'	=>	$this->input->post('leave_from_date'),
					'leave_to_date'	=>	$this->input->post('leave_to_date'),
					'emp_id'	=>	$this->input->post('emp_id'),
					'emp_wise_leave_quota_id'	=>	$this->input->post('emp_wise_leave_quota_id'),
					'leave_amount'	=>	$this->input->post('leave_amount'),
					'created_by'	=>	$created_by,
					'approved_by'	=>	$approved_by,
					'is_active_leave_details' =>	$this->input->post('is_active_leave_details'),
					'is_approved_leave' =>	$this->input->post('is_approved_leave')
				);

				$this->emp_leave_details_model->update_single($this->input->post('leave_detail_id'), $data);

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
			if($this->emp_leave_details_model->delete_single($this->input->post('id')))
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
	
	function LeaveMail($text, $userData, $url){
		
		
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
		
		$message = file_get_contents(base_url().'assets/template/leave.html'); 
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
		$message = str_replace('%text%', $text, $message); 
				
		

		// Email subject
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
	
	function approve()
	{		
					
		$json = json_decode(file_get_contents("php://input"));
			
		$phparray = (array) $json;
		
		$itemArray = array();
		$Header = $phparray["Header"];	
		$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		$emp_id =  $this->session->userdata('emp_id');
		
		
		
		$approved_by = 0;
		
		$user_group_name = $this->session->userdata('sys_user_group_name');
		if($user_group_name == 'Admin' || $user_group_name == 'Manager'){
			$approved_by = $this->session->userdata('user_id');
		}
		
		$leaveData = $this->emp_leave_details_model->fetch_single_join($Header[0]->leave_detail_id);
		$leaveData = $leaveData->result_array();
		//var_dump($leaveData[0]["leave_detail_id"]);
		
		if($leaveData[0]["leave_detail_id"] != "")
		{		
			if($Header[0]->is_approved_leave == 1 ){	

				$quotaData = $this->emp_wise_leave_quota_model->fetch_single_join_active_non_hold($leaveData[0]["emp_wise_leave_quota_id"]);
				
				
				
				if(!empty($quotaData)){
					$leave_amount = (float)$leaveData[0]["leave_amount"];
					$balance_leave_quota = (float)$quotaData[0]["balance_leave_quota"];
				
					$new_balance = $balance_leave_quota - $leave_amount;
				
					if($new_balance < 0){
						$array = array(
							'success'		=>	false,
							'message'		=>	'Leave Quoata Limit Exceeded!'
						);
					}
					else{
						$data = array(
							'approved_by'	=>	$approved_by,
							'is_approved_leave' =>	$Header[0]->is_approved_leave
						);
					
						$this->emp_leave_details_model->update_single($leaveData[0]["leave_detail_id"], $data);
						
						
						$data1 = array(
							'balance_leave_quota'	=>	$new_balance
						);
						
						$this->emp_wise_leave_quota_model->update_single($leaveData[0]["emp_wise_leave_quota_id"], $data1);
						
						//var_dump($quotaData);
						
						$text = 'Your leave request has been Approved!';
						$url = "http://localhost/dcs/EmpLeave/view";
						
						$this->LeaveMail($text, $quotaData, $url);
						
						$array = array(
							'success'		=>	true,
							'message'		=>	'Leave Approved!'
						);
						
						echo json_encode($array);
					}
				}
				else{
					$array = array(
						'success'		=>	false,
						'message'		=>	'Leave Quoata is Inactive/ Hold!'
					);
					echo json_encode($array);
				}
				
			}
			else{
				$data = array(
					'rejected_by'	=>	$approved_by,
					'is_rejected_leave' =>	1
				);
			
				$this->emp_leave_details_model->update_single($leaveData[0]["leave_detail_id"], $data);

				$array = array(
					'success'		=>	true,
					'message'		=>	'Leave Rejected!'
				);
				echo json_encode($array);
			}			
			
		}
		else
		{
			$array = array(
				'error'			=>	true,
				'message'		=>	'Please Fill Required Fields!'
			);
			echo json_encode($array);
		}
		
	}
	
}
