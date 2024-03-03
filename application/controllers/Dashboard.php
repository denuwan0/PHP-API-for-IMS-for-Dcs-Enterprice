<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		
		//var_dump();
		
		/* if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		} */
		
	}

	function data()
	{
		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		;
		
		if($sys_user_group_name == "Admin"){
			
			$system_users = 0;
			$yard_vehicles = 0;
			$yard_employees = 0;
			$customers = 0;
			
			$complete_rental_orders = 0;
			$complete_retail_orders = 0;
			$complete_online_orders = 0;
			
			$data1 = $this->Dashboard_model->fetch_all_active_system_user_count_admin();
			$data1 = $data1->result_array();
			
			$data2 = $this->Dashboard_model->fetch_all_active_yard_vehicles_count_admin();
			$data2 = $data2->result_array();
			
			$data3 = $this->Dashboard_model->fetch_all_active_employee_count_admin();
			$data3 = $data3->result_array();
			
			$data4 = $this->Dashboard_model->fetch_all_active_customer_count_admin();
			$data4 = $data4->result_array();
			
			$system_users = $data1[0]['user_count'];
			$yard_vehicles = $data2[0]['yard_vehicles'];
			$yard_employees = $data3[0]['employee_count'];
			$customers = $data4[0]['customer_count'];
			
			$userdata = array(
				'system_users'  	=> $system_users,
				'yard_vehicles' 	=> $yard_vehicles,
				'yard_employees' 	=> $yard_employees,
				'customers'  		=> $customers
			);	
			
						
			
			echo json_encode($userdata);
		}
		else if($sys_user_group_name == "Manager"){
			$data = $this->Dashboard_model->fetch_all();
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->Dashboard_model->fetch_all_join_by_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
		
		
	}
	
	
}
