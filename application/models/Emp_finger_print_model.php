<?php

class Emp_finger_print_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('fp_line_id', 'DESC');
		return $this->db->get('emp_finger_print_details');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_finger_print_details', $data);
	}

	function fetch_single($fp_line_id)
	{
		$this->db->where('fp_line_id', $fp_line_id);
		$query = $this->db->get('emp_finger_print_details');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_finger_print_details');
		return $query;
	}

	function update_single($fp_line_id, $data)
	{
		$this->db->where('fp_line_id', $fp_line_id);
		$this->db->update('emp_finger_print_details', $data);
	}

	function delete_single($fp_line_id)
	{
		$this->db->where('fp_line_id', $fp_line_id);
		$this->db->delete('emp_finger_print_details');
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
