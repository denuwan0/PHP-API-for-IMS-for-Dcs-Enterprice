<?php

class Emp_advance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('advance_id', 'ASC');
		return $this->db->get('emp_advance');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_advance', 1);
		$this->db->order_by('advance_id', 'ASC');
		return $this->db->get('emp_advance');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_advance', $data);
	}

	function fetch_all_join_by_branch_id($branch_id)
	{
		$this->db->where('branch_id', $branch_id);
		$query = $this->db->get('emp_advance');
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_advance');
		$query = $this->db->get();
		return $query->result_array();
	}
		

	function update_single($advance_id, $data)
	{
		$this->db->where('advance_id', $advance_id);
		$this->db->update('emp_advance', $data);
	}

	function delete_single($advance_id)
	{
		$this->db->where('advance_id', $advance_id);
		$this->db->delete('emp_advance');
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
