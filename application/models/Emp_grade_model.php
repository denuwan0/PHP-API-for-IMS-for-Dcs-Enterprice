<?php

class Emp_grade_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_grade_id', 'DESC');
		return $this->db->get('emp_grade');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_grade', $data);
	}

	function fetch_single($emp_grade_id)
	{
		$this->db->where('emp_grade_id', $emp_grade_id);
		$query = $this->db->get('emp_grade');
		return $query->result_array();
	}

	function update_single($emp_grade_id, $data)
	{
		$this->db->where('emp_grade_id', $emp_grade_id);
		$this->db->update('emp_grade', $data);
	}

	function delete_single($emp_grade_id)
	{
		$this->db->where('emp_grade_id', $emp_grade_id);
		$this->db->delete('emp_grade');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function fetch_all_join()
	{
		$this->db->select('*');
		$this->db->from('emp_grade');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_active_join()
	{
		$this->db->select('*');
		$this->db->from('emp_grade');
		$this->db->where('is_active_emp_grade ', 1);
		$query = $this->db->get();
		return $query;
	}
	
	function fetch_single_join($emp_grade_id)
	{
		$this->db->select('*');
		$this->db->from('emp_grade');
		$this->db->where('emp_grade_id ', $emp_grade_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	
}
