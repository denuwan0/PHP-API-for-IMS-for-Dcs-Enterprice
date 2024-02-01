<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpGrade extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_grade_model');
		$this->load->model('emp_group_model');
		$this->load->model('emp_work_contract_model');
		
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_grade_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('emp_grade_name', 'Grade Name', 'required');
		$this->form_validation->set_rules('emp_grade_desc', 'Description', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'emp_grade_name'	=>	$this->input->post('emp_grade_name'),
				'emp_grade_desc'	=>	$this->input->post('emp_grade_desc'),
				'is_active_emp_grade' =>	$this->input->post('is_active_emp_grade')
			);

			$this->emp_grade_model->insert($data);

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
				'emp_grade_name'		=>	form_error('emp_grade_name'),
				'emp_grade_desc'		=>	form_error('emp_grade_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_grade_model->fetch_all_active_join();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_grade_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_grade_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_grade_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('emp_grade_id', 'Grade Id', 'required');
		$this->form_validation->set_rules('emp_grade_name', 'Grade Name', 'required');
		$this->form_validation->set_rules('emp_grade_desc', 'Description', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_emp_grade') == 0){	
				$status = 0;
				$status += $this->emp_group_model->fetch_all_by_emp_grade_id($this->input->post('emp_grade_id'))->num_rows();
				$status += $this->emp_work_contract_model->fetch_all_by_emp_grade_id($this->input->post('emp_grade_id'))->num_rows();
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Employee Grade is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
						'emp_grade_name'	=>	$this->input->post('emp_grade_name'),
						'emp_grade_desc'	=>	$this->input->post('emp_grade_desc'),
						'is_active_emp_grade'	=>	$this->input->post('is_active_emp_grade')
					);

					$this->emp_grade_model->update_single($this->input->post('emp_grade_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'emp_grade_id'	=>	$this->input->post('emp_grade_id'),
						'emp_grade_name'	=>	$this->input->post('emp_grade_name'),
						'emp_grade_desc'	=>	$this->input->post('emp_grade_desc'),
						'is_active_emp_grade'	=>	$this->input->post('is_active_emp_grade')
					);

				$this->emp_grade_model->update_single($this->input->post('emp_grade_id'), $data);

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
			if($this->emp_grade_model->delete_single($this->input->post('id')))
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
