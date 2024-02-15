<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpBonus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_bonus_model');
		$this->load->model('emp_salary_bonus_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
				
		
	}

	function index()
	{
		$data = $this->emp_bonus_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('bonus_name', 'bonus_name', 'required');
		$this->form_validation->set_rules('bonus_desc', 'bonus_desc', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'bonus_name'	=>	$this->input->post('bonus_name'),
				'bonus_desc'	=>	$this->input->post('bonus_desc'),
				'is_active_bonus' =>	$this->input->post('is_active_bonus')
			);

			$this->emp_bonus_model->insert($data);

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
				'bonus_name'		=>	form_error('bonus_name'),
				'bonus_desc'		=>	form_error('bonus_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{	
		$data = $this->emp_bonus_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_bonus_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_bonus_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_bonus_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('bonus_name', 'bonus_name', 'required');
		$this->form_validation->set_rules('bonus_desc', 'bonus_desc', 'required');
		$this->form_validation->set_rules('bonus_id', 'bonus_id', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_bonus') == 0){		
			/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('driving_license_id')
					AND TABLE_SCHEMA='dcs_db'; */
				$status = 0;
				$status += ($this->emp_salary_bonus_model->fetch_single_by_bonus_id($this->input->post('bonus_id')))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Bonus is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'bonus_id'	=>	$this->input->post('bonus_id'),
						'bonus_name'	=>	$this->input->post('bonus_name'),
						'bonus_desc'	=>	$this->input->post('bonus_desc'),
						'is_active_bonus'	=>	$this->input->post('is_active_bonus')
					);

					$this->emp_bonus_model->update_single($this->input->post('bonus_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'bonus_id'	=>	$this->input->post('bonus_id'),
						'bonus_name'	=>	$this->input->post('bonus_name'),
						'bonus_desc'	=>	$this->input->post('bonus_desc'),
						'is_active_bonus'	=>	$this->input->post('is_active_bonus')
					);

				$this->emp_bonus_model->update_single($this->input->post('bonus_id'), $data);

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
			if($this->emp_bonus_model->delete_single($this->input->post('id')))
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
