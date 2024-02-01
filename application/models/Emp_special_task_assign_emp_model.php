<?php

class Emp_special_task_assign_emp_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('assign_emp_line_id', 'DESC');
		return $this->db->get('emp_special_task_assign_emp');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_special_task_assign_emp', $data);
	}

	function fetch_single($assign_emp_line_id)
	{
		$this->db->where('assign_emp_line_id', $assign_emp_line_id);
		$query = $this->db->get('emp_special_task_assign_emp');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_special_task_assign_emp');
		return $query;
	}

	function update_single($assign_emp_line_id, $data)
	{
		$this->db->where('assign_emp_line_id', $assign_emp_line_id);
		$this->db->update('emp_special_task_assign_emp', $data);
	}

	function delete_single($assign_emp_line_id)
	{
		$this->db->where('assign_emp_line_id', $assign_emp_line_id);
		$this->db->delete('emp_special_task_assign_emp');
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
