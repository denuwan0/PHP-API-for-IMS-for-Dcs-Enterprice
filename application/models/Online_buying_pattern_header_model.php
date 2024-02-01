<?php

class Online_buying_pattern_header_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('pattern_id', 'DESC');
		return $this->db->get('online_buying_pattern_header');
	}
	
	function insert($data)
	{
		$this->db->insert('online_buying_pattern_header', $data);
	}

	function fetch_single($pattern_id)
	{
		$this->db->where('pattern_id', $pattern_id);
		$query = $this->db->get('online_buying_pattern_header');
		return $query->result_array();
	}

	function update_single($pattern_id, $data)
	{
		$this->db->where('pattern_id', $pattern_id);
		$this->db->update('online_buying_pattern_header', $data);
	}

	function delete_single($pattern_id)
	{
		$this->db->where('pattern_id', $pattern_id);
		$this->db->delete('online_buying_pattern_header');
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
