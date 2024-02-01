<?php

class Emp_leave_quota_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('leave_quota_id', 'ASC');
		return $this->db->get('emp_leave_quota');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_leave_quota', $data);
	}

	function fetch_single($leave_quota_id)
	{
		$this->db->where('leave_quota_id', $leave_quota_id);
		$query = $this->db->get('emp_leave_quota');
		return $query->result_array();
	}
	
	function fetch_single_by_leave_type_id($leave_type_id)
	{
		$this->db->where('leave_type_id', $leave_type_id);
		$query = $this->db->get('emp_leave_quota');
		return $query;
	}
	

	function update_single($leave_quota_id, $data)
	{
		$this->db->where('leave_quota_id', $leave_quota_id);
		$this->db->update('emp_leave_quota', $data);
	}

	function delete_single($leave_quota_id)
	{
		$this->db->where('leave_quota_id', $leave_quota_id);
		$this->db->delete('emp_leave_quota');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_single_join($leave_quota_id)
	{
		$this->db->select('*');
		$this->db->from('emp_leave_quota');
		$this->db->join('emp_leave_type', 'emp_leave_quota.leave_type_id = emp_leave_type.leave_type_id','left');
		$this->db->where('leave_quota_id', $leave_quota_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_leave_quota');
		$this->db->join('emp_leave_type', 'emp_leave_quota.leave_type_id = emp_leave_type.leave_type_id','left');
		$query = $this->db->get();
		return $query;
	}
}
