<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpWorkContract extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_work_contract_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_work_contract_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('emp_grade_id', 'emp_grade_id', 'required');
		$this->form_validation->set_rules('emp_branch_id', 'emp_branch_id', 'required');
		$this->form_validation->set_rules('emp_company_id', 'emp_company_id', 'required');
		$this->form_validation->set_rules('emp_desig_id', 'emp_desig_id', 'required');
		$this->form_validation->set_rules('emp_ws_id', 'Description', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid_from_date', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid_to_date', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'emp_id'	=>	$this->input->post('emp_id'),
				'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
				'emp_branch_id'	=>	$this->input->post('emp_branch_id'),
				'emp_company_id' =>	$this->input->post('emp_company_id'),
				'emp_desig_id'	=>	$this->input->post('emp_desig_id'),
				'emp_ws_id'	=>	$this->input->post('emp_ws_id'),
				'valid_from_date'	=>	$this->input->post('valid_from_date'),
				'valid_to_date' =>	$this->input->post('valid_to_date'),
				'is_active_emp_work_cont' =>	$this->input->post('is_active_emp_work_cont')
			);

			$this->emp_work_contract_model->insert($data);

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
				'emp_id'		=>	form_error('emp_id'),
				'emp_grade_id'		=>	form_error('emp_grade_id'),
				'emp_branch_id'		=>	form_error('emp_branch_id'),
				'emp_company_id'		=>	form_error('emp_company_id'),
				'emp_desig_id'		=>	form_error('emp_desig_id'),
				'emp_ws_id'		=>	form_error('emp_ws_id'),
				'valid_from_date'		=>	form_error('valid_from_date'),
				'valid_to_date'		=>	form_error('valid_to_date'),
				'is_active_emp_work_cont'		=>	form_error('is_active_emp_work_cont')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_work_contract_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_work_contract_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_work_contract_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_work_contract_model->fetch_all_join();
		
		echo json_encode($data);
	}


	function update()
	{
		$this->form_validation->set_rules('work_contract_id', 'work_contract_id', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		$this->form_validation->set_rules('emp_grade_id', 'emp_grade_id', 'required');
		$this->form_validation->set_rules('emp_branch_id', 'emp_branch_id', 'required');
		$this->form_validation->set_rules('emp_company_id', 'emp_company_id', 'required');
		$this->form_validation->set_rules('emp_desig_id', 'emp_desig_id', 'required');
		$this->form_validation->set_rules('emp_ws_id', 'Description', 'required');
		$this->form_validation->set_rules('valid_from_date', 'valid_from_date', 'required');
		$this->form_validation->set_rules('valid_to_date', 'valid_to_date', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_emp_work_cont') == 0){	
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('emp_id')
					AND TABLE_SCHEMA='dcs_db'; */
			
				$status = 0;
				//$status += $this->branch_model->fetch_single($this->input->post('location_id'))->num_rows();
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Work Contract is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'work_contract_id'	=>	$this->input->post('work_contract_id'),
						'emp_id'	=>	$this->input->post('emp_id'),
						'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
						'emp_branch_id'	=>	$this->input->post('emp_branch_id'),
						'emp_company_id' =>	$this->input->post('emp_company_id'),
						'emp_desig_id'	=>	$this->input->post('emp_desig_id'),
						'emp_ws_id'	=>	$this->input->post('emp_ws_id'),
						'valid_from_date'	=>	$this->input->post('valid_from_date'),
						'valid_to_date' =>	$this->input->post('valid_to_date'),
						'is_active_emp_work_cont' =>	$this->input->post('is_active_emp_work_cont')
					);

					$this->emp_work_contract_model->update_single($this->input->post('work_contract_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'work_contract_id'	=>	$this->input->post('work_contract_id'),
						'emp_id'	=>	$this->input->post('emp_id'),
						'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
						'emp_branch_id'	=>	$this->input->post('emp_branch_id'),
						'emp_company_id' =>	$this->input->post('emp_company_id'),
						'emp_desig_id'	=>	$this->input->post('emp_desig_id'),
						'emp_ws_id'	=>	$this->input->post('emp_ws_id'),
						'valid_from_date'	=>	$this->input->post('valid_from_date'),
						'valid_to_date' =>	$this->input->post('valid_to_date'),
						'is_active_emp_work_cont' =>	$this->input->post('is_active_emp_work_cont')
					);

				$this->emp_work_contract_model->update_single($this->input->post('work_contract_id'), $data);

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
			if($this->emp_work_contract_model->delete_single($this->input->post('id')))
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
