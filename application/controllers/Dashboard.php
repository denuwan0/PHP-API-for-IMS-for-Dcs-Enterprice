<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->model('Emp_special_task_assign_emp_model');
		$this->load->model('Emp_wise_leave_quota_model');
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
		$emp_id = $this->session->userdata('emp_id');
		
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
			
			$data5 = $this->Dashboard_model->fetch_all_complete_retail_order_admin();
			$data5 = $data5->result_array();
			
			$data6 = $this->Dashboard_model->fetch_all_complete_rental_order_admin();
			$data6 = $data6->result_array();
			
			$data7 = $this->Dashboard_model->fetch_all_complete_online_order_admin();
			$data7 = $data7->result_array();
			
			$data8 = $this->Dashboard_model->fetch_all_latest_orders_admin();
			$data8 = $data8->result_array();
			
			$data9 = $this->Dashboard_model->fetch_all_latest_items_admin();
			$data9 = $data9->result_array();
			
			$data10 = $this->Dashboard_model->fetch_all_branch_wise_sale_admin();
			$data10 = $data10->result_array();
			
			$system_users = $data1[0]['user_count'];
			$yard_vehicles = $data2[0]['yard_vehicles'];
			$yard_employees = $data3[0]['employee_count'];
			$customers = $data4[0]['customer_count'];
			
			$complete_rental_orders = $data5[0]['retail_order_count'];
			$complete_retail_orders = $data6[0]['rental_order_count'];
			$complete_online_orders = $data7[0]['online_order_count'];
			
		
			
			$userdata = array(
				'system_users'  			=> $system_users,
				'yard_vehicles' 			=> $yard_vehicles,
				'yard_employees' 			=> $yard_employees,
				'customers'  				=> $customers,
				'complete_rental_orders' 	=> $complete_rental_orders,
				'complete_retail_orders' 	=> $complete_retail_orders,
				'complete_online_orders'  	=> $complete_online_orders,
				'latest_orders'				=> $data8,
				'latest_items'				=> $data9,
				'branch_wise_sale'				=> $data10
			);	
			
						
			
			echo json_encode($userdata);
		}
		else if($sys_user_group_name == "Manager"){
			
			$yard_vehicles = 0;
			$yard_employees = 0;
			$customers = 0;
			
			$complete_rental_orders = 0;
			$complete_retail_orders = 0;
			$complete_online_orders = 0;
			
			
			
			$data2 = $this->Dashboard_model->fetch_all_active_yard_vehicles_count_manager($emp_branch_id);
			$data2 = $data2->result_array();
			
			$data3 = $this->Dashboard_model->fetch_all_active_employee_count_manager($emp_branch_id);
			$data3 = $data3->result_array();
			
			/* $data4 = $this->Dashboard_model->fetch_all_active_customer_count_manager();
			$data4 = $data4->result_array(); */
			
			$data5 = $this->Dashboard_model->fetch_all_complete_retail_order_manager($emp_branch_id);
			$data5 = $data5->result_array();
			
			$data6 = $this->Dashboard_model->fetch_all_complete_rental_order_manager($emp_branch_id);
			$data6 = $data6->result_array();
			
			/* $data7 = $this->Dashboard_model->fetch_all_complete_online_order_manager();
			$data7 = $data7->result_array(); */
			
			$data8 = $this->Dashboard_model->fetch_all_latest_orders_manager($emp_branch_id);
			$data8 = $data8->result_array();
			
			$data9 = $this->Dashboard_model->fetch_all_latest_items_manager($emp_branch_id);
			$data9 = $data9->result_array();
			
			$data10 = $this->Dashboard_model->fetch_all_branch_wise_sale_manager($emp_branch_id);
			$data10 = $data10->result_array();
			
			//$system_users = $data1[0]['user_count'];
			$yard_vehicles = $data2[0]['yard_vehicles'];
			$yard_employees = $data3[0]['employee_count'];
			//$customers = $data4[0]['customer_count'];
			
			$complete_rental_orders = $data5[0]['retail_order_count'];
			$complete_retail_orders = $data6[0]['rental_order_count'];
			//$complete_online_orders = $data7[0]['online_order_count'];
			
		
			
			$userdata = array(
				'system_users'  			=> "",
				'yard_vehicles' 			=> $yard_vehicles,
				'yard_employees' 			=> $yard_employees,
				'customers'  				=> $customers,
				'complete_rental_orders' 	=> $complete_rental_orders,
				'complete_retail_orders' 	=> $complete_retail_orders,
				'complete_online_orders'  	=> $complete_online_orders,
				'latest_orders'				=> $data8,
				'latest_items'				=> $data9,
				'branch_wise_sale'				=> $data10
			);	
			
						
			
			echo json_encode($userdata);
		}
		else if($sys_user_group_name == "Staff"){
			
			$monthly_rank = 0;
			$monthly_task_completed = 0;
			$monthly_task_skipped = 0;			
			$monthly_task_completion_rate = 0;
			
			$daily_task_list = 0;
			$my_leave_quota = 0;
			
			$data1 = $this->Dashboard_model->fetch_all_completed_tasks_staff($emp_id);
			$data1 = $data1->result_array();			
			
			$data2 = $this->Dashboard_model->fetch_all_skipped_tasks_staff($emp_id);
			$data2 = $data2->result_array();
			
			$data3 = $this->Dashboard_model->fetch_all_ranks_staff($emp_id);
			$data3 = $data3->result_array();
			
			$data4 = $this->Emp_special_task_assign_emp_model->fetch_all_daily_join_staff($emp_id);
			$daily_task_list = $data4->result_array();
			
			$data5 = $this->Emp_wise_leave_quota_model->fetch_all_join_by_emp_id($emp_id);
			$leave_quota_list = $data5->result_array();
			
			//var_dump($leave_quota_list);
			
			$count = 1;
			$rank = 0;
			foreach ($data3 as $item) {
				if( $item["emp_id"] == $emp_id){
					//var_dump($item);
					$rank = $count;
				}
				
				$count++;
			}
			
			
			$monthly_task_completed = $data1[0]['task_completed'];
			$monthly_task_skipped = $data2[0]['task_skipped'];
			
			
			$total_tasks = $monthly_task_completed+$monthly_task_skipped;
			$monthly_task_completion_rate = ($monthly_task_completed / $total_tasks)*100;
			
			
			
			$userdata = array(
				'monthly_rank' 			=> $rank,
				'monthly_task_completed' 	=> $monthly_task_completed,
				'monthly_task_skipped'  	=> $monthly_task_skipped,
				'monthly_task_completion_rate' 	=> $monthly_task_completion_rate,
				'daily_task_list' 	=> $daily_task_list,
				'leave_quota_list' 	=> $leave_quota_list
			);	
			
						
			
			echo json_encode($userdata);
		}
		
		
	}
	
	
}
