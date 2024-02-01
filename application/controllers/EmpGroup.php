<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpGroup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Emp_group_model');
		$this->load->model('emp_salary_scale_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->Emp_group_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('emp_group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('emp_group_desc', 'Description', 'required');
		$this->form_validation->set_rules('emp_grade_id', 'emp_grade_id', 'required');
		$this->form_validation->set_rules('emp_designation_id', 'Description', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'emp_group_name'	=>	$this->input->post('emp_group_name'),
				'emp_group_desc'	=>	$this->input->post('emp_group_desc'),
				'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
				'emp_designation_id'	=>	$this->input->post('emp_designation_id'),
				'is_active_emp_group' =>	$this->input->post('is_active_emp_group')
			);

			$this->Emp_group_model->insert($data);

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
				'emp_group_name'		=>	form_error('emp_group_name'),
				'emp_group_desc'		=>	form_error('emp_group_desc'),
				'emp_designation_id'		=>	form_error('emp_designation_id'),
				'emp_grade_id'		=>	form_error('emp_grade_id')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->Emp_group_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_group_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->Emp_group_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->Emp_group_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('emp_group_id', 'emp_group_id', 'required');
		$this->form_validation->set_rules('emp_group_name', 'Group Name', 'required');
		$this->form_validation->set_rules('emp_group_desc', 'Description', 'required');
		$this->form_validation->set_rules('emp_grade_id', 'emp_grade_id', 'required');
		$this->form_validation->set_rules('emp_designation_id', 'Description', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_emp_group') == 0){	
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('emp_grade_id')
					AND TABLE_SCHEMA='dcs_db'; 
					
				emp_salary_scale*/
				$status =0;
				$status += $this->emp_salary_scale_model->fetch_all_by_emp_group_id($this->input->post('emp_group_id'))->num_rows();
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Employee Group is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'emp_group_name'	=>	$this->input->post('emp_group_name'),
						'emp_group_desc'	=>	$this->input->post('emp_group_desc'),
						'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
						'emp_designation_id'	=>	$this->input->post('emp_designation_id'),
						'is_active_emp_group' =>	$this->input->post('is_active_emp_group')
					);

					$this->Emp_group_model->update_single($this->input->post('emp_group_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'emp_group_name'	=>	$this->input->post('emp_group_name'),
					'emp_group_desc'	=>	$this->input->post('emp_group_desc'),
					'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
					'emp_designation_id'	=>	$this->input->post('emp_designation_id'),
					'is_active_emp_group' =>	$this->input->post('is_active_emp_group')
				);

				$this->Emp_group_model->update_single($this->input->post('emp_group_id'), $data);

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
			if($this->Emp_group_model->delete_single($this->input->post('id')))
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
