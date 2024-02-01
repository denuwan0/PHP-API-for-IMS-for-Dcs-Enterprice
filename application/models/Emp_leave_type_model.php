<?php

class Emp_leave_type_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('leave_type_id', 'DESC');
		$query = $this->db->get('emp_leave_type');
		return $query->result_array();
	}
	
	function fetch_all_join(){
		$this->db->order_by('leave_type_id', 'ASC');
		$query = $this->db->get('emp_leave_type');
		return $query;
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_leave_type', 1);
		$query = $this->db->get('emp_leave_type');
		return $query;
	}
	
	function insert($data)
	{
		$this->db->insert('emp_leave_type', $data);
	}

	function fetch_single($leave_type_id)
	{
		$this->db->where('leave_type_id', $leave_type_id);
		$query = $this->db->get('emp_leave_type');
		return $query->result_array();
	}

	function update_single($leave_type_id, $data)
	{
		$this->db->where('leave_type_id', $leave_type_id);
		$this->db->update('emp_leave_type', $data);
	}

	function delete_single($leave_type_id)
	{
		$this->db->where('leave_type_id', $leave_type_id);
		$this->db->delete('emp_leave_type');
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
