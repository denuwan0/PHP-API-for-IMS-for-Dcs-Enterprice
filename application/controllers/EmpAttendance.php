<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpAttendance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_attendance_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
				
		
	}

	function index()
	{
		$data = $this->Emp_attendance_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$user_id = $this->session->userdata('user_id');
		$branch_id = $this->session->userdata('emp_branch_id');
		$user_group_name = $this->session->userdata('sys_user_group_name');	
		
		$this->form_validation->set_rules('branch_id', 'branch_id', 'required');
		//$this->form_validation->set_rules('formFile', 'formFile', 'required');
			
		if($this->form_validation->run())
		{						
			$file_uploaded = 0;	
			
			
			if($_FILES['formFile']['name'] != '' && $_FILES['formFile']['type'] == 'text/csv'){
					
				$test = explode('.', $_FILES['formFile']['name']);
				$extension = end($test);    
				$name = $_FILES['formFile']['name'];
				

				$location = $_SERVER["DOCUMENT_ROOT"].'/API/assets/attendanceUpload/'.$name;
								
				if(move_uploaded_file($_FILES['formFile']['tmp_name'], $location)){
					//var_dump($location);
					$csv_path = base_url().'assets/attendanceUpload/'.$name;;
					$file_uploaded = 1;
					
					$csv_data = array_map('str_getcsv', file($csv_path));					
					
					foreach($csv_data as $item){
						//var_dump($item);
						
						
						$count = $this->Emp_attendance_model->fetch_single_by_epf_and_date($item[0], $item[1])->num_rows();
						
						$data = array(
							'emp_epf'		=>	$item[0],
							'date'			=>	$item[1],
							'time_in'		=>	$item[2],
							'time_out'		=>	$item[3],
							'branch_id'		=> $branch_id,
							'uploaded_by'	=>	$user_id,
							'approved_by'	=>	""
						);
						
						
						if($count==0){
							$this->Emp_attendance_model->insert($data);
							$array = array(
								'success'		=>	true,
								'message'		=>	"Data Saved!"
							);
						}
						else if($count>0){
							$val = $this->Emp_attendance_model->fetch_single_by_epf_and_date($item[0], $item[1]);
							$val = $val->result_array();
							//var_dump($val->result_array());
							$this->Emp_attendance_model->update_single($val[0]['attendance_id'], $data);
							$array = array(
								'success'		=>	true,
								'message'		=>	"Data Saved!"
							);
						}
						else{
							$this->Emp_attendance_model->update_single($val[0]['attendance_id'], $data);
							$array = array(
								'success'		=>	true,
								'message'		=>	"Data Saved!"
							);
						}
												
					}
					
					
				}
				else{
					$file_uploaded = 0;
				}
				
			}
									

			
		}
		else
		{
			$array = array(
				'error'					=>	true,
				'date'		=>	form_error('date')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_attendance_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_attendance_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_attendance_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Emp_attendance_model->fetch_all_join();
			echo json_encode($data);
		}
		else{
			$data = $this->Emp_attendance_model->fetch_all_active_by_emp_branch_id($emp_branch_id);
			echo json_encode($data);
		}
	}
	
	function fetch_all_days()
	{
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$branch_id =$this->input->get('branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Emp_attendance_model->fetch_all_days_join($branch_id);
			echo json_encode($data);
		}
		else{
			$data = $this->Emp_attendance_model->fetch_all_days_join($branch_id);
			echo json_encode($data);
		}
	}
	
	function fetch_all_months()
	{
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$branch_id =$this->input->get('branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->Emp_attendance_model->fetch_all_months_join($branch_id);
			echo json_encode($data);
		}
		else{
			$data = $this->Emp_attendance_model->fetch_all_months_join($branch_id);
			echo json_encode($data);
		}
	}

	function update()
	{
		$this->form_validation->set_rules('attendance_id', 'attendance_id', 'required');
		$this->form_validation->set_rules('emp_epf', 'emp_epf', 'required');
		$this->form_validation->set_rules('date', 'date', 'required');
		$this->form_validation->set_rules('time_in', 'time_in', 'required');
		$this->form_validation->set_rules('time_out', 'time_out', 'required');
		$this->form_validation->set_rules('uploaded_by', 'uploaded_by', 'required');
		$this->form_validation->set_rules('approved_by', 'approved_by', 'required');
		
		if($this->form_validation->run())
		{			
/* 			if($this->input->post('is_active_emp_allow') == 0){		
			 SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('driving_license_id')
					AND TABLE_SCHEMA='dcs_db'; 
				$status = 0;
				$status += ($this->emp_salary_allowance_model->fetch_single_by_allowance_id($this->input->post('allowance_id')))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Allowance is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'allowance_id'	=>	$this->input->post('allowance_id'),
						'allowance_name'	=>	$this->input->post('allowance_name'),
						'allowance_desc'	=>	$this->input->post('allowance_desc'),
						'is_active_emp_allow'	=>	$this->input->post('is_active_emp_allow')
					);

					$this->Emp_attendance_model->update_single($this->input->post('allowance_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'allowance_id'	=>	$this->input->post('allowance_id'),
						'allowance_name'	=>	$this->input->post('allowance_name'),
						'allowance_desc'	=>	$this->input->post('allowance_desc'),
						'is_active_emp_allow'	=>	$this->input->post('is_active_emp_allow')
					);

				$this->Emp_attendance_model->update_single($this->input->post('allowance_id'), $data);

				$array = array(
					'success'		=>	true,
					'message'		=>	'Changes Updated!'
				);
			}	 */	
			
			$data = array(
				'attendance_id'	=>	$this->input->post('attendance_id'),
				'emp_epf'	=>	$this->input->post('emp_epf'),
				'date'	=>	$this->input->post('date'),
				'time_in'	=>	$this->input->post('time_in'),
				'time_out'	=>	$this->input->post('time_out'),
				'uploaded_by'	=>	$this->input->post('uploaded_by'),
				'date'	=>	$this->input->post('date'),
				'approved_by'	=>	$this->input->post('approved_by,')
			);

			$this->Emp_attendance_model->update_single($this->input->post('attendance_id'), $data);

			$array = array(
				'success'		=>	true,
				'message'		=>	'Changes Updated!'
			);	
			
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
	
	function approve()
	{
		$this->form_validation->set_rules('branch_id', 'branch_id', 'required');
		//$this->form_validation->set_rules('day', 'day', 'required');
		//$this->form_validation->set_rules('month', 'month', 'required');
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_id = $this->session->userdata('emp_id');
		$branch_id =$this->input->get('branch_id');
		
		
		
		if($this->form_validation->run())
		{	
			$data = array(
				'approved_by'	=>	$emp_id,
				'is_approved'	=>	1,
			);
			
			if($this->input->post('day') != ""){				
				$this->Emp_attendance_model->approve_single_date($this->input->post('day'), $data);
			}
			else if($this->input->post('month') != ""){
				$this->Emp_attendance_model->approve_single_month($this->input->post('month'), $data);
			}
			
			$array = array(
				'success'		=>	true,
				'message'		=>	'Changes Updated!'
			);	
			
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
			if($this->Emp_attendance_model->delete_single($this->input->post('id')))
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
