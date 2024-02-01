<?php

class Emp_salary_increment_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('increment_id', 'DESC');
		return $this->db->get('emp_salary_increment');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_increment', $data);
	}

	function fetch_single($increment_id)
	{
		$this->db->where('increment_id', $increment_id);
		$query = $this->db->get('emp_salary_increment');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_salary_increment');
		return $query;
	}

	function update_single($increment_id, $data)
	{
		$this->db->where('increment_id', $increment_id);
		$this->db->update('emp_salary_increment', $data);
	}

	function delete_single($increment_id)
	{
		$this->db->where('increment_id', $increment_id);
		$this->db->delete('emp_salary_increment');
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
