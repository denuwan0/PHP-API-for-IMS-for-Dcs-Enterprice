<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_model');
		$this->load->model('emp_drive_license_model');
		$this->load->model('emp_final_sal_model');
		$this->load->model('emp_finger_print_model');
		$this->load->model('emp_leave_details_model');
		$this->load->model('emp_medical_records_model');
		$this->load->model('emp_over_time_allocation_model');
		$this->load->model('emp_salary_advance_model');
		$this->load->model('emp_salary_allowance_model');
		$this->load->model('emp_salary_bonus_model');
		$this->load->model('emp_salary_increment_model');
		$this->load->model('emp_special_task_assign_emp_model');
		$this->load->model('emp_work_contract_model');
		$this->load->model('inventory_rental_invoice_header_model');
		$this->load->model('inventory_retail_invoice_header_model');
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
		$this->form_validation->set_rules('emp_epf', 'Epf', 'required');
		$this->form_validation->set_rules('emp_branch_id', 'Branch', 'required');
		$this->form_validation->set_rules('emp_company_id', 'Company', 'required');
		$this->form_validation->set_rules('emp_first_name', 'First Name', 'required');
		$this->form_validation->set_rules('emp_middle_name', 'Middle Name', 'required');
		$this->form_validation->set_rules('emp_last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('emp_nic', 'Nic', 'required');
		$this->form_validation->set_rules('emp_dob', 'Date of birth', 'required');
		$this->form_validation->set_rules('emp_perm_address', 'Permenant Address', 'required');
		$this->form_validation->set_rules('emp_temp_address', 'Temp Address', 'required');
		$this->form_validation->set_rules('emp_contact_no', 'Contact No', 'required');
		$this->form_validation->set_rules('emp_email', 'Email', 'required');
		$this->form_validation->set_rules('emp_emg_contact_no', 'Emergency Contact No', 'required');
		
		
		if($this->form_validation->run())
		{
			$data = array(
				'emp_epf'	=>	$this->input->post('emp_epf'),
				'emp_branch_id'	=>	$this->input->post('emp_branch_id'),
				'emp_company_id'	=>	$this->input->post('emp_company_id'),
				'emp_first_name'	=>	$this->input->post('emp_first_name'),
				'emp_middle_name'	=>	$this->input->post('emp_middle_name'),
				'emp_last_name'	=>	$this->input->post('emp_last_name'),
				'emp_nic'	=>	$this->input->post('emp_nic'),
				'emp_dob'	=>	$this->input->post('emp_dob'),
				'emp_perm_address'	=>	$this->input->post('emp_perm_address'),
				'emp_temp_address'	=>	$this->input->post('emp_temp_address'),
				'emp_contact_no'	=>	$this->input->post('emp_contact_no'),
				'emp_email'	=>	$this->input->post('emp_email'),
				'emp_emg_contact_no'	=>	$this->input->post('emp_emg_contact_no'),
				'is_active_emp'	=>	$this->input->post('is_active_emp')
			);

			$this->emp_model->insert($data);

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
				'emp_epf'		=>	form_error('emp_epf'),
				'emp_branch_id'		=>	form_error('emp_branch_id'),
				'emp_company_id'		=>	form_error('emp_company_id'),
				'emp_first_name'		=>	form_error('emp_first_name'),
				'emp_middle_name'		=>	form_error('emp_middle_name'),
				'emp_last_name'		=>	form_error('emp_last_name'),
				'emp_nic'		=>	form_error('emp_nic'),
				'emp_dob'		=>	form_error('emp_dob'),
				'emp_perm_address'		=>	form_error('emp_perm_address'),
				'emp_temp_address'		=>	form_error('emp_temp_address'),
				'emp_contact_no'		=>	form_error('emp_contact_no'),
				'emp_email'		=>	form_error('emp_email'),
				'emp_emg_contact_no'		=>	form_error('emp_emg_contact_no')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->emp_model->fetch_all_active();
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->emp_model->fetch_all_active_by_emp_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join_by_emp_id($id)
	{
		$data = $this->emp_model->fetch_single_by_emp_id($id);
		
		echo json_encode($data);
	}
	
	function fetch_all_join()
	{	
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		$emp_epf = $this->session->userdata('emp_epf');
		$emp_id = $this->session->userdata('emp_id');
		
		if($sys_user_group_name == "Admin" ){
			$data = $this->emp_model->fetch_all_join();
			echo json_encode($data);
		}
		else if($sys_user_group_name == "Manager" ){
			$data = $this->emp_model->fetch_all_join_branch_id($emp_branch_id);
			echo json_encode($data);
		}
		else if($sys_user_group_name == "Staff" ){
			$data = $this->emp_model->fetch_all_join_branch_id_emp_id($emp_id);
			echo json_encode($data);
		}
	
		
	
		
	}

	function update()
	{
		$this->form_validation->set_rules('emp_id', 'Epf', 'required');
		$this->form_validation->set_rules('emp_epf', 'Epf', 'required');
		$this->form_validation->set_rules('emp_branch_id', 'Branch', 'required');
		$this->form_validation->set_rules('emp_company_id', 'Company', 'required');
		$this->form_validation->set_rules('emp_first_name', 'First Name', 'required');
		$this->form_validation->set_rules('emp_middle_name', 'Middle Name', 'required');
		$this->form_validation->set_rules('emp_last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('emp_nic', 'Nic', 'required');
		$this->form_validation->set_rules('emp_dob', 'Date of birth', 'required');
		$this->form_validation->set_rules('emp_perm_address', 'Permenant Address', 'required');
		$this->form_validation->set_rules('emp_temp_address', 'Temp Address', 'required');
		$this->form_validation->set_rules('emp_contact_no', 'Contact No', 'required');
		$this->form_validation->set_rules('emp_email', 'Email', 'required');
		$this->form_validation->set_rules('emp_emg_contact_no', 'Emergency Contact No', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_emp') == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('emp_id')
					AND TABLE_SCHEMA='dcs_db'; 
				
				emp_details
				emp_driving_license
				emp_final_salary
				emp_finger_print_details
				emp_leave_details
				emp_medical_records
				emp_over_time_allocation
				emp_salary_advance
				emp_salary_allowance
				emp_salary_bonus
				emp_salary_increment
				emp_special_task_assign_emp
				emp_work_contract
				inventory_rental_invoice_header
				inventory_retail_invoice_header
					*/
				
				$status = 0;
				$status += ($this->emp_drive_license_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_final_sal_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_finger_print_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_leave_details_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_medical_records_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_over_time_allocation_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_salary_advance_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_salary_allowance_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_salary_bonus_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_salary_increment_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_special_task_assign_emp_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->emp_work_contract_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->inventory_rental_invoice_header_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				$status += ($this->inventory_retail_invoice_header_model->fetch_single_by_emp_id($this->input->post('emp_id')))->num_rows();
				
				
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Employee is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'emp_id'	=>	$this->input->post('emp_id'),
						'emp_epf'	=>	$this->input->post('emp_epf'),
						'emp_branch_id'	=>	$this->input->post('emp_branch_id'),
						'emp_company_id'	=>	$this->input->post('emp_company_id'),
						'emp_first_name'	=>	$this->input->post('emp_first_name'),
						'emp_middle_name'	=>	$this->input->post('emp_middle_name'),
						'emp_last_name'	=>	$this->input->post('emp_last_name'),
						'emp_nic'	=>	$this->input->post('emp_nic'),
						'emp_dob'	=>	$this->input->post('emp_dob'),
						'emp_perm_address'	=>	$this->input->post('emp_perm_address'),
						'emp_temp_address'	=>	$this->input->post('emp_temp_address'),
						'emp_contact_no'	=>	$this->input->post('emp_contact_no'),
						'emp_email'	=>	$this->input->post('emp_email'),
						'emp_emg_contact_no'	=>	$this->input->post('emp_emg_contact_no'),
						'is_active_emp'	=>	$this->input->post('is_active_emp')
					);

					
					$this->emp_model->update_single($this->input->post('emp_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'emp_id'	=>	$this->input->post('emp_id'),
					'emp_epf'	=>	$this->input->post('emp_epf'),
					'emp_branch_id'	=>	$this->input->post('emp_branch_id'),
					'emp_company_id'	=>	$this->input->post('emp_company_id'),
					'emp_first_name'	=>	$this->input->post('emp_first_name'),
					'emp_middle_name'	=>	$this->input->post('emp_middle_name'),
					'emp_last_name'	=>	$this->input->post('emp_last_name'),
					'emp_nic'	=>	$this->input->post('emp_nic'),
					'emp_dob'	=>	$this->input->post('emp_dob'),
					'emp_perm_address'	=>	$this->input->post('emp_perm_address'),
					'emp_temp_address'	=>	$this->input->post('emp_temp_address'),
					'emp_contact_no'	=>	$this->input->post('emp_contact_no'),
					'emp_email'	=>	$this->input->post('emp_email'),
					'emp_emg_contact_no'	=>	$this->input->post('emp_emg_contact_no'),
					'is_active_emp'	=>	$this->input->post('is_active_emp')
				);
				
				$this->emp_model->update_single($this->input->post('emp_id'), $data);

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
			if($this->emp_model->delete_single($this->input->post('id')))
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
