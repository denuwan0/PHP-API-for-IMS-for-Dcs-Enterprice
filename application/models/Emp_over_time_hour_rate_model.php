<?php

class Emp_over_time_hour_rate_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('ot_rate_id', 'DESC');
		return $this->db->get('emp_over_time_hour_rate');
	}
	
	function insert($data)
	{
		$this->db->insert('emp_over_time_hour_rate', $data);
	}

	function fetch_single($ot_rate_id)
	{
		$this->db->where('ot_rate_id', $ot_rate_id);
		$query = $this->db->get('emp_over_time_hour_rate');
		return $query->result_array();
	}

	function update_single($ot_rate_id, $data)
	{
		$this->db->where('ot_rate_id', $ot_rate_id);
		$this->db->update('emp_over_time_hour_rate', $data);
	}

	function delete_single($ot_rate_id)
	{
		$this->db->where('ot_rate_id', $ot_rate_id);
		$this->db->delete('emp_over_time_hour_rate');
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
