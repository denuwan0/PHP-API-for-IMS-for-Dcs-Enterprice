<?php

class Vehicle_part_replacement_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('replacement_id', 'DESC');
		return $this->db->get('vehicle_part_replacement');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_part_replacement', $data);
	}

	function fetch_single($replacement_id)
	{
		$this->db->where('replacement_id', $replacement_id);
		$query = $this->db->get('vehicle_part_replacement');
		return $query->result_array();
	}

	function update_single($replacement_id, $data)
	{
		$this->db->where('replacement_id', $replacement_id);
		$this->db->update('vehicle_part_replacement', $data);
	}

	function delete_single($replacement_id)
	{
		$this->db->where('replacement_id', $replacement_id);
		$this->db->delete('vehicle_part_replacement');
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
