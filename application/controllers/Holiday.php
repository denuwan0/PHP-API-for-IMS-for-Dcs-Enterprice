<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('holiday_model');
		$this->load->model('holiday_calendar_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->holiday_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('holiday_name', 'Name', 'required');
		$this->form_validation->set_rules('holiday_desc', 'Description', 'required');
		$this->form_validation->set_rules('holiday_type_id', 'Holiday Type', 'required');
		//$this->form_validation->set_rules('is_active_holiday', 'Description', 'required');
		if($this->form_validation->run())
		{
			$data = array(
				'holiday_name'	=>	$this->input->post('holiday_name'),
				'holiday_desc'	=>	$this->input->post('holiday_desc'),
				'holiday_type_id'	=>	$this->input->post('holiday_type_id'),
				'is_active_holiday' =>	$this->input->post('is_active_holiday')
			);

			$this->holiday_model->insert($data);

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
				'holiday_name'		=>	form_error('holiday_name'),
				'holiday_type_id'	=>	form_error('holiday_type_id'),
				'holiday_desc'		=>	form_error('holiday_desc')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all()
	{		
		$data = $this->holiday_model->fetch_all();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_all_active()
	{		
		$data = $this->holiday_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_all_active_by_type()
	{	
		if($this->input->get('id'))
		{
			$id = $this->input->get('id');
			$data = $this->holiday_model->fetch_all_active_by_type($id);
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->holiday_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->holiday_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->holiday_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('holiday_id', 'Holiday Id', 'required');
		$this->form_validation->set_rules('holiday_name', 'Name', 'required');
		$this->form_validation->set_rules('holiday_desc', 'Description', 'required');
		$this->form_validation->set_rules('holiday_type_id', 'Holiday Type', 'required');
		//$this->form_validation->set_rules('is_active_holiday', 'Description', 'required');
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_holiday') == 0){				
				
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('holiday_id')
				AND TABLE_SCHEMA='dcs_db'; 
				
				holiday
				holiday_calendar
				*/
				
				$status = 0;				
				$status = ($this->holiday_calendar_model->fetch_all_by_holiday_id($this->input->post('holiday_id')))->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Holiday is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'holiday_id'	=>	$this->input->post('holiday_id'),
						'holiday_name'	=>	$this->input->post('holiday_name'),
						'holiday_desc'	=>	$this->input->post('holiday_desc'),
						'holiday_type_id'	=>	$this->input->post('holiday_type_id'),
						'is_active_holiday' =>	$this->input->post('is_active_holiday')
					);

					$this->holiday_model->update_single($this->input->post('holiday_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'holiday_id'	=>	$this->input->post('holiday_id'),
					'holiday_name'	=>	$this->input->post('holiday_name'),
					'holiday_desc'	=>	$this->input->post('holiday_desc'),
					'holiday_type_id'	=>	$this->input->post('holiday_type_id'),
					'is_active_holiday' =>	$this->input->post('is_active_holiday')
				);

				$this->holiday_model->update_single($this->input->post('holiday_id'), $data);

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
				'message'		=>	'Please Fill Required Fields!',
				'holiday_name'		=>	form_error('holiday_name'),
				'holiday_type_id'	=>	form_error('holiday_type_id'),
				'holiday_desc'		=>	form_error('holiday_desc')
			);
		}
		
		echo json_encode($array);
	}

	function delete()
	{
		if($this->input->post('id'))
		{
			if($this->holiday_model->delete_single($this->input->post('id')))
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
