<?php

class Emp_over_time_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('over_time_id', 'DESC');
		return $this->db->get('emp_over_time');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_over_time', $data);
	}

	function fetch_single($over_time_id)
	{
		$this->db->where('over_time_id', $over_time_id);
		$query = $this->db->get('emp_over_time');
		return $query->result_array();
	}

	function update_single($over_time_id, $data)
	{
		$this->db->where('over_time_id', $over_time_id);
		$this->db->update('emp_over_time', $data);
	}

	function delete_single($over_time_id)
	{
		$this->db->where('over_time_id', $over_time_id);
		$this->db->delete('emp_over_time');
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
