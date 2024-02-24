<?php

class Notify_model extends CI_Model{   
	
	function get_all_close_to_expire($data){
		
					
		$datetime1 = date('Y-m-d');
		$branch_id = $data["emp_branch_id"];
		$user_id = $data["user_id"];
		$emp_id =  $data["emp_id"];
		$emp_email =  $data["emp_email"];
		$emp_first_name = $data["emp_first_name"];
		$sys_user_group_name = $data["sys_user_group_name"];
		
		$query7 = $this->db->query("SELECT `sys_notify_id`, `user_id`, `create_date`, `is_sent_notify` FROM `sys_notification` WHERE user_id = '$user_id' AND create_date='$datetime1'");
		
		$data7 = $query7->result_array();
		
		
		if(empty($data7)){
			$is_driv_lic = 0;
			$is_vhcl_insu = 0;
			$is_vhcl_serv = 0;
			$is_vhcl_eco = 0;
			
			$url = "http://localhost/dcs/";	
			$body = '';
			
			$companyData = $this->db->query("SELECT * FROM company WHERE company.is_active_company = 1;");
			
			if($sys_user_group_name == "Staff"){
				$query1 = $this->db->query("SELECT *, DATEDIFF(`valid_to_date`,'$datetime1') AS days_left FROM `emp_driving_license` WHERE (DATEDIFF(`valid_to_date`,'$datetime1') < 10) AND `emp_id` = $emp_id;");
				
				$data1 = $query1->result_array();
				if(!empty($data1)){
					$is_driv_lic = $data1[0]['days_left'];
					$body .= "Please Renew your Driving License";
				}
				else{
					$body .= "You're all cought up!";
				}
				
				//var_dump($query1->result_array());
			}
			else if($sys_user_group_name == "Manager"){
				
				$query2 = $this->db->query("SELECT *, DATEDIFF(`next_service_date`,'$datetime1') AS days_left FROM `vehicle_service_details` LEFT JOIN vehicle_details ON vehicle_details.vehicle_id = vehicle_service_details.vehicle_id WHERE (DATEDIFF(`next_service_date`,'$datetime1') < 5) AND vehicle_details.branch_id = '$branch_id';");
				
				$data2 = $query2->result_array();
				if(!empty($data2)){
					$is_vhcl_serv = $data2[0]['days_left'];				
					$body .= 'Please make an appoinment for next vehicle service for '.$data2[0]['license_plate_no'].'<br>';
				}
				
				$query3 = $this->db->query("SELECT *, DATEDIFF(`valid_to_date`,'$datetime1') AS days_left FROM `vehicle_insuarance_details` LEFT JOIN vehicle_details ON vehicle_details.vehicle_id = vehicle_insuarance_details.vehicle_id WHERE (DATEDIFF(`valid_to_date`,'$datetime1') < 5 AND vehicle_details.branch_id = '$branch_id');");
				
				$data3 = $query3->result_array();
				if(!empty($data3)){
					$is_vhcl_insu = $data3[0]['days_left'];
					$body .= 'Please renew vehicle insurance for vehicle '.$data3[0]['license_plate_no'].'<br>';
					
				}
				
				$query4 = $this->db->query("SELECT *, DATEDIFF(`valid_to_date`,'$datetime1') AS days_left FROM `vehicle_eco_test` LEFT JOIN vehicle_details ON vehicle_details.vehicle_id = vehicle_eco_test.vehicle_id WHERE (DATEDIFF(`valid_to_date`,'$datetime1') < 5 AND vehicle_details.branch_id = '$branch_id');");
				
				$data4 = $query4->result_array();
				if(!empty($data4)){
					$is_vhcl_eco = $data4[0]['days_left'];
					$body .= 'Please renew vehicle Eco test for vehicle '.$data4[0]['license_plate_no'].'<br>';
				}
				
				$query5 = $this->db->query("SELECT *, DATEDIFF(`valid_to_date`,'$datetime1') AS days_left FROM `vehicle_revenue_license` LEFT JOIN vehicle_details ON vehicle_details.vehicle_id = vehicle_revenue_license.vehicle_id WHERE (DATEDIFF(`valid_to_date`,'$datetime1') < 5 AND vehicle_details.branch_id = '$branch_id');");
				
				$data5 = $query5->result_array();
				if(!empty($data5)){
					$is_vhcl_eco = $data5[0]['days_left'];
					$body .= 'Please renew vehicle Revenue license for vehicle '.$data5[0]['license_plate_no'].'<br>';
				}
			}
			/* else if($sys_user_group_name == "Admin"){
				
			} */
					
			
			$text = 'Daily reminder from DCS plateform';
			
			
			$this->stockTransferMail($text, $emp_first_name, $emp_email, $url, $companyData, $body);

			$query6 = $this->db->query("INSERT INTO `sys_notification`(`sys_notify_id`, `user_id`,  `create_date`, `is_sent_notify`) VALUES ('','$user_id','$datetime1','1')");
		}
		$data = array(
			'error'	=>	FALSE
		);	

		

	}
  	
	function stockTransferMail($text, $emp_first_name, $emp_email, $url, $companyData, $body){
		
		
		
		
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
		$companyData1 = $companyData;
		$companyData2 = $companyData1->result_array();
		
				
		$company_name = $companyData2[0]['company_name'];
		$company_address = $companyData2[0]['company_address'];
		$company_contact = $companyData2[0]['company_contact'];	
		
		

		$user_name = isset($emp_first_name) ? $emp_first_name : "";
		//$user_contact = isset(emp_first_name)? $userData[0]["customer_name"]: $userData[0]["emp_first_name"];
		$user_email = isset($emp_email)? $emp_email: "";
		
		$mail->addAddress($user_email);
			
		
		$created_date = date("Y-m-d");
		
		$company_logo = base_url().'assets/img/logo.jpg';
		
		$company_logo_elem = '<img src="http://localhost/API/assets/img/logo.jpg" height="100" width="100"></img>';
		
		$message = file_get_contents(base_url().'assets/template/dailyReminder.html'); 
		//echo base_url().'assets/template/email.html';
		$message = str_replace('%company_logo%', $company_logo_elem, $message); 
		$message = str_replace('%company_name%', $company_name, $message); 
		$message = str_replace('%company_address%', $company_address, $message); 
		$message = str_replace('%company_contact%', $company_contact, $message); 
		$message = str_replace('%user_name%', $user_name, $message);
		$message = str_replace('%url%', $url, $message); 
		$message = str_replace('%text%', $text, $message); 
		$message = str_replace('%body%', $body, $message);
				
		

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
	
}
