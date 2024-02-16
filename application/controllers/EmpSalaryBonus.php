<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpSalaryBonus extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('emp_salary_bonus_model');
		$this->load->model('emp_bonus_model');
		$this->load->library('form_validation');
		
		//$is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		
	}

	function index()
	{
		$data = $this->emp_salary_bonus_model->fetch_all();
		echo json_encode($data->result_array());
	}
	
	function insert()
	{		
		$this->form_validation->set_rules('bonus_id', 'bonus_id', 'required');
		$this->form_validation->set_rules('branch_id', 'branch_id', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		$this->form_validation->set_rules('year', 'year', 'required');
		$this->form_validation->set_rules('month', 'month', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		
		if($this->form_validation->run())
		{
			$data = array(
				'bonus_id'	=>	$this->input->post('bonus_id'),
				'branch_id'	=>	$this->input->post('branch_id'),
				'amount'	=>	$this->input->post('amount'),
				'year'	=>	$this->input->post('year'),
				'month'	=>	$this->input->post('month'),
				'emp_id'	=>	$this->input->post('emp_id'),
				'is_approve_sal_bonus'	=>	$this->input->post('is_approve_sal_bonus'),
				'is_active_sal_bonus' =>	$this->input->post('is_active_sal_bonus')
			);

			$this->emp_salary_bonus_model->insert($data);

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
				'bonus_id'		=>	form_error('bonus_id'),
				'branch_id'		=>	form_error('branch_id'),
				'amount'		=>	form_error('amount'),
				'year'		=>	form_error('year'),
				'month'		=>	form_error('month'),
				'emp_id'		=>	form_error('emp_id')
			);
		}
		echo json_encode($array);
	}
	
	function fetch_all_active()
	{		
		$data = $this->emp_salary_bonus_model->fetch_all_active();
		echo json_encode($data->result_array());
		
	}
	
	function fetch_single()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_salary_bonus_model->fetch_single($id);
			
			echo json_encode($data);
		}
	}
	
	function fetch_single_join()
	{
		if($this->input->get('id'))
		{			
			$id = $this->input->get('id');
			$data = $this->emp_salary_bonus_model->fetch_single_join($id);
			
			echo json_encode($data->result_array());
		}
	}
	
	function fetch_all_join()
	{		
		$sys_user_group_name = $this->session->userdata('sys_user_group_name');
		//var_dump($this->session->userdata());
		$emp_branch_id = $this->session->userdata('emp_branch_id');
		if($sys_user_group_name == "Admin"){
			$data = $this->emp_salary_bonus_model->fetch_all_join();		
			echo json_encode($data->result_array());
		}
		else{
			$data = $this->emp_salary_bonus_model->fetch_all_join_by_branch_id($emp_branch_id);
			echo json_encode($data->result_array());
		}
	}

	function update()
	{
		$this->form_validation->set_rules('emp_bonus_id', 'emp_bonus_id', 'required');
		$this->form_validation->set_rules('bonus_id', 'bonus_id', 'required');
		$this->form_validation->set_rules('branch_id', 'branch_id', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		$this->form_validation->set_rules('year', 'year', 'required');
		$this->form_validation->set_rules('month', 'month', 'required');
		$this->form_validation->set_rules('emp_id', 'emp_id', 'required');
		
		$branch_id = $this->session->userdata('emp_branch_id');
		$created_by = $this->session->userdata('user_id');
		
		if($this->form_validation->run())
		{			
			if($this->input->post('is_active_sal_bonus') == 0){	

				/* SELECT DISTINCT TABLE_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE COLUMN_NAME IN ('emp_salary_advance_id')
					AND TABLE_SCHEMA='dcs_db'; */
				$status = 0;
				//$status = $this->branch_model->fetch_single($this->input->post('location_id'));
				if($status>0){
					$array = array(
						'error'			=>	true,
						'message'		=>	'Salary Bonus is being used by other modules at the moment!'
					);
				}
				else{
					$data = array(
						'bonus_id'	=>	$this->input->post('bonus_id'),
						'branch_id'	=>	$this->input->post('branch_id'),
						'amount'	=>	$this->input->post('amount'),
						'year'	=>	$this->input->post('year'),
						'month'	=>	$this->input->post('month'),
						'emp_id'	=>	$this->input->post('emp_id'),
						'approved_by'	=>	$created_by,
						'is_approve_sal_bonus'	=>	$this->input->post('is_approve_sal_bonus'),
						'is_active_sal_bonus' =>	$this->input->post('is_active_sal_bonus')
					);

					$this->emp_salary_bonus_model->update_single($this->input->post('emp_bonus_id'), $data);

					$array = array(
						'success'		=>	true,
						'message'		=>	'Changes Updated!'
					);
				}
			}
			else{
				$data = array(
					'bonus_id'	=>	$this->input->post('bonus_id'),
					'branch_id'	=>	$this->input->post('branch_id'),
					'amount'	=>	$this->input->post('amount'),
					'year'	=>	$this->input->post('year'),
					'month'	=>	$this->input->post('month'),
					'emp_id'	=>	$this->input->post('emp_id'),
					'approved_by'	=>	$created_by,
					'is_approve_sal_bonus'	=>	$this->input->post('is_approve_sal_bonus'),
					'is_active_sal_bonus' =>	$this->input->post('is_active_sal_bonus')
				);

				$this->emp_salary_bonus_model->update_single($this->input->post('emp_bonus_id'), $data);

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
			if($this->emp_salary_bonus_model->delete_single($this->input->post('id')))
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
