<?php

class Emp_allowance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('allowance_id', 'ASC');
		return $this->db->get('emp_allowance');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_emp_allow', 1);
		$this->db->order_by('allowance_id', 'ASC');
		return $this->db->get('emp_allowance');
	}
	
	function fetch_all_active_by_branch_id($branch_id){
		$this->db->where('is_active_emp_allow', 1);
		$this->db->where('branch_id', $branch_id);
		$this->db->order_by('allowance_id', 'ASC');
		$this->db->get('emp_allowance');
		return $this->db->last_query();
		//var_dump($this->db->last_query());
	}
	
	function insert($data)
	{
		$this->db->insert('emp_allowance', $data);
	}

	function fetch_single($allowance_id)
	{
		$this->db->where('allowance_id', $allowance_id);
		$query = $this->db->get('emp_allowance');
		return $query->result_array();
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_allowance');
		$query = $this->db->get();
		return $query->result_array();
	}
		

	function update_single($allowance_id, $data)
	{
		$this->db->where('allowance_id', $allowance_id);
		$this->db->update('emp_allowance', $data);
	}

	function delete_single($allowance_id)
	{
		$this->db->where('allowance_id', $allowance_id);
		$this->db->delete('emp_allowance');
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
