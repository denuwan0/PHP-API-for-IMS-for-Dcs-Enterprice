<?php

class Emp_over_time_allocation_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('ot_alloc_id', 'DESC');
		return $this->db->get('emp_over_time_allocation');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_over_time_allocation', $data);
	}

	function fetch_single($ot_alloc_id)
	{
		$this->db->where('ot_alloc_id', $ot_alloc_id);
		$query = $this->db->get('emp_over_time_allocation');
		return $query->result_array();
	}
	
	function fetch_single_by_emp_id($emp_id)
	{
		$this->db->where('emp_id', $emp_id);
		$query = $this->db->get('emp_over_time_allocation');
		return $query;
	}

	function update_single($ot_alloc_id, $data)
	{
		$this->db->where('ot_alloc_id', $ot_alloc_id);
		$this->db->update('emp_over_time_allocation', $data);
	}

	function delete_single($ot_alloc_id)
	{
		$this->db->where('ot_alloc_id', $ot_alloc_id);
		$this->db->delete('emp_over_time_allocation');
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
