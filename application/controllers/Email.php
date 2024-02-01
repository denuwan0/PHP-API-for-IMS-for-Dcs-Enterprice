<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		$this->load->library('pdf');
		$this->load->library('Ciqrcode');
        //$this->load->library('email'); 
	}

	/* function index()
	{
		$data = $this->api_model->fetch_all();
		echo json_encode($data->result_array());
	} */
	
	/* public function send_mail() { 
		//---------------Email----------------------//
		$from_email = "info@dcsenterprices.com"; 
		$to_email = 'denuwan0@gmail.com';//$this->input->post('email'); 		
		$this->email->from($from_email, 'Your Name'); 
		$this->email->to($to_email);
		$this->email->set_header('Content-Type', 'text/html');
		$this->email->subject('E-Invoice for Oder No:123'); 
						
		$company_name = "DCS Enterprices";
		$company_address = "Company Address";
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
		
		//---------------Email----------------------//
		
		//---------------QR CODE----------------------//		
		$params['data'] = 'https://www.google.com/';
		$params['level'] = 'H';
		$params['size'] = 2;
		//echo base_url().'/assets/img/qr/'.$order_no.'.png';
		//$params['savename'] = base_url().'assets/img/qr/'.$order_no.'.png';//
		$params['savename'] = FCPATH.'/assets/img/qr/'.$order_no.'.png';
		//exit;
		$this->ciqrcode->generate($params);
		if(file_exists($params['savename'])){
			$this->email->attach($params['savename']);
		}
		//---------------QR CODE----------------------//
		
		$company_logo = FCPATH.'assets/img//logo.jpg';
		
		//---------------Attachment & Msg----------------------//
		$data = [
			'company_name' => $company_name,
			'company_logo' => $company_logo,
			'company_address' => $company_address,
			'company_contact' => $company_contact,
			'company_email' => $company_email,
			'customer_name' => $customer_name,
			'customer_address' => $customer_address,
			'customer_contact' => $customer_contact,
			'customer_email' => $customer_email,
			'invoice_no' => $invoice_no,
			'created_date' => $created_date,
			'order_no' => $order_no,
			'status' => $status,
			'qrCode' => $params['savename'],
			'message' => 'helo'
		];
		
		$mesg = $this->load->view('template/email',$data,true);
		//---------------PDF----------------------//
		//$html = $this->load->view('template/pdfInvoice', $data, true);
        $pdfUrl = $this->pdf->createPDF($mesg, $order_no, false);
		//---------------PDF----------------------//
		
		if($pdfUrl != ''){
			$this->email->attach($pdfUrl);			
		}
		$this->email->message($mesg); 
		//---------------Attachment & Msg----------------------//
		

		//Send mail 
		if($this->email->send()) 
		$this->session->set_flashdata("email_sent","Email sent successfully."); 
		else 
		$this->session->set_flashdata("email_sent","Error in sending Email."); 
		$this->load->view('email_form'); 
	} */ 
	
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
	
}
