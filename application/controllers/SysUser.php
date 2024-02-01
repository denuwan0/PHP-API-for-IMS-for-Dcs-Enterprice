<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SysUser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_model');
		$this->load->model('Sys_user_model');
		$this->load->model('Sys_user_group_model');
		$this->load->model('Customer_model');
		$this->load->model('Company_model');
		$this->load->library('form_validation');
		
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		/* if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}	 */	
	}

	function index()
	{		
		/* $data = $this->Sys_user_model->fetch_all();
		echo json_encode($data->result_array()); */
	}
		
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Sys_user_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->Sys_user_model->delete_single($this->input->post('id')))
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
	
	
	function authenticate()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		
		if($data){
			if($data['username'] && $data['password'])
			{	
				//check sys user table
				$username = $data['username'];
				$password = $data['password'];
				$emp_id = '';
				$customer_id = '';
				
				$username = preg_replace('/[^a-zA-Z0-9-_\.]/','', $username);//remove spaces and special charactors
				$password = preg_replace('/\s/', '', $password);//remove spaces
				
				$hash = hash('sha256', $password);
				
				$user_data = $this->Sys_user_model->validate_user_join($username, $hash);
				

											
				if($user_data){	
									
					$data = array(
						'token'		=> "",
						'otp_code'=> ""
					);
					
					$this->Sys_user_model->update_single($user_data[0]['user_id'], $data);
					
					
					if($user_data[0]['sys_user_group_name'] != "Customer"){
						$emp_id = $user_data[0]['emp_cust_id'];	
						$emp_data_result = $this->Emp_model->fetch_single($emp_id);					
						$user_data_result = $this->Sys_user_model->fetch_single_by_emp_id($emp_id);	

						//var_dump($emp_data_result[0]);
						$sys_user_group = $this->Sys_user_group_model->fetch_single($user_data_result[0]['sys_user_group_id']);
															
						$userdata = array(
							'user_id'  			=> $user_data[0]['user_id'],
							'sys_user_group_id' => $sys_user_group[0]['sys_user_group_id'],
							'sys_user_group_name' => $sys_user_group[0]['sys_user_group_name'],
							'emp_id'  			=> $emp_data_result[0]['emp_id'],
							'emp_epf'  			=> $emp_data_result[0]['emp_epf'],
							'emp_first_name'  	=> $emp_data_result[0]['emp_first_name'],
							'emp_last_name'   	=> $emp_data_result[0]['emp_last_name'],
							'emp_company_id'   	=> $emp_data_result[0]['emp_company_id'],
							'emp_branch_id'   	=> $emp_data_result[0]['emp_branch_id'],
							'is_active_emp'   	=> $emp_data_result[0]['is_active_emp'],
							'token'   			=> $user_data_result[0]['token'],
							'otp_code_gen_time' => $user_data_result[0]['otp_code_gen_time'],
							'otp_verify'   		=> FALSE,
							'logged_in' 		=> FALSE,
							'error'		=>	false,
							'message'	=>	"Valid User"
						);					
						
					}
					else{
						$customer_id = $user_data[0]['emp_cust_id'];
						$customer_data_result = $this->Customer_model->fetch_single($customer_id);
						$user_data_result = $this->Sys_user_model->fetch_single_join_by_cust_id($customer_id);
						
						//var_dump($user_data_result);
						
						$userdata = array(
							'user_id'  			=> $user_data[0]['user_id'],
							'customer_id' 		=> $customer_data_result[0]['customer_id'],
							'customer_name'  	=> $customer_data_result[0]['customer_name'],
							'customer_nic_address'  		=> $customer_data_result[0]['customer_nic_address'],
							'customer_working_address'   => $customer_data_result[0]['customer_working_address'],
							'customer_shipping_address'  => $customer_data_result[0]['customer_shipping_address'],
							'customer_contact_no'  		=> $customer_data_result[0]['customer_contact_no'],
							'is_active_customer'   	=> $customer_data_result[0]['is_active_customer'],
							'sys_user_group_name' => $user_data_result[0]['sys_user_group_name'],
							'token'   			=> $user_data_result[0]['token'],
							'otp_code_gen_time' => $user_data_result[0]['otp_code_gen_time'],
							'otp_verify'   		=> FALSE,
							'logged_in' 		=> FALSE,
							'error'		=>	false,
							'message'	=>	"Valid User"
						);
						
					}						
					
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
			else{
				$data = array(
					'error'		=>	true,
					'message'	=>	"Invalid credentials"
				);
				echo json_encode($data);
			}
		}
		
	}
	
	function otpGen()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		
		if($data){
			$user_id = $data['user_id'];
						
			if($user_id){	
			
				$otp_code = random_int(100000, 999999);
				
				
				$data = array(
					'otp_code'		=>	$otp_code
				);
				
				$this->Sys_user_model->update_single($user_id, $data);
				
				$user_data = $this->Sys_user_model->fetch_single_join($user_id);
				/* var_dump($user_data);
				exit(); */
				
				$contact_no = "";
				
				if($user_data[0]['sys_user_group_name'] != "Customer"){
					$emp_data_result = $this->Emp_model->fetch_single($user_data[0]['emp_cust_id']);
					$contact_no = $emp_data_result[0]['emp_contact_no'];
				}
				else{
					$customer_id = $user_data[0]['emp_cust_id'];
					$customer_data_result = $this->Customer_model->fetch_single($customer_id);
					$contact_no = $customer_data_result[0]['customer_contact_no'];
				}				
				
				$message = "Test: Your OTP Code is ".$otp_code;
				
				//sendSms($contact_no, $message);
				
				$data = array(
					'error'	=>	false,
					'message'	=>	"OTP Created"
				);
				echo json_encode($data);
								
			}
			else{
				$data = array(
					'error'		=>	true,
					'message'	=>	"Invalid credentials"
				);
				echo json_encode($data);
			}
		}
	}
	
	function restCodeGen()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		
		$resetMethodDisplay = $data['resetMethodDisplay'];
		$inputMethodVal = $data['inputMethodVal'];
		$emp_details = "";
		$cust_details = "";
		$user_data ="";
		
		if($resetMethodDisplay == "Mobile"){
			$cust_details = $this->Customer_model->fetch_single_by_mobile($inputMethodVal);
			if(!$cust_details){
				$emp_details = $this->Emp_model->fetch_single_by_mobile($inputMethodVal);
			}			
		}
		if($resetMethodDisplay == "Email"){
			$cust_details = $this->Customer_model->fetch_single_by_email($inputMethodVal);
			if(!$cust_details){
				$emp_details = $this->Emp_model->fetch_single_by_email($inputMethodVal);
			}			
		}
				
		if($emp_details || $cust_details){
			
								
			if(!empty($emp_details)){
				//var_dump($emp_details[0]['emp_id']);
				$user_data = $this->Sys_user_model->fetch_single_join_by_emp_id($emp_details[0]['emp_id']);
			}				
			if(!empty($cust_details)){
				//var_dump($cust_details[0]['customer_id']);
				$user_data = $this->Sys_user_model->fetch_single_join_by_cust_id($cust_details[0]['customer_id']);
			}
			
			
									
			if($user_data[0]['user_id']){	
			
				$user_id = $user_data[0]['user_id'];
				$otp_code = random_int(100000, 999999);
								
				$data = array(
					'otp_code'		=>	$otp_code
				);
				
				$this->Sys_user_model->update_single($user_id, $data);
												
				$contact_no = "";
								
				if($user_data[0]["is_customer"] == 1){
					$contact_no = $cust_details[0]["customer_contact_no"];					
				}
				else{
					$contact_no = $emp_details[0]['emp_contact_no'];					
				}				
				
				$message = "Test: Your OTP Code for Password reset is: ".$otp_code;
				
				sendSms($contact_no, $message);
				
				$data = array(
					'error'	=>	false,
					'user_id' => $user_id,
					'message'	=>	"OTP Created"
				);
				
				
				echo json_encode($data);
								
			}
			else{
				$data = array(
					'error'		=>	true,
					'message'	=>	"Invalid credentials!"
				);
				echo json_encode($data);
			}
		}
		else{
			$data = array(
				'error'		=>	true,
				'message'	=>	"Invalid credentials!"
			);
			echo json_encode($data);
		}
	}
	
	function resetPass()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		
		$otp_code = $data['otp_code'];
		$password = $data['password'];
		$confirmPassword = $data['confirmPassword'];
		$user_id = $data['user_id'];			
		
		if($otp_code !== "" && $password !== "" && $user_id !== "" && $password == $confirmPassword)
		{	
	
			$password = preg_replace('/\s/', '', $password);//remove spaces				
			$hash = hash('sha256', $password);
			
			$user_data = $this->Sys_user_model->fetch_single_join_by_user_id_and_otp($user_id, $otp_code);
			
			//var_dump($user_data);
			
			if($user_data){
				$data = array(
					'password'	=>	$hash
				);
				
				$status = $this->Sys_user_model->update_single($user_id, $data);
				
				$data = array(
					'error'	=>	false,
					'message'	=>	"Password reset successful!"
				);
			}
			else{
				$data = array(
					'error'		=>	TRUE,
					'message'	=>	"Password reset Failed!"
				);
				
			}								
			
		}
		else{
			$data = array(
				'error'		=>	TRUE,
				'message'	=>	"Password reset Failed!"
			);
			
		}
		echo json_encode($data);
		
	}
	
	function verifyOtp()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		
		if($data){
			$user_id = $data['user_id'];
			$otp_code = $data['otp_code'];
			
			if($user_id !== "" && $otp_code !== "")
			{	
		
				$valid_otp =  $this->Sys_user_model->validate_otp($user_id, $otp_code);
				
				if($valid_otp){
					//generate random token for user
					$token = bin2hex(random_bytes(10));
					
					$data = array(
						'token'		=>	$token
					);
					
					$this->Sys_user_model->update_single($user_id, $data);
					
					$data = array(
						'error'	=>	FALSE,
						'message'	=>	"OTP Verified",
						'token'		=>	$token,
						'logged_in' => TRUE,
						'otp_verify'=> TRUE
					);
				
				}
				else{
					$data = array(
						'error'		=>	TRUE,
						'message'	=>	"OTP Verification Failed"
					);
					
				}
				
			}
			else{
				$data = array(
					'error'		=>	TRUE,
					'message'	=>	"OTP Verification Failed"
				);
				
			}
			echo json_encode($data);
		}
		
		
	}
	
	function logout()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		
		if($data){
			$user_id = $data['user_id'];
						
			if($user_id){	
											
				$data = array(
					'otp_code'	=>	"",
					'token'		=>	""
				);
				
				$this->Sys_user_model->update_single($user_id, $data);
								
				$data = array(
					'success'	=>	true,
					'message'	=>	"User logout Successfully"
				);
				
								
			}
			else{
				$data = array(
					'error'		=>	true,
					'message'	=>	"Invalid credentials"
				);
				
			}
			echo json_encode($data);
		}
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('emp_cust_id', 'emp_cust_id', 'required');
		$this->form_validation->set_rules('sys_user_group_id', 'sys_user_group_id', 'required');
		$this->form_validation->set_rules('username', 'username', 'required');
		if($this->form_validation->run())
		{
			
			if($this->input->post('is_customer') == 1){
				$userData = $this->Sys_user_model->fetch_single_join_by_cust_id($this->input->post('emp_cust_id'));				
				
				
				if(!empty($userData)){
					$array = array(
						'error'		=>	true,
						'message'		=>	'User already in the System!'
					);
					
					echo json_encode($array);
				}
				else{
					
					$hash = hash('sha256', '88888888');
					
					$data = array(
						'emp_cust_id'	=>	$this->input->post('emp_cust_id'),
						'sys_user_group_id'	=>	$this->input->post('sys_user_group_id'),
						'username'	=>	$this->input->post('username'),
						'password'	=>	$hash,
						'is_customer' =>	1,
						'is_active_sys_user' =>	$this->input->post('is_active_sys_user')
					);
					
					$this->Sys_user_model->insert($data);
					
					$userData = $this->Customer_model->fetch_single($this->input->post('emp_cust_id'));
										
					$this->accountCreateMail($userData);
					
					$array = array(
						'success'		=>	true,
						'message'		=>	'Data Saved!'
					);
					echo json_encode($array);
				}
				
			}
			else{
				
				$userData = $this->Sys_user_model->fetch_single_join_by_emp_id($this->input->post('emp_cust_id'));				
				
				
				if(!empty($userData)){
					$array = array(
						'error'		=>	true,
						'message'		=>	'User already in the System!'
					);
					
					echo json_encode($array);
				}
				else{
					
					$hash = hash('sha256', '88888888');
					
					$data = array(
						'emp_cust_id'	=>	$this->input->post('emp_cust_id'),
						'sys_user_group_id'	=>	$this->input->post('sys_user_group_id'),
						'username'	=>	$this->input->post('username'),
						'password'	=>	$hash,
						'is_customer' =>	0,
						'is_active_sys_user' =>	$this->input->post('is_active_sys_user')
					);
					
					$this->Sys_user_model->insert($data);
					
					$userData = $this->Emp_model->fetch_single($this->input->post('emp_cust_id'));
										
					$this->accountCreateMail($userData);
					
					$array = array(
						'success'		=>	true,
						'message'		=>	'Data Saved!'
					);
					echo json_encode($array);
				}
			}
						
		}
		else
		{
			$hash = hash('sha256', '88888888');
			
			$array = array(
				'error'			=>	true,
				'message'		=>	'Error!',
				'emp_cust_id'	=>	form_error('emp_cust_id'),
				'sys_user_group_id'	=>	form_error('sys_user_group_id'),
				'username'	=>	form_error('username')
			);
			
		}
		
		
		
		
	}
	
	function accountCreateMail($userData){
		
		
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
		$activation_url = "testedUrl";		
		
		$created_date = date("Y-m-d");
		
		$company_logo = base_url().'assets/img/logo.jpg';
		
		$company_logo_elem = '<img src="http://localhost/API/assets/img/logo.jpg" height="100" width="100"></img>';
		
		$message = file_get_contents(base_url().'assets/template/userAccount.html'); 
		//echo base_url().'assets/template/email.html';
		$message = str_replace('%company_logo%', $company_logo_elem, $message); 
		$message = str_replace('%company_name%', $company_name, $message); 
		$message = str_replace('%company_address%', $company_address, $message); 
		$message = str_replace('%company_contact%', $company_contact, $message); 
		$message = str_replace('%user_name%', $user_name, $message); 
		$message = str_replace('%user_contact%', $user_contact, $message); 
		$message = str_replace('%user_email%', $user_email, $message); 
		$message = str_replace('%created_date%', $created_date, $message); 
		$message = str_replace('%activation_url%', $activation_url, $message); 
				
		

		// Email subject
		$mail->Subject = 'DCS Enterprices Online Plateform account created!';

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
	
	function fetch_all_join()
	{	
		$data = $this->Sys_user_model->fetch_all_join();
		
		echo json_encode($data->result_array());
	}
	
	function fetch_single_join()
	{	
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Sys_user_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
		
	}
	
	function update()
	{
		$this->form_validation->set_rules('user_id', 'user_id', 'required');	
		$this->form_validation->set_rules('emp_cust_id', 'emp_cust_id', 'required');
		$this->form_validation->set_rules('sys_user_group_id', 'sys_user_group_id', 'required');
		$this->form_validation->set_rules('username', 'username', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_sys_user') == 0){	
				$status = 0;
				//$status += $this->Emp_leave_quota_model->fetch_single($this->input->post('leave_quota_id'));
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'System User is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'emp_cust_id'	=>	$this->input->post('emp_cust_id'),
						'sys_user_group_id'	=>	$this->input->post('sys_user_group_id'),
						'username'	=>	$this->input->post('username'),
						'is_customer' =>	$this->input->post('is_customer'),
						'is_active_sys_user' =>	$this->input->post('is_active_sys_user')
					);

					$this->Sys_user_model->update_single($this->input->post('user_id'), $data);
					
					if($this->input->post('is_customer') == 1){
						$userData = $this->Customer_model->fetch_single($this->input->post('emp_cust_id'));
										
						$this->accountStatusMail($userData, $this->input->post('is_active_sys_user'));					
					}
					else{
						$userData = $this->Emp_model->fetch_single($this->input->post('emp_cust_id'));
										
						$this->accountStatusMail($userData, $this->input->post('is_active_sys_user'));
					}
					
					

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'emp_cust_id'	=>	$this->input->post('emp_cust_id'),
					'sys_user_group_id'	=>	$this->input->post('sys_user_group_id'),
					'username'	=>	$this->input->post('username'),
					'is_customer' =>	$this->input->post('is_customer'),
					'is_active_sys_user' =>	$this->input->post('is_active_sys_user')
				);

				$this->Sys_user_model->update_single($this->input->post('user_id'), $data);
				
				if($this->input->post('is_customer') == 1){
					$userData = $this->Customer_model->fetch_single($this->input->post('emp_cust_id'));
									
					$this->accountStatusMail($userData, $this->input->post('is_active_sys_user'));					
				}
				else{
					$userData = $this->Emp_model->fetch_single($this->input->post('emp_cust_id'));
									
					$this->accountStatusMail($userData, $this->input->post('is_active_sys_user'));
				}

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
	
	function accountStatusMail($userData, $status){
		
		var_dump($userData);
		
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
		$activation_url = "testedUrl";		
		
		$created_date = date("Y-m-d");
		
		$company_logo = base_url().'assets/img/logo.jpg';
		
		$company_logo_elem = '<img src="http://localhost/API/assets/img/logo.jpg" height="100" width="100"></img>';
		
		// Email subject
		$statusMsg = "";
		$message = ""; 
		if($status == 1){			
			$mail->Subject = 'DCS Enterprices Online Plateform account Enabled!';
			$statusMsg = "Enabled";
			$message = file_get_contents(base_url().'assets/template/userAccountEnabled.html'); 
		}
		else{
			$mail->Subject = 'DCS Enterprices Online Plateform account Disabled!';
			$statusMsg = "Disabled";
			$message = file_get_contents(base_url().'assets/template/userAccountDisabled.html'); 
		}	
		
		
		//echo base_url().'assets/template/email.html';
		$message = str_replace('%company_logo%', $company_logo_elem, $message); 
		$message = str_replace('%company_name%', $company_name, $message); 
		$message = str_replace('%company_address%', $company_address, $message); 
		$message = str_replace('%company_contact%', $company_contact, $message); 
		$message = str_replace('%user_name%', $user_name, $message); 
		$message = str_replace('%user_contact%', $user_contact, $message); 
		$message = str_replace('%user_email%', $user_email, $message); 
		$message = str_replace('%created_date%', $created_date, $message); 
		$message = str_replace('%activation_url%', $activation_url, $message); 
		$message = str_replace('%status%', $statusMsg, $message); 
		
				
			

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
	
}
