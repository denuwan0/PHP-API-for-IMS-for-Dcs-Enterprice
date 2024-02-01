<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpWorkSchedule extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_work_schedule_model');
		$this->load->model('emp_work_contract_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_work_schedule_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('ws_name', 'Name', 'required');
		$this->form_validation->set_rules('working_hours_per_day', 'working_hours_per_day', 'required');
		$this->form_validation->set_rules('in_time', 'in_time', 'required');
		$this->form_validation->set_rules('out_time', 'out_time', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'ws_name'	=>	$this->input->post('ws_name'),
				'working_hours_per_day'	=>	$this->input->post('working_hours_per_day'),
				'in_time'	=>	$this->input->post('in_time'),
				'out_time'	=>	$this->input->post('out_time'),
				'is_flexible'	=>	$this->input->post('is_flexible'),
				'is_active_work_schedule'	=>	$this->input->post('is_active_work_schedule')
			);

			$this->emp_work_schedule_model->insert($data);

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
				'ws_name'		=>	form_error('ws_name'),
				'working_hours_per_day'		=>	form_error('working_hours_per_day'),
				'in_time'		=>	form_error('in_time'),
				'out_time'		=>	form_error('out_time')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_work_schedule_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_work_schedule_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_work_schedule_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->emp_work_schedule_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{
		$this->form_validation->set_rules('ws_id', 'ws_id', 'required');
		$this->form_validation->set_rules('ws_name', 'Name', 'required');
		$this->form_validation->set_rules('working_hours_per_day', 'working_hours_per_day', 'required');
		$this->form_validation->set_rules('in_time', 'in_time', 'required');
		$this->form_validation->set_rules('out_time', 'out_time', 'required');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_work_schedule') == 0){
				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('ws_id')
					AND TABLE_SCHEMA='dcs_db'; 
					
				emp_work_contract	
				*/
				$status = 0;
				$status += $this->emp_work_contract_model->fetch_all_by_ws_id($this->input->post('ws_id'))->num_rows();
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Work Schedule is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'ws_name'	=>	$this->input->post('ws_name'),
						'working_hours_per_day'	=>	$this->input->post('working_hours_per_day'),
						'in_time'	=>	$this->input->post('in_time'),
						'out_time'	=>	$this->input->post('out_time'),
						'is_flexible'	=>	$this->input->post('is_flexible'),
						'is_active_work_schedule'	=>	$this->input->post('is_active_work_schedule')
					);

					$this->emp_work_schedule_model->update_single($this->input->post('ws_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
						'ws_name'	=>	$this->input->post('ws_name'),
						'working_hours_per_day'	=>	$this->input->post('working_hours_per_day'),
						'in_time'	=>	$this->input->post('in_time'),
						'out_time'	=>	$this->input->post('out_time'),
						'is_flexible'	=>	$this->input->post('is_flexible'),
						'is_active_work_schedule'	=>	$this->input->post('is_active_work_schedule')
					);

				$this->emp_work_schedule_model->update_single($this->input->post('ws_id'), $data);

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
			if($this->emp_work_schedule_model->delete_single($this->input->post('id')))
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
