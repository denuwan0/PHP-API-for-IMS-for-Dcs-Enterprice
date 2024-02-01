<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('holiday_calendar_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->holiday_calendar_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('h_holiday_date_from', 'From Date', 'required');
		$this->form_validation->set_rules('h_holiday_date_to', 'Country', 'required');
		$this->form_validation->set_rules('holiday_id', 'Holiday Id', 'required');
		$color="";
		
		if(isset($_POST['h_holiday_color'])){
			$class = $this->input->post('h_holiday_color');

			switch ($class) {
			  case "bg-warning":
				$color = "#ffc107";
				break;
			  case "bg-info":
				$color = "#17a2b8";
				break;
			  case "bg-primary":
				$color = "#007bff";
				break;
			 case "bg-danger":
				$color = "#dc3545";
				break;
			  case "bg-secondary":
				$color = "#6c757d";
				break;
			  case "bg-indigo":
				$color = "#6610f2";
				break;
			  case "bg-navy":
				$color = "#001f3f";
				break;
			  case "bg-purple":
				$color = "#6f42c1";
				break;
			  case "bg-fuchsia":
				$color = "#f012be";
				break;
			  case "bg-pink":
				$color = "#e83e8c";
				break;
			  case "bg-maroon":
				$color = "#d81b60";
				break;
			  case "bg-lime":
				$color = "#fd7e14";
				break;
			  case "bg-lime":
				$color = "#01ff70";
				break;
			  case "bg-teal":
				$color = "#20c997";
				break;
			  case "bg-olive":
				$color = "#3d9970";
				break;
			  case "bg-gray-dark":
				$color = "#343a40";
				break;
			  case "bg-black":
				$color = "#000";
				break;
			  case "bg-light":
				$color = "#f8f9fa";
				break;
			}
		}
		
		if($this->form_validation->run())
		{
			$data = array(
				'h_holiday_date_from'	=>	$this->input->post('h_holiday_date_from'),
				'h_holiday_date_to'	=>	$this->input->post('h_holiday_date_to'),
				'holiday_id'	=>	$this->input->post('holiday_id'),
				'h_holiday_bg_color'	=>	$color,
				'is_active_h_calendar' =>	$this->input->post('is_active_h_calendar')
			);

			$this->holiday_calendar_model->insert($data);

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
				'h_holiday_date_from'		=>	form_error('h_holiday_date_from'),
				'holiday_id'		=>	form_error('holiday_id')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->holiday_calendar_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->holiday_calendar_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->holiday_calendar_model->fetch_single_join($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_all_join()
	{	
		$data = $this->holiday_calendar_model->fetch_all_join();
		
		echo json_encode($data);
	}

	function update()
	{		
		$this->form_validation->set_rules('h_calendar_id', 'Calendar Id', 'required');
		$this->form_validation->set_rules('holiday_id', 'Holiday Id', 'required');
		$this->form_validation->set_rules('h_holiday_date_to', 'From Date', 'required');
		$this->form_validation->set_rules('h_holiday_date_from', 'From Date', 'required');
		//$this->form_validation->set_rules('h_holiday_color', 'Color', 'required');
		
		$color="";
		
		if(isset($_POST['h_holiday_color'])){
			$class = $this->input->post('h_holiday_color');

			switch ($class) {
			  case "bg-warning":
				$color = "#ffc107";
				break;
			  case "bg-info":
				$color = "#17a2b8";
				break;
			  case "bg-primary":
				$color = "#007bff";
				break;
			 case "bg-danger":
				$color = "#dc3545";
				break;
			  case "bg-secondary":
				$color = "#6c757d";
				break;
			  case "bg-indigo":
				$color = "#6610f2";
				break;
			  case "bg-navy":
				$color = "#001f3f";
				break;
			  case "bg-purple":
				$color = "#6f42c1";
				break;
			  case "bg-fuchsia":
				$color = "#f012be";
				break;
			  case "bg-pink":
				$color = "#e83e8c";
				break;
			  case "bg-maroon":
				$color = "#d81b60";
				break;
			  case "bg-lime":
				$color = "#fd7e14";
				break;
			  case "bg-lime":
				$color = "#01ff70";
				break;
			  case "bg-teal":
				$color = "#20c997";
				break;
			  case "bg-olive":
				$color = "#3d9970";
				break;
			  case "bg-gray-dark":
				$color = "#343a40";
				break;
			  case "bg-black":
				$color = "#000";
				break;
			  case "bg-light":
				$color = "#f8f9fa";
				break;
			}
		}
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_h_calendar') == 0){			
				
				$status = 0;
				//$status += ($this->holiday_calendar_model->fetch_single($this->input->post('location_id')))->num_rows();
								
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Calendar Date is being used by other modules at the moment!'
					);
				}
				else{
										
					$data = array(
						'h_holiday_date_from'	=>	$this->input->post('h_holiday_date_from'),
						'h_holiday_date_to'	=>	($this->input->post('h_holiday_date_to') ?? "") ,
						'holiday_id'	=>	$this->input->post('holiday_id'),
						'is_active_h_calendar' =>	($this->input->post('is_active_h_calendar') ?? 0) 
					);

					$this->holiday_calendar_model->update_single($this->input->post('h_calendar_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			
			}
			else{
				$status = 0;
				//$status = $this->holiday_calendar_model->fetch_single($this->input->post('location_id'));
				//$count = $query->num_rows();
				
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Calendar Date is being used by other modules at the moment!'
					);
				}
				else{
										
					$data = array(
						'h_holiday_date_from'	=>	$this->input->post('h_holiday_date_from'),
						'h_holiday_date_to'	=>	($this->input->post('h_holiday_date_to') ?? "") ,
						'holiday_id'	=>	$this->input->post('holiday_id'),
						'is_active_h_calendar' =>	($this->input->post('is_active_h_calendar') ?? 0) 
					);

					$this->holiday_calendar_model->update_single($this->input->post('h_calendar_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
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
			if($this->holiday_calendar_model->delete_single($this->input->post('id')))
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
