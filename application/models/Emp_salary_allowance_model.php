<?php

class Emp_salary_allowance_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('addition_id', 'DESC');
		return $this->db->get('emp_salary_allowance');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_salary_allowance', $data);
	}

	function fetch_single($addition_id)
	{
		$this->db->where('addition_id', $addition_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query;
	}
	
	function fetch_single_by_allowance_id($allowance_id)
	{
		$this->db->where('allowance_id', $allowance_id);
		$query = $this->db->get('emp_salary_allowance');
		return $query;
	}

	function update_single($addition_id, $data)
	{
		$this->db->where('addition_id', $addition_id);
		$this->db->update('emp_salary_allowance', $data);
	}

	function delete_single($addition_id)
	{
		$this->db->where('addition_id', $addition_id);
		$this->db->delete('emp_salary_allowance');
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
