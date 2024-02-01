<?php

class Vehicle_type_model extends CI_Model{   
    
	function fetch_all(){
		$this->db->order_by('vehicle_type_id', 'DESC');
		return $this->db->get('vehicle_type');
	}
	
	function fetch_all_active(){
		$this->db->where('is_active_vhcl_type', 1);
		$this->db->order_by('vehicle_type_id', 'DESC');
		return $this->db->get('vehicle_type');
	}
	
	function insert($data)
	{
		$this->db->insert('vehicle_type', $data);
	}

	function fetch_single($vehicle_type_id)
	{
		$this->db->where('vehicle_type_id', $vehicle_type_id);
		$query = $this->db->get('vehicle_type');
		return $query->result_array();
	}

	function update_single($vehicle_type_id, $data)
	{
		$this->db->where('vehicle_type_id', $vehicle_type_id);
		$this->db->update('vehicle_type', $data);
	}

	function delete_single($vehicle_type_id)
	{
		$this->db->where('vehicle_type_id', $vehicle_type_id);
		$this->db->delete('vehicle_type');
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
