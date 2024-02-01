<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('branch_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->company_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		//var_dump($this->input->post('country_name'),$this->input->post('country_desc'));
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('company_address', 'Address', 'required');
		$this->form_validation->set_rules('company_contact', 'Contact', 'required');
		$this->form_validation->set_rules('company_about_us', 'About us', 'required');
		//$this->form_validation->set_rules('company_logo', 'Logo', 'required');
		$this->form_validation->set_rules('company_country', 'Country', 'required');
		
		
		if($this->form_validation->run())
		{
						
			$file_uploaded = 0;	
			
			if($_FILES['company_logo']['name'] != '' && ($_FILES['company_logo']['type'] == 'image/jpeg' || $_FILES['company_logo']['type'] == 'image/png')){
				$test = explode('.', $_FILES['company_logo']['name']);
				$extension = end($test);    
				$name = $_FILES['company_logo']['name'];


				$location = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/'.$name;
								
				if(move_uploaded_file($_FILES['company_logo']['tmp_name'], $location)){
					//var_dump($location);
					$company_logo_path = base_url().'assets/img/'.$name;;
					$file_uploaded = 1;
					
					$data = array(
						'company_name'	=>	$this->input->post('company_name'),
						'company_address'		=>	$this->input->post('company_address'),
						'company_contact'	=>	$this->input->post('company_contact'),
						'company_about_us'		=>	$this->input->post('company_about_us'),
						'company_country'	=>	$this->input->post('company_country'),
						'company_logo'	=>	$company_logo_path,
						'is_active_company'		=>	$this->input->post('is_active_company')
					);

					$this->company_model->insert($data);
				}
				else{
					$file_uploaded = 0;
				}
				
			}
									

			$array = array(
				'success'		=>	true
			);
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'company_name'		=>	form_error('company_name'),
				'company_address'		=>	form_error('company_address'),
				'company_contact'		=>	form_error('company_contact'),
				'company_about_us'		=>	form_error('company_about_us'),
				'company_logo'		=>	form_error('company_logo'),
				'company_country'		=>	form_error('company_country')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->company_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->company_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{			
		$data = $this->company_model->fetch_all_join();
		
		echo json_encode($data);
	}
	
	function fetch_all_active()
	{		
		$data = $this->company_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}

	function update()
	{
		//var_dump($this->input->post('country_name'),$this->input->post('country_desc'));
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('company_address', 'Address', 'required');
		$this->form_validation->set_rules('company_contact', 'Contact', 'required');
		$this->form_validation->set_rules('company_about_us', 'About us', 'required');
		//$this->form_validation->set_rules('company_logo', 'Logo', 'required');
		$this->form_validation->set_rules('company_country', 'Country', 'required');
		
		
		
		if($this->form_validation->run())
		{
			if($this->input->post('is_active_company') == 0){
				
				//$status += count();
				
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('company_id')
				AND TABLE_SCHEMA='dcs_db';
				
				company
				company_branch */
				
				$status = 0;				
				
				$status += ($this->branch_model->fetch_all_by_company_id($this->input->post('company_id')))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Company is being used by other modules at the moment!'
					);
				}
				else{
				
					$company_id = $this->input->post('company_id');
					$data = $this->company_model->fetch_single($company_id);	
					
					$pathinfo2 = pathinfo($data[0]['company_logo']);
					$old_image = $this->input->post('old_image');
								
					if(!isset($_FILES['company_logo']['name'])){
						
						if($old_image == $pathinfo2['dirname'].'/'.$pathinfo2['basename']){
							$data = array(
								'company_name'	=>	$this->input->post('company_name'),
								'company_address'		=>	$this->input->post('company_address'),
								'company_contact'	=>	$this->input->post('company_contact'),
								'company_about_us'		=>	$this->input->post('company_about_us'),
								'company_country'	=>	$this->input->post('company_country'),
								'is_active_company'		=>	$this->input->post('is_active_company')
							);

							$this->company_model->update_single($company_id, $data);
							
							$array = array(
								'success'		=>	true,
								'message'		=>	'Changes Updated!'
							);
						}
						
					}		
					else
					{
						$maxsize = 1*1024*1024;//1Mb
						$file_type = $_FILES['company_logo']['type'];
						$allowed = array("image/jpeg", "image/png");
						
						if(($_FILES['company_logo']['size'] >= $maxsize) || ($_FILES["company_logo"]["size"] == 0)) {
							$array = array(
								'error'		=>	true,
								'message'		=>	'File too large. File must be less than 2 megabytes.!'
							);
						}
						else if($_FILES['company_logo']['name'] == '' ){
							$array = array(
								'error'		=>	true,
								'message'		=>	'Invalid File Name!'
							);
						}				
						else if(!in_array($file_type, $allowed)){
							$array = array(
								'error'		=>	true,
								'message'		=>	'Invalid File Type. File type must be jpg or png!'
							);
						}
						else{
							$test = explode('.', $_FILES['company_logo']['name']);
							$extension = end($test);    
							$name = $_FILES['company_logo']['name'];

							$location = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/'.$name;
											
							if(move_uploaded_file($_FILES['company_logo']['tmp_name'], $location)){
								//var_dump($location);
								$company_logo_path = base_url().'assets/img/'.$name;
								
								$data = array(
									'company_name'	=>	$this->input->post('company_name'),
									'company_address'		=>	$this->input->post('company_address'),
									'company_contact'	=>	$this->input->post('company_contact'),
									'company_about_us'		=>	$this->input->post('company_about_us'),
									'company_country'	=>	$this->input->post('company_country'),
									'company_logo'	=>	$company_logo_path,
									'is_active_company'		=>	$this->input->post('is_active_company')
								);

								$this->company_model->update_single($company_id, $data);
								
								$array = array(
									'success'		=>	true,
									'message'		=>	'Changes Updated!'
								);
							}					
						}
					}
				}
			}
			else{
				$company_id = $this->input->post('company_id');
				$data = $this->company_model->fetch_single($company_id);	
				
				$pathinfo2 = pathinfo($data[0]['company_logo']);
				$old_image = $this->input->post('old_image');
							
				if(!isset($_FILES['company_logo']['name'])){
					
					if($old_image == $pathinfo2['dirname'].'/'.$pathinfo2['basename']){
						$data = array(
							'company_name'	=>	$this->input->post('company_name'),
							'company_address'		=>	$this->input->post('company_address'),
							'company_contact'	=>	$this->input->post('company_contact'),
							'company_about_us'		=>	$this->input->post('company_about_us'),
							'company_country'	=>	$this->input->post('company_country'),
							'is_active_company'		=>	$this->input->post('is_active_company')
						);

						$this->company_model->update_single($company_id, $data);
						
						$array = array(
							'success'		=>	true,
							'message'		=>	'Changes Updated!'
						);
					}
					
				}		
				else
				{
					$maxsize = 1*1024*1024;//1Mb
					$file_type = $_FILES['company_logo']['type'];
					$allowed = array("image/jpeg", "image/png");
					
					if(($_FILES['company_logo']['size'] >= $maxsize) || ($_FILES["company_logo"]["size"] == 0)) {
						$array = array(
							'error'		=>	true,
							'message'		=>	'File too large. File must be less than 2 megabytes.!'
						);
					}
					else if($_FILES['company_logo']['name'] == '' ){
						$array = array(
							'error'		=>	true,
							'message'		=>	'Invalid File Name!'
						);
					}				
					else if(!in_array($file_type, $allowed)){
						$array = array(
							'error'		=>	true,
							'message'		=>	'Invalid File Type. File type must be jpg or png!'
						);
					}
					else{
						$test = explode('.', $_FILES['company_logo']['name']);
						$extension = end($test);    
						$name = $_FILES['company_logo']['name'];

						$location = $_SERVER["DOCUMENT_ROOT"].'/API/assets/img/'.$name;
										
						if(move_uploaded_file($_FILES['company_logo']['tmp_name'], $location)){
							//var_dump($location);
							$company_logo_path = base_url().'assets/img/'.$name;
							
							$data = array(
								'company_name'	=>	$this->input->post('company_name'),
								'company_address'		=>	$this->input->post('company_address'),
								'company_contact'	=>	$this->input->post('company_contact'),
								'company_about_us'		=>	$this->input->post('company_about_us'),
								'company_country'	=>	$this->input->post('company_country'),
								'company_logo'	=>	$company_logo_path,
								'is_active_company'		=>	$this->input->post('is_active_company')
							);

							$this->company_model->update_single($company_id, $data);
							
							$array = array(
								'success'		=>	true,
								'message'		=>	'Changes Updated!'
							);
						}					
					}
				}
			}
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'company_name'		=>	form_error('company_name'),
				'company_address'		=>	form_error('company_address'),
				'company_contact'		=>	form_error('company_contact'),
				'company_about_us'		=>	form_error('company_about_us'),
				'company_logo'		=>	form_error('company_logo'),
				'company_country'		=>	form_error('company_country')
			);
		}
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->company_model->delete_single($this->input->post('id')))
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
	
}
