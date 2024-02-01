<?php

class Emp_salary_advance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('advance_id', 'DESC');
		return $this->db->get('emp_salary_advance');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_advance', $data);
	}

	function fetch_single($advance_id)
	{
		$this->db->where('advance_id', $advance_id);
		$query = $this->db->get('emp_salary_advance');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_salary_advance');
		return $query;
	}

	function update_single($advance_id, $data)
	{
		$this->db->where('advance_id', $advance_id);
		$this->db->update('emp_salary_advance', $data);
	}

	function delete_single($advance_id)
	{
		$this->db->where('advance_id', $advance_id);
		$this->db->delete('emp_salary_advance');
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
