<?php

class Emp_final_sal_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('final_sal_id', 'DESC');
		return $this->db->get('emp_final_salary');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_final_salary', $data);
	}

	function fetch_single($final_sal_id)
	{
		$this->db->where('final_sal_id', $final_sal_id);
		$query = $this->db->get('emp_final_salary');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_final_salary');
		return $query;
	}

	function update_single($final_sal_id, $data)
	{
		$this->db->where('final_sal_id', $final_sal_id);
		$this->db->update('emp_final_salary', $data);
	}

	function delete_single($final_sal_id)
	{
		$this->db->where('final_sal_id', $final_sal_id);
		$this->db->delete('emp_final_salary');
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
