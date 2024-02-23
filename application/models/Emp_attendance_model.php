<?php

class Emp_attendance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('attendance_id', 'DESC');
		return $this->db->get('emp_attendance');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_attendance', $data);
	}

	function fetch_single($attendance_id)
	{
		$this->db->where('attendance_id', $attendance_id);
		$query = $this->db->get('emp_attendance');
		return $query->result_array();
	}
	
	function fetch_single_by_epf_and_date($emp_epf, $date)
	{
		$this->db->where('emp_epf', $emp_epf);
		$this->db->where('date', $date);
		$query = $this->db->get('emp_attendance');
		return $query;
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_attendance');
		$this->db->join('sys_user', 'emp_attendance.uploaded_by = sys_user.user_id','left');
		$this->db->join('company_branch', 'emp_attendance.branch_id = company_branch.company_branch_id','left');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_days_join($branch_id)
	{
		$this->db->select('date');
		$this->db->from('emp_attendance');
		$this->db->where('branch_id', $branch_id);
		$this->db->group_by('date'); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_months_join($branch_id)
	{
		$this->db->select("DISTINCT MONTH(STR_TO_DATE(date, '%Y-%m-%d')) as month, MONTHNAME(STR_TO_DATE(date, '%Y-%m-%d')) as month_name");
		$this->db->from('emp_attendance');
		$this->db->where('branch_id', $branch_id);
		$this->db->group_by('month'); 
		$query = $this->db->get();
		return $query->result_array();
		
		//var_dump($this->db->last_query());
	}
	
	function fetch_all_active_by_emp_branch_id($branch_id)
	{
		$this->db->select('*');
		$this->db->from('emp_attendance');
		$this->db->join('sys_user', 'emp_attendance.uploaded_by = sys_user.user_id','left');
		$this->db->join('company_branch', 'emp_attendance.branch_id = company_branch.company_branch_id','left');	
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_active_by_emp_branch_id_emp_epf($branch_id, $emp_epf)
	{
		$this->db->select('*');
		$this->db->from('emp_attendance');
		$this->db->join('sys_user', 'emp_attendance.uploaded_by = sys_user.user_id','left');
		$this->db->join('company_branch', 'emp_attendance.branch_id = company_branch.company_branch_id','left');	
		$this->db->where('branch_id', $branch_id);
		$this->db->where('emp_epf', $emp_epf);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_single_join($id)
	{
		$this->db->select('*');
		$this->db->from('emp_attendance');
		$this->db->join('sys_user', 'emp_attendance.uploaded_by = sys_user.user_id','left');
		$this->db->where('attendance_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
		

	function update_single($attendance_id, $data)
	{
		$this->db->where('attendance_id', $attendance_id);
		$this->db->update('emp_attendance', $data);
	}
	
	function approve_single_date($date, $data)
	{
		$this->db->where('date', $date);
		$this->db->update('emp_attendance', $data);
	}
	
	function approve_single_month($month, $data)
	{
		$this->db->where("MONTH(STR_TO_DATE(date, '%Y-%m-%d')) =", $month);
		$this->db->update('emp_attendance', $data);
		
		//var_dump($this->db->last_query());
	}

	function delete_single($attendance_id)
	{
		$this->db->where('attendance_id', $attendance_id);
		$this->db->delete('emp_attendance');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
}
