<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpAdvance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_advance_model');
		$this->load->model('emp_salary_advance_model');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
				
		
	}

	function index()
	{
		$data = $this->emp_advance_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('advance_name', 'advance_name', 'required');
		$this->form_validation->set_rules('advance_desc', 'advance_desc', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'advance_name'	=>	$this->input->post('advance_name'),
				'advance_desc'	=>	$this->input->post('advance_desc'),
				'is_active_advance' =>	$this->input->post('is_active_advance')
			);

			$this->emp_advance_model->insert($data);

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
				'advance_name'		=>	form_error('advance_name'),
				'advance_desc'		=>	form_error('advance_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_advance_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_advance_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_advance_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_advance_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('advance_name', 'advance_name', 'required');
		$this->form_validation->set_rules('advance_desc', 'advance_desc', 'required');
		$this->form_validation->set_rules('advance_id', 'advance_id', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_emp_allow') == 0){		
			/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('advance_id')
					AND TABLE_SCHEMA='dcs_db'; */
				$status = 0;
				$status += ($this->emp_salary_advance_model->fetch_single_by_advance_id($this->input->post('advance_id')))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Advance is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'advance_name'	=>	$this->input->post('advance_name'),
						'advance_desc'	=>	$this->input->post('advance_desc'),
						'advance_id'	=>	$this->input->post('advance_id'),
						'is_active_advance'	=>	$this->input->post('is_active_advance')
					);

					$this->emp_advance_model->update_single($this->input->post('advance_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'advance_name'	=>	$this->input->post('advance_name'),
						'advance_desc'	=>	$this->input->post('advance_desc'),
						'advance_id'	=>	$this->input->post('advance_id'),
						'is_active_advance'	=>	$this->input->post('is_active_advance')
					);

				$this->emp_advance_model->update_single($this->input->post('advance_id'), $data);

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
			if($this->emp_advance_model->delete_single($this->input->post('id')))
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
