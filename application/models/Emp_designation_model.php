<?php

class Emp_designation_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('emp_desig_id', 'DESC');
		return $this->db->get('emp_designation');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_designation', $data);
	}

	function fetch_single($emp_desig_id)
	{
		$this->db->where('emp_desig_id', $emp_desig_id);
		$query = $this->db->get('emp_designation');
		return $query->result_array();
	}

	function update_single($emp_desig_id, $data)
	{
		$this->db->where('emp_desig_id', $emp_desig_id);
		$this->db->update('emp_designation', $data);
	}

	function delete_single($emp_desig_id)
	{
		$this->db->where('emp_desig_id', $emp_desig_id);
		$this->db->delete('emp_designation');
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
		$this->db->from('emp_designation');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_single_join($emp_desig_id)
	{
		$this->db->select('*');
		$this->db->from('emp_designation');
		$this->db->where('emp_desig_id', $emp_desig_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function fetch_all_active()
	{
		$this->db->where('is_active_emp_desig', 1);
		$query = $this->db->get('emp_designation');
		return $query;
	}
	
}
